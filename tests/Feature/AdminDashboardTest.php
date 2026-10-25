<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Treatment;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    signInAdmin();
});

it('renders the dashboard with today\'s stats and bookings', function () {
    $checkup = Treatment::query()->where('name', 'General Checkup')->first(); // $40 fee
    $day = CarbonImmutable::today()->toDateString();

    Appointment::factory()->pending()->create([
        'treatment_id' => $checkup->id,
        'patient_name' => 'Dana Whitmore',
        'appointment_date' => $day,
        'appointment_time' => '17:00',
    ]);

    // Revenue counts completed + in-clinic appointments only → $40.00.
    Appointment::factory()->create([
        'treatment_id' => $checkup->id,
        'patient_name' => 'Omar Khalil',
        'appointment_date' => $day,
        'appointment_time' => '17:30',
        'status' => AppointmentStatus::Completed,
    ]);

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee("Today's appointments")
        ->assertSee('Revenue today')
        ->assertSee('$40.00')
        ->assertSee('Dana Whitmore')
        ->assertSee('Omar Khalil');
});

it('lists appointments for a filtered date', function () {
    $treatment = Treatment::query()->firstOrFail();
    $monday = CarbonImmutable::today()->next('Monday')->toDateString();

    Appointment::factory()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Laila Hassan',
        'appointment_date' => $monday,
        'appointment_time' => '17:00',
    ]);

    $this->get(route('admin.dashboard', ['date' => $monday]))
        ->assertOk()
        ->assertSee('Appointments')
        ->assertSee('Laila Hassan')
        ->assertSee('wa.me', false); // click-to-WhatsApp link
});

it('opens the selected day from the latest bookings panel with date-scoped stats and appointments', function () {
    $checkup = Treatment::query()->where('name', 'General Checkup')->firstOrFail(); // $40 fee
    $targetDate = CarbonImmutable::today()->addDays(2);
    $otherDate = CarbonImmutable::today()->addDays(3);

    Appointment::factory()->pending()->create([
        'treatment_id' => $checkup->id,
        'patient_name' => 'Selected Pending',
        'appointment_date' => $targetDate->toDateString(),
        'appointment_time' => '17:00',
    ]);

    Appointment::factory()->create([
        'treatment_id' => $checkup->id,
        'patient_name' => 'Selected Confirmed',
        'appointment_date' => $targetDate->toDateString(),
        'appointment_time' => '17:30',
        'status' => AppointmentStatus::Confirmed,
    ]);

    Appointment::factory()->create([
        'treatment_id' => $checkup->id,
        'patient_name' => 'Selected In Clinic',
        'appointment_date' => $targetDate->toDateString(),
        'appointment_time' => '18:00',
        'status' => AppointmentStatus::InClinic,
    ]);

    Appointment::factory()->create([
        'treatment_id' => $checkup->id,
        'patient_name' => 'Selected Completed',
        'appointment_date' => $targetDate->toDateString(),
        'appointment_time' => '18:30',
        'status' => AppointmentStatus::Completed,
    ]);

    Appointment::factory()->pending()->create([
        'treatment_id' => $checkup->id,
        'patient_name' => 'Other Day Patient',
        'appointment_date' => $otherDate->toDateString(),
        'appointment_time' => '17:00',
    ]);

    // The latest-bookings panel links to the appointment's own date.
    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('data-open-day="'.$targetDate->toDateString().'"', false)
        ->assertSee('href="'.route('admin.dashboard', ['date' => $targetDate->toDateString()]).'"', false);

    // Following that link filters the day view, stats and header together.
    $response = $this->get(route('admin.dashboard', ['date' => $targetDate->toDateString()]));

    $response
        ->assertOk()
        ->assertViewHas('date', fn (CarbonImmutable $date): bool => $date->toDateString() === $targetDate->toDateString())
        ->assertViewHas('stats', fn (array $stats): bool => $stats === [
            'total' => 4,
            'pending' => 1,
            'confirmed' => 1,
            'completed' => 1,
            'revenue' => '$80.00',
        ])
        ->assertViewHas('appointments', function ($appointments) use ($targetDate): bool {
            return $appointments->count() === 4
                && $appointments->every(
                    fn (Appointment $appointment): bool => $appointment->appointment_date->toDateString() === $targetDate->toDateString()
                );
        })
        ->assertSee($targetDate->format('l, F j, Y'))
        ->assertSee('value="'.$targetDate->toDateString().'"', false)
        ->assertSee('Selected Pending')
        ->assertSee('Selected Confirmed')
        ->assertSee('Selected In Clinic')
        ->assertSee('Selected Completed')
        ->assertDontSee('Revenue today');
});

it('filters the list by status while keeping full-day stats', function () {
    $treatment = Treatment::query()->firstOrFail();
    $day = CarbonImmutable::today()->toDateString();

    Appointment::factory()->pending()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Zainab Ali',
        'appointment_date' => $day,
        'appointment_time' => '17:00',
    ]);
    Appointment::factory()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Mustafa Noor',
        'appointment_date' => $day,
        'appointment_time' => '18:00',
    ]);

    $response = $this->get(route('admin.dashboard', ['status' => 'pending']));

    $response->assertOk()
        ->assertSee('Zainab Ali')
        ->assertDontSee('Mustafa Noor')
        // Stats bar still counts the whole day (2 appointments).
        ->assertSee('<p class="mt-2 text-2xl font-bold tracking-tight text-amber-700">1</p>', false);
});

