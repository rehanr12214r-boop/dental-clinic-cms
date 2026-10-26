<x-layouts.public title="Reschedule appointment">

    <section class="bg-cream">
        <div class="site-container pb-20 pt-10 lg:pt-14">
            <nav class="flex items-center gap-2 text-[11px] font-medium text-muted" aria-label="Breadcrumb">
                <a href="{{ route('patient.dashboard') }}" class="transition hover:text-terracotta">My dashboard</a>
                <span aria-hidden="true">/</span>
                <span class="text-ink">Reschedule</span>
            </nav>

            <div class="mt-7 max-w-2xl">
                <p class="eyebrow">
                    <span class="eyebrow-mark" aria-hidden="true">//</span>
                    Change of plans
                </p>
                <h1 class="display-title mt-4 text-[2.8rem] leading-[1.02] sm:text-[3.5rem]">Move your <em>appointment.</em></h1>
                <p class="mt-4 max-w-xl text-[12px] leading-6 text-body">
                    Pick a new date and time below — availability updates live and your booking is moved instantly.
                </p>
            </div>

            <div class="mt-8 grid gap-5 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                <div class="rounded-[24px] border border-line bg-white p-6 sm:p-7">
                    <p class="eyebrow">
                        <span class="eyebrow-mark" aria-hidden="true">//</span>
                        Currently booked
                    </p>
                    <div class="mt-4 flex items-start justify-between gap-4">
                        <div>
                            <h2 class="font-display text-[1.55rem] leading-tight tracking-[-0.03em] text-ink">{{ $appointment->treatment?->name }}</h2>
                            <p class="mt-2 text-[12px] leading-6 text-body">
                                {{ $appointment->dateLabel('l, F j, Y') }} · {{ $appointment->timeLabel() }}
                                <span class="block text-[10px] text-muted">{{ $appointment->reference }}</span>
                            </p>
                        </div>
                        <x-public.status-badge :status="$appointment->status" />
                    </div>
                    <div class="mt-5 border-t border-line/70 pt-4">
                        <p class="text-[10px] leading-5 text-muted">
                            Rescheduling is free and cancels the old slot automatically. Online changes are available until
                            {{ \App\Models\Appointment::CANCELLATION_CUTOFF_HOURS }} hours before the visit.
                        </p>
                    </div>
                </div>

                <div>
                    {{-- Runtime config for the picker --}}
                    <div id="reschedule-config"
                         data-days-off="{{ implode(',', $daysOff) }}"
                         data-max-date="{{ $maxBookingDate }}"
                         data-slots-endpoint="{{ $slotsEndpoint }}"
                         hidden></div>

                    <form method="POST" action="{{ route('patient.appointments.reschedule.update', $appointment) }}"
                          class="rounded-[24px] border border-line bg-white p-6 sm:p-8">
                        @csrf
                        @method('PATCH')

                        <div class="grid gap-5 sm:grid-cols-[minmax(0,1fr)_minmax(0,1.6fr)] sm:items-start">
                            <div>
                                <label for="reschedule-date-picker" class="field-label">New date</label>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="pointer-events-none absolute bottom-3 left-0 size-4.5 text-muted">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                    </svg>
                                    <input id="reschedule-date-picker" name="appointment_date" type="text"
                                           autocomplete="off" placeholder="Select a date"
                                           class="field-input pl-6"/>
                                </div>
                                @error('appointment_date')
                                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                                @enderror

                                <input type="hidden" id="reschedule-time" name="appointment_time" value="{{ old('appointment_time') }}"/>
                                @error('appointment_time')
                                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <p class="field-label">New time</p>

                                <div id="reschedule-slots-loading" class="flex items-center gap-2 py-2 text-[12px] text-body" hidden>
                                    <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"/>
                                    </svg>
                                    <span>Loading available time slots…</span>
                                </div>

                                <p id="reschedule-slots-meta" class="mb-3 text-[12px] font-medium text-body" hidden></p>

                                <div id="reschedule-slots-grid" class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4" hidden></div>

                                <p id="reschedule-slots-empty" class="rounded-[14px] border border-dashed border-ink/20 bg-cream px-4 py-3 text-[12px] text-body" hidden>
                                    Select a date to see the available time slots.
                                </p>

                                <p id="reschedule-slots-error" class="mt-2 text-[12px] font-medium text-[#963f2b]" hidden></p>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-line/70 pt-6">
                            <button type="submit" id="reschedule-submit" disabled
                                    class="btn-medio disabled:cursor-not-allowed disabled:opacity-50">
                                Confirm new time
                                <span class="btn-medio-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                    </svg>
                                </span>
                            </button>
                            <a href="{{ route('patient.dashboard') }}" class="btn-medio-light">Keep current booking</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-layouts.public>
