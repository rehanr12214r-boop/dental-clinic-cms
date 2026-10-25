<?php

use App\Models\Patient;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('registers a new patient, signs them in and redirects to the dashboard', function () {
    $response = $this->post(route('patient.register.store'), [
        'name' => 'Saima Ali',
        'email' => 'saima@example.com',
        'phone' => '+964 770 123 4567',
        'age' => 32,
        'password' => 'Secure-pass1!',
        'password_confirmation' => 'Secure-pass1!',
    ]);

    $response->assertRedirect(route('patient.dashboard'))
        ->assertSessionHas('status');

    $patient = Patient::query()->where('email', 'saima@example.com')->firstOrFail();

    expect($patient->name)->toBe('Saima Ali')
        ->and($patient->age)->toBe(32)
        ->and($patient->password)->not->toBe('Secure-pass1!');

    $this->assertAuthenticatedAs($patient, 'patient');
});

it('rejects an email that already has an account', function () {
    Patient::factory()->create(['email' => 'taken@example.com']);

    $this->post(route('patient.register.store'), [
        'name' => 'Someone Else',
        'email' => 'taken@example.com',
        'phone' => '+964 770 000 0000',
        'password' => 'Secure-pass1!',
        'password_confirmation' => 'Secure-pass1!',
    ])->assertSessionHasErrors('email');
});

it('logs a patient in with valid credentials', function () {
    $patient = Patient::factory()->create([
        'email' => 'patient@example.com',
        'password' => 'secret-password',
    ]);

    $this->post(route('patient.login.authenticate'), [
        'email' => 'patient@example.com',
        'password' => 'secret-password',
    ])->assertRedirect(route('patient.dashboard'));

    $this->assertAuthenticatedAs($patient, 'patient');
});

it('rejects invalid login credentials', function () {
    Patient::factory()->create([
        'email' => 'patient@example.com',
        'password' => 'secret-password',
    ]);

    $this->post(route('patient.login.authenticate'), [
        'email' => 'patient@example.com',
        'password' => 'wrong-password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest('patient');
});

it('signs a patient out', function () {
    signInPatient();

    $this->post(route('patient.logout'))->assertRedirect(route('home'));

    $this->assertGuest('patient');
});

it('redirects guests to the patient login page for protected routes', function () {
    $this->get(route('patient.dashboard'))->assertRedirect(route('patient.login'));
    $this->get(route('patient.profile.edit'))->assertRedirect(route('patient.login'));
});

it('redirects a signed-in patient away from the login and register pages', function () {
    signInPatient();

    $this->get(route('patient.login'))->assertRedirect(route('patient.dashboard'));
    $this->get(route('patient.register'))->assertRedirect(route('patient.dashboard'));
});

it('claims guest bookings that used the same phone number on registration', function () {
    $booking = makeGuestBooking(['patient_phone' => '+964 770 123 4567']);

    $this->post(route('patient.register.store'), [
        'name' => 'Saima Ali',
        'email' => 'saima@example.com',
        'phone' => '+9647701234567', // same digits, different formatting
        'password' => 'Secure-pass1!',
        'password_confirmation' => 'Secure-pass1!',
    ])->assertRedirect(route('patient.dashboard'));

    expect($booking->refresh()->patient_id)->not->toBeNull()
        ->and($booking->patient_id)->toBe(Patient::query()->where('email', 'saima@example.com')->value('id'));
});
