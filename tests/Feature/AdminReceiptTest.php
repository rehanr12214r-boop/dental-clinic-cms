<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\Treatment;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('renders a print-ready receipt for a completed appointment', function () {
    signInAdmin();

    // The receipt must reflect the live clinic settings.
    Setting::put(Setting::ClinicName, 'Smile Experts Clinic');
    Setting::put(Setting::DoctorName, 'Dr. Lina Haddad');

    $treatment = Treatment::query()->where('name', 'Root Canal')->firstOrFail(); // $300 fee

    $appointment = Appointment::factory()->create([
        'patient_name' => 'Mona Saleh',
        'patient_phone' => '+964 770 123 4567',
        'patient_age' => 29,
        'treatment_id' => $treatment->id,
        'appointment_date' => '2026-10-12',
        'appointment_time' => '17:30',
        'status' => AppointmentStatus::Completed,
    ]);

    $receiptNumber = 'R-'.str_pad((string) $appointment->id, 5, '0', STR_PAD_LEFT);

    $this->get(route('admin.appointments.receipt', $appointment))
        ->assertOk()
        ->assertSee('Smile Experts Clinic')
        ->assertSee('123 Main Street, City Center') // default clinic address
        ->assertSee('Dr. Lina Haddad')
        ->assertSee('Mona Saleh')
        ->assertSee('+964 770 123 4567')
        ->assertSee('29 years old')
        ->assertSee('Root Canal')
        ->assertSee('Oct 12, 2026')
        ->assertSee('5:30 PM')
        ->assertSee('$300.00')
        ->assertSee($receiptNumber)
        ->assertSee('Authorized signature')
        ->assertSee('window.print()', false);
});

it('refuses a receipt until the appointment is completed', function () {
    signInAdmin();

    $appointment = Appointment::factory()->pending()->create();

    $this->get(route('admin.appointments.receipt', $appointment))
        ->assertRedirect(route('admin.dashboard'))
        ->assertSessionHas('error');
});

it('requires authentication to open a receipt', function () {
    $appointment = Appointment::factory()->create([
        'status' => AppointmentStatus::Completed,
    ]);

    $this->get(route('admin.appointments.receipt', $appointment))
        ->assertRedirect(route('login'));
});
