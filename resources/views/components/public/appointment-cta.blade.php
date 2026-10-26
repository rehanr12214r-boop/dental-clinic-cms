@props([
    'title' => 'Get the Smile You Deserve Today!',
    'description' => null,
    'href' => null,
    'label' => 'Make An Appointment',
])

@php
    $href = $href ?: route('book');
@endphp

<section class="relative isolate overflow-hidden bg-dark text-cream">
    <div class="dark-panel absolute inset-0 -z-10" aria-hidden="true"></div>

    <div class="pointer-events-none absolute inset-0 hidden lg:block" aria-hidden="true">
        <div class="absolute left-[0.3%] top-[16%] w-[14.3%] overflow-hidden">
            <img src="{{ asset('images/site/cta-3.jpg') }}" alt="" class="aspect-[206/183] w-full object-cover" loading="lazy">
        </div>
        <div class="absolute right-[4.3%] top-[14%] w-[22.8%] overflow-hidden">
            <img src="{{ asset('images/site/cta-2.jpg') }}" alt="" class="aspect-[329/291] w-full object-cover" loading="lazy">
        </div>
        <div class="absolute bottom-[11.9%] left-0 w-[26.1%] overflow-hidden">
            <img src="{{ asset('images/site/cta-1.jpg') }}" alt="" class="aspect-[376/333] w-full object-cover" loading="lazy">
        </div>
        <div class="absolute bottom-[17.7%] right-[16.2%] w-[14.7%] overflow-hidden">
            <img src="{{ asset('images/site/cta-4.jpg') }}" alt="" class="aspect-[212/188] w-full object-cover" loading="lazy">
        </div>
    </div>

    <div class="site-container relative z-10 flex min-h-[540px] flex-col items-center justify-center py-24 text-center lg:min-h-[953px] lg:py-32">
        <p class="flex items-center gap-2 text-[16px] font-normal text-cream/70">
            <span class="font-normal tracking-normal text-terracotta" aria-hidden="true">//</span>
            Appointment
        </p>

        <h2 class="mt-5 max-w-[620px] font-display text-[2.7rem] font-semibold leading-[1.1] tracking-[-0.02em] text-cream sm:text-[3.5rem]">
            {!! nl2br(e($title)) !!}
        </h2>

        @if ($description)
            <p class="mt-5 max-w-xl text-[15px] leading-7 text-cream/65">{{ $description }}</p>
        @endif

        <a href="{{ $href }}" class="group mt-9 inline-flex items-center gap-3 rounded-full bg-cream py-[7px] pl-6 pr-[7px] text-[18px] font-bold text-ink transition duration-200 hover:-translate-y-0.5 hover:bg-white">
            {{ $label }}
            <span class="grid size-11 place-items-center rounded-full bg-terracotta text-white transition duration-200 group-hover:rotate-[-8deg]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                </svg>
            </span>
        </a>
    </div>
</section>
