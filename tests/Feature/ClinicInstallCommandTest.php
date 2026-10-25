<?php

use App\Models\DoctorSchedule;
use App\Models\Treatment;
use App\Models\User;

it('installs the clinic: migrates, seeds and reports the admin credentials', function () {
    $this->artisan('clinic:install')
        ->expectsOutputToContain('admin@clinic.com')
        ->assertSuccessful();

    expect(User::query()->where('email', 'admin@clinic.com')->exists())->toBeTrue()
        ->and(Treatment::query()->count())->toBe(5)
        ->and(DoctorSchedule::query()->count())->toBeGreaterThan(0);
});
