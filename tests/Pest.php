<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Sign in the seeded admin (admin@clinic.com) for the current test.
 */
function signInAdmin(): void
{
    test()->actingAs(
        User::query()->where('email', 'admin@clinic.com')->firstOrFail(),
    );
}

/**
 * Sign a patient account (created when none is given) in for the current test.
 */
function signInPatient(?Patient $patient = null): Patient
{
    $patient ??= Patient::factory()->create();

    test()->actingAs($patient, 'patient');

    return $patient;
}

/**
 * Create a guest appointment on the next Monday evening (well outside the
 * 4-hour cancellation cutoff), seeded General Checkup by default.
 *
 * @param  array<string, mixed>  $overrides
 */
function makeGuestBooking(array $overrides = []): Appointment
{
    $treatment = Treatment::query()->where('name', 'General Checkup')->firstOrFail();
    $monday = CarbonImmutable::today()->next('monday');

    return Appointment::factory()->create(array_merge([
        'treatment_id' => $treatment->id,
        'appointment_date' => $monday->toDateString(),
        'appointment_time' => '17:00',
        'status' => AppointmentStatus::Confirmed,
    ], $overrides));
}
