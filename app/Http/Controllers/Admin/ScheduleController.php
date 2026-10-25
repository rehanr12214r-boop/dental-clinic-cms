<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Day names keyed by Carbon day-of-week (0 = Sunday).
     */
    protected const WEEKDAYS = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];

    /**
     * Show the editable weekly working schedule (one card per day).
     */
    public function index(): View
    {
        $schedules = DoctorSchedule::query()
            ->orderBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');

        $weekdays = array_map(
            static fn (int $day, string $label): array => ['day' => $day, 'label' => $label],
            array_keys(self::WEEKDAYS),
            self::WEEKDAYS,
        );

        return view('admin.schedule', [
            'schedules' => $schedules,
            'weekdays' => $weekdays,
            'slotOptions' => [15, 20, 30, 45, 60],
        ]);
    }

    /**
     * Save the weekly schedule: start/end times, slot durations and days off.
     */
    public function update(Request $request): RedirectResponse
    {
        $schedules = $request->input('schedules', []);

        // Normalize the submitted times to "HH:MM" before validating.
        $normalized = [];
        foreach ($schedules as $dayOfWeek => $schedule) {
            $schedule['start_time'] = $this->normalizeTime($schedule['start_time'] ?? null);
            $schedule['end_time'] = $this->normalizeTime($schedule['end_time'] ?? null);
            $normalized[$dayOfWeek] = $schedule;
        }
        $request->merge(['schedules' => $normalized]);

        $rules = [];
        foreach ($schedules as $dayOfWeek => $schedule) {
            $isDayOff = ! empty($normalized[$dayOfWeek]['is_day_off']);

            $rules["schedules.$dayOfWeek.slot_duration_minutes"] = ['required', 'integer', 'min:5', 'max:240'];
            $rules["schedules.$dayOfWeek.is_day_off"] = ['nullable', 'boolean'];

            if (! $isDayOff) {
                $rules["schedules.$dayOfWeek.start_time"] = ['required', 'date_format:H:i'];
                $rules["schedules.$dayOfWeek.end_time"] = [
                    'required',
                    'date_format:H:i',
                    "after:schedules.$dayOfWeek.start_time",
                ];
            }
        }

        $request->validate($rules);

        foreach ($normalized as $dayOfWeek => $schedule) {
            // Days off may have empty time inputs; fall back to the clinic
            // defaults so the schedule rows always store valid times.
            DoctorSchedule::query()->updateOrCreate(
                ['day_of_week' => (int) $dayOfWeek],
                [
                    'start_time' => $schedule['start_time'] !== '' ? $schedule['start_time'] : '17:00',
                    'end_time' => $schedule['end_time'] !== '' ? $schedule['end_time'] : '21:00',
                    'slot_duration_minutes' => (int) ($schedule['slot_duration_minutes'] ?? 30),
                    'is_day_off' => $request->boolean("schedules.$dayOfWeek.is_day_off"),
                ],
            );
        }

        return back()->with('status', 'Doctor schedule updated.');
    }

    /**
     * Normalize "17:00", "5:00", "17:00:00" … to "HH:MM"; anything else is
     * left untouched so the date_format validation rejects it cleanly.
     */
    protected function normalizeTime(mixed $value): string
    {
        return is_string($value) && preg_match('/^(\d{1,2}):(\d{2})(?::\d{2})?$/', trim($value), $matches) === 1
            ? sprintf('%02d:%02d', $matches[1], $matches[2])
            : (string) $value;
    }
}
