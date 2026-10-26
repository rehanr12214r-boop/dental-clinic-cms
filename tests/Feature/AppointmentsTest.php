<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Treatment;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);

    $this->checkup = Treatment::query()->where('name', 'General Checkup')->first();
    $this->rootCanal = Treatment::query()->where('name', 'Root Canal')->first();

    $this->monday = CarbonImmutable::today()->next('monday');
    $this->sunday = CarbonImmutable::today()->next('sunday');

    $this->patient = signInPatient();
});

it('renders the booking page with the seeded treatments and working hours', function () {
    $this->get(route('book'))
        ->assertOk()
        ->assertSee('Teeth Cleaning')
        ->assertSee('Root Canal')
        ->assertSee('General Checkup')
        ->assertSee('Tooth Extraction')
        ->assertSee('Braces Consultation')
        ->assertSee('5:00 PM – 9:00 PM');
});

it('returns no slots on a day off (Sunday)', function () {
    $this->getJson(route('appointments.available-slots', [
        'treatment_id' => $this->checkup->id,
        'date' => $this->sunday->toDateString(),
    ]))
        ->assertOk()
        ->assertJsonPath('day_off', true)
        ->assertJsonPath('slots', []);
});

it('returns all evening slots for a working day', function () {
    $response = $this->getJson(route('appointments.available-slots', [
        'treatment_id' => $this->checkup->id,
        'date' => $this->monday->toDateString(),
    ]));

    $response->assertOk();

    $slots = $response->json('slots');

    expect($slots)->toHaveCount(8)
        ->and(array_column($slots, 'time'))->toBe([
            '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30',
        ])
        ->and($response->json('available_count'))->toBe(8);
});

