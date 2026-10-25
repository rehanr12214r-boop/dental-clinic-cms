<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\Setting;
use App\Models\Treatment;
use App\Services\SlotAvailabilityService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private readonly SlotAvailabilityService $slotAvailability) {}

    /**
     * The public landing page: hero, doctor bio, featured treatments, how it
     * works, reviews and the clinic location & hours block.
     */
    public function index(): View
    {
        $featuredTreatments = Treatment::query()
            ->active()
            ->featured()
            ->orderBy('cost')
            ->limit(6)
            ->get();

        if ($featuredTreatments->isEmpty()) {
            $featuredTreatments = Treatment::query()->active()->orderBy('cost')->limit(6)->get();
        }

        return view('home', [
            'featuredTreatments' => $featuredTreatments,
            'weeklySchedule' => $this->weeklySchedule(),
            'openStatus' => $this->openStatus(),
            'stats' => [
                'happy_patients' => Setting::get(Setting::StatHappyPatients),
                'years_experience' => Setting::get(Setting::StatYearsExperience),
                'treatments' => Treatment::query()->active()->count(),
                'visits_completed' => Appointment::query()->where('status', AppointmentStatus::Completed->value)->count(),
            ],
        ]);
    }

    /**
     * All seven weekdays with their working hours, flagging today.
     *
     * @return list<array{day: string, hours: string, is_today: bool, is_open_day: bool}>
     */
    protected function weeklySchedule(): array
    {
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $today = CarbonImmutable::now()->dayOfWeek;

        /** @var array<int, DoctorSchedule> $schedules */
        $schedules = DoctorSchedule::query()->get()->keyBy('day_of_week')->all();

        $week = [];

        foreach ($dayNames as $dayNumber => $dayName) {
            $schedule = $schedules[$dayNumber] ?? null;

            $isOpenDay = $schedule !== null && ! $schedule->is_day_off;

            $week[] = [
                'day' => $dayName,
                'hours' => $isOpenDay
                    ? CarbonImmutable::parse($schedule->start_time)->format('g:i A').' – '.CarbonImmutable::parse($schedule->end_time)->format('g:i A')
                    : 'Closed',
                'is_today' => $dayNumber === $today,
                'is_open_day' => $isOpenDay,
            ];
        }

        return $week;
    }

    /**
     * Human-readable open/closed status for the clinic right now.
     *
     * @return array{is_open: bool, label: string, detail: string, today_hours: string|null}
     */
    protected function openStatus(): array
    {
        $now = CarbonImmutable::now();
        $schedule = $this->slotAvailability->scheduleForDate($now);

        if ($schedule === null || $schedule->is_day_off) {
            return [
                'is_open' => false,
                'label' => 'Closed today',
                'detail' => "We're back on {$this->nextWorkingDayLabel($now)}.",
                'today_hours' => null,
            ];
        }

        $start = $now->setTimeFromTimeString($schedule->start_time);
        $end = $now->setTimeFromTimeString($schedule->end_time);
        $hours = $start->format('g:i A').' – '.$end->format('g:i A');

        if ($now->between($start, $end)) {
            return [
                'is_open' => true,
                'label' => 'Open now',
                'detail' => "Today's hours: {$hours}",
                'today_hours' => $hours,
            ];
        }

        if ($now->lessThan($start)) {
            return [
                'is_open' => false,
                'label' => 'Closed now',
                'detail' => "Opens today at {$start->format('g:i A')}",
                'today_hours' => $hours,
            ];
        }

        return [
            'is_open' => false,
            'label' => 'Closed now',
            'detail' => "We're back on {$this->nextWorkingDayLabel($now)}.",
            'today_hours' => $hours,
        ];
    }

    /**
     * The next weekday name (within a week) on which the doctor works.
     */
    protected function nextWorkingDayLabel(CarbonImmutable $now): string
    {
        for ($offset = 1; $offset <= 7; $offset++) {
            $candidate = $now->addDays($offset);
            $schedule = $this->slotAvailability->scheduleForDate($candidate);

            if ($schedule !== null && ! $schedule->is_day_off) {
                return $candidate->format('l');
            }
        }

        return 'a working day';
    }
}
