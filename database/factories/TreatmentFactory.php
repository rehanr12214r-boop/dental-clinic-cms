<?php

namespace Database\Factories;

use App\Models\Treatment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Treatment>
 */
class TreatmentFactory extends Factory
{
    /**
     * Sample treatment names that never collide with the ones the
     * TreatmentSeeder plants; generated names stay unique among
     * treatments already stored in the database.
     */
    public function definition(): array
    {
        $baseNames = [
            'Teeth Whitening',
            'Dental Implant',
            'Gum Treatment',
            'Fissure Sealant',
            'Emergency Filling',
            'Wisdom Tooth Removal',
            'Crowns And Bridges',
            'Dentures',
            'Fluoride Application',
            'Periodontal Scaling',
            'Root Planing',
            'Cosmetic Bonding',
            'Smile Makeover',
            'Night Guard Fitting',
        ];

        $taken = Treatment::query()->pluck('name')->all();
        $available = array_values(array_diff($baseNames, $taken));

        return [
            'name' => count($available) > 0
                ? fake()->unique()->randomElement($available)
                : 'Custom Treatment '.fake()->unique()->numberBetween(1000, 999999),
            'duration_minutes' => fake()->randomElement([30, 45, 60, 90, 120]),
            'cost' => fake()->randomFloat(2, 30, 400),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the treatment cannot be booked.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
