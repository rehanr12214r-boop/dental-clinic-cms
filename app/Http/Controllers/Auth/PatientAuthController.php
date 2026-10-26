<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PatientLoginRequest;
use App\Http\Requests\Auth\PatientRegisterRequest;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientAuthController extends Controller
{
    /**
     * Show the patient signup form.
     */
    public function showRegister(): View
    {
        return view('patient.auth.register');
    }

    /**
     * Create a patient account, sign in immediately and adopt any guest
     * bookings made with the same phone number.
     */
    public function register(PatientRegisterRequest $request): RedirectResponse
    {
        /** @var array{name: string, email: string, phone: string, age?: int|null, password: string} $validated */
        $validated = $request->validated();

        $patient = Patient::query()->create($validated);

        Auth::guard('patient')->login($patient);
        $request->session()->regenerate();

        $patient->claimGuestAppointments();

        return redirect()
            ->route('patient.dashboard')
            ->with('status', 'Welcome to your patient portal, '.$patient->name.'! Any previous bookings made with this phone number are now linked to your account.');
    }

    /**
     * Show the patient sign-in form.
     */
    public function showLogin(Request $request): View
    {
        if ($request->has('intended') && ! $request->session()->has('url.intended')) {
            $request->session()->put('url.intended', $request->query('intended'));
        }

        return view('patient.auth.login');
    }

    /**
     * Authenticate a patient against the "patient" guard.
     */
    public function authenticate(PatientLoginRequest $request): RedirectResponse
    {
        $credentials = $request->safe()->only(['email', 'password']);

        if (! Auth::guard('patient')->attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'These credentials do not match our records.']);
        }

        $request->session()->regenerate();

        $request->user('patient')?->claimGuestAppointments();

        return redirect()->intended(route('patient.dashboard'));
    }

    /**
     * Sign the patient out without destroying other guards' session data.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('patient')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'You have been signed out.');
    }
}
