<x-layouts.public title="About Us">

    <x-public.page-hero
        title="<span class='text-terracotta italic'>Our Mission</span> is to Make you<br>Smile More Beautiful."
        description="Harness the power of artificial intelligence to unlock faster diagnoses, tailored treatment plans, and proactive care."
        :breadcrumb="[['label' => 'Home', 'url' => route('home')], ['label' => 'About Us']]"
    />

    <section class="site-container pb-16">
        <div class="overflow-hidden rounded-[12px] bg-beige">
            <img src="{{ asset('images/site/about-hero.jpg') }}"
                 alt="A dentist caring for a patient at the clinic"
                 class="aspect-[1296/548] w-full object-cover"
                 loading="eager">
        </div>
    </section>

    <section class="site-container pb-20 lg:pb-24">
        <p class="text-center font-display text-[20px] leading-[1.25] text-ink">Trusted Partners</p>

        <div class="mt-8 grid grid-cols-2 gap-6 sm:grid-cols-4">
            @foreach ([
                ['name' => 'Springfield', 'image' => 'partner-springfield.jpg'],
                ['name' => 'Sweden', 'image' => 'partner-sweden.jpg'],
                ['name' => 'Delaware', 'image' => 'partner-delaware.jpg'],
                ['name' => 'Umbrella', 'image' => 'partner-umbrella.jpg'],
            ] as $partner)
                <div class="flex h-[80px] items-center justify-center rounded-[8px] bg-white px-6 transition duration-200 hover:shadow-[0_8px_20px_rgba(60,61,66,0.05)]">
                    <img src="{{ asset('images/site/'.$partner['image']) }}"
                         alt="{{ $partner['name'] }}"
                         class="max-h-8 w-auto max-w-full object-contain opacity-75 grayscale transition hover:opacity-100 hover:grayscale-0"
                         loading="lazy">
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-beige py-20 lg:py-24">
        <div class="site-container">
            <div class="grid items-stretch gap-5 lg:grid-cols-2">
                <div class="rounded-[20px] bg-white p-8 sm:p-12 lg:p-16">
                    <h2 class="font-display text-[38px] font-normal leading-[1.2] text-ink sm:text-[48px]">
                        What we<br>stand for!
                    </h2>

                    <div class="mt-9 border-t border-line/80">
                        @foreach ([
                            [
                                'title' => 'Patient-Centered Care',
                                'body' => 'Your comfort, goals and questions guide every decision we make — never the other way around.',
                                'open' => false,
                            ],
                            [
                                'title' => 'Clinical Excellence',
                                'body' => 'Evidence-led dentistry, modern tools and careful attention to detail at every appointment.',
                                'open' => false,
                            ],
                            [
                                'title' => 'Trust & Transparency',
                                'body' => 'We believe in honest communication and clear guidance at every step.',
                                'open' => true,
                            ],
                            [
                                'title' => 'Comfort & Care',
                                'body' => 'Gentle techniques, clear aftercare and a team that never rushes you through your visit.',
                                'open' => false,
                            ],
                        ] as $value)
                            <details class="group border-b border-line/80" @if ($value['open']) open @endif>
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-5 font-display text-[20px] leading-[1.2] text-ink marker:hidden [&::-webkit-details-marker]:hidden">
                                    {{ $value['title'] }}
                                    <span class="grid size-8 shrink-0 place-items-center rounded-full border border-line text-ink transition group-open:rotate-45 group-open:border-terracotta group-open:text-terracotta">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                                        </svg>
                                    </span>
                                </summary>
                                <p class="max-w-md pb-5 text-[15px] leading-[1.6] text-body">{{ $value['body'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>

                <div class="min-h-[420px] overflow-hidden rounded-[20px] bg-white lg:min-h-[622px]">
                    <img src="{{ asset('images/site/about-collage-2.jpg') }}"
                         alt="A calm, welcoming dental treatment room"
                         class="h-full w-full object-cover"
                         loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <section class="site-container py-20 lg:py-24">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach (array_slice($team, 0, 3) as $dentist)
                <x-public.dentist-card :dentist="$dentist"/>
            @endforeach

            <x-public.dentist-card :dentist="$team[3]"/>

            <div class="flex min-h-[361px] flex-col items-center justify-center rounded-[10px] px-8 text-center">
                <p class="flex items-center gap-2 text-[15px] text-body">
                    <span class="text-terracotta" aria-hidden="true">//</span>
                    Dentists
                </p>
                <h2 class="mt-4 font-display text-[42px] font-semibold leading-[1.2] text-ink sm:text-[56px]">
                    A Trusted,<br>Caring Team.
                </h2>
                <a href="{{ route('dentists.index') }}" class="link-arrow mt-6">
                    Meet the team
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </a>
            </div>

            <x-public.dentist-card :dentist="$team[4]"/>
        </div>
    </section>

    <x-public.appointment-cta/>

</x-layouts.public>
