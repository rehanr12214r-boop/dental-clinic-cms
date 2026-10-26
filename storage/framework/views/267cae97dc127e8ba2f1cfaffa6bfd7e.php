<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'Reschedule appointment']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Reschedule appointment']); ?>

    <section class="bg-cream">
        <div class="site-container pb-20 pt-10 lg:pt-14">
            <nav class="flex items-center gap-2 text-[11px] font-medium text-muted" aria-label="Breadcrumb">
                <a href="<?php echo e(route('patient.dashboard')); ?>" class="transition hover:text-terracotta">My dashboard</a>
                <span aria-hidden="true">/</span>
                <span class="text-ink">Reschedule</span>
            </nav>

            <div class="mt-7 max-w-2xl">
                <p class="eyebrow">
                    <span class="eyebrow-mark" aria-hidden="true">//</span>
                    Change of plans
                </p>
                <h1 class="display-title mt-4 text-[2.8rem] leading-[1.02] sm:text-[3.5rem]">Move your <em>appointment.</em></h1>
                <p class="mt-4 max-w-xl text-[12px] leading-6 text-body">
                    Pick a new date and time below — availability updates live and your booking is moved instantly.
                </p>
            </div>

            <div class="mt-8 grid gap-5 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                <div class="rounded-[24px] border border-line bg-white p-6 sm:p-7">
                    <p class="eyebrow">
                        <span class="eyebrow-mark" aria-hidden="true">//</span>
                        Currently booked
                    </p>
                    <div class="mt-4 flex items-start justify-between gap-4">
                        <div>
                            <h2 class="font-display text-[1.55rem] leading-tight tracking-[-0.03em] text-ink"><?php echo e($appointment->treatment?->name); ?></h2>
                            <p class="mt-2 text-[12px] leading-6 text-body">
                                <?php echo e($appointment->dateLabel('l, F j, Y')); ?> · <?php echo e($appointment->timeLabel()); ?>

                                <span class="block text-[10px] text-muted"><?php echo e($appointment->reference); ?></span>
                            </p>
                        </div>
                        <?php if (isset($component)) { $__componentOriginalb81fc6772e73f4437f3632bd6b51a80c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb81fc6772e73f4437f3632bd6b51a80c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.status-badge','data' => ['status' => $appointment->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointment->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb81fc6772e73f4437f3632bd6b51a80c)): ?>
<?php $attributes = $__attributesOriginalb81fc6772e73f4437f3632bd6b51a80c; ?>
<?php unset($__attributesOriginalb81fc6772e73f4437f3632bd6b51a80c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb81fc6772e73f4437f3632bd6b51a80c)): ?>
<?php $component = $__componentOriginalb81fc6772e73f4437f3632bd6b51a80c; ?>
<?php unset($__componentOriginalb81fc6772e73f4437f3632bd6b51a80c); ?>
<?php endif; ?>
                    </div>
                    <div class="mt-5 border-t border-line/70 pt-4">
                        <p class="text-[10px] leading-5 text-muted">
                            Rescheduling is free and cancels the old slot automatically. Online changes are available until
                            <?php echo e(\App\Models\Appointment::CANCELLATION_CUTOFF_HOURS); ?> hours before the visit.
                        </p>
                    </div>
                </div>

                <div>
                    
                    <div id="reschedule-config"
                         data-days-off="<?php echo e(implode(',', $daysOff)); ?>"
                         data-max-date="<?php echo e($maxBookingDate); ?>"
                         data-slots-endpoint="<?php echo e($slotsEndpoint); ?>"
                         hidden></div>

                    <form method="POST" action="<?php echo e(route('patient.appointments.reschedule.update', $appointment)); ?>"
                          class="rounded-[24px] border border-line bg-white p-6 sm:p-8">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <div class="grid gap-5 sm:grid-cols-[minmax(0,1fr)_minmax(0,1.6fr)] sm:items-start">
                            <div>
                                <label for="reschedule-date-picker" class="field-label">New date</label>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="pointer-events-none absolute bottom-3 left-0 size-4.5 text-muted">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                    </svg>
                                    <input id="reschedule-date-picker" name="appointment_date" type="text"
                                           autocomplete="off" placeholder="Select a date"
                                           class="field-input pl-6"/>
                                </div>
                                <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-[11px] font-medium text-[#963f2b]"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <input type="hidden" id="reschedule-time" name="appointment_time" value="<?php echo e(old('appointment_time')); ?>"/>
                                <?php $__errorArgs = ['appointment_time'];
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
                                <p class="field-label">New time</p>

                                <div id="reschedule-slots-loading" class="flex items-center gap-2 py-2 text-[12px] text-body" hidden>
                                    <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"/>
                                    </svg>
                                    <span>Loading available time slots…</span>
                                </div>

                                <p id="reschedule-slots-meta" class="mb-3 text-[12px] font-medium text-body" hidden></p>

                                <div id="reschedule-slots-grid" class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4" hidden></div>

                                <p id="reschedule-slots-empty" class="rounded-[14px] border border-dashed border-ink/20 bg-cream px-4 py-3 text-[12px] text-body" hidden>
                                    Select a date to see the available time slots.
                                </p>

                                <p id="reschedule-slots-error" class="mt-2 text-[12px] font-medium text-[#963f2b]" hidden></p>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-line/70 pt-6">
                            <button type="submit" id="reschedule-submit" disabled
                                    class="btn-medio disabled:cursor-not-allowed disabled:opacity-50">
                                Confirm new time
                                <span class="btn-medio-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                    </svg>
                                </span>
                            </button>
                            <a href="<?php echo e(route('patient.dashboard')); ?>" class="btn-medio-light">Keep current booking</a>
                        </div>
                    </form>
                </div>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/patient/reschedule.blade.php ENDPATH**/ ?>