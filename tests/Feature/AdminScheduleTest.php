<?php

use App\Models\DoctorSchedule;
use App\Models\Treatment;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    signInAdmin();
});

/**
 * A complete, valid week payload (Sunday off).
 */
function schedulePayload(): array
{
    $schedules = [];

    foreach (range(0, 6) as $day) {
        $schedules[$day] = [
            'start_time' => '17:00',
            'end_time' => '21:00',
            'slot_duration_minutes' => '30',
            'is_day_off' => $day === 0 ? '1' : '0',
        ];
    }

    return ['schedules' => $schedules];
}

it('shows the schedule editor pre-filled with the seeded week', function () {
    $response = $this->get(route('admin.schedule.index'));

    $response
        ->assertOk()
        ->assertSee('Sunday')
        ->assertSee('Monday')
        ->assertSee('Saturday')
        ->assertSee('17:00')
        ->assertSee('21:00')
        ->assertSee('peer-checked:after:translate-x-4', false)
        ->assertSee('peer-checked:bg-emerald-600', false);

    // Every weekday has a working toggle with an animated knob.
    expect(substr_count($response->getContent(), 'peer-checked:after:translate-x-4'))->toBe(7);
});

it('updates working hours, slot durations and days off', function () {
    $payload = schedulePayload();
    $payload['schedules'][1]['start_time'] = '18:00'; // Monday later start
    $payload['schedules'][5]['slot_duration_minutes'] = '45'; // Friday 45-min slots

    $this->put(route('admin.schedule.update'), $payload)
        ->assertRedirect()
        ->assertSessionHas('status');

    $monday = DoctorSchedule::query()->where('day_of_week', 1)->firstOrFail();
    $friday = DoctorSchedule::query()->where('day_of_week', 5)->firstOrFail();
    $sunday = DoctorSchedule::query()->where('day_of_week', 0)->firstOrFail();

    expect($monday->start_time)->toBe('18:00')
        ->and($monday->end_time)->toBe('21:00')
        ->and($friday->slot_duration_minutes)->toBe(45)
        ->and($sunday->is_day_off)->toBeTrue()
        ->and(DoctorSchedule::query()->count())->toBe(7);
});

it('reopens a previously-off day', function () {
    // Sunday currently seeded as a day off.
    $payload = schedulePayload();
    $payload['schedules'][0]['is_day_off'] = '0';

    $this->put(route('admin.schedule.update'), $payload)->assertRedirect();

    expect(DoctorSchedule::query()->where('day_of_week', 0)->firstOrFail()->is_day_off)->toBeFalse();
});

it('requires open-day times and rejects end before start', function () {
    $payload = schedulePayload();
    $payload['schedules'][1]['start_time'] = '19:00';
    $payload['schedules'][1]['end_time'] = '17:00';

    $this->from(route('admin.schedule.index'))
        ->put(route('admin.schedule.update'), $payload)
        ->assertSessionHasErrors('schedules.1.end_time');

    $payload = schedulePayload();
    unset($payload['schedules'][2]['start_time'], $payload['schedules'][2]['end_time']);

    $this->put(route('admin.schedule.update'), $payload)
        ->assertSessionHasErrors(['schedules.2.start_time', 'schedules.2.end_time']);
});

it('requires sane slot durations', function () {
    $payload = schedulePayload();
    $payload['schedules'][3]['slot_duration_minutes'] = '500';

    $this->put(route('admin.schedule.update'), $payload)
        ->assertSessionHasErrors('schedules.3.slot_duration_minutes');
});

it('applies schedule changes to the public slot API', function () {
    $payload = schedulePayload();
    // Monday 18:00–21:00 in 30-min slots → 6 bookable slots.
    $payload['schedules'][1]['start_time'] = '18:00';
    $payload['schedules'][1]['end_time'] = '21:00';
    $payload['schedules'][1]['is_day_off'] = '0';

    $this->put(route('admin.schedule.update'), $payload)->assertRedirect();

    $checkup = Treatment::query()->where('name', 'General Checkup')->firstOrFail();
    $nextMonday = CarbonImmutable::today()->next('Monday')->toDateString();

    $this->getJson(route('appointments.available-slots', [
        'treatment_id' => $checkup->id,
        'date' => $nextMonday,
    ]))
        ->assertOk()
        ->assertJsonCount(6, 'slots');
});
