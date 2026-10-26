<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Treatment;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    signInPatient();
});

it('shows a same-day portal booking on the admin dashboard immediately', function () {
    $monday = CarbonImmutable::today()->next('monday');

    CarbonImmutable::setTestNow($monday->setTime(10, 0));

    try {
        $treatment = Treatment::query()->where('name', 'General Checkup')->firstOrFail();

        $this->postJson(route('appointments.store'), [
            'patient_name' => 'Portal Patient',
            'patient_phone' => '+964 770 123 4567',
            'patient_age' => 30,
            'treatment_id' => $treatment->id,
            'appointment_date' => $monday->toDateString(),
            'appointment_time' => '17:00',
        ])->assertCreated();

        $this->assertDatabaseHas('appointments', [
            'patient_name' => 'Portal Patient',
            'appointment_date' => $monday->toDateString(),
            'patient_phone' => '+964 770 123 4567',
            'status' => AppointmentStatus::Pending->value,
        ]);

        signInAdmin();

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Portal Patient')
            ->assertSee('General Checkup')
            ->assertSee('APT-00001');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('keeps a future-date portal booking visible in the latest list and global appointments table', function () {
    $monday = CarbonImmutable::today()->next('monday');

    CarbonImmutable::setTestNow($monday->setTime(10, 0));

    try {
        $treatment = Treatment::query()->where('name', 'General Checkup')->firstOrFail();
        $futureDate = $monday->addDays(3);

        $this->postJson(route('appointments.store'), [
            'patient_name' => 'Future Patient',
            'patient_phone' => '+964 770 123 4567',
            'patient_age' => 30,
            'treatment_id' => $treatment->id,
            'appointment_date' => $futureDate->toDateString(),
            'appointment_time' => '17:00',
        ])->assertCreated();

        signInAdmin();

        // The day view is correctly empty for today, but it must not look like
        // a database failure: the latest-booking panel and the upcoming hint
        // make the booking visible immediately.
        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Latest bookings')
            ->assertSee('Future Patient')
            ->assertSee('APT-00001')
            ->assertSee('upcoming appointment')
            ->assertSee('Next booking:');

        $this->get(route('admin.appointments.index', ['period' => 'all']))
            ->assertOk()
            ->assertSee('Future Patient')
            ->assertSee('APT-00001')
            ->assertSee($futureDate->format('D, M j, Y'));

        $this->get(route('admin.appointments.index', ['period' => 'all', 'q' => 'APT-00001']))
            ->assertOk()
            ->assertSee('Future Patient');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('only links a booking to the signed-in patient when the phone matches their account', function () {
    $monday = CarbonImmutable::today()->next('monday');

    CarbonImmutable::setTestNow($monday->setTime(10, 0));

    try {
        $treatment = Treatment::query()->where('name', 'General Checkup')->firstOrFail();

        $patient = signInPatient(Patient::factory()->create([
            'phone' => '+964 770 123 4567',
        ]));

        $this->postJson(route('appointments.store'), [
            'patient_name' => 'Account Owner',
            'patient_phone' => '+964 770 123 4567',
            'patient_age' => 30,
            'treatment_id' => $treatment->id,
            'appointment_date' => $monday->toDateString(),
            'appointment_time' => '17:00',
        ])->assertCreated();

        $this->postJson(route('appointments.store'), [
            'patient_name' => 'Different Phone',
            'patient_phone' => '+964 750 999 8888',
            'patient_age' => 30,
            'treatment_id' => $treatment->id,
            'appointment_date' => $monday->toDateString(),
            'appointment_time' => '17:30',
        ])->assertCreated();

        expect(Appointment::query()->where('patient_name', 'Account Owner')->value('patient_id'))
            ->toBe($patient->id)
            ->and(Appointment::query()->where('patient_name', 'Different Phone')->value('patient_id'))
            ->toBeNull();
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('defaults the admin dashboard to the clinic-local date around UTC midnight', function () {
    // 21:30 UTC on October 25 is already 00:30 on October 26 in Baghdad.
    CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-10-25 21:30:00', 'UTC'));

    try {
        $treatment = Treatment::query()->where('name', 'General Checkup')->firstOrFail();

        $this->postJson(route('appointments.store'), [
            'patient_name' => 'Late Night Patient',
            'patient_phone' => '+964 770 123 4567',
            'patient_age' => 30,
            'treatment_id' => $treatment->id,
            'appointment_date' => '2026-10-26',
            'appointment_time' => '17:00',
        ])->assertCreated();

        signInAdmin();

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Monday, October 26, 2026')
            ->assertSee('Late Night Patient');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('shows a system error state instead of a fake empty day when the query fails', function () {
    signInAdmin();

    Schema::rename('appointments', 'appointments_backup');

    try {
        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Appointments could not be loaded')
            ->assertDontSee('No appointments for');
    } finally {
        Schema::rename('appointments_backup', 'appointments');
    }
});
