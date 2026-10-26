@props([
    'title',
    'subtitle' => null,
    'eyebrow' => 'Patient portal',
    'image' => 'appointment-hero.jpg',
    'quote' => null,
    'compact' => false,
])

<section class="bg-cream">
    <div class="site-container py-14 sm:py-20">
        <div @class([
            'mx-auto overflow-hidden rounded-[28px] border border-line bg-white shadow-[0_24px_70px_rgba(60,61,66,0.08)]',
            'max-w-md' => $compact,
            'grid max-w-5xl lg:grid-cols-[0.85fr_1.15fr]' => ! $compact,
        ])>
            @unless ($compact)
                <div class="relative hidden min-h-[640px] lg:block">
                    <img src="{{ asset('images/site/'.$image) }}" alt=""
                         class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/20 to-transparent" aria-hidden="true"></div>
                    <div class="relative flex h-full flex-col justify-between p-8 text-cream">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.16em] text-cream/75 transition hover:text-cream">
                            <span class="grid size-7 place-items-center rounded-full border border-cream/30">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                                </svg>
                            </span>
                            Back to clinic
                        </a>
                        <div>
                            <p class="font-display text-[2.1rem] leading-[1.1] tracking-[-0.03em]">
                                {{ $quote ?: 'Your care, remembered.' }}
                            </p>
                            <p class="mt-3 max-w-xs text-[12px] leading-6 text-cream/65">
                                Upcoming visits, treatment history and receipts — all in one calm place.
                            </p>
                        </div>
                    </div>
                </div>
            @endunless

            <div class="p-6 sm:p-10 lg:p-12">
                <p class="eyebrow">
                    <span class="eyebrow-mark" aria-hidden="true">//</span>
                    {{ $eyebrow }}
                </p>
                <h1 class="display-title mt-4 text-[2.3rem] leading-[1.02] text-ink sm:text-[2.8rem]">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="mt-3 max-w-md text-[12px] leading-6 text-body">{{ $subtitle }}</p>
                @endif

                <div class="mt-7">
                    {{ $slot }}
                </div>

                @isset($footer)
                    <div class="mt-7 border-t border-line/70 pt-5 text-center text-[12px] text-body">
                        {{ $footer }}
                    </div>
                @endisset
            </div>
        </div>

        @isset($note)
            <div class="mx-auto mt-5 max-w-5xl text-center text-[10px] leading-5 text-muted">
                {{ $note }}
            </div>
        @endisset
    </div>
</section>
