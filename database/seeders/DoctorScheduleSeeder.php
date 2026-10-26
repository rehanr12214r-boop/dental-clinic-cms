<?php

namespace Database\Seeders;

use App\Models\DoctorSchedule;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Seed the default doctor working schedule: Monday to Saturday from
     * 5:00 PM to 9:00 PM in 30-minute slots, with Sunday as a day off.
     */
    public function run(): void
    {
        foreach (range(0, 6) as $dayOfWeek) {
            DoctorSchedule::query()->updateOrCreate(
                ['day_of_week' => $dayOfWeek],
                [
                    'start_time' => '17:00',
                    'end_time' => '21:00',
                    'slot_duration_minutes' => 30,
                    'is_day_off' => $dayOfWeek === 0,
                ],
            );
        }
    }
}
