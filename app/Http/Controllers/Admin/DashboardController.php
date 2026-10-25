<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Throwable;

class DashboardController extends Controller
{
    /**
     * Appointments overview (main admin dashboard):
     * stats bar, newest bookings (regardless of date) and the day's list.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d'],
            'status' => ['nullable', 'string', 'max:32'],
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        // The app timezone is the clinic's wall clock, so today() reflects the
        // date the receptionist is actually working in — not the UTC date.
        // createFromFormat keeps the selected day as a date-only value, avoiding
        // any time component leaking in from the query string.
        $date = isset($validated['date'])
            ? CarbonImmutable::createFromFormat('!Y-m-d', $validated['date'])
            : CarbonImmutable::today();
        $status = AppointmentStatus::tryFrom((string) ($validated['status'] ?? ''));
        $search = (string) ($validated['q'] ?? '');

        $payload = [
            'date' => $date,
            'status' => $status,
            'search' => $search,
            'statuses' => AppointmentStatus::cases(),
        ];

        try {
            $appointments = Appointment::query()
                ->where('appointment_date', $date->toDateString())
                ->when($status !== null, fn (Builder $query) => $query->where('status', $status->value))
                ->when($search !== '', fn (Builder $query) => $query->where(
                    fn (Builder $inner) => $this->applySearch($inner, $search)
                ))
                ->with(['treatment', 'patient:id,name,email'])
                ->orderBy('appointment_time')
                ->orderBy('patient_name')
                ->get();

            // A single grouped query keeps the stats correct even if a legacy
            // row ever contains an unexpected status string.
            $statusCounts = Appointment::query()
                ->where('appointment_date', $date->toDateString())
                ->selectRaw('status, COUNT(*) as aggregate')
                ->groupBy('status')
                ->pluck('aggregate', 'status');

            $revenue = Appointment::query()
                ->where('appointment_date', $date->toDateString())
                // Patients who arrived in the clinic (or finished) are the
                // revenue of that day; pending/confirmed/cancelled bookings are not.
                ->whereIn('status', [AppointmentStatus::InClinic->value, AppointmentStatus::Completed->value])
                ->join('treatments', 'treatments.id', '=', 'appointments.treatment_id')
                ->sum('treatments.cost');

            $stats = [
                'total' => (int) $statusCounts->sum(),
                'pending' => (int) $statusCounts->get(AppointmentStatus::Pending->value, 0),
                'confirmed' => (int) $statusCounts->get(AppointmentStatus::Confirmed->value, 0),
                'completed' => (int) $statusCounts->get(AppointmentStatus::Completed->value, 0),
                'revenue' => '$'.number_format((float) $revenue, 2),
            ];

            // Newest bookings are shown irrespective of the selected date.
            // This is what makes a portal booking visible the instant it is
            // created, even when it is for a future date.
            $latestBookings = Appointment::query()
                ->with(['treatment', 'patient:id,name,email'])
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit(5)
                ->get();

            $upcomingCount = Appointment::query()
                ->where('appointment_date', '>=', CarbonImmutable::today()->toDateString())
                ->where('status', '!=', AppointmentStatus::Cancelled->value)
                ->count();

            $nextAppointmentDate = Appointment::query()
                ->where('appointment_date', '>', $date->toDateString())
                ->where('status', '!=', AppointmentStatus::Cancelled->value)
                ->min('appointment_date');
        } catch (Throwable $exception) {
            report($exception);

            return view('admin.dashboard', array_merge($payload, [
                'appointments' => collect(),
                'latestBookings' => collect(),
                'stats' => null,
                'upcomingCount' => 0,
                'nextAppointmentDate' => null,
                'queryError' => 'We could not load appointments right now. The error has been logged — please refresh the page or try again.',
            ]));
        }

        return view('admin.dashboard', array_merge($payload, [
            'appointments' => $appointments,
            'latestBookings' => $latestBookings,
            'stats' => $stats,
            'upcomingCount' => $upcomingCount,
            'nextAppointmentDate' => $nextAppointmentDate === null
                ? null
                : CarbonImmutable::parse($nextAppointmentDate),
            'queryError' => null,
        ]));
    }

    /**
     * Match a patient by name, phone, or public booking reference.
     */
    private function applySearch(Builder $query, string $search): void
    {
        $query
            ->where('patient_name', 'like', "%{$search}%")
            ->orWhere('patient_phone', 'like', "%{$search}%");

        if (preg_match('/^APT-(\d+)$/i', trim($search), $matches) === 1) {
            $query->orWhere('id', (int) $matches[1]);
        }
    }
}
