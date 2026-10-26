<x-layouts.admin

    title="All appointments"
    heading="All appointments"
    :headingSub="$appointments->total().' booking(s) match the current filters · clinic timezone: '.config('app.timezone')"
>
    <x-slot name="actions">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Today's dashboard
        </a>
    </x-slot>

    {{-- Period tabs --}}
    <nav class="flex flex-wrap gap-1 rounded-2xl bg-white p-1.5 shadow-sm ring-1 ring-slate-200" aria-label="Appointment period">
        @foreach (['upcoming' => 'Upcoming', 'today' => 'Today', 'past' => 'Past', 'all' => 'All dates'] as $value => $label)
            <a href="{{ route('admin.appointments.index', array_filter([
                    'period' => $value,
                    'status' => $status?->value,
                    'q' => $search !== '' ? $search : null,
                ])) }}"
               @class([
                   'rounded-xl px-4 py-2 text-sm font-semibold transition',
                   'bg-slate-900 text-white shadow-sm' => $period === $value && $from === null && $to === null,
                   'text-slate-600 hover:bg-slate-100' => ! ($period === $value && $from === null && $to === null),
               ])>
                {{ $label }}
            </a>
        @endforeach
    </nav>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.appointments.index') }}"
          class="mt-4 grid gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:grid-cols-2 lg:grid-cols-6">
        <input type="hidden" name="period" value="{{ $period }}"/>

        <div class="lg:col-span-2">
            <label for="appointments-q" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Search</label>
            <input id="appointments-q" type="search" name="q" value="{{ $search }}" placeholder="Name, phone or APT-00042…"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div>
            <label for="appointments-status" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Status</label>
            <select id="appointments-status" name="status"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <option value="" @selected($status === null)>All statuses</option>
                @foreach ($statuses as $option)
                    <option value="{{ $option->value }}" @selected(($status?->value ?? '') === $option->value)>{{ $option->label() }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="appointments-from" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">From</label>
            <input id="appointments-from" type="date" name="from" value="{{ $from?->toDateString() }}"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div>
            <label for="appointments-to" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">To</label>
            <input id="appointments-to" type="date" name="to" value="{{ $to?->toDateString() }}"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit"
                    class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                Apply
            </button>
            <a href="{{ route('admin.appointments.index') }}"
               class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                Reset
            </a>
        </div>
    </form>

    @if ($search !== '' || $status !== null || $from !== null || $to !== null)
        <p class="mt-3 text-xs font-medium text-slate-500">
            Filters active — the table shows matching bookings from the selected period only.
        </p>
    @endif

    {{-- Global table --}}
    <div class="mt-4 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="w-full min-w-[68rem] text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-4 py-3 font-semibold">Reference</th>
                <th class="px-4 py-3 font-semibold">Patient</th>
                <th class="px-4 py-3 font-semibold">Contact</th>
                <th class="px-4 py-3 font-semibold">Treatment</th>
                <th class="px-4 py-3 font-semibold">Scheduled</th>
                <th class="px-4 py-3 font-semibold">Booked</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 font-semibold"></th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            @forelse ($appointments as $appointment)
                <tr class="align-top transition hover:bg-slate-50/70">
                    <td class="px-4 py-3.5">
                        <span class="rounded bg-slate-100 px-2 py-0.5 font-mono text-xs font-semibold text-slate-700">{{ $appointment->reference }}</span>
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="font-semibold text-slate-900">{{ $appointment->patient_name }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->patient_age }} years old</p>
                        @if ($appointment->patient_id)
                            <span class="mt-1 inline-block rounded-full bg-teal-50 px-1.5 py-0.5 text-[10px] font-bold text-teal-700 ring-1 ring-teal-600/20">Portal account</span>
                        @endif
                    </td>

                    <td class="px-4 py-3.5">
                        <a href="{{ $appointment->whatsappUrl() }}" target="_blank" rel="noopener noreferrer"
                           class="text-xs font-semibold text-slate-700 underline-offset-2 hover:text-emerald-700 hover:underline">
                            {{ $appointment->patient_phone }}
                        </a>
                        @if ($appointment->patient?->email)
                            <p class="mt-0.5 truncate text-xs text-slate-400">{{ $appointment->patient->email }}</p>
                        @endif
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="font-medium text-slate-900">{{ $appointment->treatment?->name ?? '—' }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->treatment?->duration_minutes ?? 0 }} min · ${{ number_format((float) ($appointment->treatment?->cost ?? 0), 2) }}</p>
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="font-semibold text-slate-900">{{ $appointment->dateLabel('D, M j, Y') }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->timeLabel() }}</p>
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="text-xs text-slate-600">{{ $appointment->created_at?->format('M j, Y') ?? '—' }}</p>
                        <p class="text-[11px] text-slate-400">{{ $appointment->created_at?->diffForHumans() ?? '' }}</p>
                    </td>

                    <td class="px-4 py-3.5">
                        <x-admin.status-badge :status="$appointment->status"/>
                    </td>

                    <td class="px-4 py-3.5 text-right">
                        <a href="{{ route('admin.dashboard', ['date' => $appointment->appointment_date->toDateString()]) }}"
                           class="inline-flex whitespace-nowrap rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50">
                            Open day
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-16 text-center">
                        @if ($search !== '' || $status !== null || $from !== null || $to !== null)
                            <p class="text-4xl">🔍</p>
                            <p class="mt-3 font-semibold text-slate-900">No appointments match your filters</p>
                            <p class="mt-1 text-sm text-slate-500">Try a different search term, status or date range — or reset the filters.</p>
                            <a href="{{ route('admin.appointments.index') }}"
                               class="mt-4 inline-flex rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                Clear filters
                            </a>
                        @else
                            <p class="text-4xl">🦷</p>
                            <p class="mt-3 font-semibold text-slate-900">No appointments in this period</p>
                            <p class="mt-1 text-sm text-slate-500">This is an empty result, not a system error. New portal bookings will appear here immediately.</p>
                            <a href="{{ route('admin.appointments.index', ['period' => 'all']) }}"
                               class="mt-4 inline-flex rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                                Show all dates
                            </a>
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if ($appointments->hasPages())
        <div class="mt-4">{{ $appointments->links() }}</div>
    @endif

    <p class="mt-4 text-xs text-slate-500">
        @if ($appointments->total() > 0)
            Showing {{ $appointments->firstItem() }}–{{ $appointments->lastItem() }} of {{ $appointments->total() }} appointment(s).
        @else
            No appointments to show.
        @endif
        Times are displayed in the clinic timezone ({{ config('app.timezone') }}).
    </p>

</x-layouts.admin>
