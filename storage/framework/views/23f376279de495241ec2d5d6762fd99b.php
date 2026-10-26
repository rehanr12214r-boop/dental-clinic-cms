<?php
    use App\Models\Setting;

    $clinicAddress = Setting::get(Setting::ClinicAddress);
    $clinicPhone = Setting::get(Setting::ClinicPhone);
?>

<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => $dentist['short_name']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dentist['short_name'])]); ?>

    <section class="site-container pb-20 pt-12 lg:pb-24 lg:pt-[4.5rem]">
        <div class="grid gap-12 lg:grid-cols-[minmax(0,1fr)_571px] lg:items-start lg:gap-20">
            <div>
                <h1 class="font-display text-[2.35rem] font-semibold leading-[1.2] tracking-[-0.02em] text-ink sm:text-[2.75rem] lg:text-[3rem]">
                    <?php echo e($dentist['short_name']); ?>

                </h1>
                <p class="mt-3 text-[16px] font-medium leading-[1.21] text-body"><?php echo e($dentist['role']); ?></p>

                <div class="mt-6 flex items-center gap-2 text-ink/55" aria-hidden="true">
                    <span class="grid size-9 place-items-center rounded-full border border-line transition hover:border-terracotta hover:text-terracotta">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                            <path d="M13.5 21v-7.5h2.5l.5-3h-3V8.6c0-.9.3-1.5 1.6-1.5H17V4.4c-.3 0-1.4-.1-2.6-.1-2.6 0-4.4 1.6-4.4 4.5v2.7H7.5v3H10V21h3.5Z"/>
                        </svg>
                    </span>
                    <span class="grid size-9 place-items-center rounded-full border border-line transition hover:border-terracotta hover:text-terracotta">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                            <path d="M18.9 7.1c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.7-.6.4-1.3.7-2.1.8a3.3 3.3 0 0 0-5.7 3 9.4 9.4 0 0 1-6.8-3.4 3.3 3.3 0 0 0 1 4.4c-.5 0-1-.2-1.5-.4 0 1.6 1.2 3 2.7 3.3-.5.2-1 .2-1.5.1.4 1.3 1.6 2.2 3.1 2.2a6.7 6.7 0 0 1-4.1 1.4H4a9.4 9.4 0 0 0 5.1 1.5c6.1 0 9.4-5 9.4-9.4v-.4c.6-.5 1.2-1 1.6-1.7Z"/>
                        </svg>
                    </span>
                    <span class="grid size-9 place-items-center rounded-full border border-line transition hover:border-terracotta hover:text-terracotta">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                            <path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 2A2.5 2.5 0 0 0 5 7.5v9A2.5 2.5 0 0 0 7.5 19h9a2.5 2.5 0 0 0 2.5-2.5v-9A2.5 2.5 0 0 0 16.5 5h-9Zm4.5 3.2a4.8 4.8 0 1 1 0 9.6 4.8 4.8 0 0 1 0-9.6Zm0 2a2.8 2.8 0 1 0 0 5.6 2.8 2.8 0 0 0 0-5.6Zm5.1-3.4a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2Z"/>
                        </svg>
                    </span>
                </div>

                <div class="mt-12 grid gap-x-12 gap-y-10 sm:grid-cols-2">
                    <div>
                        <p class="text-[16px] font-medium leading-[1.21] text-ink">Location</p>
                        <address class="mt-2 max-w-xs not-italic text-[16px] font-medium leading-[1.21] text-ink">
                            <?php echo e($clinicAddress); ?>

                        </address>
                        <a href="https://maps.google.com/?q=<?php echo e(urlencode((string) $clinicAddress)); ?>"
                           target="_blank" rel="noopener"
                           class="mt-2 inline-flex text-[15px] font-medium leading-[1.21] text-body underline decoration-line underline-offset-4 transition hover:text-terracotta">
                            Open on Google Maps
                        </a>
                    </div>

                    <div>
                        <p class="text-[16px] font-medium leading-[1.21] text-ink">Contact us</p>
                        <a href="tel:<?php echo e(preg_replace('/\s+/', '', (string) $clinicPhone)); ?>"
                           class="mt-2 block text-[16px] font-medium leading-[1.21] text-ink transition hover:text-terracotta">
                            <?php echo e($clinicPhone); ?>

                        </a>
                    </div>

                    <div>
                        <p class="text-[16px] font-medium leading-[1.21] text-ink">Working hours</p>
                        <p class="mt-2 text-[16px] font-medium leading-[1.21] text-ink"><?php echo e($workingHours ?? 'See the booking page for daily hours'); ?></p>
                    </div>

                    <div>
                        <p class="text-[16px] font-medium leading-[1.21] text-ink">Email address</p>
                        <a href="mailto:<?php echo e($clinicEmail); ?>"
                           class="mt-2 block text-[16px] font-medium leading-[1.21] text-ink transition hover:text-terracotta">
                            <?php echo e($clinicEmail); ?>

                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-[20px] bg-beige">
                <img src="<?php echo e(asset('images/site/'.$dentist['image'])); ?>"
                     alt="<?php echo e($dentist['name']); ?>"
                     class="aspect-[571/460] w-full object-cover"
                     loading="eager">
            </div>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\dentists\show.blade.php ENDPATH**/ ?>