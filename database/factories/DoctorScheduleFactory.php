<?php

namespace Database\Factories;

use App\Models\DoctorSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DoctorSchedule>
 */
class DoctorScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Note: there is one schedule row per weekday, so tests should pass an
     * explicit `day_of_week` to avoid clashes.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day_of_week' => fake()->numberBetween(0, 6),
            'start_time' => fake()->randomElement(['09:00', '12:00', '17:00']),
            'end_time' => '21:00',
            'slot_duration_minutes' => 30,
            'is_day_off' => false,
        ];
    }

    /**
     * Evening working hours (5:00 PM – 9:00 PM).
     */
    public function eveningShift(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => '17:00',
            'end_time' => '21:00',
            'slot_duration_minutes' => 30,
        ]);
    }

    /**
     * Indicate that the doctor is off on this weekday.
     */
    public function dayOff(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_day_off' => true,
        ]);
    }
}
