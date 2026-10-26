<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'eyebrow' => null,
    'align' => 'left',
    'as' => 'h2',
    'description' => null,
]));

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

foreach (array_filter(([
    'eyebrow' => null,
    'align' => 'left',
    'as' => 'h2',
    'description' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => $align === 'center' ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl'])); ?>>
    <?php if($eyebrow): ?>
        <p class="<?php echo \Illuminate\Support\Arr::toCssClasses(['eyebrow', 'justify-center' => $align === 'center']); ?>">
            <span class="eyebrow-mark" aria-hidden="true">//</span>
            <?php echo e($eyebrow); ?>

        </p>
    <?php endif; ?>

    <<?php echo e($as); ?> class="display-title mt-4 section-title">
        <?php echo e($slot); ?>

    </<?php echo e($as); ?>>

    <?php if($description): ?>
        <p class="<?php echo \Illuminate\Support\Arr::toCssClasses(['body-copy mt-5', 'mx-auto' => $align === 'center']); ?>"><?php echo e($description); ?></p>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/components/public/section-heading.blade.php ENDPATH**/ ?>