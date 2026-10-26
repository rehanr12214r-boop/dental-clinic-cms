<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['dentist']));

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

foreach (array_filter((['dentist']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<a href="<?php echo e(route('dentists.show', ['slug' => $dentist['slug']])); ?>"
   class="group flex min-h-[361px] flex-col justify-between rounded-[10px] bg-white p-6 transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(60,61,66,0.08)]">
    <div class="flex items-start justify-between gap-4">
        <div class="flex items-center gap-2 text-ink/55" aria-hidden="true">
            <span class="grid size-8 place-items-center rounded-full border border-line/80 transition group-hover:border-terracotta/40 group-hover:text-terracotta">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                    <path d="M13.5 21v-7.5h2.5l.5-3h-3V8.6c0-.9.3-1.5 1.6-1.5H17V4.4c-.3 0-1.4-.1-2.6-.1-2.6 0-4.4 1.6-4.4 4.5v2.7H7.5v3H10V21h3.5Z"/>
                </svg>
            </span>
            <span class="grid size-8 place-items-center rounded-full border border-line/80 transition group-hover:border-terracotta/40 group-hover:text-terracotta">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                    <path d="M18.9 7.1c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.7-.6.4-1.3.7-2.1.8a3.3 3.3 0 0 0-5.7 3 9.4 9.4 0 0 1-6.8-3.4 3.3 3.3 0 0 0 1 4.4c-.5 0-1-.2-1.5-.4 0 1.6 1.2 3 2.7 3.3-.5.2-1 .2-1.5.1.4 1.3 1.6 2.2 3.1 2.2a6.7 6.7 0 0 1-4.1 1.4H4a9.4 9.4 0 0 0 5.1 1.5c6.1 0 9.4-5 9.4-9.4v-.4c.6-.5 1.2-1 1.6-1.7Z"/>
                </svg>
            </span>
            <span class="grid size-8 place-items-center rounded-full border border-line/80 transition group-hover:border-terracotta/40 group-hover:text-terracotta">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                    <path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 2A2.5 2.5 0 0 0 5 7.5v9A2.5 2.5 0 0 0 7.5 19h9a2.5 2.5 0 0 0 2.5-2.5v-9A2.5 2.5 0 0 0 16.5 5h-9Zm4.5 3.2a4.8 4.8 0 1 1 0 9.6 4.8 4.8 0 0 1 0-9.6Zm0 2a2.8 2.8 0 1 0 0 5.6 2.8 2.8 0 0 0 0-5.6Zm5.1-3.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2Z"/>
                </svg>
            </span>
        </div>

        <div class="h-[138px] w-[216px] max-w-[62%] shrink-0 overflow-hidden rounded-[12px] bg-beige">
            <img src="<?php echo e(asset('images/site/'.$dentist['image'])); ?>"
                 alt="<?php echo e($dentist['name']); ?>"
                 class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]"
                 loading="lazy">
        </div>
    </div>

    <div class="mt-8">
        <h2 class="font-display text-[22px] font-normal leading-[1.2] text-ink sm:text-[24px]">
            <?php echo e($dentist['name']); ?>

        </h2>
        <p class="mt-2 text-[15px] leading-[1.21] text-body">
            <?php echo e($dentist['role']); ?> \ Experience: <?php echo e($dentist['experience']); ?>

        </p>
    </div>
</a>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\public\dentist-card.blade.php ENDPATH**/ ?>