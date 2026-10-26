<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'subtitle' => null,
    'eyebrow' => 'Patient portal',
    'image' => 'appointment-hero.jpg',
    'quote' => null,
    'compact' => false,
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
    'title',
    'subtitle' => null,
    'eyebrow' => 'Patient portal',
    'image' => 'appointment-hero.jpg',
    'quote' => null,
    'compact' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="bg-cream">
    <div class="site-container py-14 sm:py-20">
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'mx-auto overflow-hidden rounded-[28px] border border-line bg-white shadow-[0_24px_70px_rgba(60,61,66,0.08)]',
            'max-w-md' => $compact,
            'grid max-w-5xl lg:grid-cols-[0.85fr_1.15fr]' => ! $compact,
        ]); ?>">
            <?php if (! ($compact)): ?>
                <div class="relative hidden min-h-[640px] lg:block">
                    <img src="<?php echo e(asset('images/site/'.$image)); ?>" alt=""
                         class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/20 to-transparent" aria-hidden="true"></div>
                    <div class="relative flex h-full flex-col justify-between p-8 text-cream">
                        <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.16em] text-cream/75 transition hover:text-cream">
                            <span class="grid size-7 place-items-center rounded-full border border-cream/30">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                                </svg>
                            </span>
                            Back to clinic
                        </a>
                        <div>
                            <p class="font-display text-[2.1rem] leading-[1.1] tracking-[-0.03em]">
                                <?php echo e($quote ?: 'Your care, remembered.'); ?>

                            </p>
                            <p class="mt-3 max-w-xs text-[12px] leading-6 text-cream/65">
                                Upcoming visits, treatment history and receipts — all in one calm place.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="p-6 sm:p-10 lg:p-12">
                <p class="eyebrow">
                    <span class="eyebrow-mark" aria-hidden="true">//</span>
                    <?php echo e($eyebrow); ?>

                </p>
                <h1 class="display-title mt-4 text-[2.3rem] leading-[1.02] text-ink sm:text-[2.8rem]"><?php echo e($title); ?></h1>
                <?php if($subtitle): ?>
                    <p class="mt-3 max-w-md text-[12px] leading-6 text-body"><?php echo e($subtitle); ?></p>
                <?php endif; ?>

                <div class="mt-7">
                    <?php echo e($slot); ?>

                </div>

                <?php if(isset($footer)): ?>
                    <div class="mt-7 border-t border-line/70 pt-5 text-center text-[12px] text-body">
                        <?php echo e($footer); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if(isset($note)): ?>
            <div class="mx-auto mt-5 max-w-5xl text-center text-[10px] leading-5 text-muted">
                <?php echo e($note); ?>

            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\public\auth-shell.blade.php ENDPATH**/ ?>