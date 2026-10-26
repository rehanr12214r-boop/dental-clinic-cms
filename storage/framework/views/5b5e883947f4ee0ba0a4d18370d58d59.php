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
        <div class="flex items-center gap-1.5" aria-hidden="true">
            <span class="grid size-[34px] place-items-center rounded-full bg-flame text-white transition duration-200 group-hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                    <path d="M13.5 21v-7.5h2.5l.5-3h-3V8.6c0-.9.3-1.5 1.6-1.5H17V4.4c-.3 0-1.4-.1-2.6-.1-2.6 0-4.4 1.6-4.4 4.5v2.7H7.5v3H10V21h3.5Z"/>
                </svg>
            </span>
            <span class="grid size-[34px] place-items-center rounded-full bg-terracotta text-white transition duration-200 group-hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
            </span>
            <span class="grid size-[34px] place-items-center rounded-full bg-flame text-white transition duration-200 group-hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                    <path d="M18.9 7.1c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.7-.6.4-1.3.7-2.1.8a3.3 3.3 0 0 0-5.7 3 9.4 9.4 0 0 1-6.8-3.4 3.3 3.3 0 0 0 1 4.4c-.5 0-1-.2-1.5-.4 0 1.6 1.2 3 2.7 3.3-.5.2-1 .2-1.5.1.4 1.3 1.6 2.2 3.1 2.2a6.7 6.7 0 0 1-4.1 1.4H4a9.4 9.4 0 0 0 5.1 1.5c6.1 0 9.4-5 9.4-9.4v-.4c.6-.5 1.2-1 1.6-1.7Z"/>
                </svg>
            </span>
        </div>

        <div class="aspect-[216/138] h-[138px] w-[216px] max-w-[62%] shrink-0 overflow-hidden rounded-[12px] bg-beige">
            <img src="<?php echo e(asset('images/site/'.$dentist['image'])); ?>"
                 alt="<?php echo e($dentist['name']); ?>"
                 class="h-full w-full object-cover object-top transition duration-700 group-hover:scale-[1.03]"
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/components/public/dentist-card.blade.php ENDPATH**/ ?>