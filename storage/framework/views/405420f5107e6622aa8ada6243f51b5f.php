<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'Our Services']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Our Services']); ?>

    <?php
        $images = [
            'teeth-cleaning' => 'service-whitening.jpg',
            'root-canal' => 'service-root-canal.jpg',
            'general-checkup' => 'benefits-smile.jpg',
            'tooth-extraction' => 'service-fillings.jpg',
            'braces-consultation' => 'service-orthodontics.jpg',
        ];
    ?>

    <?php if (isset($component)) { $__componentOriginal7667e390c55120bda1fc27c0189959e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7667e390c55120bda1fc27c0189959e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.page-hero','data' => ['title' => 'Our Services','description' => 'Treatments & transparent pricing — explore our comprehensive dental services designed to keep your smile healthy, bright, and confident.','breadcrumb' => [['label' => 'Home', 'url' => route('home')], ['label' => 'Services']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Our Services','description' => 'Treatments & transparent pricing — explore our comprehensive dental services designed to keep your smile healthy, bright, and confident.','breadcrumb' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Home', 'url' => route('home')], ['label' => 'Services']])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7667e390c55120bda1fc27c0189959e9)): ?>
<?php $attributes = $__attributesOriginal7667e390c55120bda1fc27c0189959e9; ?>
<?php unset($__attributesOriginal7667e390c55120bda1fc27c0189959e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7667e390c55120bda1fc27c0189959e9)): ?>
<?php $component = $__componentOriginal7667e390c55120bda1fc27c0189959e9; ?>
<?php unset($__componentOriginal7667e390c55120bda1fc27c0189959e9); ?>
<?php endif; ?>

    <section class="site-container pb-20 lg:pb-24">
        <?php if($workingHours): ?>
            <div class="mb-10 flex justify-center">
                <span class="status-pill normal-case tracking-normal"><?php echo e($workingHours); ?></span>
            </div>
        <?php endif; ?>

        <div class="space-y-12">
            <?php $__empty_1 = true; $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('treatments.show', ['treatment' => $treatment->slug])); ?>"
                   class="treatment-row group grid overflow-hidden rounded-[12px] bg-white lg:grid-cols-[636px_minmax(0,1fr)]">
                    <div class="flex flex-col items-center justify-center px-8 py-10 text-center lg:px-14">
                        <h2 class="font-display text-[24px] font-bold leading-[1.2] text-ink transition group-hover:text-terracotta">
                            <?php echo e($treatment->name); ?>

                        </h2>

                        <?php if($treatment->description): ?>
                            <p class="mt-3 max-w-md text-[14px] leading-[1.6] text-body"><?php echo e($treatment->description); ?></p>
                        <?php endif; ?>

                        <div class="mt-6 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-[13px] text-body">
                            <span><?php echo e($treatment->duration_minutes); ?> min visit</span>
                            <span class="size-1 rounded-full bg-line" aria-hidden="true"></span>
                            <span class="font-semibold text-ink">$<?php echo e(number_format((float) $treatment->cost, 2)); ?></span>
                        </div>
                    </div>

                    <div class="min-h-[226px] overflow-hidden bg-beige">
                        <img src="<?php echo e(asset('images/site/'.($images[$treatment->slug] ?? 'benefits-smile.jpg'))); ?>"
                             alt="<?php echo e($treatment->name); ?>"
                             class="h-full min-h-[226px] w-full object-cover"
                             loading="lazy">
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="rounded-[12px] bg-white p-10 text-center text-body">
                    Our treatment list is being updated. Please contact the clinic for current services.
                </p>
            <?php endif; ?>
        </div>
    </section>

    <?php if (isset($component)) { $__componentOriginal929e175e4f46955bd5ac6d22970c33ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal929e175e4f46955bd5ac6d22970c33ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.appointment-cta','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.appointment-cta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal929e175e4f46955bd5ac6d22970c33ab)): ?>
<?php $attributes = $__attributesOriginal929e175e4f46955bd5ac6d22970c33ab; ?>
<?php unset($__attributesOriginal929e175e4f46955bd5ac6d22970c33ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal929e175e4f46955bd5ac6d22970c33ab)): ?>
<?php $component = $__componentOriginal929e175e4f46955bd5ac6d22970c33ab; ?>
<?php unset($__componentOriginal929e175e4f46955bd5ac6d22970c33ab); ?>
<?php endif; ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd)): ?>
<?php $attributes = $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd; ?>
<?php unset($__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd)): ?>
<?php $component = $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd; ?>
<?php unset($__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd); ?>
<?php endif; ?>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\treatments\index.blade.php ENDPATH**/ ?>