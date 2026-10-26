<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['class' => 'size-6']));

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

foreach (array_filter((['class' => 'size-6']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<svg <?php echo e($attributes->merge(['class' => $class])); ?> viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="1.6" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M12 5.4c-1.2-1.35-2.65-1.95-4.15-1.95-2.7 0-4.3 2.05-4.3 4.8 0 2.55.95 4.2 1.65 6.25.6 1.75.9 3.6 1.55 5.05.3.65.85.95 1.35.85.6-.1.9-.6 1-1.35.2-1.65.3-3.5.75-4.55.2-.4.6-.7 1.05-.7s.85.3 1.05.7c.45 1.05.55 2.9.75 4.55.1.75.4 1.25 1 1.35.5.1 1.05-.2 1.35-.85.65-1.45.95-3.3 1.55-5.05.7-2.05 1.65-3.7 1.65-6.25 0-2.75-1.6-4.8-4.3-4.8-1.5 0-2.95.6-4.15 1.95Z"/>
</svg>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\public\tooth-icon.blade.php ENDPATH**/ ?>