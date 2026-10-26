<?php

use App\Enums\AppointmentStatus;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('finds a booking with the reference and phone number', function () {
    $booking = makeGuestBooking([
        'patient_name' => 'Mona Saleh',
        'patient_phone' => '+964 770 123 4567',
    ]);

    $this->post(route('appointment.lookup.find'), [
        'reference' => $booking->reference,
        'phone' => '+964 770 123 4567',
    ])->assertRedirect(route('appointment.lookup', [
        'reference' => $booking->reference,
        'phone' => '+964 770 123 4567',
    ]));

    $this->get(route('appointment.lookup', [
        'reference' => $booking->reference,
        'phone' => '+964 770 123 4567',
    ]))
        ->assertOk()
        ->assertSee($booking->reference)
        ->assertSee('Mona Saleh')
        ->assertSee('General Checkup')
        ->assertSee('Cancel this appointment');
});

it('matches the phone number digit-by-digit regardless of formatting', function () {
    $booking = makeGuestBooking(['patient_phone' => '+964 770 123 4567']);

    $this->post(route('appointment.lookup.find'), [
        'reference' => strtolower($booking->reference), // "apt-00001" is accepted too
        'phone' => '+9647701234567',
    ])->assertRedirect(route('appointment.lookup', [
        'reference' => $booking->reference,
        'phone' => '+9647701234567',
    ]));

    $this->get(route('appointment.lookup', [
        'reference' => $booking->reference,
        'phone' => '+9647701234567',
    ]))->assertOk()->assertSee('General Checkup');
});

it('rejects a lookup with the wrong phone number', function () {
    $booking = makeGuestBooking(['patient_phone' => '+964 770 123 4567']);

    $this->post(route('appointment.lookup.find'), [
        'reference' => $booking->reference,
        'phone' => '+964 700 000 0000',
    ])->assertSessionHasErrors('reference');
});

it('rejects a malformed reference', function () {
    makeGuestBooking(['patient_phone' => '+964 770 123 4567']);

    $this->post(route('appointment.lookup.find'), [
        'reference' => 'NOT-A-REFERENCE',
        'phone' => '+964 770 123 4567',
    ])->assertSessionHasErrors('reference');
});

it('shows a friendly "no booking found" message for a failed direct lookup', function () {
    makeGuestBooking(['patient_phone' => '+964 770 123 4567']);

    $this->get(route('appointment.lookup', [
        'reference' => 'APT-99999',
        'phone' => '+964 770 123 4567',
    ]))
        ->assertOk()
        ->assertSee('No booking found');
});

it('cancels a guest booking that is more than 4 hours away', function () {
    $booking = makeGuestBooking(['patient_phone' => '+964 770 123 4567']);

    $this->post(route('appointment.lookup.cancel'), [
        'reference' => $booking->reference,
        'phone' => '+964 770 123 4567',
    ])->assertRedirect(route('appointment.lookup', [
        'reference' => $booking->reference,
        'phone' => '+964 770 123 4567',
    ]))->assertSessionHas('status');

    expect($booking->refresh()->status)->toBe(AppointmentStatus::Cancelled);
});

it('refuses to cancel within the 4-hour cutoff', function () {
    $monday = CarbonImmutable::today()->next('monday');
    CarbonImmutable::setTestNow($monday->setTime(12, 0));

    try {
        $booking = makeGuestBooking([
            'patient_phone' => '+964 770 123 4567',
            'appointment_date' => $monday->toDateString(),
            'appointment_time' => '15:00', // only 3 hours away
        ]);

        $this->post(route('appointment.lookup.cancel'), [
            'reference' => $booking->reference,
            'phone' => '+964 770 123 4567',
        ])->assertSessionHas('error');

        expect($booking->refresh()->status)->toBe(AppointmentStatus::Confirmed);
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('refuses to cancel a completed appointment from the lookup page', function () {
    $booking = makeGuestBooking([
        'patient_phone' => '+964 770 123 4567',
        'status' => AppointmentStatus::Completed,
    ]);

    $this->post(route('appointment.lookup.cancel'), [
        'reference' => $booking->reference,
        'phone' => '+964 770 123 4567',
    ])->assertSessionHas('error');

    expect($booking->refresh()->status)->toBe(AppointmentStatus::Completed);
});

it('shows the closed-for-changes notice for a cancelled booking', function () {
    $booking = makeGuestBooking([
        'patient_phone' => '+964 770 123 4567',
        'status' => AppointmentStatus::Cancelled,
    ]);

    $this->get(route('appointment.lookup', [
        'reference' => $booking->reference,
        'phone' => '+964 770 123 4567',
    ]))
        ->assertOk()
        ->assertSee('Online changes are closed for this visit')
        ->assertDontSee('Cancel this appointment');
});
