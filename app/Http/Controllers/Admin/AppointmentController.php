<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Enums\WhatsAppTemplate;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Setting;
use App\Services\WhatsAppMessageService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    /**
     * Global appointments table: every booking, filterable by period, status
     * and patient. The dashboard itself is intentionally day-scoped, so this
     * is the place where reception can see bookings for any date.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'max:32'],
            'period' => ['nullable', Rule::in(['upcoming', 'today', 'past', 'all'])],
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d'],
        ]);

        $status = AppointmentStatus::tryFrom((string) ($validated['status'] ?? ''));
        $period = (string) ($validated['period'] ?? 'upcoming');
        $search = (string) ($validated['q'] ?? '');
        $today = CarbonImmutable::today();

        $from = isset($validated['from']) ? CarbonImmutable::parse($validated['from']) : null;
        $to = isset($validated['to']) ? CarbonImmutable::parse($validated['to']) : null;

        if ($from !== null && $to !== null && $from->greaterThan($to)) {
            [$from, $to] = [$to, $from];
        }

        $query = Appointment::query()->with(['treatment', 'patient:id,name,email']);

        if ($from !== null || $to !== null) {
            $query->whereBetween('appointment_date', [
                ($from ?? CarbonImmutable::createFromFormat('Y-m-d', '1970-01-01'))->toDateString(),
                ($to ?? $today->addYears(5))->toDateString(),
            ]);
        } else {
            match ($period) {
                'today' => $query->where('appointment_date', $today->toDateString()),
                'past' => $query->where('appointment_date', '<', $today->toDateString()),
                'all' => $query,
                default => $query->where('appointment_date', '>=', $today->toDateString()),
            };
        }

        if ($status !== null) {
            $query->where('status', $status->value);
        }

        if ($search !== '') {
            $query->where(function (Builder $inner) use ($search): void {
                $inner
                    ->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('patient_phone', 'like', "%{$search}%");

                if (preg_match('/^APT-(\d+)$/i', trim($search), $matches) === 1) {
                    $inner->orWhere('id', (int) $matches[1]);
                }
            });
        }

        $ascending = $from === null && $to === null && in_array($period, ['upcoming', 'today'], true);

        $appointments = $query
            ->orderBy('appointment_date', $ascending ? 'asc' : 'desc')
            ->orderBy('appointment_time', $ascending ? 'asc' : 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.appointments.index', [
            'appointments' => $appointments,
            'status' => $status,
            'statuses' => AppointmentStatus::cases(),
            'period' => $period,
            'search' => $search,
            'from' => $from,
            'to' => $to,
            'today' => $today,
        ]);
    }

    /**
     * One-click status update (Confirm, Check-In, Complete, Cancel, Reopen).
     */
    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(AppointmentStatus::class)],
        ]);

        $status = AppointmentStatus::from($validated['status']);
        $appointment->update(['status' => $status]);

        return back()->with(
            'status',
            "{$appointment->patient_name}'s appointment on {$appointment->dateLabel()} was changed to {$status->label()}."
        );
    }

    /**
     * Save (optional) doctor/staff clinical notes for an appointment.
     */
    public function updateNotes(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $appointment->update($validated);

        return back()->with('status', "Notes saved for {$appointment->patient_name}.");
    }

    /**
     * Send one of the configured WhatsApp templates directly via Whapi.cloud.
     */
    public function sendWhatsApp(
        Request $request,
        Appointment $appointment,
        WhatsAppMessageService $whatsapp,
    ): JsonResponse {
        $validated = $request->validate([
            'template' => ['required', Rule::enum(WhatsAppTemplate::class)],
        ]);

        $template = WhatsAppTemplate::from($validated['template']);

        if ($whatsapp->send($appointment, $template)) {
            return response()->json([
                'success' => true,
                'message' => 'WhatsApp message sent successfully via Whapi!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $whatsapp->lastError() ?? 'The WhatsApp message could not be sent.',
        ], 422);
    }

    /**
     * The patient's appointment history (all bookings made with the same
     * phone number), consumed by the dashboard history modal.
     */
    public function history(Appointment $appointment): JsonResponse
    {
        $appointments = Appointment::query()
            ->where('patient_phone', $appointment->patient_phone)
            ->with('treatment')
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        $completed = $appointments->where('status', AppointmentStatus::Completed);
        $lastVisit = $completed->first() ?? $appointments->first();

        return response()->json([
            'patient' => [
                'name' => $appointment->patient_name,
                'phone' => $appointment->patient_phone,
                'age' => $appointment->patient_age,
                'total_visits' => $appointments->count(),
                'completed_visits' => $completed->count(),
                'total_spent' => number_format(
                    (float) $completed->sum(fn (Appointment $visit): float => (float) ($visit->treatment?->cost ?? 0)),
                    2,
                    '.',
                    '',
                ),
                'last_visit' => $lastVisit?->dateLabel('M j, Y'),
            ],
            'appointments' => $appointments->map(fn (Appointment $visit): array => [
                'date_iso' => $visit->appointment_date?->toDateString(),
                'date' => $visit->dateLabel('M j, Y'),
                'time' => $visit->timeLabel(),
                'treatment' => $visit->treatment?->name,
                'duration_minutes' => $visit->treatment?->duration_minutes,
                'cost' => number_format((float) ($visit->treatment?->cost ?? 0), 2, '.', ''),
                'status' => $visit->status->value,
                'status_label' => $visit->status->label(),
                'badge_class' => $visit->status->badgeClass(),
                'notes' => $visit->notes,
            ])->values(),
        ]);
    }

    /**
     * Print-optimised receipt (A4 / thermal) for a completed appointment.
     */
    public function receipt(Appointment $appointment): View|RedirectResponse
    {
        if ($appointment->status !== AppointmentStatus::Completed) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Receipts are available once the appointment is completed.');
        }

        $appointment->loadMissing('treatment');

        return view('admin.receipts.show', [
            'appointment' => $appointment,
            'settings' => array_merge(Setting::defaults(), Setting::allKeyed()),
            'receiptNumber' => 'R-'.str_pad((string) $appointment->id, 5, '0', STR_PAD_LEFT),
            'issuedAt' => CarbonImmutable::now(),
        ]);
    }
}
