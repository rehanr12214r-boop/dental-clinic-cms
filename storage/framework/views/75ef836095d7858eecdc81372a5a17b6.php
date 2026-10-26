<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'href',
    'label',
    'active' => false,
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
    'href',
    'label',
    'active' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $linkClasses = $active
        ? 'bg-white/10 text-white ring-1 ring-white/15'
        : 'text-slate-300 hover:bg-white/5 hover:text-white';
    $iconClasses = $active
        ? 'text-sky-400'
        : 'text-slate-500 group-hover:text-slate-300';
?>

<a href="<?php echo e($href); ?>"
   <?php echo e($attributes->merge(['class' => "group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-400 {$linkClasses}"])); ?>

   <?php echo e($active ? 'aria-current="page"' : ''); ?>>
    <span class="<?php echo e($iconClasses); ?>"><?php echo e($slot); ?></span>
    <span><?php echo e($label); ?></span>
    <?php if($active): ?>
        <span class="ml-auto size-1.5 rounded-full bg-sky-400" aria-hidden="true"></span>
    <?php endif; ?>
</a>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\admin\nav-link.blade.php ENDPATH**/ ?>