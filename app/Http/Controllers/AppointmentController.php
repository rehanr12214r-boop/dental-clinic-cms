<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Exceptions\SlotUnavailable;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Treatment;
use App\Services\SlotAvailabilityService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private readonly SlotAvailabilityService $slotAvailability) {}

    /**
     * Show the public booking wizard (/book), pre-filled for signed-in
     * patients and open for guest bookings.
     */
    public function index(Request $request): View
    {
        $patient = auth('patient')->user();
        $serviceParam = $request->query('service') ?? $request->query('treatment');
        $selectedTreatment = null;

        if ($serviceParam !== null && $serviceParam !== '') {
            $selectedTreatment = Treatment::query()->active()
                ->where(function ($query) use ($serviceParam): void {
                    if (is_numeric($serviceParam)) {
                        $query->where('id', (int) $serviceParam);
                    } else {
                        $query->where('slug', (string) $serviceParam);
                    }
                })
                ->first();
        }

        return view('booking.index', [
            'treatments' => Treatment::query()->active()->orderBy('cost')->get(),
            'selectedTreatment' => $selectedTreatment,
            'selectedTreatmentId' => $selectedTreatment?->id,
            'daysOff' => $this->slotAvailability->daysOffWeekdays(),
            'maxBookingDate' => CarbonImmutable::today()
                ->addDays(SlotAvailabilityService::BOOKING_WINDOW_DAYS)
                ->toDateString(),
            'workingHours' => $this->slotAvailability->workingHoursSummary(),
            'patientPrefill' => $patient === null ? null : [
                'name' => $patient->name,
                'phone' => $patient->phone,
                'age' => $patient->age,
            ],
        ]);
    }

    /**
     * Public availability endpoint consumed by the booking wizard.
     */
    public function availableSlots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'treatment_id' => [
                'required',
                'integer',
                Rule::exists('treatments', 'id')->where(
                    fn ($query) => $query->where('is_active', true)
                ),
            ],
            'date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
                'before_or_equal:'.CarbonImmutable::today()
                    ->addDays(SlotAvailabilityService::BOOKING_WINDOW_DAYS)
                    ->toDateString(),
            ],
        ]);

        $treatment = Treatment::query()->active()->findOrFail($validated['treatment_id']);
        $date = CarbonImmutable::parse($validated['date']);
        $schedule = $this->slotAvailability->scheduleForDate($date);
        $slots = $this->slotAvailability->slotsForDate($date, $treatment);

        return response()->json([
            'treatment' => [
                'id' => $treatment->id,
                'name' => $treatment->name,
                'duration_minutes' => (int) $treatment->duration_minutes,
            ],
            'date' => $date->toDateString(),
            'date_label' => $date->format('l, F j, Y'),
            'day_off' => $schedule === null || $schedule->is_day_off,
            'slots' => $slots,
            'available_count' => count(array_filter($slots, static fn (array $slot): bool => $slot['available'])),
        ]);
    }

    /**
     * Create a new booking from the public form.
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $treatment = Treatment::query()->active()->findOrFail($validated['treatment_id']);
        $date = CarbonImmutable::parse($validated['appointment_date']);

        // Only link the booking to the signed-in account when the submitted
        // phone number actually belongs to that account. Otherwise a patient
        // could attach someone else's appointment to their portal by changing
        // the form field.
        /** @var Patient|null $patient */
        $patient = auth('patient')->user();
        $submittedPhone = preg_replace('/\D+/', '', (string) $validated['patient_phone']) ?? '';
        $patientId = $patient !== null && $patient->phoneDigits() !== '' && $patient->phoneDigits() === $submittedPhone
            ? $patient->getKey()
            : null;

        try {
            $appointment = DB::transaction(function () use ($validated, $date, $treatment, $patientId): Appointment {
                // Serialize bookings for this weekday by locking its schedule
                // row first. Availability is then re-checked inside the same
                // transaction, so two simultaneous submissions can never both
                // grab the same (or an overlapping) slot. See the migration
                // comment on why this is enforced here rather than by a plain
                // unique index.
                DoctorSchedule::query()
                    ->where('day_of_week', $date->dayOfWeek)
                    ->lockForUpdate()
                    ->first();

                if (! $this->slotAvailability->canBookAppointment(
                    $date,
                    $validated['appointment_time'],
                    $treatment,
                    lock: true
                )) {
                    throw new SlotUnavailable;
                }

                return Appointment::query()->create([
                    'patient_id' => $patientId,
                    'patient_name' => $validated['patient_name'],
                    'patient_phone' => $validated['patient_phone'],
                    'patient_age' => (int) $validated['patient_age'],
                    'treatment_id' => $treatment->id,
                    'appointment_date' => $date->toDateString(),
                    'appointment_time' => CarbonImmutable::parse($validated['appointment_time'])->format('H:i:s'),
                    'status' => AppointmentStatus::Pending,
                    'notes' => $validated['notes'] ?? null,
                ]);
            }, attempts: 3);
        } catch (SlotUnavailable) {
            return response()->json([
                'message' => 'This time slot is no longer available. Please pick another one.',
            ], 409);
        }

        return response()->json([
            'message' => 'Your appointment has been booked successfully. We look forward to seeing you!',
            'appointment' => $this->appointmentPayload($appointment),
        ], 201);
    }

    /**
     * Confirmation details for the booking confirmation card.
     *
     * @return array<string, mixed>
     */
    protected function appointmentPayload(Appointment $appointment): array
    {
        $appointment->load('treatment');
        $treatment = $appointment->treatment;
        $date = CarbonImmutable::parse($appointment->appointment_date);
        $time = CarbonImmutable::parse($appointment->appointment_time);

        return [
            'id' => $appointment->id,
            'reference' => $appointment->reference,
            'patient_name' => $appointment->patient_name,
            'patient_phone' => $appointment->patient_phone,
            'patient_age' => (int) $appointment->patient_age,
            'treatment' => [
                'id' => $treatment->id,
                'name' => $treatment->name,
                'duration_minutes' => (int) $treatment->duration_minutes,
                'cost_label' => '$'.number_format((float) $treatment->cost, 2),
            ],
            'appointment_date' => $date->toDateString(),
            'appointment_date_label' => $date->format('l, F j, Y'),
            'appointment_time' => $time->format('H:i'),
            'appointment_time_label' => $time->format('g:i A'),
            'status' => $appointment->status->value,
            'status_label' => $appointment->status->label(),
        ];
    }
}
