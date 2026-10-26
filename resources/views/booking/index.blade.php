<x-layouts.public title="Book an appointment">

    @php
        $inputClasses = 'field-input';
        $labelClasses = 'field-label';
    @endphp

    {{-- Runtime configuration for the booking wizard --}}
    <div id="page-config"
         data-days-off="{{ implode(',', $daysOff) }}"
         data-max-date="{{ $maxBookingDate }}"
         data-slots-endpoint="{{ route('appointments.available-slots') }}"
         data-appointments-endpoint="{{ route('appointments.store') }}"
         hidden></div>

    {{-- Page header --}}
    <section class="bg-cream">
        <div class="site-container pb-12 pt-10 lg:pb-16 lg:pt-14">
            <nav class="flex items-center gap-2 text-[11px] font-medium text-muted" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-terracotta">Home</a>
                <span aria-hidden="true">/</span>
                <span class="text-ink">Book an appointment</span>
            </nav>

            <div class="mt-7 grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:gap-16">
                <div>
                    <p class="eyebrow">
                        <span class="eyebrow-mark" aria-hidden="true">//</span>
                        Appointments
                    </p>
                    <h1 class="display-title mt-4 text-[2.9rem] leading-[1.01] sm:text-[3.8rem] lg:text-[4.2rem]">
                        Book your <em>appointment.</em>
                    </h1>
                    <p class="body-copy mt-5 max-w-lg">
                        Pick a treatment, choose a time slot from the doctor's real availability and confirm —
                        it takes less than a minute.
                    </p>

                    <div class="mt-7 flex flex-wrap items-center gap-2.5">
                        @if ($workingHours)
                            <span class="status-pill border-line bg-white/65">
                                <span class="status-dot bg-[#3f9660]"></span>
                                {{ $workingHours }}
                            </span>
                        @endif
                        <span class="status-pill border-line bg-white/65">
                            <span class="status-dot bg-terracotta"></span>
                            Instant WhatsApp confirmation
                        </span>
                        <span class="status-pill border-line bg-white/65">
                            <span class="status-dot bg-ink/40"></span>
                            Pay at the clinic
                        </span>
                    </div>
                </div>

                <div class="relative hidden lg:block">
                    <div class="overflow-hidden rounded-[28px]">
                        <img src="{{ asset('images/site/appointment-hero.jpg') }}"
                             alt="A dentist ready to welcome a patient"
                             class="h-[310px] w-full object-cover object-center" loading="eager">
                    </div>
                    <div class="absolute -bottom-5 -left-5 rounded-[18px] border border-line bg-cream px-5 py-4 shadow-[0_16px_45px_rgba(60,61,66,0.12)]">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-muted">Booking made simple</p>
                        <p class="mt-1 font-display text-[1.2rem] tracking-[-0.025em] text-ink">No phone queues. No waiting.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Booking wizard --}}
    <main id="booking-shell" class="bg-cream">
        <div class="site-container pb-20">
            @if ($patientPrefill)
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4 rounded-[18px] border border-terracotta/20 bg-beige/70 px-5 py-4">
                    <p class="flex items-center gap-3 text-[13px] font-medium text-ink">
                        <span class="grid size-9 shrink-0 place-items-center rounded-full bg-terracotta text-[12px] font-semibold text-white">
                            {{ mb_substr($patientPrefill['name'], 0, 1) }}
                        </span>
                        Booking as <span class="font-semibold">{{ $patientPrefill['name'] }}</span> — this visit will appear in your patient dashboard.
                    </p>
                    <a href="{{ route('patient.dashboard') }}" class="text-[12px] font-semibold text-terracotta underline-offset-2 hover:underline">My dashboard</a>
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-start lg:gap-8">

                <section id="booking-wizard" class="space-y-5">

                    {{-- Step 1: treatment --}}
                    <article data-step="1" class="rounded-[24px] border border-line bg-white p-6 sm:p-8">
                        <header class="flex items-center gap-4">
                            <span class="grid size-10 shrink-0 place-items-center rounded-full bg-ink font-display text-[1.05rem] italic text-cream">1</span>
                            <div>
                                <h2 class="font-display text-[1.55rem] leading-tight tracking-[-0.03em] text-ink">Choose a treatment</h2>
                                <p class="mt-1 text-[12px] text-body">Select one of the services below to get started.</p>
                            </div>
                        </header>

                        <div class="mt-5 sm:max-w-md">
                            <label for="treatment-dropdown" class="field-label">Quick select service / treatment</label>
                            <select id="treatment-dropdown" class="field-input w-full cursor-pointer rounded-lg border border-line bg-cream/30 px-3 py-2.5 font-form text-[14px] text-ink focus:border-terracotta focus:outline-none focus:ring-0">
                                <option value="">-- Choose a service --</option>
                                @foreach ($treatments as $treatment)
                                    <option value="{{ $treatment->id }}"
                                            data-slug="{{ $treatment->slug }}"
                                            @selected(
                                                (isset($selectedTreatmentId) && $selectedTreatmentId === $treatment->id) ||
                                                (string) request('service') === (string) $treatment->slug ||
                                                (string) request('service') === (string) $treatment->id ||
                                                (string) request('treatment') === (string) $treatment->slug ||
                                                (string) request('treatment') === (string) $treatment->id
                                            )>
                                        {{ $treatment->name }} — ${{ number_format((float) $treatment->cost, 2) }} ({{ (int) $treatment->duration_minutes }} min)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <fieldset class="mt-6">
                            <legend class="sr-only">Treatment</legend>
                            <div id="treatment-options" class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                @forelse ($treatments as $treatment)
                                    <label class="block cursor-pointer">
                                        <input
                                            type="radio"
                                            name="treatment_id"
                                            value="{{ $treatment->id }}"
                                            class="peer sr-only"
                                            data-treatment-card
                                            data-slug="{{ $treatment->slug }}"
                                            data-name="{{ $treatment->name }}"
                                            data-duration="{{ $treatment->duration_minutes }}"
                                            data-cost="{{ $treatment->cost }}"
                                            @checked(
                                                (isset($selectedTreatmentId) && $selectedTreatmentId === $treatment->id) ||
                                                (string) request('service') === (string) $treatment->slug ||
                                                (string) request('service') === (string) $treatment->id ||
                                                (string) request('treatment') === (string) $treatment->slug ||
                                                (string) request('treatment') === (string) $treatment->id
                                            )
                                            required
                                        />
                                        <div class="flex h-full flex-col gap-1.5 rounded-[16px] border border-line bg-cream/45 p-4 transition hover:border-terracotta/40 hover:bg-beige/60 peer-checked:border-terracotta peer-checked:bg-terracotta/[0.06] peer-checked:ring-1 peer-checked:ring-terracotta/25 peer-focus-visible:ring-2 peer-focus-visible:ring-terracotta">
                                            <span class="text-[14px] font-semibold text-ink">{{ $treatment->name }}</span>
                                            <span class="text-[10px] font-semibold uppercase tracking-[0.1em] text-muted">{{ (int) $treatment->duration_minutes }} min visit</span>
                                            <span class="mt-auto pt-3 font-display text-[1.3rem] tracking-[-0.03em] text-terracotta">${{ number_format((float) $treatment->cost, 2) }}</span>
                                        </div>
                                    </label>
                                @empty
                                    <p class="rounded-[16px] bg-cream px-4 py-3 text-[13px] text-body">
                                        No treatments are currently available for booking. Please check back soon.
                                    </p>
                                @endforelse
                            </div>
                        </fieldset>
                    </article>

                    {{-- Step 2: date & time --}}
                    <article id="step-2" data-step="2" aria-disabled="true" class="pointer-events-none rounded-[24px] border border-line bg-white p-6 opacity-50 transition sm:p-8">
                        <header class="flex items-center gap-4">
                            <span data-step-badge class="grid size-10 shrink-0 place-items-center rounded-full bg-line font-display text-[1.05rem] italic text-ink/40">2</span>
                            <div>
                                <h2 class="font-display text-[1.55rem] leading-tight tracking-[-0.03em] text-ink">Pick a date &amp; time</h2>
                                <p class="mt-1 text-[12px] leading-5 text-body">Available slots are calculated from the doctor's schedule and existing bookings.</p>
                                <p data-lock-hint class="mt-1.5 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-[0.08em] text-terracotta">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                    </svg>
                                    Choose a treatment first.
                                </p>
                            </div>
                        </header>

                        <div class="mt-6 grid gap-4 sm:flex sm:items-end">
                            <div class="relative w-full sm:max-w-xs">
                                <label for="appointment-date-picker" class="field-label">Appointment date</label>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="pointer-events-none absolute bottom-3 left-0 size-4.5 text-muted">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                </svg>
                                <input id="appointment-date-picker" name="appointment_date" type="text"
                                       autocomplete="off" placeholder="Select a date"
                                       class="{!! $inputClasses !!} pl-6"/>
                            </div>
                            @if ($workingHours)
                                <p class="pb-3 text-[11px] text-muted">Working hours: {{ $workingHours }}</p>
                            @endif
                        </div>

                        <input type="hidden" id="appointment-time" name="appointment_time" value=""/>

                        <div class="mt-6">
                            <div id="slots-loading" class="flex items-center gap-2 py-2 text-[12px] text-body" hidden>
                                <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"/>
                                </svg>
                                <span>Loading available time slots…</span>
                            </div>

                            <p id="slots-meta" class="mb-3 text-[12px] font-medium text-body" hidden></p>

                            <div id="slots-grid" class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-5" hidden></div>

                            <div id="slots-empty" class="rounded-[14px] border border-dashed border-ink/20 bg-cream px-4 py-3 text-[12px] text-body" hidden>
                                No suitable slots — please pick another date.
                            </div>

                            <p id="slots-error" class="mt-2 text-[12px] font-medium text-[#963f2b]" hidden></p>
                        </div>
                    </article>

                    {{-- Step 3: patient details --}}
                    <article id="step-3" data-step="3" aria-disabled="true" class="pointer-events-none rounded-[24px] border border-line bg-white p-6 opacity-50 transition sm:p-8">
                        <header class="flex items-center gap-4">
                            <span data-step-badge class="grid size-10 shrink-0 place-items-center rounded-full bg-line font-display text-[1.05rem] italic text-ink/40">3</span>
                            <div>
                                <h2 class="font-display text-[1.55rem] leading-tight tracking-[-0.03em] text-ink">Your details</h2>
                                <p class="mt-1 text-[12px] text-body">Tell us who is coming in for the visit.</p>
                                <p data-lock-hint class="mt-1.5 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-[0.08em] text-terracotta">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                    </svg>
                                    Pick a date &amp; time first.
                                </p>
                            </div>
                        </header>

                        <form id="booking-form" class="mt-6 grid gap-5 sm:grid-cols-2">
                            <label class="block">
                                <span class="{{ $labelClasses }}">Full name</span>
                                <input id="patient-name" name="patient_name" type="text" required maxlength="255"
                                       autocomplete="name" placeholder="e.g. Saima Ali"
                                       value="{{ old('patient_name', $patientPrefill['name'] ?? '') }}"
                                       class="{!! $inputClasses !!}"/>
                            </label>

                            <label class="block">
                                <span class="{{ $labelClasses }}">WhatsApp number</span>
                                <input id="patient-phone" name="patient_phone" type="tel" required
                                       autocomplete="tel" placeholder="+964 770 123 4567" inputmode="tel"
                                       value="{{ old('patient_phone', $patientPrefill['phone'] ?? '') }}"
                                       class="{!! $inputClasses !!}"/>
                                <span class="mt-1.5 block text-[10px] text-muted">Include the country code so we can reach you on WhatsApp.</span>
                            </label>

                            <label class="block">
                                <span class="{{ $labelClasses }}">Age</span>
                                <input id="patient-age" name="patient_age" type="number" required min="1" max="120"
                                       inputmode="numeric" placeholder="e.g. 32"
                                       value="{{ old('patient_age', $patientPrefill['age'] ?? '') }}"
                                       class="{!! $inputClasses !!}"/>
                            </label>

                            <label class="block sm:col-span-2">
                                <span class="{{ $labelClasses }}">Notes for the doctor <span class="normal-case tracking-normal text-muted">(optional)</span></span>
                                <textarea id="patient-notes" name="notes" rows="3" maxlength="2000"
                                          placeholder="Allergies, pain level, previous visits…"
                                          class="{!! $inputClasses !!}">{{ old('notes') }}</textarea>
                            </label>

                            <div class="sm:col-span-2">
                                <p id="form-error" class="text-[12px] font-medium text-[#963f2b]" role="alert" hidden></p>
                            </div>

                            <div class="sm:col-span-2 sm:flex sm:items-center sm:justify-between sm:gap-4">
                                @if (auth('patient')->check() || auth()->check())
                                    <button type="submit" id="booking-submit"
                                            class="btn-medio w-full justify-center disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto">
                                        Confirm booking
                                        <span class="btn-medio-icon" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                            </svg>
                                        </span>
                                    </button>
                                @else
                                    <button type="submit" id="booking-submit" disabled
                                            class="btn-medio w-full justify-center disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto"
                                            title="Please log in to book an appointment.">
                                        Confirm booking
                                        <span class="btn-medio-icon" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                            </svg>
                                        </span>
                                    </button>
                                @endif
                                <p class="mt-3 text-[10px] leading-5 text-muted sm:mt-0 sm:max-w-xs sm:text-right">
                                    The clinic will reserve this time for you. Payment is made at the clinic.
                                </p>
                            </div>
                        </form>

                        @if (!auth('patient')->check() && !auth()->check())
                            <p class="mt-5 border-t border-line/70 pt-4 text-[11px] leading-5 text-muted">
                                Please <a href="{{ route('patient.login', ['intended' => request()->getRequestUri()]) }}" class="font-semibold text-terracotta underline-offset-2 hover:underline">log in</a>
                                or <a href="{{ route('patient.register') }}" class="font-semibold text-terracotta underline-offset-2 hover:underline">create a free account</a>
                                to book an appointment.
                            </p>
                        @endif
                    </article>
                </section>

                {{-- Sticky summary --}}
                <aside id="booking-summary" class="overflow-hidden rounded-[24px] bg-terracotta text-white lg:sticky lg:top-28">
                    <div class="p-6">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/60">Your appointment</p>
                        <h2 class="mt-2 font-display text-[1.7rem] leading-tight tracking-[-0.03em]">Booking summary</h2>
                        <dl class="mt-6 space-y-4 text-[12px]">
                            <div class="flex items-start justify-between gap-3 border-b border-white/20 pb-3">
                                <dt class="text-white/60">Treatment</dt>
                                <dd id="summary-treatment" class="max-w-[10rem] text-right font-semibold">—</dd>
                            </div>
                            <div class="flex items-start justify-between gap-3 border-b border-white/20 pb-3">
                                <dt class="text-white/60">Date</dt>
                                <dd id="summary-date" class="max-w-[10rem] text-right font-semibold">—</dd>
                            </div>
                            <div class="flex items-start justify-between gap-3 border-b border-white/20 pb-3">
                                <dt class="text-white/60">Time</dt>
                                <dd id="summary-time" class="text-right font-semibold">—</dd>
                            </div>
                        </dl>
                        <div class="mt-5 flex items-end justify-between gap-3">
                            <span class="text-[11px] text-white/60">Fee at clinic</span>
                            <span id="summary-cost" class="font-display text-[2rem] leading-none tracking-[-0.04em]">—</span>
                        </div>
                        <p class="mt-5 text-[10px] leading-5 text-white/60">
                            Please arrive 10 minutes before your slot. You can track or cancel your booking online
                            up to 4 hours before it starts.
                        </p>
                        <a href="{{ route('appointment.lookup') }}" class="mt-3 inline-flex text-[10px] font-semibold text-white underline decoration-white/30 underline-offset-4 hover:decoration-white">
                            Already booked? Track it here
                        </a>
                    </div>
                    <div class="border-t border-white/20 bg-ink/10 px-6 py-4">
                        <p class="text-[10px] leading-5 text-white/60">
                            <span class="font-semibold text-white">Booking takes under a minute.</span>
                            Pick a treatment and a slot — we'll send your confirmation on WhatsApp instantly.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    {{-- Instant confirmation card --}}
    <main id="booking-confirmation" class="hidden bg-cream">
        <div class="site-container py-16 sm:py-20">
            <div class="mx-auto max-w-2xl rounded-[26px] border border-line bg-white p-6 sm:p-10">
                <div class="flex flex-col items-center text-center">
                    <span class="grid size-16 place-items-center rounded-full bg-terracotta text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </span>
                    <p class="eyebrow mt-6 justify-center">
                        <span class="eyebrow-mark" aria-hidden="true">//</span>
                        You're booked
                    </p>
                    <h1 class="display-title mt-3 text-[2.6rem] leading-[1.02] text-ink sm:text-[3.2rem]">Appointment booked!</h1>
                    <p id="confirmation-message" class="mt-3 max-w-md text-[13px] leading-6 text-body"></p>
                </div>

                <dl class="mt-8 divide-y divide-line/70 rounded-[18px] border border-line bg-cream/50 text-[12px]">
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">Reference</dt>
                        <dd id="confirmation-reference" class="font-mono font-bold text-ink"></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">Treatment</dt>
                        <dd id="confirmation-treatment" class="text-right font-semibold text-ink"></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">Date</dt>
                        <dd id="confirmation-date" class="text-right font-semibold text-ink"></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">Time</dt>
                        <dd id="confirmation-time" class="font-semibold text-ink"></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">Patient</dt>
                        <dd id="confirmation-name" class="font-semibold text-ink"></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">WhatsApp number</dt>
                        <dd id="confirmation-phone" class="font-semibold text-ink"></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">Age</dt>
                        <dd id="confirmation-age" class="font-semibold text-ink"></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">Fee at clinic</dt>
                        <dd id="confirmation-fee" class="font-semibold text-ink"></dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                        <dt class="text-muted">Status</dt>
                        <dd id="confirmation-status" class="rounded-full bg-[#f7eddf] px-3 py-0.5 font-semibold text-[#8b5a2b]"></dd>
                    </div>
                </dl>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a href="{{ route('appointment.lookup') }}" class="btn-medio justify-center">
                        Track this booking
                        <span class="btn-medio-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </a>
                    <button id="booking-again" class="btn-medio-light justify-center">Book another appointment</button>
                </div>

                <p class="mt-5 text-center text-[10px] leading-5 text-muted">
                    Please arrive 10 minutes early. If your plans change, cancel or reschedule online up to 4 hours before your visit.
                </p>
            </div>
        </div>
    </main>

</x-layouts.public>
