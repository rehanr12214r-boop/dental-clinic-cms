<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppointmentLookupController extends Controller
{
    /**
     * Guest appointment lookup: enter the booking reference plus the phone
     * number used at booking to see the status, or cancel a visit.
     */
    public function show(Request $request): View
    {
        $reference = (string) $request->query('reference', '');
        $phone = (string) $request->query('phone', '');

        $appointment = null;
        $lookupAttempted = $reference !== '' && $phone !== '';

        if ($lookupAttempted) {
            $appointment = $this->findAppointment($reference, $phone);
        }

        return view('appointment-lookup', [
            'appointment' => $appointment,
            'reference' => $reference,
            'phone' => $phone,
            'lookupAttempted' => $lookupAttempted,
            'cutoffHours' => Appointment::CANCELLATION_CUTOFF_HOURS,
        ]);
    }

    /**
     * Validate the submitted credentials and hand off to the result view.
     */
    public function lookup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:32'],
        ]);

        if ($this->findAppointment($validated['reference'], $validated['phone']) === null) {
            return back()
                ->withInput()
                ->withErrors(['reference' => 'No appointment matches that reference and phone number. Please check both and try again.']);
        }

        return redirect()->route('appointment.lookup', [
            'reference' => strtoupper(trim($validated['reference'])),
            'phone' => $validated['phone'],
        ]);
    }

    /**
     * Cancel a guest booking when it is still more than the cutoff window
     * (4 hours) ahead.
     */
    public function cancel(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:32'],
        ]);

        $appointment = $this->findAppointment($validated['reference'], $validated['phone']);

        if ($appointment === null) {
            return redirect()->route('appointment.lookup')
                ->with('error', 'No appointment matches that reference and phone number.');
        }

        if (! $appointment->isCancellable()) {
            return redirect()
                ->route('appointment.lookup', ['reference' => $appointment->reference, 'phone' => $validated['phone']])
                ->with('error', 'This appointment can no longer be cancelled online — online changes close '.Appointment::CANCELLATION_CUTOFF_HOURS.' hours before the visit. Please call the clinic instead.');
        }

        $appointment->update(['status' => AppointmentStatus::Cancelled]);

        return redirect()
            ->route('appointment.lookup', ['reference' => $appointment->reference, 'phone' => $validated['phone']])
            ->with('status', 'Your appointment on '.$appointment->dateLabel().' at '.$appointment->timeLabel().' has been cancelled. The slot is free for other patients.');
    }

    /**
     * Resolve "APT-00042" + phone to an appointment, or null when either the
     * reference format or the phone number does not match.
     */
    protected function findAppointment(string $reference, string $phone): ?Appointment
    {
        if (preg_match('/^APT-(\d+)$/i', trim($reference), $matches) !== 1) {
            return null;
        }

        /** @var Appointment|null $appointment */
        $appointment = Appointment::query()->with('treatment')->find((int) $matches[1]);

        if ($appointment === null) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if ($digits === '' || $digits !== (preg_replace('/\D+/', '', (string) $appointment->patient_phone) ?? '')) {
            return null;
        }

        return $appointment;
    }
}
