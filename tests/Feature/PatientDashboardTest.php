<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Treatment;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);

    $this->monday = CarbonImmutable::today()->next('monday');
});

it('shows upcoming appointments with a live countdown and actions', function () {
    $patient = signInPatient();
    $booking = makeGuestBooking([
        'patient_id' => $patient->id,
        'patient_name' => $patient->name,
        'patient_phone' => $patient->phone,
    ]);

    $this->get(route('patient.dashboard'))
        ->assertOk()
        ->assertSee('General Checkup')
        ->assertSee('data-countdown-to', false)
        ->assertSee($booking->reference)
        ->assertSee('30 min')
        ->assertSee('$40.00')
        ->assertSee('Reschedule')
        ->assertSee('Cancel');
});

it('shows completed visits with a digital receipt link', function () {
    $patient = signInPatient();
    $booking = makeGuestBooking([
        'patient_id' => $patient->id,
        'status' => AppointmentStatus::Completed,
        'appointment_date' => CarbonImmutable::today()->subWeek()->toDateString(),
    ]);

    $this->get(route('patient.dashboard'))
        ->assertOk()
        ->assertSee('Treatment history')
        ->assertSee('Receipt')
        ->assertSee(route('patient.appointments.receipt', $booking));
});

it('shows welcoming empty states without appointments', function () {
    signInPatient();

    $this->get(route('patient.dashboard'))
        ->assertOk()
        ->assertSee('No upcoming appointments')
        ->assertSee('Your visit history is empty');
});