it('searches patients by name or phone', function () {
    $treatment = Treatment::query()->firstOrFail();
    $day = CarbonImmutable::today()->toDateString();

    Appointment::factory()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Test Person A',
        'patient_phone' => '+9647701111111',
        'appointment_date' => $day,
        'appointment_time' => '17:00',
    ]);
    Appointment::factory()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Test Person B',
        'patient_phone' => '+9647702222222',
        'appointment_date' => $day,
        'appointment_time' => '18:00',
    ]);

    $this->get(route('admin.dashboard', ['q' => '2222222']))
        ->assertOk()
        ->assertSee('Test Person B')
        ->assertDontSee('Test Person A');

    $this->get(route('admin.dashboard', ['q' => 'Person A']))
        ->assertOk()
        ->assertSee('Test Person A')
        ->assertDontSee('Test Person B');
});

it('shows quick action buttons matching the current status', function () {
    $treatment = Treatment::query()->where('name', 'Teeth Cleaning')->firstOrFail();
    $day = CarbonImmutable::today()->toDateString();

    Appointment::factory()->pending()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Quick Action Tester',
        'appointment_date' => $day,
        'appointment_time' => '17:00',
    ]);

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Confirm')
        ->assertSee('Cancel');
});

it('offers whatsapp quick actions per appointment, with review only for completed visits', function () {
    $treatment = Treatment::query()->where('name', 'Teeth Cleaning')->firstOrFail();
    $day = CarbonImmutable::today()->toDateString();

    $pending = Appointment::factory()->pending()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Wanda Pending',
        'patient_phone' => '+964 770 555 1111',
        'appointment_date' => $day,
        'appointment_time' => '17:00',
    ]);

    $completed = Appointment::factory()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Carla Completed',
        'patient_phone' => '+964 770 555 2222',
        'appointment_date' => $day,
        'appointment_time' => '18:00',
        'status' => AppointmentStatus::Completed,
    ]);

    $response = $this->get(route('admin.dashboard'));

    $response->assertOk();

    $content = $response->getContent();

    // Confirmation + reminder for both rows, review request only for the completed visit.
    expect(substr_count($content, 'Send Confirmation'))->toBe(2)
        ->and(substr_count($content, 'Send Reminder'))->toBe(2)
        ->and(substr_count($content, 'Request Review'))->toBe(1);

    // Every button posts to the background Whapi endpoint with its template.
    $response
        ->assertSee('data-whatsapp-send', false)
        ->assertSee('data-whatsapp-url="'.route('admin.appointments.send-whatsapp', $pending).'"', false)
        ->assertSee('data-whatsapp-url="'.route('admin.appointments.send-whatsapp', $completed).'"', false)
        ->assertSee('data-whatsapp-template="confirmation"', false)
        ->assertSee('data-whatsapp-template="reminder"', false)
        ->assertSee('data-whatsapp-template="review"', false);
});

it('exposes patient history triggers and the history modal', function () {
    $treatment = Treatment::query()->firstOrFail();
    $day = CarbonImmutable::today()->toDateString();

    $appointment = Appointment::factory()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'History Trigger',
        'appointment_date' => $day,
        'appointment_time' => '17:00',
    ]);

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('id="patient-history-modal"', false)
        ->assertSee('data-history-url="'.route('admin.appointments.history', $appointment).'"', false);
});

it('shows a print receipt button only for completed appointments', function () {
    $treatment = Treatment::query()->firstOrFail();
    $day = CarbonImmutable::today()->toDateString();

    $completed = Appointment::factory()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Receipt Ready',
        'appointment_date' => $day,
        'appointment_time' => '17:00',
        'status' => AppointmentStatus::Completed,
    ]);

    $pending = Appointment::factory()->pending()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'No Receipt Yet',
        'appointment_date' => $day,
        'appointment_time' => '18:00',
    ]);

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Print receipt')
        ->assertSee(route('admin.appointments.receipt', $completed), false)
        ->assertDontSee(route('admin.appointments.receipt', $pending), false);
});

it('shows a dedicated empty state when filters exclude everything', function () {
    $treatment = Treatment::query()->firstOrFail();
    $day = CarbonImmutable::today()->toDateString();

    Appointment::factory()->create([
        'treatment_id' => $treatment->id,
        'patient_name' => 'Only Patient',
        'appointment_date' => $day,
        'appointment_time' => '17:00',
    ]);

    $this->get(route('admin.dashboard', ['q' => 'zzz-no-match']))
        ->assertOk()
        ->assertSee('No appointments match your filters')
        ->assertSee('Clear filters')
        ->assertDontSee('Only Patient');
});

it('shows an empty state when the selected date has no appointments', function () {
    $farFuture = CarbonImmutable::today()->addMonths(2)->toDateString();

    $this->get(route('admin.dashboard', ['date' => $farFuture]))
        ->assertOk()
        ->assertSee('No appointments for');
});

it('rejects an invalid date filter', function () {
    $this->get(route('admin.dashboard', ['date' => 'not-a-date']))
        ->assertSessionHasErrors('date');
});
