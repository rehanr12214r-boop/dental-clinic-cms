<?php

namespace App\Http\Controllers\Patient;

use App\Enums\AppointmentStatus;
use App\Exceptions\SlotUnavailable;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\Setting;
use App\Services\SlotAvailabilityService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private readonly SlotAvailabilityService $slotAvailability) {}

    /**
     * Cancel an upcoming appointment (only when it starts after the online
     * change cutoff, currently 4 hours from now).
     */
    public function cancel(Request $request, Appointment $appointment): RedirectResponse
    {
        $appointment = $this->ownedAppointment($request, $appointment);

        if (! $appointment->isCancellable()) {
            return back()->with('error', 'This appointment can only be cancelled more than '.Appointment::CANCELLATION_CUTOFF_HOURS.' hours before it starts. Please call the clinic instead.');
        }

        $appointment->update(['status' => AppointmentStatus::Cancelled]);

        return back()->with('status', 'Your '.($appointment->treatment?->name ?? 'appointment').' on '.$appointment->dateLabel().' at '.$appointment->timeLabel().' has been cancelled.');
    }

    /**
     * Show the reschedule form (date picker + live slot grid) for an
     * appointment that is still outside the 4-hour cutoff window.
     */
    public function rescheduleForm(Request $request, Appointment $appointment): View|RedirectResponse
    {
        $appointment = $this->ownedAppointment($request, $appointment)->loadMissing('treatment');

        if (! $appointment->isReschedulable()) {
            return redirect()->route('patient.dashboard')
                ->with('error', 'This appointment can no longer be moved online. Please call the clinic to change it.');
        }

        return view('patient.reschedule', [
            'appointment' => $appointment,
            'daysOff' => $this->slotAvailability->daysOffWeekdays(),
            'maxBookingDate' => CarbonImmutable::today()
                ->addDays(SlotAvailabilityService::BOOKING_WINDOW_DAYS)
                ->toDateString(),
            'slotsEndpoint' => route('patient.appointments.slots', $appointment),
        ]);
    }

    /**
     * Slot availability for the reschedule picker. This ignores the
     * appointment being moved, so its current slot (and any slot that only
     * overlaps itself) can be chosen.
     */
    public function slots(Request $request, Appointment $appointment): JsonResponse
    {
        $appointment = $this->ownedAppointment($request, $appointment)->loadMissing('treatment');

        abort_unless($appointment->isReschedulable(), 403);

        $validated = $request->validate([
            'date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
                'before_or_equal:'.CarbonImmutable::today()
                    ->addDays(SlotAvailabilityService::BOOKING_WINDOW_DAYS)
                    ->toDateString(),
            ],
        ]);

        $date = CarbonImmutable::parse($validated['date']);
        $schedule = $this->slotAvailability->scheduleForDate($date);
        $slots = $this->slotAvailability->slotsForDate(
            $date,
            $appointment->treatment,
            ignoreAppointmentId: $appointment->getKey(),
        );

        return response()->json([
            'date' => $date->toDateString(),
            'date_label' => $date->format('l, F j, Y'),
            'day_off' => $schedule === null || $schedule->is_day_off,
            'slots' => $slots,
            'available_count' => count(array_filter($slots, static fn (array $slot): bool => $slot['available'])),
        ]);
    }

    /**
     * Move the appointment to the chosen free slot, re-checking availability
     * inside a serialized transaction (double-booking protection intact).
     */
    public function reschedule(Request $request, Appointment $appointment): RedirectResponse
    {
        $appointment = $this->ownedAppointment($request, $appointment)->loadMissing('treatment');

        if (! $appointment->isReschedulable()) {
            return redirect()->route('patient.dashboard')
                ->with('error', 'This appointment can no longer be moved online. Please call the clinic to change it.');
        }

        $validated = $request->validate([
            'appointment_date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
                'before_or_equal:'.CarbonImmutable::today()
                    ->addDays(SlotAvailabilityService::BOOKING_WINDOW_DAYS)
                    ->toDateString(),
            ],
            'appointment_time' => ['required', 'date_format:H:i'],
        ]);

        $date = CarbonImmutable::parse($validated['appointment_date']);

        try {
            DB::transaction(function () use ($appointment, $date, $validated): void {
                DoctorSchedule::query()
                    ->where('day_of_week', $date->dayOfWeek)
                    ->lockForUpdate()
                    ->first();

                if (! $this->slotAvailability->canBookAppointment(
                    $date,
                    $validated['appointment_time'],
                    $appointment->treatment,
                    lock: true,
                    ignoreAppointmentId: $appointment->getKey(),
                )) {
                    throw new SlotUnavailable;
                }

                $appointment->update([
                    'appointment_date' => $date->toDateString(),
                    'appointment_time' => CarbonImmutable::parse($validated['appointment_time'])->format('H:i:s'),
                ]);
            }, attempts: 3);
        } catch (SlotUnavailable) {
            return redirect()
                ->route('patient.appointments.reschedule', $appointment)
                ->with('error', 'That time slot is no longer available. Please pick another one.');
        }

        return redirect()
            ->route('patient.dashboard')
            ->with('status', 'Your appointment was moved to '.$appointment->refresh()->dateLabel().' at '.$appointment->timeLabel().'.');
    }

    /**
     * Printable digital receipt for a completed appointment, reusing the
     * same print layout as the admin receipt.
     */
    public function receipt(Request $request, Appointment $appointment): View|RedirectResponse
    {
        $appointment = $this->ownedAppointment($request, $appointment)->loadMissing('treatment');

        if ($appointment->status !== AppointmentStatus::Completed) {
            return redirect()->route('patient.dashboard')
                ->with('error', 'Digital receipts become available once the appointment is completed.');
        }

        return view('admin.receipts.show', [
            'appointment' => $appointment,
            'settings' => array_merge(Setting::defaults(), Setting::allKeyed()),
            'backUrl' => route('patient.dashboard'),
            'backLabel' => 'Back to my dashboard',
        ]);
    }

    /**
     * Only appointments linked to the signed-in patient account are visible.
     */
    protected function ownedAppointment(Request $request, Appointment $appointment): Appointment
    {
        abort_unless(
            $appointment->patient_id !== null && $appointment->patient_id === $request->user('patient')->id,
            404,
        );

        return $appointment;
    }
}
