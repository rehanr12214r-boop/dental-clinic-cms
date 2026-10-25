@props([
    'eyebrow' => null,
    'align' => 'left',
    'as' => 'h2',
    'description' => null,
])

<div {{ $attributes->merge(['class' => $align === 'center' ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl']) }}>
    @if ($eyebrow)
        <p @class(['eyebrow', 'justify-center' => $align === 'center'])>
            <span class="eyebrow-mark" aria-hidden="true">//</span>
            {{ $eyebrow }}
        </p>
    @endif

    <{{ $as }} class="display-title mt-4 section-title">
        {{ $slot }}
    </{{ $as }}>

    @if ($description)
        <p @class(['body-copy mt-5', 'mx-auto' => $align === 'center'])>{{ $description }}</p>
    @endif
</div>
