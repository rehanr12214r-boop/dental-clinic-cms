<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePatientProfileRequest;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the patient's profile details form.
     */
    public function edit(Request $request): View
    {
        return view('patient.profile', [
            'patient' => $request->user('patient'),
        ]);
    }

    /**
     * Update the patient's name, phone number and age. The phone number is
     * used to link guest bookings, so changes are re-applied immediately.
     */
    public function update(UpdatePatientProfileRequest $request): RedirectResponse
    {
        /** @var Patient $patient */
        $patient = $request->user('patient');

        $patient->update($request->validated());

        $patient->claimGuestAppointments();

        return back()->with('status', 'Your profile has been updated.');
    }
}
