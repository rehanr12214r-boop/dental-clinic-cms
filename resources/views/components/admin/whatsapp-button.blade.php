@props(['url', 'template', 'label'])

<button type="button"
        data-whatsapp-send
        data-whatsapp-url="{{ $url }}"
        data-whatsapp-template="{{ $template }}"
        {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-600/20 transition hover:bg-emerald-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 disabled:cursor-wait disabled:opacity-70']) }}>
    <x-admin.whatsapp-icon class="size-3.5 shrink-0"/>
    <span data-whatsapp-label>{{ $label }}</span>
</button>
