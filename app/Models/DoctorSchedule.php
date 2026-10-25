<?php

namespace App\Models;

use Database\Factories\DoctorScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    /** @use HasFactory<DoctorScheduleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration_minutes',
        'is_day_off',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * start_time / end_time stay as raw "HH:MM(:SS)" strings; the slot
     * availability service combines them with the date being booked.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_day_off' => 'boolean',
        ];
    }
}
