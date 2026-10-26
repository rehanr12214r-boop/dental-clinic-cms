@props([
    'href',
    'label',
    'active' => false,
])

@php
    $linkClasses = $active
        ? 'bg-white/10 text-white ring-1 ring-white/15'
        : 'text-slate-300 hover:bg-white/5 hover:text-white';
    $iconClasses = $active
        ? 'text-sky-400'
        : 'text-slate-500 group-hover:text-slate-300';
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => "group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-400 {$linkClasses}"]) }}
   {{ $active ? 'aria-current="page"' : '' }}>
    <span class="{{ $iconClasses }}">{{ $slot }}</span>
    <span>{{ $label }}</span>
    @if ($active)
        <span class="ml-auto size-1.5 rounded-full bg-sky-400" aria-hidden="true"></span>
    @endif
</a>
