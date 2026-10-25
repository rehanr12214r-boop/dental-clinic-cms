<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TreatmentSeeder::class,
            DoctorScheduleSeeder::class,
        ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@clinic.com'],
            [
                'name' => 'Clinic Admin',
                // Password is hashed automatically by the "hashed" cast.
                'password' => 'password',
            ],
        );
    }
}
