@props([
    'title',
    'description' => null,
    'breadcrumb' => [],
    'align' => 'center',
])

@php
    $centered = $align === 'center';
@endphp

<section class="page-hero-section bg-cream">
    <div @class([
        'site-container pb-12 pt-16 lg:pt-[4.4rem]',
        'text-center' => $centered,
    ])>
        <h1 @class([
            'page-hero-title font-display text-[2.35rem] font-semibold leading-[1.2] tracking-[-0.02em] text-ink sm:text-[2.75rem] lg:text-[3rem]',
            'mx-auto max-w-4xl' => $centered,
            'max-w-3xl' => ! $centered,
        ])>{!! $title !!}</h1>

        @if ($description)
            <p @class([
                'page-hero-description mt-4 text-[15px] leading-[1.6] text-body sm:text-base',
                'mx-auto max-w-2xl' => $centered,
                'max-w-2xl' => ! $centered,
            ])>{{ $description }}</p>
        @endif

        @if ($breadcrumb !== [])
            <nav @class([
                'page-hero-breadcrumb mt-9 flex flex-wrap items-center gap-2 text-[15px] leading-5 text-body',
                'justify-center' => $centered,
            ]) aria-label="Breadcrumb">
                @foreach ($breadcrumb as $item)
                    @php
                        $label = is_array($item) ? $item['label'] : $item;
                        $url = is_array($item) ? ($item['url'] ?? null) : null;
                    @endphp

                    @if (! $loop->first)
                        <span class="text-body/50" aria-hidden="true">/</span>
                    @endif

                    @if ($url)
                        <a href="{{ $url }}" class="transition hover:text-terracotta">{{ $label }}</a>
                    @else
                        <span @if ($loop->last) aria-current="page" @endif class="{{ $loop->last ? 'text-ink' : '' }}">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        @endif
    </div>
</section>
