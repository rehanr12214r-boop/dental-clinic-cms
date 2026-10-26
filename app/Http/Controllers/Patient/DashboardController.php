<?php

namespace App\Http\Controllers\Patient;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * The patient portal home: upcoming visits with a live countdown, past
     * treatment history with digital receipts, and headline stats.
     */
    public function index(Request $request): View
    {
        /** @var Patient $patient */
        $patient = $request->user('patient');

        $patient->claimGuestAppointments();

        $appointments = $patient->appointments()
            ->with('treatment:id,name,duration_minutes,cost')
            ->get();

        $upcoming = $appointments
            ->filter(static fn (Appointment $appointment): bool => $appointment->isUpcoming())
            ->sortBy(static fn (Appointment $appointment) => $appointment->startsAt())
            ->values();

        $past = $appointments
            ->reject(static fn (Appointment $appointment): bool => $appointment->isUpcoming())
            ->sortByDesc(static fn (Appointment $appointment) => $appointment->startsAt())
            ->values();

        return view('patient.dashboard', [
            'patient' => $patient,
            'upcomingAppointments' => $upcoming,
            'pastAppointments' => $past,
            'cutoffHours' => Appointment::CANCELLATION_CUTOFF_HOURS,
            'stats' => [
                'upcoming' => $upcoming->count(),
                'completed' => $appointments->where('status', AppointmentStatus::Completed)->count(),
                'total_paid' => $appointments
                    ->where('status', AppointmentStatus::Completed)
                    ->sum(static fn (Appointment $appointment): float => (float) ($appointment->treatment?->cost ?? 0)),
            ],
        ]);
    }
}
