<x-layouts.public title="Our Services">

    @php
        $images = [
            'teeth-cleaning' => 'service-whitening.jpg',
            'root-canal' => 'service-root-canal.jpg',
            'general-checkup' => 'benefits-smile.jpg',
            'tooth-extraction' => 'service-fillings.jpg',
            'braces-consultation' => 'service-orthodontics.jpg',
        ];
    @endphp

    <x-public.page-hero
        title="Our Services"
        description="Treatments & transparent pricing — explore our comprehensive dental services designed to keep your smile healthy, bright, and confident."
        :breadcrumb="[['label' => 'Home', 'url' => route('home')], ['label' => 'Services']]"
    />

    <section class="site-container pb-20 lg:pb-24">
        @if ($workingHours)
            <div class="mb-10 flex justify-center">
                <span class="status-pill normal-case tracking-normal">{{ $workingHours }}</span>
            </div>
        @endif

        <div class="space-y-10 lg:space-y-12 stagger-cards">
            @forelse ($treatments as $treatment)
                <div class="treatment-row stagger-card group grid gap-6 lg:grid-cols-2">
                    <div class="flex min-h-[226px] flex-col items-center justify-center rounded-[12px] bg-white px-8 py-8 text-center transition duration-300 hover:shadow-[0_16px_40px_rgba(60,61,66,0.06)]">
                        <h2 class="font-display text-[24px] font-bold leading-[1.2] text-ink">
                            <a href="{{ route('treatments.show', ['treatment' => $treatment->slug]) }}" class="transition hover:text-terracotta">
                                {{ $treatment->name }}
                            </a>
                        </h2>

                        @if ($treatment->description)
                            <p class="mt-2.5 max-w-md text-[14px] leading-[1.6] text-body line-clamp-2">{{ $treatment->description }}</p>
                        @endif

                        <div class="mt-4 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-[13px] text-body">
                            <span>{{ $treatment->duration_minutes }} min visit</span>
                            <span class="size-1 rounded-full bg-line" aria-hidden="true"></span>
                            <span class="font-semibold text-ink">${{ number_format((float) $treatment->cost, 2) }}</span>
                        </div>

                        <div class="mt-5 flex items-center justify-center gap-3">
                            <a href="{{ route('treatments.show', ['treatment' => $treatment->slug]) }}"
                               class="text-[13px] font-medium text-body underline-offset-4 hover:text-terracotta hover:underline">
                                Details
                            </a>
                            <a href="{{ route('appointment', ['service' => $treatment->slug]) }}"
                               class="inline-flex items-center gap-1.5 rounded-full bg-ink px-4 py-1.5 text-[12px] font-semibold text-white transition hover:bg-near-black">
                                Book online
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('treatments.show', ['treatment' => $treatment->slug]) }}"
                       class="block min-h-[226px] overflow-hidden rounded-[12px] bg-beige">
                        <img src="{{ asset('images/site/'.($images[$treatment->slug] ?? 'benefits-smile.jpg')) }}"
                             alt="{{ $treatment->name }}"
                             class="h-full min-h-[226px] w-full object-cover object-center transition duration-700 hover:scale-[1.04]"
                             loading="lazy">
                    </a>
                </div>
            @empty
                <p class="rounded-[12px] bg-white p-10 text-center text-body">
                    Our treatment list is being updated. Please contact the clinic for current services.
                </p>
            @endforelse
        </div>
    </section>

    <x-public.appointment-cta/>

</x-layouts.public>
