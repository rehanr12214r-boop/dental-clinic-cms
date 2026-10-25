@php
    use App\Enums\AppointmentStatus;
    use App\Enums\WhatsAppTemplate;
@endphp

<x-layouts.admin
    title="Dashboard"
    heading="Appointments overview"
    :headingSub="$date->format('l, F j, Y')"
>
    <x-slot name="actions">
        <a href="{{ route('admin.appointments.index') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm0 5.25h.007v.008H3.75V12Zm0 5.25h.007v.008H3.75v-.008Z"/>
            </svg>
            All appointments
        </a>
        <a href="{{ route('admin.reports.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
            </svg>
            Reports & analytics
        </a>
    </x-slot>

    @if ($queryError)
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-6 text-rose-800 shadow-sm" role="alert">
            <p class="text-base font-bold">Appointments could not be loaded</p>
            <p class="mt-1 text-sm">{{ $queryError }}</p>
            <a href="{{ route('admin.dashboard') }}"
               class="mt-4 inline-flex rounded-xl bg-rose-700 px-4 py-2 text-sm font-bold text-white transition hover:bg-rose-600">
                Retry
            </a>
        </div>
    @else

    {{-- Top stats bar (reflects the selected date; defaults to today) --}}
    @php
        $totalLabel = $date->isToday() ? "Today's appointments" : 'Appointments';
        $revenueLabel = $date->isToday() ? 'Revenue today' : 'Revenue';
    @endphp

    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
        <x-admin.stat-card :label="$totalLabel" :value="$stats['total']"/>
        <x-admin.stat-card label="Pending" :value="$stats['pending']" tone="amber"/>
        <x-admin.stat-card label="Confirmed" :value="$stats['confirmed']" tone="sky"/>
        <x-admin.stat-card label="Completed" :value="$stats['completed']" tone="emerald"/>
        <x-admin.stat-card :label="$revenueLabel" :value="$stats['revenue']" tone="violet"/>
    </div>

    {{-- Newest bookings — hidden while filtering so the list stays unambiguous --}}
    @if ($latestBookings->isNotEmpty() && $search === '' && $status === null)
        <section class="mt-6 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <header class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
                <div>
                    <h2 class="text-sm font-bold tracking-tight text-slate-900">Latest bookings</h2>
                    <p class="mt-0.5 text-xs text-slate-500">
                        Newest bookings across every date — portal bookings appear here the moment they are created.
                    </p>
                </div>
                <a href="{{ route('admin.appointments.index', ['period' => 'all']) }}"
                   class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50">
                    View all
                </a>
            </header>

            <ul class="divide-y divide-slate-100">
                @foreach ($latestBookings as $booking)
                    @php
                        $isNew = $booking->created_at?->greaterThan(now()->subDay()) ?? false;
                    @endphp
                    <li class="flex flex-wrap items-center justify-between gap-3 px-5 py-3">
                        <div class="min-w-0">
                            <p class="flex flex-wrap items-center gap-2 text-sm font-semibold text-slate-900">
                                {{ $booking->patient_name }}
                                @if ($booking->patient_id)
                                    <span class="rounded-full bg-teal-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-teal-700 ring-1 ring-teal-600/20">Portal account</span>
                                @endif
                                @if ($isNew)
                                    <span class="rounded-full bg-cyan-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-cyan-700 ring-1 ring-cyan-600/20">New</span>
                                @endif
                            </p>
                            <p class="mt-0.5 truncate text-xs text-slate-500">
                                {{ $booking->reference }} · {{ $booking->treatment?->name ?? 'Treatment removed' }}
                                · booked {{ $booking->created_at?->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-900">{{ $booking->dateLabel('D, M j') }}</p>
                                <p class="text-xs text-slate-500">{{ $booking->timeLabel() }}</p>
                            </div>
                            <x-admin.status-badge :status="$booking->status"/>
                            <a href="{{ route('admin.dashboard', ['date' => $booking->appointment_date->format('Y-m-d')]) }}"
                               data-open-day="{{ $booking->appointment_date->format('Y-m-d') }}"
                               class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50">
                                Open day
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.dashboard') }}"
          class="mt-6 grid gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:grid-cols-2 sm:items-end lg:grid-cols-4">
        <div>
            <label for="filter-date" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Date</label>
            <input id="filter-date" type="date" name="date" value="{{ $date->toDateString() }}"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div>
            <label for="filter-status" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Status</label>
            <select id="filter-status" name="status"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <option value="" @selected($status === null)>All statuses</option>
                @foreach ($statuses as $option)
                    <option value="{{ $option->value }}" @selected(($status?->value ?? '') === $option->value)>{{ $option->label() }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="filter-q" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Search patient</label>
            <input id="filter-q" type="search" name="q" value="{{ $search }}" placeholder="Name or phone…"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                    class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
                Apply filters
            </button>
            <a href="{{ route('admin.dashboard') }}"
               class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                Reset
            </a>
        </div>
    </form>

    {{-- Appointments table --}}
    <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="w-full min-w-[72rem] text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-4 py-3 font-semibold">Patient</th>
                <th class="px-4 py-3 font-semibold">Contact</th>
                <th class="px-4 py-3 font-semibold">Treatment</th>
                <th class="px-4 py-3 font-semibold">Scheduled</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 font-semibold">Quick actions</th>
                <th class="px-4 py-3 font-semibold">WhatsApp</th>
                <th class="px-4 py-3 font-semibold">Notes</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            @forelse ($appointments as $appointment)
                @php
                    $nextActions = match ($appointment->status) {
                        AppointmentStatus::Pending => ['confirmed', 'cancelled'],
                        AppointmentStatus::Confirmed => ['in-clinic', 'cancelled'],
                        AppointmentStatus::InClinic => ['completed', 'cancelled'],
                        AppointmentStatus::Completed => [],
                        AppointmentStatus::Cancelled => ['pending'],
                        default => [],
                    };

                    $actionMeta = [
                        'confirmed' => ['label' => 'Confirm', 'class' => 'bg-sky-600 hover:bg-sky-500'],
                        'in-clinic' => ['label' => 'Check-In', 'class' => 'bg-violet-600 hover:bg-violet-500'],
                        'completed' => ['label' => 'Complete', 'class' => 'bg-emerald-600 hover:bg-emerald-500'],
                        'cancelled' => ['label' => 'Cancel', 'class' => 'bg-rose-600 hover:bg-rose-500'],
                        'pending' => ['label' => 'Reopen', 'class' => 'bg-amber-600 hover:bg-amber-500'],
                    ];
                @endphp

                <tr class="align-top transition hover:bg-slate-50/70">
                    {{-- Patient (click for full appointment history) --}}
                    <td class="px-4 py-3.5">
                        <button type="button" data-patient-history data-history-url="{{ route('admin.appointments.history', $appointment) }}"
                                class="group text-left" title="View patient history">
                            <span class="block font-semibold text-slate-900 underline-offset-2 transition group-hover:text-cyan-700 group-hover:underline">
                                {{ $appointment->patient_name }}
                            </span>
                            <span class="block text-xs text-slate-500">{{ $appointment->patient_age }} years old</span>
                            <span class="mt-1 flex flex-wrap items-center gap-1.5">
                                <span class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-[10px] font-semibold text-slate-600">{{ $appointment->reference }}</span>
                                @if ($appointment->patient_id)
                                    <span class="rounded-full bg-teal-50 px-1.5 py-0.5 text-[10px] font-bold text-teal-700 ring-1 ring-teal-600/20">Portal</span>
                                @endif
                            </span>
                        </button>
                    </td>

                    {{-- Phone: history modal + click-to-WhatsApp --}}
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-1.5">
                            <button type="button" data-patient-history data-history-url="{{ route('admin.appointments.history', $appointment) }}"
                                    title="View patient history"
                                    class="rounded-lg px-2 py-1.5 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 transition hover:bg-slate-50 hover:text-cyan-700">
                                {{ $appointment->patient_phone }}
                            </button>
                            <a href="{{ $appointment->whatsappUrl() }}" target="_blank" rel="noopener noreferrer" title="Chat on WhatsApp"
                               class="grid size-7 shrink-0 place-items-center rounded-lg bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20 transition hover:bg-emerald-100">
                                <x-admin.whatsapp-icon class="size-3.5 content-center"/>
                            </a>
                        </div>
                    </td>

                    {{-- Treatment --}}
                    <td class="px-4 py-3.5">
                        <p class="font-medium text-slate-900">{{ $appointment->treatment?->name }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->treatment?->duration_minutes }} min · ${{ number_format((float) ($appointment->treatment?->cost ?? 0), 2) }}</p>
                    </td>

                    {{-- Scheduled --}}
                    <td class="px-4 py-3.5">
                        <p class="font-semibold text-slate-900">{{ $appointment->timeLabel() }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->dateLabel() }}</p>
                    </td>

                    {{-- Status badge --}}
                    <td class="px-4 py-3.5">
                        <x-admin.status-badge :status="$appointment->status"/>
                    </td>

                    {{-- 1-click quick actions (+ receipt for completed visits) --}}
                    <td class="px-4 py-3.5">
                        <div class="flex flex-wrap items-center gap-1.5">
                            @if ($appointment->status === AppointmentStatus::Completed)
                                <a href="{{ route('admin.appointments.receipt', $appointment) }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-1.5 rounded-md bg-slate-900 px-2.5 py-1 text-xs font-bold text-white shadow-sm transition hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Z"/>
                                    </svg>
                                    Print receipt
                                </a>
                            @elseif (count($nextActions) > 0)
                                @foreach ($nextActions as $target)
                                    <form method="POST" action="{{ route('admin.appointments.update-status', $appointment) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $target }}">
                                        <button type="submit"
                                                class="rounded-md px-2.5 py-1 text-xs font-bold text-white shadow-sm transition focus-visible:outline-2 focus-visible:outline-offset-2 {{ $actionMeta[$target]['class'] }}">
                                            {{ $actionMeta[$target]['label'] }}
                                        </button>
                                    </form>
                                @endforeach
                            @else
                                <span class="text-xs text-slate-400">No actions</span>
                            @endif
                        </div>
                    </td>

                    {{-- WhatsApp quick actions (sent directly through Whapi.cloud) --}}
                    <td class="px-4 py-3.5">
                        <div class="flex flex-col items-start gap-1.5">
                            <x-admin.whatsapp-button
                                :url="route('admin.appointments.send-whatsapp', $appointment)"
                                :template="WhatsAppTemplate::Confirmation->value"
                                label="Send Confirmation"/>
                            <x-admin.whatsapp-button
                                :url="route('admin.appointments.send-whatsapp', $appointment)"
                                :template="WhatsAppTemplate::Reminder->value"
                                label="Send Reminder"/>
                            @if ($appointment->status === AppointmentStatus::Completed)
                                <x-admin.whatsapp-button
                                    :url="route('admin.appointments.send-whatsapp', $appointment)"
                                    :template="WhatsAppTemplate::Review->value"
                                    label="Request Review"/>
                            @endif
                        </div>
                    </td>

                    {{-- Staff notes --}}
                    <td class="px-4 py-3.5">
                        <details class="group">
                            <summary class="inline-flex cursor-pointer list-none items-center gap-1.5 rounded-md bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-200">
                                {{ $appointment->notes ? 'View notes' : 'Add note' }}
                            </summary>
                            <form method="POST" action="{{ route('admin.appointments.update-notes', $appointment) }}" class="mt-2 w-64">
                                @csrf
                                @method('PATCH')
                                <textarea name="notes" rows="3" placeholder="Doctor / staff remarks…"
                                          class="w-full rounded-lg border border-slate-300 bg-white px-2.5 py-2 text-xs transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">{{ old('notes', $appointment->notes) }}</textarea>
                                <button type="submit"
                                        class="mt-1.5 w-full rounded-md bg-slate-900 py-1.5 text-xs font-bold text-white transition hover:bg-slate-700">
                                    Save
                                </button>
                            </form>
                        </details>
                    </td>
                </tr>
            @empty
                <tr>
                    @if ($search !== '' || $status !== null)
                        <td colspan="8" class="px-4 py-16 text-center">
                            <p class="text-4xl">🔍</p>
                            <p class="mt-3 font-semibold text-slate-900">No appointments match your filters</p>
                            <p class="mt-1 text-sm text-slate-500">Try a different search term, or clear the filters to see the full day.</p>
                            <a href="{{ route('admin.dashboard', ['date' => $date->toDateString()]) }}"
                               class="mt-4 inline-flex rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                Clear filters
                            </a>
                        </td>
                    @else
                        <td colspan="8" class="px-4 py-16 text-center">
                            <p class="text-4xl">🦷</p>
                            <p class="mt-3 font-semibold text-slate-900">No appointments for {{ $date->format('l, F j, Y') }}</p>
                            <p class="mt-1 text-sm text-slate-500">
                                This day is currently empty — it is not a loading or database error.
                                @if ($upcomingCount > 0)
                                    There {{ $upcomingCount === 1 ? 'is' : 'are' }} {{ $upcomingCount }} upcoming {{ $upcomingCount === 1 ? 'appointment' : 'appointments' }} on other dates.
                                @endif
                            </p>
                            <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                                <a href="{{ route('admin.dashboard') }}"
                                   class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                    Back to today
                                </a>
                                <a href="{{ route('admin.appointments.index') }}"
                                   class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                    View all appointments
                                </a>
                                @if ($nextAppointmentDate !== null)
                                    <a href="{{ route('admin.dashboard', ['date' => $nextAppointmentDate->toDateString()]) }}"
                                       class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                                        Next booking: {{ $nextAppointmentDate->format('D, M j') }}
                                    </a>
                                @else
                                    <a href="{{ route('home') }}" target="_blank"
                                       class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                                        Open booking portal
                                    </a>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <p class="mt-4 text-xs text-slate-500">
        Showing {{ $appointments->count() }} appointment(s)
        {{ $status ? ' · status: '.$status->label() : '' }}
        {{ $search !== '' ? ' · search: "'.$search.'"' : '' }}
    </p>

    @endif

    {{-- Patient history modal (content loaded via fetch, see resources/js/app.js) --}}
    <div id="patient-history-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="patient-history-title">
        <div data-history-backdrop class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="relative flex max-h-[85vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200">
            <header class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-4">
                <div class="min-w-0">
                    <h2 id="patient-history-title" data-history-name class="truncate text-lg font-bold tracking-tight text-slate-900">Patient history</h2>
                    <p data-history-subtitle class="mt-0.5 truncate text-sm text-slate-500">Loading…</p>
                </div>
                <button type="button" data-history-close
                        class="grid size-8 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                    <span class="sr-only">Close</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </header>

            <div data-history-body class="flex-1 overflow-y-auto px-6 py-5">
                <div class="flex items-center justify-center gap-3 py-10 text-sm text-slate-500">
                    <span class="inline-block size-4 animate-spin rounded-full border-2 border-current border-t-transparent"></span>
                    Loading patient history…
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin>
