<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Treatment;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    signInAdmin();
});

/**
 * Deterministic report fixtures:
 * - Alice Completed: today, completed, Teeth Cleaning ($50)
 * - Bob Cancelled: today, cancelled, General Checkup ($40)
 * - Carol Old: 40 days ago, completed, Root Canal ($300) — outside the week.
 *
 * @return array{0: Appointment, 1: Appointment, 2: Appointment}
 */
function reportsScenario(): array
{
    $cleaning = Treatment::query()->where('name', 'Teeth Cleaning')->firstOrFail();
    $checkup = Treatment::query()->where('name', 'General Checkup')->firstOrFail();
    $rootCanal = Treatment::query()->where('name', 'Root Canal')->firstOrFail();

    $today = CarbonImmutable::today()->toDateString();

    $alice = Appointment::factory()->create([
        'treatment_id' => $cleaning->id,
        'patient_name' => 'Alice Completed',
        'patient_phone' => '+964 770 123 0001',
        'appointment_date' => $today,
        'appointment_time' => '17:00',
        'status' => AppointmentStatus::Completed,
        'notes' => 'Patient needs a follow-up, maybe next week.',
    ]);

    $bob = Appointment::factory()->create([
        'treatment_id' => $checkup->id,
        'patient_name' => 'Bob Cancelled',
        'patient_phone' => '+964 770 123 0002',
        'appointment_date' => $today,
        'appointment_time' => '18:00',
        'status' => AppointmentStatus::Cancelled,
    ]);

    $carol = Appointment::factory()->create([
        'treatment_id' => $rootCanal->id,
        'patient_name' => 'Carol Old',
        'patient_phone' => '+964 770 123 0003',
        'appointment_date' => CarbonImmutable::today()->subDays(40)->toDateString(),
        'appointment_time' => '17:30',
        'status' => AppointmentStatus::Completed,
    ]);

    return [$alice, $bob, $carol];
}

it('summarises the current week by default', function () {
    reportsScenario();

    $this->get(route('admin.reports.index'))
        ->assertOk()
        ->assertSee('Reports & analytics')
        ->assertSee('This Week')
        ->assertSee('Alice Completed')
        ->assertSee('Bob Cancelled')
        ->assertDontSee('Carol Old')
        ->assertSee('1 vs 1')          // completed vs cancelled ratio
        ->assertSee('50% completion rate')
        ->assertSee('$50.00')          // revenue: completed $50 only
        ->assertSee('Top treatments');
});

it('filters by a custom range', function () {
    [, , $carol] = reportsScenario();

    $from = CarbonImmutable::today()->subDays(50)->toDateString();
    $to = CarbonImmutable::today()->subDays(30)->toDateString();

    $this->get(route('admin.reports.index', ['range' => 'custom', 'from' => $from, 'to' => $to]))
        ->assertOk()
        ->assertSee('Custom Range')
        ->assertSee('Carol Old')
        ->assertDontSee('Alice Completed')
        ->assertDontSee('Bob Cancelled')
        ->assertSee('$300.00')
        ->assertSee($carol->dateLabel()); // the resolved range includes the visit
});

it('falls back gracefully when custom dates are invalid', function () {
    reportsScenario();

    // Malformed dates fall back to "this month" (which contains today).
    $this->get(route('admin.reports.index', ['range' => 'custom', 'from' => 'not-a-date', 'to' => '2026-99-99']))
        ->assertOk()
        ->assertSee('Alice Completed');
});

it('exports the filtered appointments as a csv download', function () {
    reportsScenario();

    $from = CarbonImmutable::today()->subDay()->toDateString();
    $to = CarbonImmutable::today()->toDateString();

    $response = $this->get(route('admin.reports.export', ['range' => 'custom', 'from' => $from, 'to' => $to]));

    $response->assertOk();
    $response->assertDownload("appointments-{$from}-to-{$to}.csv");

    $raw = $response->streamedContent();

    // Excel-friendly UTF-8 BOM at the start of the file.
    expect($raw)->toStartWith("\u{FEFF}");

    $rows = array_map('str_getcsv', explode("\n", trim(ltrim($raw, "\u{FEFF}"))));

    expect($rows)->toHaveCount(3)
        ->and($rows[0])->toBe(['Patient Name', 'Phone', 'Treatment', 'Date', 'Time', 'Fee', 'Status', 'Doctor Notes'])
        ->and($rows[1])->toBe([
            'Alice Completed',
            '+964 770 123 0001',
            'Teeth Cleaning',
            $to,
            '5:00 PM',
            '50.00',
            'Completed',
            'Patient needs a follow-up, maybe next week.',
        ])
        ->and($rows[2])->toBe([
            'Bob Cancelled',
            '+964 770 123 0002',
            'General Checkup',
            $to,
            '6:00 PM',
            '40.00',
            'Cancelled',
            '',
        ])
        // Carol's visit is outside the exported range.
        ->and($raw)->not->toContain('Carol Old');
});

it('shows an empty state when the range has no appointments', function () {
    $this->get(route('admin.reports.index', [
        'range' => 'custom',
        'from' => '2020-01-01',
        'to' => '2020-02-01',
    ]))
        ->assertOk()
        ->assertSee('No appointments in this range')
        ->assertSee('No treatment activity in this range');
});
