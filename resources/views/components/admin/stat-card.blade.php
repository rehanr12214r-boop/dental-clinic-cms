@props([
    'label' => '',
    'value' => '',
    'tone' => 'slate',
    'hint' => null,
])

@php
    $tones = [
        'slate' => ['card' => '', 'value' => 'text-slate-900'],
        'amber' => ['card' => 'bg-amber-50/70 ring-amber-600/20', 'value' => 'text-amber-700'],
        'sky' => ['card' => 'bg-sky-50/70 ring-sky-600/20', 'value' => 'text-sky-700'],
        'violet' => ['card' => 'bg-violet-50/70 ring-violet-600/20', 'value' => 'text-violet-700'],
        'emerald' => ['card' => 'bg-emerald-50/70 ring-emerald-600/20', 'value' => 'text-emerald-700'],
        'rose' => ['card' => 'bg-rose-50/70 ring-rose-600/20', 'value' => 'text-rose-700'],
    ];
@endphp

<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200/70 {{ $tones[$tone]['card'] }}">
    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">{{ $label }}</p>
    <p class="mt-2 text-2xl font-bold tracking-tight {{ $tones[$tone]['value'] }}">{{ $value }}</p>
    @if ($hint)
        <p class="mt-1 text-xs font-medium text-slate-500">{{ $hint }}</p>
    @endif
</div>
