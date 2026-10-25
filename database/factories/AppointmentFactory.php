<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Treatment;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * By default appointments are booked on the seeded evening schedule
     * (Monday–Saturday, 5:00 PM – 9:00 PM), aligned to 30-minute slots.
     * Tests that rely on the exact slot usually override the date and time.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = CarbonImmutable::tomorrow()
            ->addDays(fake()->numberBetween(0, 21))
            ->setTime(fake()->numberBetween(17, 20), fake()->randomElement([0, 30]));

        return [
            'patient_name' => fake()->name(),
            'patient_phone' => fake()->e164PhoneNumber(),
            'patient_age' => fake()->numberBetween(5, 85),
            'treatment_id' => Treatment::factory(),
            'appointment_date' => $startsAt->toDateString(),
            'appointment_time' => $startsAt->format('H:i'),
            'status' => AppointmentStatus::Confirmed,
            'notes' => null,
        ];
    }

    /**
     * Indicate that the appointment was cancelled (its slot is free again).
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Cancelled,
        ]);
    }

    /**
     * Indicate that the appointment is still pending confirmation.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Pending,
        ]);
    }
}
