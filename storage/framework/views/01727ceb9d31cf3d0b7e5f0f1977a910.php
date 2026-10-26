<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => $post['title']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post['title'])]); ?>

    <?php if (isset($component)) { $__componentOriginal7667e390c55120bda1fc27c0189959e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7667e390c55120bda1fc27c0189959e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.page-hero','data' => ['title' => $post['title'],'description' => $post['excerpt'],'breadcrumb' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Blog', 'url' => route('blog.index')],
            ['label' => $post['title']],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post['title']),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post['excerpt']),'breadcrumb' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Blog', 'url' => route('blog.index')],
            ['label' => $post['title']],
        ])]); ?>
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
            <img src="<?php echo e(asset('images/site/'.$post['image'])); ?>"
                 alt="<?php echo e($post['title']); ?>"
                 class="aspect-[1296/601] w-full object-cover"
                 loading="eager">
        </div>
    </section>

    <section class="site-container pb-20 lg:pb-24">
        <div class="grid gap-12 lg:grid-cols-[220px_minmax(0,770px)] lg:justify-between lg:gap-10">
            <aside class="lg:pt-2">
                <div class="flex items-center gap-3">
                    <div class="size-[52px] shrink-0 overflow-hidden rounded-full bg-beige">
                        <img src="<?php echo e(asset('images/site/'.$post['author_image'])); ?>"
                             alt="<?php echo e($post['author']); ?>"
                             class="h-full w-full object-cover"
                             loading="lazy">
                    </div>
                    <div>
                        <p class="text-[18px] font-medium leading-[1.4] text-ink"><?php echo e($post['author']); ?></p>
                        <p class="text-[16px] leading-[1.4] text-body"><?php echo e($post['author_role']); ?></p>
                    </div>
                </div>

                <div class="mt-9 border-t border-line/70 pt-6">
                    <p class="text-[16px] leading-[1.4] text-body">
                        Category :
                        <span class="text-ink"><?php echo e($post['category']); ?></span>
                    </p>
                    <p class="mt-2 text-[13px] leading-[1.5] text-body"><?php echo e($post['date']); ?> · <?php echo e($post['read_time']); ?></p>
                </div>
            </aside>

            <article class="article-copy max-w-[770px] lg:ml-auto">
                <?php $__currentLoopData = $post['sections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h2><?php echo e($section['heading']); ?></h2>

                    <?php $__currentLoopData = $section['body']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><?php echo e($paragraph); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($loop->first): ?>
                        <div class="my-10 grid gap-5 sm:grid-cols-2">
                            <div class="aspect-square overflow-hidden rounded-[4px] bg-beige">
                                <img src="<?php echo e(asset('images/site/blog-5.jpg')); ?>"
                                     alt="A dentist explaining a treatment plan"
                                     class="h-full w-full object-cover"
                                     loading="lazy">
                            </div>
                            <div class="aspect-square overflow-hidden rounded-[4px] bg-beige">
                                <img src="<?php echo e(asset('images/site/blog-6.jpg')); ?>"
                                     alt="A patient smiling after cosmetic treatment"
                                     class="h-full w-full object-cover"
                                     loading="lazy">
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($loop->index === 1): ?>
                        <blockquote class="my-10 rounded-[12px] bg-white px-8 py-9 sm:px-10 sm:py-11">
                            <p class="font-display text-[22px] font-bold leading-[1.2] text-ink sm:text-[24px]">
                                “<?php echo e($post['quote']); ?>”
                            </p>
                            <footer class="mt-5 text-[14px] leading-[1.2] text-body"><?php echo e($post['quote_author']); ?></footer>
                        </blockquote>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </article>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\blog\show.blade.php ENDPATH**/ ?>