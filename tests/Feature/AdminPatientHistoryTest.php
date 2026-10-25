<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Treatment;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

/**
 * Create an appointment belonging to the shared history-test patient
 * (same name, age and phone number for every call).
 */
function historyFixtureAppointment(array $attributes = []): Appointment
{
    $treatment = Treatment::query()->where('name', 'Teeth Cleaning')->firstOrFail(); // $50 fee

    return Appointment::factory()->create([
        'patient_name' => 'Hana Ali',
        'patient_phone' => '+964 770 111 2233',
        'patient_age' => 34,
        'treatment_id' => $treatment->id,
        'appointment_date' => '2026-10-05',
        'appointment_time' => '18:00',
        'status' => AppointmentStatus::Confirmed,
        ...$attributes,
    ]);
}

it('returns the full appointment history for the same phone number', function () {
    signInAdmin();

    $latest = historyFixtureAppointment();

    historyFixtureAppointment([
        'appointment_date' => '2026-09-07',
        'appointment_time' => '17:00',
        'status' => AppointmentStatus::Completed,
        'notes' => 'Deep cleaning done, no complications.',
    ]);

    historyFixtureAppointment([
        'appointment_date' => '2026-08-10',
        'appointment_time' => '16:30',
        'status' => AppointmentStatus::Cancelled,
    ]);

    // A different patient must never leak into the history.
    Appointment::factory()->create([
        'patient_name' => 'Someone Else',
        'patient_phone' => '+964 999 000 1111',
    ]);

    $this->getJson(route('admin.appointments.history', $latest))
        ->assertOk()
        ->assertJsonCount(3, 'appointments')
        ->assertJsonPath('patient.name', 'Hana Ali')
        ->assertJsonPath('patient.phone', '+964 770 111 2233')
        ->assertJsonPath('patient.age', 34)
        ->assertJsonPath('patient.total_visits', 3)
        ->assertJsonPath('patient.completed_visits', 1)
        ->assertJsonPath('patient.total_spent', '50.00')
        ->assertJsonPath('patient.last_visit', 'Sep 7, 2026')
        // Newest appointment first.
        ->assertJsonPath('appointments.0.date_iso', '2026-10-05')
        ->assertJsonPath('appointments.0.status', 'confirmed')
        ->assertJsonPath('appointments.0.badge_class', AppointmentStatus::Confirmed->badgeClass())
        ->assertJsonPath('appointments.1.notes', 'Deep cleaning done, no complications.')
        ->assertJsonPath('appointments.1.cost', '50.00')
        ->assertJsonPath('appointments.2.status', 'cancelled');
});

it('requires authentication to view patient history', function () {
    $appointment = Appointment::factory()->create();

    $this->get(route('admin.appointments.history', $appointment))
        ->assertRedirect(route('login'));
});
