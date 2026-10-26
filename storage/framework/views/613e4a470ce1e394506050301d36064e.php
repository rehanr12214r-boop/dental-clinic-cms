<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['phone' => null, 'doctorName' => null]));

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

foreach (array_filter((['phone' => null, 'doctorName' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $marqueeItems = [
        'Now welcoming new patients',
        'Same-day emergency care',
        'Instant WhatsApp confirmation',
        $phone ?: 'Call the clinic',
        'Open six days a week',
        $doctorName ?: 'Gentle, personal dentistry',
    ];
?>

<div class="marquee border-y border-ink/10 bg-lavender" aria-label="Clinic highlights">
    <div class="marquee-track">
        <?php $__currentLoopData = [0, 1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loopIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex shrink-0 items-center" <?php if($loopIndex === 1): ?> aria-hidden="true" <?php endif; ?>>
                <?php $__currentLoopData = $marqueeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="flex items-center gap-8 px-5 py-3.5 text-[12px] font-semibold uppercase tracking-[0.16em] text-ink/80 sm:px-8">
                        <?php echo e($item); ?>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3 shrink-0 text-terracotta">
                            <path d="M10 1.667 12.163 7.837 18.333 10l-6.17 2.163L10 18.333l-2.163-6.17L1.667 10l6.17-2.163L10 1.667Z"/>
                        </svg>
                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/components/public/marquee.blade.php ENDPATH**/ ?>