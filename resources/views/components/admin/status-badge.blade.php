@props(['status'])

<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $status->badgeClass() }}">
    {{ $status->label() }}
</span>
