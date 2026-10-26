<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['url', 'template', 'label']));

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

foreach (array_filter((['url', 'template', 'label']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<button type="button"
        data-whatsapp-send
        data-whatsapp-url="<?php echo e($url); ?>"
        data-whatsapp-template="<?php echo e($template); ?>"
        <?php echo e($attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-600/20 transition hover:bg-emerald-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 disabled:cursor-wait disabled:opacity-70'])); ?>>
    <?php if (isset($component)) { $__componentOriginale389fdb35e370a49ebaee5b38d79b27b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale389fdb35e370a49ebaee5b38d79b27b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.whatsapp-icon','data' => ['class' => 'size-3.5 shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.whatsapp-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-3.5 shrink-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale389fdb35e370a49ebaee5b38d79b27b)): ?>
<?php $attributes = $__attributesOriginale389fdb35e370a49ebaee5b38d79b27b; ?>
<?php unset($__attributesOriginale389fdb35e370a49ebaee5b38d79b27b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale389fdb35e370a49ebaee5b38d79b27b)): ?>
<?php $component = $__componentOriginale389fdb35e370a49ebaee5b38d79b27b; ?>
<?php unset($__componentOriginale389fdb35e370a49ebaee5b38d79b27b); ?>
<?php endif; ?>
    <span data-whatsapp-label><?php echo e($label); ?></span>
</button>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\admin\whatsapp-button.blade.php ENDPATH**/ ?>