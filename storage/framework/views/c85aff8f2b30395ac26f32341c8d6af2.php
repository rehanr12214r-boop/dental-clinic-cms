<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $classes = match ($status) {
        \App\Enums\AppointmentStatus::Pending => 'bg-[#f7eddf] text-[#8b5a2b] border-[#e6cfad]',
        \App\Enums\AppointmentStatus::Confirmed => 'bg-[#e9f2e9] text-[#346346] border-[#c8ddca]',
        \App\Enums\AppointmentStatus::InClinic => 'bg-[#eee9f4] text-[#5d4b75] border-[#d9cee7]',
        \App\Enums\AppointmentStatus::Completed => 'bg-beige text-stat border-line',
        \App\Enums\AppointmentStatus::Cancelled => 'bg-[#f9e9e4] text-[#963f2b] border-[#eccbc1]',
    };
?>

<span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.08em] <?php echo e($classes); ?>">
    <?php echo e($status->label()); ?>

</span>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\public\status-badge.blade.php ENDPATH**/ ?>