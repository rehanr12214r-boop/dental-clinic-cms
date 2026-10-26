@props(['phone' => null, 'doctorName' => null])

@php
    $marqueeItems = [
        'Now welcoming new patients',
        'Same-day emergency care',
        'Instant WhatsApp confirmation',
        $phone ?: 'Call the clinic',
        'Open six days a week',
        $doctorName ?: 'Gentle, personal dentistry',
    ];
@endphp

<div class="marquee border-y border-ink/10 bg-lavender" aria-label="Clinic highlights">
    <div class="marquee-track">
        @foreach ([0, 1] as $loopIndex)
            <div class="flex shrink-0 items-center" @if ($loopIndex === 1) aria-hidden="true" @endif>
                @foreach ($marqueeItems as $item)
                    <span class="flex items-center gap-8 px-5 py-3.5 text-[12px] font-semibold uppercase tracking-[0.16em] text-ink/80 sm:px-8">
                        {{ $item }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3 shrink-0 text-terracotta">
                            <path d="M10 1.667 12.163 7.837 18.333 10l-6.17 2.163L10 18.333l-2.163-6.17L1.667 10l6.17-2.163L10 1.667Z"/>
                        </svg>
                    </span>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
