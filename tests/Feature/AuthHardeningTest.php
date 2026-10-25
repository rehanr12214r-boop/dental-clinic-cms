<?php

use App\Models\Patient;
use App\Notifications\PatientResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

/**
 * A complete patient registration payload.
 *
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function authHardeningRegistrationPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Saima Ali',
        'email' => 'saima@example.com',
        'phone' => '+964 770 123 4567',
        'age' => 32,
        'password' => 'Secure-pass1!',
        'password_confirmation' => 'Secure-pass1!',
    ], $overrides);
}

it('rejects weak passwords during registration', function (string $password) {
    $this->post(route('patient.register.store'), authHardeningRegistrationPayload([
        'password' => $password,
        'password_confirmation' => $password,
    ]))->assertSessionHasErrors('password');

    $this->assertDatabaseMissing('patients', ['email' => 'saima@example.com']);
})->with([
    'too short' => 'Ab1!',
    'no number' => 'Secret-pass!',
    'no symbol' => 'Secretpass1',
    'no letter' => '12345678!',
]);

it('rejects malformed, dummy and out-of-range phone numbers', function (string $phone) {
    $this->post(route('patient.register.store'), authHardeningRegistrationPayload(['phone' => $phone]))
        ->assertSessionHasErrors('phone');

    $this->assertDatabaseCount('patients', 0);
})->with([
    'too short' => '12345',
    'too long' => '+964 770 123 4567 890',
    'contains letters' => '+964 770 ABC 4567',
    'all zeros' => '0000000000',
    'sequential dummy' => '1234567890',
    'leading zero after plus' => '+0123 456 789',
]);

it('accepts local and international phone formats', function (string $phone) {
    $this->post(route('patient.register.store'), authHardeningRegistrationPayload(['phone' => $phone]))
        ->assertRedirect(route('patient.dashboard'));

    expect(Patient::query()->where('email', 'saima@example.com')->value('phone'))->toBe($phone);
})->with([
    'international' => '+964 770 123 4567',
    'parentheses and dashes' => '+964 (770) 123-4567',
    'local digits' => '0770 123 4567',
]);

it('rejects malformed, missing and duplicate emails', function () {
    $this->post(route('patient.register.store'), authHardeningRegistrationPayload(['email' => 'not-an-email']))
        ->assertSessionHasErrors('email');

    Patient::factory()->create(['email' => 'taken@example.com']);

    $this->post(route('patient.register.store'), authHardeningRegistrationPayload(['email' => 'TAKEN@example.com']))
        ->assertSessionHasErrors('email');

    $this->assertDatabaseCount('patients', 1);
});

it('normalizes email casing for login and registration', function () {
    $this->post(route('patient.register.store'), authHardeningRegistrationPayload(['email' => 'SAIMA@Example.COM']))
        ->assertRedirect(route('patient.dashboard'));

    $this->post(route('patient.logout'));

    $this->post(route('patient.login.authenticate'), [
        'email' => 'Saima@Example.com',
        'password' => 'Secure-pass1!',
    ])->assertRedirect(route('patient.dashboard'));

    $this->assertAuthenticated('patient');
});

it('rate limits patient login attempts', function () {
    Patient::factory()->create([
        'email' => 'rate-limited@example.com',
        'password' => 'Secure-pass1!',
    ]);

    for ($attempt = 1; $attempt <= 6; $attempt++) {
        $this->post(route('patient.login.authenticate'), [
            'email' => 'rate-limited@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    $this->post(route('patient.login.authenticate'), [
        'email' => 'rate-limited@example.com',
        'password' => 'wrong-password',
    ])->assertStatus(429);

    $this->assertGuest('patient');
});

it('rate limits patient registration attempts', function () {
    for ($attempt = 1; $attempt <= 6; $attempt++) {
        $this->post(route('patient.register.store'), authHardeningRegistrationPayload([
            'email' => "attempt-{$attempt}@example.com",
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ]))->assertSessionHasErrors('password');
    }

    $this->post(route('patient.register.store'), authHardeningRegistrationPayload([
        'email' => 'attempt-7@example.com',
    ]))->assertStatus(429);
});

it('rate limits admin login attempts', function () {
    for ($attempt = 1; $attempt <= 6; $attempt++) {
        $this->post(route('login.authenticate'), [
            'email' => 'admin@clinic.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    $this->post(route('login.authenticate'), [
        'email' => 'admin@clinic.com',
        'password' => 'wrong-password',
    ])->assertStatus(429);

    $this->assertGuest();
});

it('renders the patient password reset pages', function () {
    $this->get(route('patient.password.request'))
        ->assertOk()
        ->assertSee('Forgot your password?');

    $this->get(route('patient.password.reset', ['token' => 'test-token']))
        ->assertOk()
        ->assertSee('Choose a new password')
        ->assertSee('test-token');
});

it('sends a password reset link and resets the password', function () {
    Notification::fake();

    $patient = Patient::factory()->create([
        'email' => 'reset-me@example.com',
        'password' => 'Old-pass1!',
    ]);

    $this->post(route('patient.password.email'), ['email' => 'RESET-ME@example.com'])
        ->assertRedirect()
        ->assertSessionHas('status');

    $token = null;

    Notification::assertSentTo(
        $patient,
        PatientResetPassword::class,
        function (PatientResetPassword $notification) use (&$token, $patient): bool {
            $token = $notification->token;

            expect($notification->toMail($patient)->actionUrl)
                ->toContain('/patient/reset-password/'.$token);

            return true;
        },
    );

    expect($token)->not->toBeNull();

    $this->post(route('patient.password.store'), [
        'token' => $token,
        'email' => 'reset-me@example.com',
        'password' => 'Brand-new2!',
        'password_confirmation' => 'Brand-new2!',
    ])->assertRedirect(route('patient.dashboard'));

    $this->assertAuthenticatedAs($patient->refresh(), 'patient');
    expect(Hash::check('Brand-new2!', $patient->password))->toBeTrue();

    $this->assertDatabaseMissing('password_reset_tokens', ['email' => 'reset-me@example.com']);
});

it('rejects a weak password during reset', function () {
    $patient = Patient::factory()->create(['email' => 'reset-me@example.com']);
    $token = Password::broker('patients')->createToken($patient);

    $this->post(route('patient.password.store'), [
        'token' => $token,
        'email' => 'reset-me@example.com',
        'password' => 'weakpassword',
        'password_confirmation' => 'weakpassword',
    ])->assertSessionHasErrors('password');

    expect(Hash::check('weakpassword', $patient->refresh()->password))->toBeFalse();
});

it('does not reveal whether an email has a patient account', function () {
    Notification::fake();

    $this->post(route('patient.password.email'), ['email' => 'nobody@example.com'])
        ->assertSessionHasErrors('email');

    Notification::assertNothingSent();
});

it('rate limits password reset requests', function () {
    Notification::fake();

    for ($attempt = 1; $attempt <= 6; $attempt++) {
        $this->post(route('patient.password.email'), [
            'email' => "nobody-{$attempt}@example.com",
        ]);
    }

    $this->post(route('patient.password.email'), ['email' => 'nobody-7@example.com'])
        ->assertStatus(429);
});

it('keeps the admin and patient guards isolated', function () {
    signInPatient();

    // actingAs() switches the default guard for the test request; reset it
    // to the web guard, exactly as a real browser session would behave.
    $this->app['auth']->shouldUse('web');

    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));

    // Sign the patient out of their own guard before checking the reverse.
    Auth::guard('patient')->logout();

    signInAdmin();

    $this->get(route('patient.dashboard'))->assertRedirect(route('patient.login'));
});
