<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Treatment;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    signInAdmin();
});

it('updates an appointment status in one click', function () {
    $appointment = Appointment::factory()->pending()->create();

    $this->patch(route('admin.appointments.update-status', $appointment), ['status' => 'confirmed'])
        ->assertRedirect()
        ->assertSessionHas('status');

    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'status' => AppointmentStatus::Confirmed->value,
    ]);
});

it('walks an appointment through the full workflow', function () {
    $appointment = Appointment::factory()->pending()->create();

    $targets = ['confirmed', 'in-clinic', 'completed'];

    foreach ($targets as $target) {
        $this->patch(route('admin.appointments.update-status', $appointment), ['status' => $target])
            ->assertRedirect();
    }

    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'status' => AppointmentStatus::Completed->value,
    ]);
});

it('rejects unknown statuses and keeps the appointment unchanged', function () {
    $appointment = Appointment::factory()->pending()->create();

    $this->patch(route('admin.appointments.update-status', $appointment), ['status' => 'bogus'])
        ->assertSessionHasErrors('status');

    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'status' => AppointmentStatus::Pending->value,
    ]);
});

it('saves doctor and staff notes for an appointment', function () {
    $appointment = Appointment::factory()->create();

    $this->patch(route('admin.appointments.update-notes', $appointment), [
        'notes' => 'Prescribed antibiotics; follow-up in two weeks.',
    ])->assertRedirect()->assertSessionHas('status');

    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'notes' => 'Prescribed antibiotics; follow-up in two weeks.',
    ]);
});

it('clears notes when saved empty', function () {
    $appointment = Appointment::factory()->create(['notes' => 'Old remark']);

    // Note: ConvertEmptyStringsToNull middleware turns "" into NULL.
    $this->patch(route('admin.appointments.update-notes', $appointment), ['notes' => ''])
        ->assertRedirect();

    $this->assertDatabaseHas('appointments', ['id' => $appointment->id, 'notes' => null]);
});

it('shows the status workflow on the dashboard', function () {
    $treatment = Treatment::query()->where('name', 'Teeth Cleaning')->first();
    $day = CarbonImmutable::today()->toDateString();

    $appointment = Appointment::factory()->pending()->create([
        'treatment_id' => $treatment->id,
        'appointment_date' => $day,
        'appointment_time' => '17:00',
    ]);

    // Confirm via the quick action button…
    $this->patch(route('admin.appointments.update-status', $appointment), ['status' => 'confirmed'])
        ->assertRedirect();

    // …and see the colour-coded badge rendered for the new status.
    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('bg-sky-100 text-sky-800 ring-1 ring-sky-600/20', false);
});

it('sends a whatsapp template through the admin ajax endpoint', function () {
    config([
        'services.whatsapp.driver' => 'whapi',
        'services.whatsapp.api_url' => 'https://gate.whapi.cloud/',
        'services.whatsapp.token' => 'test-whapi-token',
    ]);

    Http::fake([
        'gate.whapi.cloud/*' => Http::response(['message' => ['id' => 'wamid.test']], 200),
    ]);

    $appointment = Appointment::factory()->pending()->create([
        'patient_phone' => '+964 770 123 4567',
    ]);

    $this->postJson(route('admin.appointments.send-whatsapp', $appointment), [
        'template' => 'confirmation',
    ])
        ->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'WhatsApp message sent successfully via Whapi!',
        ]);

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://gate.whapi.cloud/messages/text'
            && $request->hasHeader('Authorization', 'Bearer test-whapi-token')
            && $request['to'] === '9647701234567@s.whatsapp.net';
    });
});

it('returns a json error when whapi rejects a whatsapp message', function () {
    config([
        'services.whatsapp.driver' => 'whapi',
        'services.whatsapp.api_url' => 'https://gate.whapi.cloud/',
        'services.whatsapp.token' => 'test-whapi-token',
    ]);

    Http::fake([
        'gate.whapi.cloud/*' => Http::response(['error' => ['message' => 'Invalid or expired token']], 401),
    ]);

    $appointment = Appointment::factory()->pending()->create();

    $this->postJson(route('admin.appointments.send-whatsapp', $appointment), [
        'template' => 'reminder',
    ])
        ->assertUnprocessable()
        ->assertJson([
            'success' => false,
            'message' => 'Invalid or expired token',
        ]);
});

it('rejects an unknown whatsapp template', function () {
    $appointment = Appointment::factory()->pending()->create();

    $this->postJson(route('admin.appointments.send-whatsapp', $appointment), [
        'template' => 'bogus',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('template');

    Http::assertNothingSent();
});
