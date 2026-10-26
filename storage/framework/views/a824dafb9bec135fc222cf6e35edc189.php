<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description' => null,
    'breadcrumb' => [],
    'align' => 'center',
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
    'description' => null,
    'breadcrumb' => [],
    'align' => 'center',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $centered = $align === 'center';
?>

<section class="page-hero-section bg-cream">
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'site-container pb-12 pt-16 lg:pt-[4.4rem]',
        'text-center' => $centered,
    ]); ?>">
        <h1 class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'page-hero-title font-display text-[2.35rem] font-semibold leading-[1.2] tracking-[-0.02em] text-ink sm:text-[2.75rem] lg:text-[3rem]',
            'mx-auto max-w-4xl' => $centered,
            'max-w-3xl' => ! $centered,
        ]); ?>"><?php echo $title; ?></h1>

        <?php if($description): ?>
            <p class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'page-hero-description mt-4 text-[15px] leading-[1.6] text-body sm:text-base',
                'mx-auto max-w-2xl' => $centered,
                'max-w-2xl' => ! $centered,
            ]); ?>"><?php echo e($description); ?></p>
        <?php endif; ?>

        <?php if($breadcrumb !== []): ?>
            <nav class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'page-hero-breadcrumb mt-9 flex flex-wrap items-center gap-2 text-[15px] leading-5 text-body',
                'justify-center' => $centered,
            ]); ?>" aria-label="Breadcrumb">
                <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $label = is_array($item) ? $item['label'] : $item;
                        $url = is_array($item) ? ($item['url'] ?? null) : null;
                    ?>

                    <?php if(! $loop->first): ?>
                        <span class="text-body/50" aria-hidden="true">/</span>
                    <?php endif; ?>

                    <?php if($url): ?>
                        <a href="<?php echo e($url); ?>" class="transition hover:text-terracotta"><?php echo e($label); ?></a>
                    <?php else: ?>
                        <span <?php if($loop->last): ?> aria-current="page" <?php endif; ?> class="<?php echo e($loop->last ? 'text-ink' : ''); ?>"><?php echo e($label); ?></span>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/components/public/page-hero.blade.php ENDPATH**/ ?>