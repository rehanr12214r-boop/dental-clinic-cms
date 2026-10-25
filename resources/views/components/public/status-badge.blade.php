@props(['status'])

@php
    $classes = match ($status) {
        \App\Enums\AppointmentStatus::Pending => 'bg-[#f7eddf] text-[#8b5a2b] border-[#e6cfad]',
        \App\Enums\AppointmentStatus::Confirmed => 'bg-[#e9f2e9] text-[#346346] border-[#c8ddca]',
        \App\Enums\AppointmentStatus::InClinic => 'bg-[#eee9f4] text-[#5d4b75] border-[#d9cee7]',
        \App\Enums\AppointmentStatus::Completed => 'bg-beige text-stat border-line',
        \App\Enums\AppointmentStatus::Cancelled => 'bg-[#f9e9e4] text-[#963f2b] border-[#eccbc1]',
    };
@endphp

<span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.08em] {{ $classes }}">
    {{ $status->label() }}
</span>
