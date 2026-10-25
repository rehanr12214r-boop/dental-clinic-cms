@php
    use App\Enums\AppointmentStatus;
    use Illuminate\Support\Str;

    $presetClasses = fn (string $value): string => $range === $value
        ? 'rounded-full bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm'
        : 'rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50';

    $exportUrl = route('admin.reports.export', [
        'range' => $range,
        'from' => $from->toDateString(),
        'to' => $to->toDateString(),
    ]);
@endphp

<x-layouts.admin
    title="Reports"
    heading="Reports & analytics"
    :headingSub="$from->format('M j, Y').' – '.$to->format('M j, Y')"
>
    <x-slot name="actions">
        <a href="{{ $exportUrl }}" data-loading-link
           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Export to CSV
        </a>
    </x-slot>

    {{-- Range picker --}}
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.reports.index', ['range' => 'week']) }}" class="{{ $presetClasses('week') }}">This Week</a>
        <a href="{{ route('admin.reports.index', ['range' => 'month']) }}" class="{{ $presetClasses('month') }}">This Month</a>
        <a href="{{ route('admin.reports.index', ['range' => 'custom']) }}" class="{{ $presetClasses('custom') }}">Custom Range</a>
    </div>

    @if ($range === 'custom')
        <form method="GET" action="{{ route('admin.reports.index') }}"
              class="mt-4 flex flex-wrap items-end gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
            <input type="hidden" name="range" value="custom">

            <div>
                <label for="report-from" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">From</label>
                <input id="report-from" type="date" name="from" value="{{ $from->toDateString() }}"
                       class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
            </div>

            <div>
                <label for="report-to" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">To</label>
                <input id="report-to" type="date" name="to" value="{{ $to->toDateString() }}"
                       class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
            </div>

            <button type="submit"
                    class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
                Apply range
            </button>
        </form>
    @endif

    {{-- Summary metrics --}}
    <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
        <x-admin.stat-card label="Total appointments" :value="$summary['total']"/>
        <x-admin.stat-card label="Revenue" :value="$summary['revenue']" tone="violet" hint="Completed + checked-in visits"/>
        <x-admin.stat-card label="Completed" :value="$summary['completed']" tone="emerald"/>
        <x-admin.stat-card label="Cancelled" :value="$summary['cancelled']" tone="rose"/>
        <x-admin.stat-card
            label="Completed vs cancelled"
            :value="$summary['completed'].' vs '.$summary['cancelled']"
            tone="sky"
            :hint="$summary['completion_rate'] !== null ? $summary['completion_rate'].'% completion rate' : 'No decided appointments yet'"
        />
    </div>

    {{-- Status breakdown --}}
    <section class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Status breakdown</h2>
        <p class="mt-1 text-sm text-slate-500">Where the appointments of this range ended up.</p>

        <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($breakdown as $row)
                <div class="rounded-xl bg-slate-50 p-3.5 ring-1 ring-slate-200">
                    <x-admin.status-badge :status="$row['status']"/>
                    <p class="mt-2.5 text-xl font-bold tracking-tight text-slate-900">{{ $row['count'] }}</p>
                    @if ($row['revenue'] > 0)
                        <p class="mt-0.5 text-xs font-medium text-slate-500">${{ number_format($row['revenue'], 2) }} revenue</p>
                    @else
                        <p class="mt-0.5 text-xs text-slate-400">No revenue</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    {{-- Top treatments --}}
    <section class="mt-6 rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-bold text-slate-900">Top treatments</h2>
            <p class="mt-1 text-sm text-slate-500">Most booked services in the selected range.</p>
        </div>

        @if ($topTreatments->isEmpty())
            <div class="px-6 py-12 text-center">
                <p class="text-3xl">🦷</p>
                <p class="mt-2 font-semibold text-slate-900">No treatment activity in this range</p>
                <p class="mt-1 text-sm text-slate-500">Widen the custom range — or check back after a few bookings.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[36rem] text-left text-sm">
                    <thead>
                    <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-3 font-semibold">Treatment</th>
                        <th class="px-6 py-3 font-semibold">Appointments</th>
                        <th class="px-6 py-3 text-right font-semibold">Revenue</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @foreach ($topTreatments as $treatment)
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="px-6 py-3 font-semibold text-slate-900">{{ $treatment->name }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $treatment->aggregate }}</td>
                            <td class="px-6 py-3 text-right font-medium text-slate-900">${{ number_format((float) $treatment->revenue, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    {{-- Appointments in range --}}
    <section class="mt-6 rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-bold text-slate-900">Appointments in range</h2>
            <p class="mt-1 text-sm text-slate-500">The exact rows exported by the CSV button above.</p>
        </div>

        @if ($appointments->isEmpty())
            <div class="px-6 py-16 text-center">
                <p class="text-4xl">📊</p>
                <p class="mt-3 font-semibold text-slate-900">No appointments in this range</p>
                <p class="mt-1 text-sm text-slate-500">Pick a wider range or another preset to see activity.</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="mt-4 inline-flex rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Back to the dashboard
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[64rem] text-left text-sm">
                    <thead>
                    <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-3 font-semibold">Patient</th>
                        <th class="px-6 py-3 font-semibold">Phone</th>
                        <th class="px-6 py-3 font-semibold">Treatment</th>
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold">Time</th>
                        <th class="px-6 py-3 font-semibold">Fee</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Doctor notes</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @foreach ($appointments as $appointment)
                        <tr class="align-top transition hover:bg-slate-50/70">
                            <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $appointment->patient_name }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $appointment->patient_phone }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $appointment->treatment?->name }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $appointment->dateLabel() }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $appointment->timeLabel() }}</td>
                            <td class="px-6 py-3.5 font-medium text-slate-900">${{ number_format((float) ($appointment->treatment?->cost ?? 0), 2) }}</td>
                            <td class="px-6 py-3.5"><x-admin.status-badge :status="$appointment->status"/></td>
                            <td class="max-w-xs px-6 py-3.5 text-slate-500">{{ $appointment->notes ? Str::limit($appointment->notes, 60) : '—' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-6 py-4">
                <p class="text-xs text-slate-500">
                    Showing {{ $appointments->firstItem() }}–{{ $appointments->lastItem() }} of {{ $appointments->total() }} appointment(s)
                </p>
                @if ($appointments->hasPages())
                    {{ $appointments->links() }}
                @endif
            </div>
        @endif
    </section>

</x-layouts.admin>
