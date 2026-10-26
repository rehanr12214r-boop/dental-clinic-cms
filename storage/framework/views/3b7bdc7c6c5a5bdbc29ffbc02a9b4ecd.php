<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'About Us']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'About Us']); ?>

    <?php if (isset($component)) { $__componentOriginal7667e390c55120bda1fc27c0189959e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7667e390c55120bda1fc27c0189959e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.page-hero','data' => ['title' => 'Our Mission is to Make you Smile More Beautiful.','description' => 'Gentle, modern dentistry built around you — from your first checkup to the confidence you carry out of the door.','breadcrumb' => [['label' => 'Home', 'url' => route('home')], ['label' => 'About Us']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Our Mission is to Make you Smile More Beautiful.','description' => 'Gentle, modern dentistry built around you — from your first checkup to the confidence you carry out of the door.','breadcrumb' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Home', 'url' => route('home')], ['label' => 'About Us']])]); ?>
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

    <section class="site-container pb-16">
        <div class="overflow-hidden rounded-[12px] bg-beige">
            <img src="<?php echo e(asset('images/site/about-hero.jpg')); ?>"
                 alt="A dentist caring for a patient at the clinic"
                 class="aspect-[1296/548] w-full object-cover"
                 loading="eager">
        </div>
    </section>

    <section class="site-container pb-20 lg:pb-24">
        <p class="text-center font-display text-[20px] leading-[1.23] text-ink">Trusted Partners</p>

        <div class="mx-auto mt-8 grid max-w-5xl grid-cols-2 gap-4 sm:grid-cols-4">
            <?php $__currentLoopData = [
                ['name' => 'Springfield', 'image' => 'partner-springfield.jpg'],
                ['name' => 'Sweden', 'image' => 'partner-sweden.jpg'],
                ['name' => 'Delaware', 'image' => 'partner-delaware.jpg'],
                ['name' => 'Umbrella', 'image' => 'partner-umbrella.jpg'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex h-[80px] items-center justify-center rounded-[8px] bg-white px-6">
                    <img src="<?php echo e(asset('images/site/'.$partner['image'])); ?>"
                         alt="<?php echo e($partner['name']); ?>"
                         class="max-h-8 w-auto max-w-full object-contain opacity-70 grayscale"
                         loading="lazy">
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section class="bg-beige py-20 lg:py-24">
        <div class="site-container">
            <div class="grid items-stretch gap-5 lg:grid-cols-2">
                <div class="rounded-[20px] bg-white p-8 sm:p-12 lg:p-16">
                    <h2 class="font-display text-[38px] font-normal leading-[1.2] text-ink sm:text-[48px]">
                        What we<br>stand for!
                    </h2>

                    <div class="mt-9 border-t border-line/80">
                        <?php $__currentLoopData = [
                            [
                                'title' => 'Patient-Centered Care',
                                'body' => 'Your comfort, goals and questions guide every decision we make — never the other way around.',
                                'open' => false,
                            ],
                            [
                                'title' => 'Clinical Excellence',
                                'body' => 'Evidence-led dentistry, modern tools and careful attention to detail at every appointment.',
                                'open' => false,
                            ],
                            [
                                'title' => 'Trust & Transparency',
                                'body' => 'We believe in honest communication and clear guidance at every step.',
                                'open' => true,
                            ],
                            [
                                'title' => 'Comfort & Care',
                                'body' => 'Gentle techniques, clear aftercare and a team that never rushes you through your visit.',
                                'open' => false,
                            ],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <details class="group border-b border-line/80" <?php if($value['open']): ?> open <?php endif; ?>>
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-5 font-display text-[20px] leading-[1.2] text-ink marker:hidden [&::-webkit-details-marker]:hidden">
                                    <?php echo e($value['title']); ?>

                                    <span class="grid size-8 shrink-0 place-items-center rounded-full border border-line text-ink transition group-open:rotate-45 group-open:border-terracotta group-open:text-terracotta">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                                        </svg>
                                    </span>
                                </summary>
                                <p class="max-w-md pb-5 text-[15px] leading-[1.6] text-body"><?php echo e($value['body']); ?></p>
                            </details>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="min-h-[420px] overflow-hidden rounded-[20px] bg-white lg:min-h-[622px]">
                    <img src="<?php echo e(asset('images/site/about-collage-2.jpg')); ?>"
                         alt="A calm, welcoming dental treatment room"
                         class="h-full w-full object-cover"
                         loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <section class="site-container py-20 lg:py-24">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = array_slice($team, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dentist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.dentist-card','data' => ['dentist' => $dentist]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.dentist-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dentist' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dentist)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3)): ?>
<?php $attributes = $__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3; ?>
<?php unset($__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3)): ?>
<?php $component = $__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3; ?>
<?php unset($__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if (isset($component)) { $__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.dentist-card','data' => ['dentist' => $team[3]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.dentist-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dentist' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($team[3])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3)): ?>
<?php $attributes = $__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3; ?>
<?php unset($__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3)): ?>
<?php $component = $__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3; ?>
<?php unset($__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3); ?>
<?php endif; ?>

            <div class="flex min-h-[361px] flex-col items-center justify-center rounded-[10px] px-8 text-center">
                <p class="flex items-center gap-2 text-[15px] text-body">
                    <span class="text-terracotta" aria-hidden="true">//</span>
                    Dentists
                </p>
                <h2 class="mt-4 font-display text-[42px] font-semibold leading-[1.2] text-ink sm:text-[56px]">
                    A Trusted,<br>Caring Team.
                </h2>
                <a href="<?php echo e(route('dentists.index')); ?>" class="link-arrow mt-6">
                    Meet the team
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </a>
            </div>

            <?php if (isset($component)) { $__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.dentist-card','data' => ['dentist' => $team[4]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.dentist-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dentist' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($team[4])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3)): ?>
<?php $attributes = $__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3; ?>
<?php unset($__attributesOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3)): ?>
<?php $component = $__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3; ?>
<?php unset($__componentOriginala7768a2c76cad2e6da1e7bb3cf8fe3e3); ?>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\about.blade.php ENDPATH**/ ?>