<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Get the Smile You Deserve Today!',
    'description' => null,
    'href' => null,
    'label' => 'Make An Appointment',
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
    'title' => 'Get the Smile You Deserve Today!',
    'description' => null,
    'href' => null,
    'label' => 'Make An Appointment',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $href = $href ?: route('book');
?>

<section class="relative isolate overflow-hidden bg-dark text-cream">
    <div class="dark-panel absolute inset-0 -z-10" aria-hidden="true"></div>

    <div class="pointer-events-none absolute inset-0 hidden lg:block" aria-hidden="true">
        <div class="absolute left-[0.3%] top-[16%] w-[14.3%] overflow-hidden rounded-[2px] border border-white/10">
            <img src="<?php echo e(asset('images/site/cta-3.jpg')); ?>" alt="" class="aspect-[206/183] w-full object-cover" loading="lazy">
        </div>
        <div class="absolute right-[2%] top-[14%] w-[22.8%] overflow-hidden rounded-[2px] border border-white/10">
            <img src="<?php echo e(asset('images/site/cta-2.jpg')); ?>" alt="" class="aspect-[329/291] w-full object-cover" loading="lazy">
        </div>
        <div class="absolute bottom-0 left-0 w-[26.1%] overflow-hidden rounded-[2px] border border-white/10">
            <img src="<?php echo e(asset('images/site/cta-1.jpg')); ?>" alt="" class="aspect-[376/333] w-full object-cover" loading="lazy">
        </div>
        <div class="absolute bottom-[14%] right-[3%] w-[14.7%] overflow-hidden rounded-[2px] border border-white/10">
            <img src="<?php echo e(asset('images/site/cta-4.jpg')); ?>" alt="" class="aspect-[212/188] w-full object-cover" loading="lazy">
        </div>
    </div>

    <div class="site-container relative z-10 flex min-h-[540px] flex-col items-center justify-center py-24 text-center lg:min-h-[953px] lg:py-32">
        <p class="flex items-center gap-2 text-[15px] font-normal text-cream/70">
            <span class="font-normal tracking-normal text-terracotta" aria-hidden="true">//</span>
            Appointment
        </p>

        <h2 class="mt-5 max-w-3xl font-display text-[2.7rem] font-semibold leading-[1.1] tracking-[-0.02em] text-cream sm:text-[3.5rem]">
            <?php echo nl2br(e($title)); ?>

        </h2>

        <?php if($description): ?>
            <p class="mt-5 max-w-xl text-[15px] leading-7 text-cream/65"><?php echo e($description); ?></p>
        <?php endif; ?>

        <a href="<?php echo e($href); ?>" class="group mt-9 inline-flex items-center gap-3 rounded-full bg-cream py-1.5 pl-6 pr-1.5 text-[16px] font-bold text-ink transition duration-200 hover:-translate-y-0.5 hover:bg-white">
            <?php echo e($label); ?>

            <span class="grid size-11 place-items-center rounded-full bg-terracotta text-white transition duration-200 group-hover:rotate-[-8deg]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                </svg>
            </span>
        </a>
    </div>
</section>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\public\appointment-cta.blade.php ENDPATH**/ ?>