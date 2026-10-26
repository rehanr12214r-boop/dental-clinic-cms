<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ReportController extends Controller
{
    /**
     * Supported report ranges.
     *
     * @var list<string>
     */
    private const Ranges = ['week', 'month', 'custom'];

    /**
     * Reports & analytics: date-range summary metrics, per-status breakdown,
     * top treatments and an appointments table, plus a CSV export.
     */
    public function index(Request $request): View
    {
        [$range, $from, $to] = $this->resolveRange($request);

        $baseQuery = Appointment::query()
            ->whereBetween('appointment_date', [$from->toDateString(), $to->toDateString()]);

        $revenueStatuses = [AppointmentStatus::InClinic->value, AppointmentStatus::Completed->value];

        // Revenue follows the dashboard convention: patients who arrived
        // (in-clinic) or finished (completed) count towards revenue.
        $statusRows = (clone $baseQuery)
            ->join('treatments', 'treatments.id', '=', 'appointments.treatment_id')
            ->selectRaw(
                'appointments.status as status_value, COUNT(*) as aggregate, COALESCE(SUM(CASE WHEN appointments.status IN (?, ?) THEN treatments.cost ELSE 0 END), 0) as revenue',
                $revenueStatuses,
            )
            ->groupBy('appointments.status')
            ->get();

        $statusCounts = $statusRows->pluck('aggregate', 'status_value')->map(static fn ($count): int => (int) $count);

        $completed = (int) $statusCounts->get(AppointmentStatus::Completed->value, 0);
        $cancelled = (int) $statusCounts->get(AppointmentStatus::Cancelled->value, 0);
        $decided = $completed + $cancelled;

        $summary = [
            'total' => (int) $statusCounts->sum(),
            'completed' => $completed,
            'cancelled' => $cancelled,
            'completion_rate' => $decided > 0 ? (int) round($completed / $decided * 100) : null,
            'revenue' => '$'.number_format((float) $statusRows->sum('revenue'), 2),
        ];

        $breakdown = collect(AppointmentStatus::cases())->map(fn (AppointmentStatus $status): array => [
            'status' => $status,
            'count' => (int) $statusCounts->get($status->value, 0),
            'revenue' => (float) ($statusRows->firstWhere('status_value', $status->value)?->revenue ?? 0),
        ]);

        $topTreatments = (clone $baseQuery)
            ->join('treatments', 'treatments.id', '=', 'appointments.treatment_id')
            ->selectRaw(
                'treatments.name as name, COUNT(*) as aggregate, COALESCE(SUM(CASE WHEN appointments.status IN (?, ?) THEN treatments.cost ELSE 0 END), 0) as revenue',
                $revenueStatuses,
            )
            ->groupBy('treatments.name')
            ->orderByDesc('aggregate')
            ->orderBy('treatments.name')
            ->limit(5)
            ->get();

        $appointments = (clone $baseQuery)
            ->with('treatment')
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->paginate(25)
            ->withQueryString();

        return view('admin.reports', [
            'range' => $range,
            'from' => $from,
            'to' => $to,
            'summary' => $summary,
            'breakdown' => $breakdown,
            'topTreatments' => $topTreatments,
            'appointments' => $appointments,
        ]);
    }

    /**
     * Download the filtered appointments of the selected range as a CSV file.
     */
    public function export(Request $request): StreamedResponse
    {
        [, $from, $to] = $this->resolveRange($request);

        $appointments = Appointment::query()
            ->whereBetween('appointment_date', [$from->toDateString(), $to->toDateString()])
            ->with('treatment')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $filename = sprintf('appointments-%s-to-%s.csv', $from->toDateString(), $to->toDateString());

        return response()->streamDownload(function () use ($appointments): void {
            $handle = fopen('php://output', 'w');

            if ($handle === false) {
                return;
            }

            // UTF-8 BOM so Excel opens the file with the correct encoding.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['Patient Name', 'Phone', 'Treatment', 'Date', 'Time', 'Fee', 'Status', 'Doctor Notes']);

            foreach ($appointments as $appointment) {
                fputcsv($handle, [
                    $appointment->patient_name,
                    $appointment->patient_phone,
                    $appointment->treatment?->name,
                    $appointment->dateLabel('Y-m-d'),
                    $appointment->timeLabel(),
                    number_format((float) ($appointment->treatment?->cost ?? 0), 2, '.', ''),
                    $appointment->status->label(),
                    $appointment->notes,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Resolve the requested range into concrete dates.
     *
     * @return array{0: string, 1: CarbonImmutable, 2: CarbonImmutable}
     */
    private function resolveRange(Request $request): array
    {
        $today = CarbonImmutable::today();
        $range = (string) $request->query('range', 'week');

        if (! in_array($range, self::Ranges, true)) {
            $range = 'week';
        }

        if ($range === 'week') {
            return [$range, $today->startOfWeek(), $today->endOfWeek()];
        }

        if ($range === 'month') {
            return [$range, $today->startOfMonth(), $today->endOfMonth()];
        }

        $from = $this->parseDate($request->query('from')) ?? $today->startOfMonth();
        $to = $this->parseDate($request->query('to')) ?? $today;

        if ($from->greaterThan($to)) {
            [$from, $to] = [$to, $from];
        }

        return [$range, $from, $to];
    }

    /**
     * Parse a Y-m-d query value, returning null for anything malformed.
     */
    private function parseDate(mixed $value): ?CarbonImmutable
    {
        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        try {
            $date = CarbonImmutable::createFromFormat('Y-m-d', $value);
        } catch (Throwable) {
            return null;
        }

        if ($date === false || $date->format('Y-m-d') !== $value) {
            return null;
        }

        return $date->startOfDay();
    }
}
