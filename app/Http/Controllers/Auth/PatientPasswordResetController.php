<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PatientPasswordResetController extends Controller
{
    /**
     * Ask for the account email to send a reset link to.
     */
    public function requestForm(): View
    {
        return view('patient.auth.forgot-password');
    }

    /**
     * Email a single-use password reset link. The route is rate limited and
     * the broker itself also throttles repeated requests per account.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $validated['email'] = mb_strtolower(trim($validated['email']));

        $status = Password::broker('patients')->sendResetLink($validated);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }

    /**
     * Show the reset form for a valid token.
     */
    public function resetForm(Request $request, string $token): View
    {
        return view('patient.auth.reset-password', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ]);
    }

    /**
     * Validate the token and store the new, strong password.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => is_string($request->input('email')) ? mb_strtolower(trim($request->input('email'))) : $request->input('email'),
        ]);

        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => [
                'required',
                'string',
                'confirmed',
                PasswordRule::min(8)->letters()->numbers()->symbols()->max(255),
            ],
        ]);

        /** @var Patient|null $resetPatient */
        $resetPatient = null;

        $status = Password::broker('patients')->reset(
            $validated,
            function (Patient $patient, string $password) use (&$resetPatient): void {
                $patient->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                $resetPatient = $patient;

                event(new PasswordReset($patient));
            },
        );

        if ($status !== Password::PASSWORD_RESET || $resetPatient === null) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        }

        Auth::guard('patient')->login($resetPatient);
        $request->session()->regenerate();

        return redirect()
            ->route('patient.dashboard')
            ->with('status', 'Your password has been reset. You are now signed in.');
    }
}
