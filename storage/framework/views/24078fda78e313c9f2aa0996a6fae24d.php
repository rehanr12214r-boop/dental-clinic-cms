<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['treatment']));

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

foreach (array_filter((['treatment']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $images = [
        'teeth-cleaning' => 'service-whitening.jpg',
        'root-canal' => 'service-root-canal.jpg',
        'general-checkup' => 'benefits-smile.jpg',
        'tooth-extraction' => 'service-fillings.jpg',
        'braces-consultation' => 'service-orthodontics.jpg',
    ];

    $image = asset('images/site/'.($images[$treatment->slug] ?? 'service-fillings.jpg'));
?>

<article class="group flex flex-col overflow-hidden rounded-[20px] border border-line bg-white transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_50px_rgba(60,61,66,0.08)]">
    <a href="<?php echo e(route('treatments.show', ['treatment' => $treatment->slug])); ?>" class="relative block overflow-hidden">
        <div class="aspect-[4/3] overflow-hidden bg-beige">
            <img src="<?php echo e($image); ?>" alt="<?php echo e($treatment->name); ?>"
                 class="h-full w-full object-cover transition duration-700 group-hover:scale-105" loading="lazy">
        </div>
        <span class="absolute left-4 top-4 rounded-full bg-cream/95 px-3 py-1.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-ink backdrop-blur">
            <?php echo e((int) $treatment->duration_minutes); ?> min visit
        </span>
    </a>

    <div class="flex flex-1 flex-col p-5 sm:p-6">
        <div class="flex items-start justify-between gap-4">
            <h3 class="font-display text-[1.45rem] leading-tight tracking-[-0.025em] text-ink">
                <a href="<?php echo e(route('treatments.show', ['treatment' => $treatment->slug])); ?>" class="transition hover:text-terracotta">
                    <?php echo e($treatment->name); ?>

                </a>
            </h3>
            <p class="shrink-0 text-right text-[15px] font-semibold text-ink">
                $<?php echo e(number_format((float) $treatment->cost, 2)); ?>

            </p>
        </div>

        <p class="mt-2 flex-1 font-form text-[13px] leading-6 text-body">
            <?php echo e($treatment->description ? \Illuminate\Support\Str::limit($treatment->description, 112) : 'Book this treatment and our dentist will take care of the rest — with honest pricing and gentle care.'); ?>

        </p>

        <div class="mt-5 flex items-center justify-between border-t border-line/70 pt-4">
            <a href="<?php echo e(route('treatments.show', ['treatment' => $treatment->slug])); ?>"
               class="text-[12px] font-semibold text-muted transition group-hover:text-ink">
                Details
            </a>
            <a href="<?php echo e(route('book', ['treatment' => $treatment->getKey()])); ?>"
               class="inline-flex items-center gap-1.5 text-[12px] font-semibold text-ink transition hover:text-terracotta">
                Book this
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                </svg>
            </a>
        </div>
    </div>
</article>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\public\treatment-card.blade.php ENDPATH**/ ?>