it('marks passed slots of the current day as unavailable', function () {
    // Freeze "now" into the evening so early slots are already over.
    CarbonImmutable::setTestNow($this->monday->setTime(18, 15));

    try {
        $slots = collect($this->getJson(route('appointments.available-slots', [
            'treatment_id' => $this->checkup->id,
            'date' => $this->monday->toDateString(),
        ]))->json('slots'));

        expect($slots->firstWhere('time', '18:00')['available'])->toBeFalse()
            ->and($slots->firstWhere('time', '18:30')['available'])->toBeTrue();
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('fills only the slots a long treatment fits into', function () {
    $slots = collect($this->getJson(route('appointments.available-slots', [
        'treatment_id' => $this->rootCanal->id, // 90 minutes
        'date' => $this->monday->toDateString(),
    ]))->json('slots'));

    // A 90-minute treatment cannot start later than 19:30.
    expect($slots->firstWhere('time', '19:30')['available'])->toBeTrue()
        ->and($slots->firstWhere('time', '20:00')['available'])->toBeFalse()
        ->and($slots->firstWhere('time', '20:30')['available'])->toBeFalse();
});

it('excludes booked appointments from the available slots', function () {
    Appointment::factory()->create([
        'treatment_id' => $this->checkup->id,
        'appointment_date' => $this->monday->toDateString(),
        'appointment_time' => '17:30',
        'status' => AppointmentStatus::Confirmed,
    ]);

    $slots = collect($this->getJson(route('appointments.available-slots', [
        'treatment_id' => $this->checkup->id,
        'date' => $this->monday->toDateString(),
    ]))->json('slots'));

    // Back-to-back is fine: a 17:30–18:00 booking leaves 17:00 and 18:00 open.
    expect($slots->firstWhere('time', '17:00')['available'])->toBeTrue()
        ->and($slots->firstWhere('time', '17:30')['available'])->toBeFalse()
        ->and($slots->firstWhere('time', '18:00')['available'])->toBeTrue();
});

it('blocks the whole interval of a booked long treatment', function () {
    Appointment::factory()->create([
        'treatment_id' => $this->rootCanal->id, // 17:00 – 18:30
        'appointment_date' => $this->monday->toDateString(),
        'appointment_time' => '17:00',
        'status' => AppointmentStatus::Confirmed,
    ]);

    $slots = collect($this->getJson(route('appointments.available-slots', [
        'treatment_id' => $this->checkup->id,
        'date' => $this->monday->toDateString(),
    ]))->json('slots'));

    expect($slots->firstWhere('time', '17:00')['available'])->toBeFalse()
        ->and($slots->firstWhere('time', '17:30')['available'])->toBeFalse()
        ->and($slots->firstWhere('time', '18:00')['available'])->toBeFalse()
        ->and($slots->firstWhere('time', '18:30')['available'])->toBeTrue();
});

it('stores a new booking and returns its confirmation', function () {
    $this->postJson(route('appointments.store'), validBooking())
        ->assertCreated()
        ->assertJsonPath('message', 'Your appointment has been booked successfully. We look forward to seeing you!')
        ->assertJsonPath('appointment.treatment.name', 'Root Canal')
        ->assertJsonPath('appointment.status', 'pending');

    assertBooked(validBooking());
});

it('prevents double-booking the same date and time slot', function () {
    Appointment::factory()->create([
        'treatment_id' => $this->checkup->id,
        'appointment_date' => $this->monday->toDateString(),
        'appointment_time' => '17:30',
        'status' => AppointmentStatus::Confirmed,
    ]);

    $this->postJson(route('appointments.store'), validBooking())
        ->assertStatus(409)
        ->assertJsonPath('message', 'This time slot is no longer available. Please pick another one.');

    $this->assertDatabaseCount('appointments', 1);
});

it('prevents booking a slot that overlaps a long treatment', function () {
    Appointment::factory()->create([
        'treatment_id' => $this->rootCanal->id, // 17:00 – 18:30
        'appointment_date' => $this->monday->toDateString(),
        'appointment_time' => '17:00',
        'status' => AppointmentStatus::Confirmed,
    ]);

    // A 30-minute treatment in the middle of the long one must be refused.
    $this->postJson(route('appointments.store'), [
        ...validBooking(),
        'treatment_id' => $this->checkup->id,
        'appointment_time' => '18:00',
    ])->assertStatus(409);
});

it('frees the slot of a cancelled appointment', function () {
    Appointment::factory()->cancelled()->create([
        'treatment_id' => $this->checkup->id,
        'appointment_date' => $this->monday->toDateString(),
        'appointment_time' => '17:30',
    ]);

    $this->postJson(route('appointments.store'), validBooking())->assertCreated();
});

it('rejects slots that are not on the schedule grid', function () {
    $this->postJson(route('appointments.store'), [
        ...validBooking(),
        'appointment_time' => '17:15',
    ])->assertStatus(409);
});

it('validates the booking form', function () {
    $this->postJson(route('appointments.store'), [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['patient_name', 'patient_phone', 'patient_age', 'treatment_id', 'appointment_date', 'appointment_time'])
        ->assertJsonCount(6, 'errors');
});

it('rejects an invalid WhatsApp phone number', function () {
    $this->postJson(route('appointments.store'), [
        ...validBooking(),
        'patient_phone' => '123', // too short / not phone-shaped
    ])->assertUnprocessable()->assertJsonValidationErrors(['patient_phone']);
});

it('rejects booking dates in the past or outside the booking window', function () {
    $this->postJson(route('appointments.store'), [
        ...validBooking(),
        'appointment_date' => CarbonImmutable::today()->subDay()->toDateString(),
    ])->assertUnprocessable()->assertJsonValidationErrors(['appointment_date']);

    $this->postJson(route('appointments.store'), [
        ...validBooking(),
        'appointment_date' => CarbonImmutable::today()->addDays(61)->toDateString(),
    ])->assertUnprocessable()->assertJsonValidationErrors(['appointment_date']);
});

it('rejects inactive treatments', function () {
    $inactive = Treatment::factory()->inactive()->create(['name' => 'Old Cleaning Procedure']);

    $this->postJson(route('appointments.store'), [
        ...validBooking(),
        'treatment_id' => $inactive->id,
    ])->assertUnprocessable()->assertJsonValidationErrors(['treatment_id']);
});

it('rejects unauthenticated appointment creation', function () {
    auth('patient')->logout();
    auth('web')->logout();

    $this->postJson(route('appointments.store'), validBooking())
        ->assertUnauthorized();
});

it('disables submit button and shows login prompt for guest users', function () {
    auth('patient')->logout();
    auth('web')->logout();

    $this->get(route('book', ['service' => 'general-checkup']))
        ->assertOk()
        ->assertSee('disabled', false)
        ->assertSee('Please log in');
});

/**
 * A complete, valid booking payload for Monday 5:30 PM.
 *
 * @return array<string, mixed>
 */
function validBooking(): array
{
    $today = CarbonImmutable::today();

    return [
        'patient_name' => 'Ali Hassan',
        'patient_phone' => '+964 770 123 4567',
        'patient_age' => 27,
        'treatment_id' => Treatment::query()->where('name', 'Root Canal')->firstOrFail()->id,
        'appointment_date' => $today->next('monday')->toDateString(),
        'appointment_time' => '17:30',
        'notes' => 'Sensitivity on the upper left molar.',
    ];
}

/**
 * Assert the booking above was persisted (status is always pending).
 *
 * @param  array<string, mixed>  $booking
 */
function assertBooked(array $booking): void
{
    $today = CarbonImmutable::today();

    test()->assertDatabaseHas('appointments', [
        'patient_name' => $booking['patient_name'],
        'patient_phone' => $booking['patient_phone'],
        'patient_age' => $booking['patient_age'],
        'treatment_id' => $booking['treatment_id'],
        'appointment_date' => $today->next('monday')->toDateString(),
        'appointment_time' => '17:30:00',
        'status' => 'pending',
    ]);
}
