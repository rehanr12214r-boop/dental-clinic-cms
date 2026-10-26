<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['post']));

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

foreach (array_filter((['post']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<article class="group">
    <a href="<?php echo e(route('blog.show', ['slug' => $post['slug']])); ?>" class="block">
        <div class="aspect-[306/205] overflow-hidden rounded-[12px] bg-beige">
            <img src="<?php echo e(asset('images/site/'.$post['image'])); ?>"
                 alt="<?php echo e($post['title']); ?>"
                 class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                 loading="lazy">
        </div>

        <p class="mt-5 text-[16px] leading-[1.21] text-body"><?php echo e($post['category']); ?></p>
        <h2 class="mt-2 font-display text-[20px] font-medium leading-[1.2] text-ink transition group-hover:text-terracotta">
            <?php echo e($post['title']); ?>

        </h2>
    </a>
</article>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\public\blog-card.blade.php ENDPATH**/ ?>