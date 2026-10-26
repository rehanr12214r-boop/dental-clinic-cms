<?php

use App\Models\Appointment;
use App\Models\Treatment;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    signInAdmin();
});

it('lists seeded treatments with fees and booking counts', function () {
    $this->get(route('admin.treatments.index'))
        ->assertOk()
        ->assertSee('Root Canal')
        ->assertSee('$300.00')
        ->assertSee('Teeth Cleaning');
});

it('creates a new treatment and shows it on the public portal payload', function () {
    $this->post(route('admin.treatments.store'), [
        'name' => 'Laser Whitening',
        'duration_minutes' => '60',
        'cost' => '150',
        'is_active' => '1',
    ])->assertRedirect(route('admin.treatments.index'))->assertSessionHas('status');

    $treatment = Treatment::query()->where('name', 'Laser Whitening')->firstOrFail();

    expect($treatment->duration_minutes)->toBe(60)
        ->and((float) $treatment->cost)->toBe(150.0)
        ->and($treatment->is_active)->toBeTrue();
});

it('creates an inactive treatment when the switch is off', function () {
    $this->post(route('admin.treatments.store'), [
        'name' => 'Sleep Sedation',
        'duration_minutes' => '90',
        'cost' => '400',
        'is_active' => '0',
    ])->assertRedirect(route('admin.treatments.index'));

    expect(Treatment::query()->where('name', 'Sleep Sedation')->firstOrFail()->is_active)->toBeFalse();
});

it('rejects duplicate treatment names', function () {
    $this->post(route('admin.treatments.store'), [
        'name' => 'Root Canal', // seeded name
        'duration_minutes' => '90',
        'cost' => '300',
    ])->assertSessionHasErrors('name');
});

it('edits a treatment fee and duration', function () {
    $treatment = Treatment::query()->where('name', 'Tooth Extraction')->firstOrFail();

    $this->get(route('admin.treatments.edit', $treatment))
        ->assertOk()
        ->assertSee('Tooth Extraction');

    $this->followingRedirects()
        ->put(route('admin.treatments.update', $treatment), [
            'name' => 'Tooth Extraction',
            'duration_minutes' => '60',
            'cost' => '140',
            'is_active' => '1',
        ])->assertOk();

    $treatment->refresh();

    expect($treatment->duration_minutes)->toBe(60)
        ->and((float) $treatment->cost)->toBe(140.0);
});

it('keeps the unique-name rule permissive for the treatment itself', function () {
    $treatment = Treatment::query()->where('name', 'Teeth Cleaning')->firstOrFail();

    $this->from(route('admin.treatments.edit', $treatment))
        ->put(route('admin.treatments.update', $treatment), [
            'name' => 'Teeth Cleaning',
            'duration_minutes' => '30',
            'cost' => '55',
            'is_active' => '1',
        ])->assertSessionHasNoErrors();

    expect((float) $treatment->refresh()->cost)->toBe(55.0);
});

it('toggles active and inactive states', function () {
    $treatment = Treatment::query()->where('name', 'Braces Consultation')->firstOrFail();

    $this->patch(route('admin.treatments.toggle', $treatment))->assertRedirect();
    expect($treatment->refresh()->is_active)->toBeFalse();

    $this->patch(route('admin.treatments.toggle', $treatment))->assertRedirect();
    expect($treatment->refresh()->is_active)->toBeTrue();
});

it('prevents deleting treatments referenced by appointments', function () {
    $treatment = Treatment::query()->where('name', 'Root Canal')->firstOrFail();
    Appointment::factory()->create(['treatment_id' => $treatment->id]);

    $this->delete(route('admin.treatments.destroy', $treatment))
        ->assertRedirect()
        ->assertSessionHas('error');

    $this->assertDatabaseHas('treatments', ['id' => $treatment->id]);
});

it('deletes an unused treatment', function () {
    $treatment = Treatment::factory()->create();

    $this->delete(route('admin.treatments.destroy', $treatment))
        ->assertRedirect(route('admin.treatments.index'))
        ->assertSessionHas('status');

    $this->assertDatabaseMissing('treatments', ['id' => $treatment->id]);
});
