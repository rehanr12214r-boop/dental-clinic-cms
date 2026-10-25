@php
    use App\Models\Setting;

    $clinicName = Setting::get(Setting::ClinicName);
    $clinicAddress = Setting::get(Setting::ClinicAddress);
    $clinicPhone = Setting::get(Setting::ClinicPhone);
    $doctorName = Setting::get(Setting::DoctorName);
    $reviewLink = Setting::get(Setting::ReviewLink);
    $heroSubtitle = Setting::get(Setting::HeroSubtitle);
@endphp

<x-layouts.public>

    @php
        $testimonials = [
            ['name' => 'Lana K.', 'treatment' => 'Teeth Cleaning', 'rating' => 5, 'text' => 'Quick, gentle and thorough. The reminder on WhatsApp the day before was a nice touch — I did not have to remember anything.'],
            ['name' => 'Omar S.', 'treatment' => 'Root Canal', 'rating' => 5, 'text' => 'I was honestly terrified of a root canal. It was completely painless and the doctor explained every step before doing it.'],
            ['name' => 'Rania M.', 'treatment' => 'Orthodontics', 'rating' => 5, 'text' => 'Clear options, clear prices, no pressure at all. She showed me the timeline and the monthly payments and let me decide at home.'],
            ['name' => 'Hassan A.', 'treatment' => 'Tooth Extraction', 'rating' => 5, 'text' => 'Fast appointment, even faster procedure. Got written aftercare instructions and a follow-up message the next day to check on me.'],
            ['name' => 'Dina T.', 'treatment' => 'Routine Checkup', 'rating' => 5, 'text' => 'Booking online took me less than a minute and the confirmation arrived on WhatsApp instantly. Zero waiting time when I arrived.'],
            ['name' => 'Karim N.', 'treatment' => 'Teeth Cleaning', 'rating' => 4, 'text' => 'Very professional clinic and fair pricing. The evening hours are perfect if you work during the day — hard to find that elsewhere.'],
        ];

        $steps = [
            [
                'title' => 'Choose your treatment',
                'text' => 'Browse treatments with clear prices and visit durations, then pick the one you need.',
            ],
            [
                'title' => 'Pick a time that suits you',
                'text' => 'See real availability for the next 60 days and lock the slot that fits your day.',
            ],
            [
                'title' => 'Get instant WhatsApp confirmation',
                'text' => 'Your booking is confirmed on WhatsApp right away — reminders and updates included.',
            ],
        ];

        $serviceImages = [
            'teeth-cleaning' => 'service-whitening.jpg',
            'root-canal' => 'service-root-canal.jpg',
            'general-checkup' => 'benefits-smile.jpg',
            'tooth-extraction' => 'service-fillings.jpg',
            'braces-consultation' => 'service-orthodontics.jpg',
        ];

        $journal = [
            [
                'title' => 'Common myths about root canal treatments',
                'excerpt' => 'What actually happens during a root canal — and why the modern version feels far calmer than its reputation.',
                'image' => 'blog-4.jpg',
                'post' => 'common-myths-about-root-canal-treatments-explained',
                'read' => '4 min read',
            ],
            [
                'title' => 'What to expect during a dental implant',
                'excerpt' => 'From the first scan to the final crown, a clear look at what treatment really involves.',
                'image' => 'blog-5.jpg',
                'post' => 'what-to-expect-during-a-dental-implant-procedure',
                'read' => '5 min read',
            ],
            [
                'title' => 'Simple cosmetic dentistry for everyday smiles',
                'excerpt' => 'Small, considered changes that protect your enamel and help you feel more confident in your smile.',
                'image' => 'blog-3.jpg',
                'post' => 'simple-cosmetic-dentistry-options-for-everyday-smiles',
                'read' => '5 min read',
            ],
        ];
    @endphp

    {{-- ================= Hero ================= --}}
    <section class="hero-section relative overflow-hidden bg-cream">
        <div class="pointer-events-none absolute -right-24 -top-24 size-[34rem] rounded-full border border-terracotta/15" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-6 -top-6 size-[24rem] rounded-full border border-terracotta/10" aria-hidden="true"></div>

        <div class="site-container relative grid gap-12 pb-14 pt-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-center lg:gap-16 lg:pb-20 lg:pt-16">
            <div class="hero-content relative z-10">
                <p class="hero-eyebrow eyebrow">
                    <span class="eyebrow-mark" aria-hidden="true">//</span>
                    Thoughtful dentistry, every day
                </p>

                <h1 class="hero-title display-title mt-5 text-[3.15rem] leading-[0.98] sm:text-[4.5rem] lg:text-[5.25rem]">
                    Healthy teeth.<br>
                    Confident smiles.<br>
                    <em>Care you can trust.</em>
                </h1>

                <p class="hero-text body-copy mt-7 max-w-lg">
                    {{ $heroSubtitle ?: "Welcome to {$clinicName}. Book your visit with {$doctorName} — choose your treatment, pick a time that suits you and receive an instant confirmation on WhatsApp." }}
                </p>

                <div class="hero-cta mt-8 flex flex-wrap items-center gap-3.5">
                    <a href="{{ route('book') }}" class="btn-medio">
                        Book appointment
                        <span class="btn-medio-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </a>
                    <a href="{{ route('treatments.index') }}" class="btn-medio-light">
                        View treatments
                        <span class="grid size-9 place-items-center rounded-full border border-ink/15 text-ink" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </a>
                </div>

                <div class="hero-status mt-8 flex flex-wrap items-center gap-3">
                    <span @class([
                        'status-pill',
                        'border-[#b9d8c3] bg-[#edf7ef] text-[#346346]' => $openStatus['is_open'],
                        'border-line bg-white/55 text-muted' => ! $openStatus['is_open'],
                    ])>
                        <span @class([
                            'status-dot',
                            'bg-[#3f9660]' => $openStatus['is_open'],
                            'bg-terracotta' => ! $openStatus['is_open'],
                        ])></span>
                        {{ $openStatus['label'] }}
                    </span>
                    <span class="text-[12px] font-medium text-body">{{ $openStatus['detail'] }}</span>
                </div>

                <dl class="hero-stats stats-container mt-10 grid max-w-xl grid-cols-2 gap-x-8 gap-y-5 border-t border-line/80 pt-7 sm:grid-cols-4 sm:gap-x-5">
                    <div>
                        <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Happy patients</dt>
                        <dd class="mt-1.5 font-display text-[2rem] leading-none tracking-[-0.04em] text-ink"><span class="stat-counter" data-target="{{ $stats['happy_patients'] }}">{{ $stats['happy_patients'] }}</span>+</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Years experience</dt>
                        <dd class="mt-1.5 font-display text-[2rem] leading-none tracking-[-0.04em] text-ink"><span class="stat-counter" data-target="{{ $stats['years_experience'] }}">{{ $stats['years_experience'] }}</span>+</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Treatments</dt>
                        <dd class="mt-1.5 font-display text-[2rem] leading-none tracking-[-0.04em] text-ink"><span class="stat-counter" data-target="{{ $stats['treatments'] }}">{{ $stats['treatments'] }}</span></dd>
                    </div>
                    <div>
                        <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Visits completed</dt>
                        <dd class="mt-1.5 font-display text-[2rem] leading-none tracking-[-0.04em] text-ink"><span class="stat-counter" data-target="{{ $stats['visits_completed'] }}">{{ number_format($stats['visits_completed']) }}</span></dd>
                    </div>
                </dl>
            </div>

            <div class="hero-image relative">
                <div class="relative overflow-hidden rounded-[34px] bg-beige shadow-[0_30px_80px_rgba(60,61,66,0.12)]">
                    <img src="{{ asset('images/site/hero-smile.jpg') }}"
                         alt="A patient smiling confidently after dental care"
                         class="h-[420px] w-full object-cover object-center sm:h-[560px] lg:h-[660px]">
                    <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-ink/50 to-transparent" aria-hidden="true"></div>
                    <div class="absolute bottom-5 left-5 right-5 flex items-end justify-between gap-4 text-cream sm:bottom-7 sm:left-7 sm:right-7">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-cream/65">Your visit, considered</p>
                            <p class="mt-1 font-display text-[1.65rem] leading-tight tracking-[-0.03em]">A little calmer.<br>A lot brighter.</p>
                        </div>
                        <a href="{{ route('book') }}" class="grid size-12 shrink-0 place-items-center rounded-full bg-cream text-ink transition hover:bg-terracotta hover:text-white" aria-label="Book an appointment">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="absolute -left-3 top-8 hidden rounded-[18px] border border-line bg-cream/95 px-5 py-4 shadow-[0_14px_40px_rgba(60,61,66,0.1)] backdrop-blur sm:block lg:-left-8">
                    <p class="font-display text-[1.9rem] leading-none tracking-[-0.04em] text-ink">4.9<span class="text-terracotta">/5</span></p>
                    <div class="mt-2 flex items-center gap-0.5 text-terracotta" aria-label="5 star average rating">
                        @for ($star = 1; $star <= 5; $star++)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-muted">Patient rated</p>
                </div>
            </div>
        </div>
    </section>

    <x-public.marquee :phone="$clinicPhone" :doctor-name="$doctorName" />

    {{-- ================= About ================= --}}
    <section id="about" class="site-container py-20 lg:py-28">
        <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:gap-20">
            <div>
                <x-public.section-heading eyebrow="Our philosophy">
                    Dentistry that feels <em>personal.</em>
                </x-public.section-heading>

                <p class="body-copy mt-6">
                    At {{ $clinicName }}, we believe a dental visit should feel less like an appointment and more
                    like a conversation. {{ $doctorName }} takes the time to listen, explain every option and build a
                    plan around your life — never the other way around.
                </p>

                <p class="body-copy mt-4">
                    From a routine clean to a complete smile plan, every step is clear, gentle and honestly priced.
                    No pressure. No surprises. Just thoughtful care from people who remember your name.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('book') }}" class="btn-medio">
                        Book a visit
                        <span class="btn-medio-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </a>
                    @if ($reviewLink)
                        <a href="{{ $reviewLink }}" target="_blank" rel="noopener" class="link-arrow">
                            Read patient reviews
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </a>
                    @endif
                </div>

                <div class="mt-10 grid max-w-lg grid-cols-2 gap-6 border-t border-line pt-7 stats-container">
                    <div>
                        <p class="font-display text-[2.1rem] leading-none tracking-[-0.04em] text-ink"><span class="stat-counter" data-target="{{ $stats['happy_patients'] }}">{{ $stats['happy_patients'] }}</span>+</p>
                        <p class="mt-1.5 text-[12px] font-medium text-muted">Smiles cared for</p>
                    </div>
                    <div>
                        <p class="font-display text-[2.1rem] leading-none tracking-[-0.04em] text-ink"><span class="stat-counter" data-target="{{ $stats['years_experience'] }}">{{ $stats['years_experience'] }}</span>+</p>
                        <p class="mt-1.5 text-[12px] font-medium text-muted">Years of gentle care</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div class="row-span-2 overflow-hidden rounded-[24px]">
                        <img src="{{ asset('images/site/about-collage-3.jpg') }}"
                             alt="A dentist holding dental instruments"
                             class="h-full min-h-[330px] w-full object-cover sm:min-h-[460px]" loading="lazy">
                    </div>
                    <div class="overflow-hidden rounded-[24px]">
                        <img src="{{ asset('images/site/about-collage-1.jpg') }}"
                             alt="A patient relaxing during a dental visit"
                             class="h-40 w-full object-cover sm:h-56" loading="lazy">
                    </div>
                    <div class="overflow-hidden rounded-[24px]">
                        <img src="{{ asset('images/site/about-collage-2.jpg') }}"
                             alt="A patient showing a healthy smile"
                             class="h-40 w-full object-cover sm:h-56" loading="lazy">
                    </div>
                </div>

                <div class="absolute -bottom-6 left-6 max-w-[230px] rounded-[18px] bg-terracotta p-5 text-white shadow-[0_18px_45px_rgba(194,113,77,0.3)] sm:left-10">
                    <p class="font-display text-[1.45rem] leading-[1.15] tracking-[-0.03em]">Care that remembers you.</p>
                    <p class="mt-2 text-[11px] leading-5 text-white/75">Same dentist. Same warmth. Every visit.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= Benefits ================= --}}
    <section class="border-y border-line bg-beige/55">
        <div class="site-container grid gap-12 py-20 lg:grid-cols-[0.95fr_1.05fr] lg:items-center lg:gap-20 lg:py-28">
            <div class="relative order-2 lg:order-1">
                <div class="overflow-hidden rounded-[28px]">
                    <img src="{{ asset('images/site/benefits-smile.jpg') }}"
                         alt="A close-up of a healthy, confident smile"
                         class="h-[360px] w-full object-cover sm:h-[500px] lg:h-[560px]" loading="lazy">
                </div>
                <div class="absolute bottom-5 left-5 right-5 flex items-center justify-between gap-4 rounded-[18px] bg-cream/95 p-4 backdrop-blur sm:bottom-7 sm:left-7 sm:right-auto sm:max-w-[270px]">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-muted">Gentle by design</p>
                        <p class="mt-1 text-[13px] font-semibold leading-5 text-ink">Comfort checks at every step.</p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-full bg-terracotta text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="order-1 lg:order-2">
                <x-public.section-heading eyebrow="The Medio difference">
                    The little things that make a <em>big difference.</em>
                </x-public.section-heading>

                <p class="body-copy mt-6 max-w-lg">
                    Good dentistry is as much about how you feel as what happens in the chair. Here is what every
                    visit at our clinic is built around.
                </p>

                <div class="mt-8 grid gap-x-8 gap-y-7 sm:grid-cols-2">
                    @foreach ([
                        ['title' => 'Clear, upfront pricing', 'text' => 'Every treatment and visit duration is visible before you book.'],
                        ['title' => 'Time to be heard', 'text' => 'Unhurried appointments and a dentist who listens first.'],
                        ['title' => 'Modern, gentle care', 'text' => 'Minimally invasive techniques designed around your comfort.'],
                        ['title' => 'A plan you own', 'text' => 'No pressure and no surprises — decide what feels right for you.'],
                    ] as $benefit)
                        <div class="border-t border-ink/15 pt-4">
                            <h3 class="font-display text-[1.25rem] leading-tight tracking-[-0.025em] text-ink">{{ $benefit['title'] }}</h3>
                            <p class="mt-2 text-[13px] leading-6 text-body">{{ $benefit['text'] }}</p>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('treatments.index') }}" class="link-arrow mt-9">
                    Explore treatments
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ================= Services ================= --}}
    <section id="treatments" class="site-container py-20 lg:py-28">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-public.section-heading eyebrow="What we do">
                Considered care for <em>every smile.</em>
            </x-public.section-heading>

            <a href="{{ route('treatments.index') }}" class="btn-medio-light">
                All treatments
                <span class="grid size-9 place-items-center rounded-full border border-ink/15 text-ink" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </span>
            </a>
        </div>

        <div class="mt-10 border-t border-line stagger-cards">
            @foreach ($featuredTreatments->take(4) as $index => $treatment)
                <article class="treatment-row stagger-card group grid gap-4 border-b border-line py-6 sm:grid-cols-[48px_132px_minmax(0,1fr)_auto] sm:items-center sm:gap-6">
                    <span class="hidden font-display text-[1.2rem] italic text-terracotta sm:block">
                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <a href="{{ route('treatments.show', ['treatment' => $treatment->slug]) }}" class="overflow-hidden rounded-[14px]">
                        <img src="{{ asset('images/site/'.($serviceImages[$treatment->slug] ?? 'service-fillings.jpg')) }}"
                             alt="{{ $treatment->name }}"
                             class="aspect-[132/88] h-24 w-full object-cover object-center sm:h-[88px]" loading="lazy">
                    </a>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-baseline gap-x-4 gap-y-1">
                            <h3 class="font-display text-[1.55rem] leading-tight tracking-[-0.03em] text-ink">
                                <a href="{{ route('treatments.show', ['treatment' => $treatment->slug]) }}" class="transition group-hover:text-terracotta">
                                    {{ $treatment->name }}
                                </a>
                            </h3>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">{{ (int) $treatment->duration_minutes }} min visit</span>
                        </div>
                        <p class="mt-1.5 max-w-xl text-[13px] leading-6 text-body">
                            {{ $treatment->description ? \Illuminate\Support\Str::limit($treatment->description, 120) : 'Gentle, professionally delivered care with clear pricing and honest advice.' }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between gap-5 sm:justify-end">
                        <p class="font-display text-[1.35rem] tracking-[-0.03em] text-ink">${{ number_format((float) $treatment->cost, 2) }}</p>
                        <a href="{{ route('appointment', ['service' => $treatment->slug]) }}"
                           class="inline-flex items-center gap-2 text-[12px] font-semibold text-ink transition hover:text-terracotta">
                            Book this
                            <span class="grid size-8 place-items-center rounded-full border border-ink/15 transition group-hover:border-terracotta group-hover:bg-terracotta group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- ================= How it works ================= --}}
    <section id="how-it-works" class="site-container pb-20 lg:pb-28">
        <div class="dark-panel overflow-hidden rounded-[28px] px-6 py-12 sm:px-10 lg:px-14 lg:py-16">
            <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">
                <div>
                    <p class="eyebrow text-cream/55">
                        <span class="eyebrow-mark text-terracotta" aria-hidden="true">//</span>
                        How it works
                    </p>
                    <h2 class="display-title mt-4 text-[2.5rem] leading-[1.03] text-cream sm:text-[3.3rem]">
                        Supporting your path to a <em>healthier smile.</em>
                    </h2>
                    <p class="mt-5 max-w-sm text-[14px] leading-6 text-cream/60">
                        Three simple steps from “I should book that” to a calmer, brighter smile.
                    </p>
                    <a href="{{ route('book') }}" class="mt-7 inline-flex items-center gap-3 rounded-full bg-cream py-1.5 pl-6 pr-1.5 text-sm font-semibold text-ink transition hover:-translate-y-0.5 hover:bg-white">
                        Book online
                        <span class="grid size-9 place-items-center rounded-full bg-terracotta text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </a>
                </div>

                <ol class="grid gap-3 sm:grid-cols-3">
                    @foreach ($steps as $index => $step)
                        <li class="flex flex-col rounded-[18px] border border-cream/12 bg-white/[0.035] p-5">
                            <span class="grid size-9 place-items-center rounded-full border border-cream/20 font-display text-sm italic text-terracotta">
                                {{ $index + 1 }}
                            </span>
                            <h3 class="mt-8 font-display text-[1.2rem] leading-tight tracking-[-0.02em] text-cream">{{ $step['title'] }}</h3>
                            <p class="mt-2.5 text-[12px] leading-6 text-cream/55">{{ $step['text'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- ================= Team ================= --}}
    <section id="team" class="border-y border-line bg-beige/45">
        <div class="site-container py-20 lg:py-28">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-public.section-heading eyebrow="The people behind your care">
                    A team that takes the <em>time.</em>
                </x-public.section-heading>
                <a href="{{ route('book') }}" class="link-arrow">
                    Book with {{ explode(' ', $doctorName)[0] }} {{ explode(' ', $doctorName)[1] ?? '' }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </a>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4 stagger-cards">
                @foreach ([
                    ['name' => $doctorName, 'role' => 'Lead Dentist & Founder', 'image' => 'team-nadal.jpg'],
                    ['name' => 'Patient Care', 'role' => 'Front desk & scheduling', 'image' => 'team-lena.jpg'],
                    ['name' => 'Dental Hygiene', 'role' => 'Preventive care', 'image' => 'team-james.jpg'],
                    ['name' => 'Clinical Support', 'role' => 'Chair-side assistance', 'image' => 'team-alex.jpg'],
                ] as $member)
                    <article class="group stagger-card">
                        <div class="overflow-hidden rounded-[18px] bg-beige">
                            <img src="{{ asset('images/site/'.$member['image']) }}"
                                 alt="{{ $member['name'] }} — {{ $member['role'] }}"
                                 class="aspect-[3/4] h-[320px] w-full object-cover object-top transition duration-700 group-hover:scale-[1.03] sm:h-[360px]" loading="lazy">
                        </div>
                        <div class="mt-4 flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-display text-[1.3rem] leading-tight tracking-[-0.025em] text-ink">{{ $member['name'] }}</h3>
                                <p class="mt-1 text-[11px] font-medium uppercase tracking-[0.1em] text-muted">{{ $member['role'] }}</p>
                            </div>
                            <span class="mt-1 grid size-8 shrink-0 place-items-center rounded-full border border-ink/15 text-ink transition group-hover:border-terracotta group-hover:bg-terracotta group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                </svg>
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= Testimonials ================= --}}
    <section id="reviews" class="site-container py-20 lg:py-28">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-public.section-heading eyebrow="Patient stories">
                Kind words from <em>our patients.</em>
            </x-public.section-heading>
            <div class="flex items-center gap-3 pb-1">
                <div class="flex items-center gap-0.5 text-terracotta" aria-hidden="true">
                    @for ($star = 1; $star <= 5; $star++)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-[12px] font-semibold text-ink">4.9 average rating</p>
            </div>
        </div>

        <div class="mt-10 grid gap-5 lg:grid-cols-[0.78fr_1.22fr]">
            <figure class="relative overflow-hidden rounded-[24px] bg-terracotta p-6 text-white sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <span class="font-display text-[4rem] leading-none text-white/30" aria-hidden="true">“</span>
                    <div class="flex items-center gap-0.5 text-cream" aria-label="5 out of 5 stars">
                        @for ($star = 1; $star <= 5; $star++)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd"/>
                            </svg>
                        @endfor
                    </div>
                </div>

                <blockquote class="relative mt-2 font-display text-[1.8rem] leading-[1.22] tracking-[-0.03em] sm:text-[2.15rem]">
                    “{{ $testimonials[0]['text'] }}”
                </blockquote>

                <figcaption class="mt-8 flex items-center gap-3 border-t border-white/25 pt-5">
                    <img src="{{ asset('images/site/testimonial-1.jpg') }}" alt="{{ $testimonials[0]['name'] }}"
                         class="size-11 rounded-full object-cover grayscale-[15%]" loading="lazy">
                    <div>
                        <p class="text-sm font-semibold">{{ $testimonials[0]['name'] }}</p>
                        <p class="mt-0.5 text-[11px] text-white/65">{{ $testimonials[0]['treatment'] }} · verified patient</p>
                    </div>
                </figcaption>
            </figure>

            <div class="rounded-[24px] border border-line bg-white px-5 py-2 sm:px-7">
                @foreach (array_slice($testimonials, 1) as $index => $testimonial)
                    <details class="group border-b border-line/70 py-5 last:border-b-0" @if ($index === 0) open @endif>
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 [&::-webkit-details-marker]:hidden">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/site/testimonial-'.(($index % 3) + 1).'.jpg') }}"
                                     alt="" class="size-9 rounded-full object-cover grayscale-[20%]" loading="lazy">
                                <div>
                                    <p class="text-sm font-semibold text-ink">{{ $testimonial['name'] }}</p>
                                    <p class="mt-0.5 text-[10px] font-medium uppercase tracking-[0.1em] text-muted">{{ $testimonial['treatment'] }}</p>
                                </div>
                            </div>
                            <span class="grid size-8 shrink-0 place-items-center rounded-full border border-ink/15 text-ink transition group-open:border-terracotta group-open:bg-terracotta group-open:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5 group-open:hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="hidden size-3.5 group-open:block">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-4 pr-12 font-form text-[13px] leading-6 text-body">“{{ $testimonial['text'] }}”</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= Journal ================= --}}
    <section class="border-y border-line bg-beige/45">
        <div class="site-container py-20 lg:py-28">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-public.section-heading eyebrow="Notes from the clinic">
                    A little dental <em>know-how.</em>
                </x-public.section-heading>
                <p class="max-w-xs text-[12px] leading-5 text-muted">Practical notes from our team, written to make your next visit feel a little more familiar.</p>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-3">
                @foreach ($journal as $article)
                    <article class="journal-card group flex flex-col">
                        <a href="{{ route('blog.show', ['slug' => $article['post']]) }}" class="overflow-hidden rounded-[18px]">
                            <img src="{{ asset('images/site/'.$article['image']) }}" alt=""
                                 class="h-[250px] w-full object-cover" loading="lazy">
                        </a>
                        <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">{{ $article['read'] }}</p>
                        <h3 class="mt-2 font-display text-[1.45rem] leading-[1.12] tracking-[-0.03em] text-ink">
                            <a href="{{ route('blog.show', ['slug' => $article['post']]) }}" class="transition group-hover:text-terracotta">{{ $article['title'] }}</a>
                        </h3>
                        <p class="mt-2 flex-1 text-[13px] leading-6 text-body">{{ $article['excerpt'] }}</p>
                        <a href="{{ route('blog.show', ['slug' => $article['post']]) }}" class="link-arrow mt-4">
                            Read the note
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= Location & hours ================= --}}
    <section id="location" class="site-container py-20 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16">
            <div>
                <x-public.section-heading eyebrow="Find us">
                    Easy to reach. <em>Easy to feel at home.</em>
                </x-public.section-heading>

                <div class="relative mt-7 h-[310px] overflow-hidden rounded-[24px] border border-line bg-beige">
                    <svg class="absolute inset-0 h-full w-full text-[#d8d0c2]" aria-hidden="true">
                        <defs>
                            <pattern id="map-grid" width="36" height="36" patternUnits="userSpaceOnUse">
                                <path d="M36 0H0v36" fill="none" stroke="currentColor" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#map-grid)"/>
                        <path d="M0 215 C 120 190, 200 258, 340 225 S 560 160, 820 195" fill="none" stroke="#c8beb0" stroke-width="12" opacity="0.75"/>
                        <path d="M185 0 C 205 90, 160 180, 195 310" fill="none" stroke="#d8d0c2" stroke-width="9"/>
                        <path d="M530 0 C 505 110, 565 200, 535 310" fill="none" stroke="#d8d0c2" stroke-width="9"/>
                    </svg>
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                        <span class="grid size-14 place-items-center rounded-full bg-terracotta text-white shadow-[0_12px_30px_rgba(194,113,77,0.4)] ring-4 ring-cream">
                            <x-public.tooth-icon class="size-7" />
                        </span>
                    </div>
                    <div class="absolute inset-x-4 bottom-4 flex items-center justify-between gap-3 rounded-[16px] bg-cream/95 px-4 py-3 backdrop-blur">
                        <p class="min-w-0 truncate text-[12px] font-semibold text-ink">{{ $clinicAddress }}</p>
                        <a href="https://maps.google.com/?q={{ urlencode((string) $clinicAddress) }}" target="_blank" rel="noopener"
                           class="shrink-0 text-[11px] font-semibold text-terracotta underline-offset-2 hover:underline">Maps</a>
                    </div>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <a href="tel:{{ preg_replace('/\s+/', '', (string) $clinicPhone) }}" class="soft-card p-4 transition hover:border-terracotta/40 hover:bg-white">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Call the clinic</p>
                        <p class="mt-1.5 text-sm font-semibold text-ink">{{ $clinicPhone }}</p>
                    </a>
                    <a href="{{ route('book') }}" class="soft-card p-4 transition hover:border-terracotta/40 hover:bg-white">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Book online</p>
                        <p class="mt-1.5 text-sm font-semibold text-ink">Choose your time in under a minute</p>
                    </a>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between gap-3">
                    <h3 class="font-display text-[1.6rem] tracking-[-0.03em] text-ink">Opening hours</h3>
                    <span @class([
                        'status-pill',
                        'border-[#b9d8c3] bg-[#edf7ef] text-[#346346]' => $openStatus['is_open'],
                        'border-line bg-white/55 text-muted' => ! $openStatus['is_open'],
                    ])>
                        <span @class([
                            'status-dot',
                            'bg-[#3f9660]' => $openStatus['is_open'],
                            'bg-terracotta' => ! $openStatus['is_open'],
                        ])></span>
                        {{ $openStatus['label'] }}
                    </span>
                </div>

                <div class="mt-5 overflow-hidden rounded-[24px] border border-line bg-white">
                    @foreach ($weeklySchedule as $day)
                        <div @class([
                            'flex items-center justify-between gap-4 border-b border-line/60 px-5 py-3.5 last:border-b-0',
                            'bg-beige/65' => $day['is_today'],
                        ])>
                            <p @class([
                                'text-[12px] font-semibold',
                                'text-ink' => $day['is_today'],
                                'text-body' => ! $day['is_today'],
                            ])>
                                {{ $day['day'] }}
                                @if ($day['is_today'])
                                    <span class="ml-2 rounded-full bg-terracotta/10 px-2 py-0.5 text-[9px] font-semibold uppercase tracking-[0.1em] text-terracotta">Today</span>
                                @endif
                            </p>
                            <p @class([
                                'text-[12px] font-semibold',
                                'text-ink' => $day['is_today'] || $day['is_open_day'],
                                'text-muted' => ! $day['is_open_day'],
                            ])>{{ $day['hours'] }}</p>
                        </div>
                    @endforeach
                </div>

                <p class="mt-4 text-[11px] leading-5 text-muted">
                    Slots are 30 minutes. Longer treatments book consecutive slots automatically, so the availability
                    you see online is always the availability you get.
                </p>
            </div>
        </div>
    </section>

    <x-public.appointment-cta/>

</x-layouts.public>