it('cancels an upcoming appointment when it is more than 4 hours away', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $patient = signInPatient();
        $booking = makeGuestBooking([
            'patient_id' => $patient->id,
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '19:00', // 7 hours away
        ]);

        $this->post(route('patient.appointments.cancel', $booking))
            ->assertSessionHas('status');

        expect($booking->refresh()->status)->toBe(AppointmentStatus::Cancelled);
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('refuses to cancel within the 4-hour cutoff', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $patient = signInPatient();
        $booking = makeGuestBooking([
            'patient_id' => $patient->id,
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '15:00', // only 3 hours away
        ]);

        $this->post(route('patient.appointments.cancel', $booking))
            ->assertSessionHas('error');

        expect($booking->refresh()->status)->toBe(AppointmentStatus::Confirmed);
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('refuses to cancel a completed appointment', function () {
    $patient = signInPatient();
    $booking = makeGuestBooking([
        'patient_id' => $patient->id,
        'status' => AppointmentStatus::Completed,
    ]);

    $this->post(route('patient.appointments.cancel', $booking))
        ->assertSessionHas('error');

    expect($booking->refresh()->status)->toBe(AppointmentStatus::Completed);
});

it('reschedules an appointment to a free slot', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $patient = signInPatient();
        $booking = makeGuestBooking([
            'patient_id' => $patient->id,
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '19:00',
        ]);

        $this->patch(route('patient.appointments.reschedule.update', $booking), [
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '20:00',
        ])
            ->assertRedirect(route('patient.dashboard'))
            ->assertSessionHas('status');

        expect($booking->refresh()->timeLabel())->toBe('8:00 PM');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('can reschedule into its own current slot (self-conflict ignored)', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $patient = signInPatient();
        $booking = makeGuestBooking([
            'patient_id' => $patient->id,
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '19:00',
        ]);

        $this->patch(route('patient.appointments.reschedule.update', $booking), [
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '19:00',
        ])
            ->assertRedirect(route('patient.dashboard'))
            ->assertSessionHas('status');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('refuses to reschedule onto a slot booked by someone else', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $patient = signInPatient();
        $booking = makeGuestBooking([
            'patient_id' => $patient->id,
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '19:00',
        ]);

        makeGuestBooking([
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '20:00',
        ]);

        $this->patch(route('patient.appointments.reschedule.update', $booking), [
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '20:00',
        ])
            ->assertRedirect(route('patient.appointments.reschedule', $booking))
            ->assertSessionHas('error');

        expect($booking->refresh()->timeLabel())->toBe('7:00 PM');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('refuses to open or submit a reschedule within the cutoff', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $patient = signInPatient();
        $booking = makeGuestBooking([
            'patient_id' => $patient->id,
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '15:00',
        ]);

        $this->get(route('patient.appointments.reschedule', $booking))
            ->assertRedirect(route('patient.dashboard'))
            ->assertSessionHas('error');

        $this->patch(route('patient.appointments.reschedule.update', $booking), [
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '19:00',
        ])
            ->assertRedirect(route('patient.dashboard'))
            ->assertSessionHas('error');

        expect($booking->refresh()->timeLabel())->toBe('3:00 PM');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('lists reschedule slots while ignoring the appointment being moved', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $patient = signInPatient();
        $booking = makeGuestBooking([
            'patient_id' => $patient->id,
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '19:00',
        ]);

        $response = $this->getJson(route('patient.appointments.slots', [
            'appointment' => $booking,
            'date' => $this->monday->toDateString(),
        ]));

        $response->assertOk()
            ->assertJsonPath('available_count', 8);

        $slots = collect($response->json('slots'));

        expect($slots->firstWhere('time', '19:00')['available'])->toBeTrue();
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('forbids the slots endpoint within the cutoff', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $patient = signInPatient();
        $booking = makeGuestBooking([
            'patient_id' => $patient->id,
            'appointment_date' => $this->monday->toDateString(),
            'appointment_time' => '15:00',
        ]);

        $this->getJson(route('patient.appointments.slots', [
            'appointment' => $booking,
            'date' => $this->monday->toDateString(),
        ]))->assertForbidden();
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('cannot touch another patient\'s appointment', function () {
    $owner = signInPatient();
    $booking = makeGuestBooking(['patient_id' => $owner->id]);

    $other = Patient::factory()->create();
    $this->actingAs($other, 'patient');

    $this->post(route('patient.appointments.cancel', $booking))->assertNotFound();
    $this->get(route('patient.appointments.receipt', $booking))->assertNotFound();
    $this->get(route('patient.appointments.reschedule', $booking))->assertNotFound();

    expect($booking->refresh()->status)->toBe(AppointmentStatus::Confirmed);
});

it('shows a printable digital receipt for a completed visit', function () {
    $patient = signInPatient();
    $booking = makeGuestBooking([
        'patient_id' => $patient->id,
        'patient_name' => 'Mona Saleh',
        'status' => AppointmentStatus::Completed,
    ]);

    $this->get(route('patient.appointments.receipt', $booking))
        ->assertOk()
        ->assertSee('Authorized signature')
        ->assertSee('Back to my dashboard')
        ->assertSee('Mona Saleh')
        ->assertSee('window.print()', false);
});

it('refuses a digital receipt until the visit is completed', function () {
    $patient = signInPatient();
    $booking = makeGuestBooking(['patient_id' => $patient->id]);

    $this->get(route('patient.appointments.receipt', $booking))
        ->assertRedirect(route('patient.dashboard'))
        ->assertSessionHas('error');
});

it('updates the patient profile', function () {
    $patient = signInPatient();

    $this->patch(route('patient.profile.update'), [
        'name' => 'Saima Updated',
        'phone' => '+964 750 000 1111',
        'age' => 34,
    ])->assertSessionHas('status');

    expect($patient->refresh()->name)->toBe('Saima Updated')
        ->and($patient->phone)->toBe('+964 750 000 1111')
        ->and($patient->age)->toBe(34);
});

it('validates the patient profile', function () {
    signInPatient();

    $this->patch(route('patient.profile.update'), [
        'name' => '',
        'phone' => '',
        'age' => 999,
    ])->assertSessionHasErrors(['name', 'phone', 'age']);
});

it('claims guest bookings by phone number when visiting the dashboard', function () {
    $patient = signInPatient(Patient::factory()->create(['phone' => '+964 770 123 4567']));

    $booking = makeGuestBooking(['patient_phone' => '+9647701234567']);

    $this->get(route('patient.dashboard'))
        ->assertOk()
        ->assertSee('General Checkup');

    expect($booking->refresh()->patient_id)->toBe($patient->id);
});

it('links bookings made while signed in to the patient account', function () {
    $patient = signInPatient(Patient::factory()->create([
        'phone' => '+964 770 123 4567',
    ]));

    $this->postJson(route('appointments.store'), [
        'treatment_id' => Treatment::query()->where('name', 'General Checkup')->value('id'),
        'appointment_date' => $this->monday->toDateString(),
        'appointment_time' => '17:00',
        'patient_name' => 'Saima Ali',
        'patient_phone' => '+964 770 123 4567',
        'patient_age' => 30,
    ])->assertCreated();

    $booking = Appointment::query()->latest('id')->firstOrFail();

    expect($booking->patient_id)->toBe($patient->id)
        ->and($booking->appointment_date->toDateString())->toBe($this->monday->toDateString())
        ->and($booking->timeLabel())->toBe('5:00 PM');
});

it('prefills the booking form for signed-in patients', function () {
    signInPatient(Patient::factory()->create([
        'name' => 'Saima Ali',
        'phone' => '+964 700 111 2222',
        'age' => 32,
    ]));

    $this->get(route('book'))
        ->assertOk()
        ->assertSee('Booking as')
        ->assertSee('Saima Ali')
        ->assertSee('+964 700 111 2222');
});
