<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'Profile settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Profile settings']); ?>

    <section class="bg-cream">
        <div class="site-container pb-20 pt-10 lg:pt-14">
            <nav class="flex items-center gap-2 text-[11px] font-medium text-muted" aria-label="Breadcrumb">
                <a href="<?php echo e(route('patient.dashboard')); ?>" class="transition hover:text-terracotta">My dashboard</a>
                <span aria-hidden="true">/</span>
                <span class="text-ink">Profile settings</span>
            </nav>

            <div class="mt-7 max-w-2xl">
                <p class="eyebrow">
                    <span class="eyebrow-mark" aria-hidden="true">//</span>
                    Your details
                </p>
                <h1 class="display-title mt-4 text-[2.8rem] leading-[1.02] sm:text-[3.5rem]">Profile <em>settings.</em></h1>
                <p class="mt-4 max-w-xl text-[12px] leading-6 text-body">
                    Keep your details up to date. Your WhatsApp number is used to link bookings made with this phone
                    number to your account automatically.
                </p>
            </div>

            <div class="mt-8 grid gap-5 lg:grid-cols-[1.2fr_0.8fr] lg:items-start">
                <div class="rounded-[24px] border border-line bg-white p-6 sm:p-8 lg:p-10">
                    <form method="POST" action="<?php echo e(route('patient.profile.update')); ?>" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <div>
                            <label for="email" class="field-label">Email address</label>
                            <input id="email" type="email" value="<?php echo e($patient->email); ?>" disabled
                                   class="field-input"/>
                            <p class="mt-2 text-[10px] text-muted">To change your email address, please contact the clinic.</p>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="field-label">Full name</label>
                                <input id="name" type="text" name="name" required maxlength="255" autocomplete="name"
                                       value="<?php echo e(old('name', $patient->name)); ?>"
                                       class="field-input"/>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="phone" class="field-label">WhatsApp number</label>
                                <input id="phone" type="tel" name="phone" required maxlength="32" autocomplete="tel" inputmode="tel"
                                       value="<?php echo e(old('phone', $patient->phone)); ?>"
                                       class="field-input"/>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="sm:max-w-[12rem]">
                            <label for="age" class="field-label">Age <span class="normal-case tracking-normal text-muted">(optional)</span></label>
                            <input id="age" type="number" name="age" min="1" max="120" inputmode="numeric"
                                   value="<?php echo e(old('age', $patient->age)); ?>"
                                   class="field-input"/>
                            <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 border-t border-line/70 pt-6">
                            <button type="submit" class="btn-medio">
                                Save changes
                                <span class="btn-medio-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                    </svg>
                                </span>
                            </button>
                            <a href="<?php echo e(route('patient.dashboard')); ?>" class="btn-medio-light">Back to dashboard</a>
                        </div>
                    </form>
                </div>

                <aside class="rounded-[24px] bg-beige/70 p-6 sm:p-7">
                    <p class="eyebrow">
                        <span class="eyebrow-mark" aria-hidden="true">//</span>
                        Good to know
                    </p>
                    <h2 class="mt-3 font-display text-[1.6rem] leading-tight tracking-[-0.03em] text-ink">One number, every visit.</h2>
                    <p class="mt-3 text-[12px] leading-6 text-body">
                        Use the same WhatsApp number you booked with and any guest bookings will appear in your portal
                        automatically. Your email address stays fixed for account security.
                    </p>

                    <div class="mt-6 border-t border-ink/10 pt-5">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Signed in as</p>
                        <p class="mt-1 text-[12px] font-semibold text-ink"><?php echo e($patient->email); ?></p>
                        <p class="mt-1 text-[10px] leading-5 text-muted">Signing out ends this session on this device only.</p>
                    </div>

                    <form method="POST" action="<?php echo e(route('patient.logout')); ?>" class="mt-5">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-outline w-full">Sign out</button>
                    </form>
                </aside>
            </div>
        </div>
    </section>

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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\patient\profile.blade.php ENDPATH**/ ?>