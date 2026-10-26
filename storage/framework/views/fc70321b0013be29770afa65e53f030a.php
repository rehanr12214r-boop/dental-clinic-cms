<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => '',
    'value' => '',
    'tone' => 'slate',
    'hint' => null,
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
    'label' => '',
    'value' => '',
    'tone' => 'slate',
    'hint' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $tones = [
        'slate' => ['card' => '', 'value' => 'text-slate-900'],
        'amber' => ['card' => 'bg-amber-50/70 ring-amber-600/20', 'value' => 'text-amber-700'],
        'sky' => ['card' => 'bg-sky-50/70 ring-sky-600/20', 'value' => 'text-sky-700'],
        'violet' => ['card' => 'bg-violet-50/70 ring-violet-600/20', 'value' => 'text-violet-700'],
        'emerald' => ['card' => 'bg-emerald-50/70 ring-emerald-600/20', 'value' => 'text-emerald-700'],
        'rose' => ['card' => 'bg-rose-50/70 ring-rose-600/20', 'value' => 'text-rose-700'],
    ];
?>

<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200/70 <?php echo e($tones[$tone]['card']); ?>">
    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500"><?php echo e($label); ?></p>
    <p class="mt-2 text-2xl font-bold tracking-tight <?php echo e($tones[$tone]['value']); ?>"><?php echo e($value); ?></p>
    <?php if($hint): ?>
        <p class="mt-1 text-xs font-medium text-slate-500"><?php echo e($hint); ?></p>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\admin\stat-card.blade.php ENDPATH**/ ?>