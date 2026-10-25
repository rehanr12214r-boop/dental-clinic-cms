<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\Treatment;
use Carbon\CarbonImmutable;
use DateTimeInterface;

class SlotAvailabilityService
{
    /**
     * How many days into the future patients may book an appointment.
     */
    public const BOOKING_WINDOW_DAYS = 60;

    /**
     * Build the bookable time slots for the given date.
     *
     * Slots are derived from the doctor schedule for that weekday. A slot is
     * only marked available when the (optional) treatment still fits inside
     * the working hours, the slot is in the future, and no other active
     * appointment overlaps it (longer treatments may therefore block the
     * following slots as well).
     *
     * @param  bool  $lockBookedAppointments  Lock the date's booked rows (MySQL & co.)
     *                                        while the result is used inside a transaction.
     * @param  int|null  $ignoreAppointmentId  Exclude this appointment from the conflict
     *                                         check (used when rescheduling it).
     * @return list<array{time: string, label: string, available: bool}>
     */
    public function slotsForDate(CarbonImmutable $date, ?Treatment $treatment = null, bool $lockBookedAppointments = false, ?int $ignoreAppointmentId = null): array
    {
        $schedule = $this->scheduleForDate($date);

        if ($schedule === null || $schedule->is_day_off || $date->lessThan(CarbonImmutable::today())) {
            return [];
        }

        $slotMinutes = max(1, (int) $schedule->slot_duration_minutes);
        $treatmentMinutes = (int) ($treatment?->duration_minutes ?? $slotMinutes);

        $startAt = $date->setTimeFromTimeString($schedule->start_time);
        $endAt = $date->setTimeFromTimeString($schedule->end_time);
        $busyIntervals = $this->busyIntervals($date, $lockBookedAppointments, $ignoreAppointmentId);
        $now = CarbonImmutable::now();

        $slots = [];

        for ($cursor = $startAt; $cursor->lessThan($endAt); $cursor = $cursor->addMinutes($slotMinutes)) {
            $available = $cursor->addMinutes($treatmentMinutes)->lessThanOrEqualTo($endAt)
                && $cursor->greaterThanOrEqualTo($now)
                && ! $this->overlapsAnyBusyPeriod($cursor, $cursor->addMinutes($treatmentMinutes), $busyIntervals);

            $slots[] = [
                'time' => $cursor->format('H:i'),
                'label' => $cursor->format('g:i A'),
                'available' => $available,
            ];
        }

        return $slots;
    }

    /**
     * Determine whether a still-free slot can be booked at the given date/time.
     *
     * @param  int|null  $ignoreAppointmentId  Exclude this appointment from the conflict
     *                                         check (used when rescheduling it).
     */
    public function canBookAppointment(CarbonImmutable $date, string $time, Treatment $treatment, bool $lock = false, ?int $ignoreAppointmentId = null): bool
    {
        $requestedTime = $date->setTimeFromTimeString($time)->format('H:i');

        foreach ($this->slotsForDate($date, $treatment, $lock, $ignoreAppointmentId) as $slot) {
            if ($slot['time'] === $requestedTime) {
                return $slot['available'];
            }
        }

        // The requested time is not on the schedule's slot grid.
        return false;
    }

    /**
     * The doctor schedule that applies to the given date.
     */
    public function scheduleForDate(CarbonImmutable $date): ?DoctorSchedule
    {
        return DoctorSchedule::query()
            ->where('day_of_week', $date->dayOfWeek)
            ->first();
    }

    /**
     * Weekdays the doctor is off, as Carbon day-of-week integers (0 = Sunday).
     *
     * @return list<int>
     */
    public function daysOffWeekdays(): array
    {
        return DoctorSchedule::query()
            ->where('is_day_off', true)
            ->pluck('day_of_week')
            ->map(static fn ($day): int => (int) $day)
            ->values()
            ->all();
    }

    /**
     * A short, human readable summary of the regular working hours,
     * e.g. "Monday – Saturday · 5:00 PM – 9:00 PM". Returns null when the
     * schedule is empty or too irregular for a single summary line.
     */
    public function workingHoursSummary(): ?string
    {
        $schedules = DoctorSchedule::query()
            ->where('is_day_off', false)
            ->orderBy('day_of_week')
            ->get();

        if ($schedules->isEmpty()) {
            return null;
        }

        $weekdays = $schedules
            ->map(static fn (DoctorSchedule $schedule): int => (int) $schedule->day_of_week)
            ->values();

        $dayLabel = match (true) {
            $weekdays->all() === range(1, 5) => 'Monday – Friday',
            $weekdays->all() === range(1, 6) => 'Monday – Saturday',
            default => null,
        };

        if ($dayLabel === null) {
            return null;
        }

        $startTimes = $schedules->unique('start_time');
        $endTimes = $schedules->unique('end_time');

        if ($startTimes->count() !== 1 || $endTimes->count() !== 1) {
            return null;
        }

        $timeLabel = CarbonImmutable::parse($startTimes->first()->start_time)->format('g:i A')
            .' – '.CarbonImmutable::parse($endTimes->first()->end_time)->format('g:i A');

        return "$dayLabel · $timeLabel";
    }

    /**
     * All reserved ("busy") time intervals on the given date. Cancelled
     * appointments are ignored, so their slots become bookable again.
     *
     * @param  bool  $lock  Lock the read rows for the duration of the calling transaction.
     * @param  int|null  $ignoreAppointmentId  Exclude this appointment from the busy intervals.
     * @return list<array{starts_at: CarbonImmutable, ends_at: CarbonImmutable}>
     */
    protected function busyIntervals(CarbonImmutable $date, bool $lock = false, ?int $ignoreAppointmentId = null): array
    {
        $query = Appointment::query()
            ->notCancelled()
            ->where('appointment_date', $date->toDateString())
            ->when($ignoreAppointmentId !== null, fn ($query) => $query->whereKeyNot($ignoreAppointmentId))
            ->with(['treatment:id,name,duration_minutes']);

        // SQLite allows a single writer at a time, so the check-then-insert
        // below is already serialized there. MySQL & co. need row locks to
        // stop two concurrent requests from both passing this check.
        if ($lock && $query->getConnection()->getDriverName() !== 'sqlite') {
            $query->lockForUpdate();
        }

        return $query->get()
            ->map(static function (Appointment $appointment) use ($date): array {
                // Depending on the driver the raw attribute may come back as a
                // "HH:MM(:SS)" string or as a Carbon instance (datetime cast).
                $timeValue = $appointment->appointment_time;
                $timeString = $timeValue instanceof DateTimeInterface
                    ? $timeValue->format('H:i')
                    : (string) $timeValue;

                $startsAt = $date->setTimeFromTimeString($timeString);

                return [
                    'starts_at' => $startsAt,
                    'ends_at' => $startsAt->addMinutes((int) ($appointment->treatment?->duration_minutes ?? 0)),
                ];
            })
            ->all();
    }

    /**
     * Whether the candidate interval [startsAt, endsAt) intersects any of the
     * booked intervals.
     *
     * @param  list<array{starts_at: CarbonImmutable, ends_at: CarbonImmutable}>  $busyIntervals
     */
    protected function overlapsAnyBusyPeriod(CarbonImmutable $startsAt, CarbonImmutable $endsAt, array $busyIntervals): bool
    {
        foreach ($busyIntervals as ['starts_at' => $busyStartsAt, 'ends_at' => $busyEndsAt]) {
            if ($busyStartsAt->lessThan($endsAt) && $startsAt->lessThan($busyEndsAt)) {
                return true;
            }
        }

        return false;
    }
}
