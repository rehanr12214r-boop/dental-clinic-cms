<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'Track your appointment']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Track your appointment']); ?>

    <section class="bg-cream">
        <div class="site-container pb-10 pt-10 lg:pb-14 lg:pt-14">
            <nav class="flex items-center gap-2 text-[11px] font-medium text-muted" aria-label="Breadcrumb">
                <a href="<?php echo e(route('home')); ?>" class="transition hover:text-terracotta">Home</a>
                <span aria-hidden="true">/</span>
                <span class="text-ink">Track appointment</span>
            </nav>

            <div class="mt-7 grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-end lg:gap-16">
                <div>
                    <p class="eyebrow">
                        <span class="eyebrow-mark" aria-hidden="true">//</span>
                        Already booked
                    </p>
                    <h1 class="display-title mt-4 text-[2.9rem] leading-[1.01] sm:text-[3.7rem] lg:text-[4.2rem]">
                        Track your <em>appointment.</em>
                    </h1>
                    <p class="body-copy mt-5 max-w-xl">
                        Enter the booking reference from your confirmation (it looks like
                        <span class="font-mono font-semibold text-ink">APT-00042</span>) together with the WhatsApp
                        number you booked with, to see the status of your visit — or cancel it.
                    </p>
                </div>

                <div class="relative hidden overflow-hidden rounded-[26px] lg:block">
                    <img src="<?php echo e(asset('images/site/contact-hero.jpg')); ?>"
                         alt="A dentist checking a patient's appointment"
                         class="h-[220px] w-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-ink/55 to-transparent" aria-hidden="true"></div>
                    <p class="absolute bottom-5 left-6 right-6 font-display text-[1.35rem] leading-tight tracking-[-0.025em] text-cream">
                        Everything you need to know, right here.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="site-container pb-20">
        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-start lg:gap-8">

            
            <div class="rounded-[24px] border border-line bg-white p-6 sm:p-8">
                <p class="eyebrow">
                    <span class="eyebrow-mark" aria-hidden="true">//</span>
                    Find my booking
                </p>
                <h2 class="mt-3 font-display text-[1.9rem] leading-tight tracking-[-0.03em] text-ink">Let's find your visit.</h2>
                <p class="mt-2 text-[12px] leading-5 text-body">Both fields are required — they protect your booking from strangers.</p>

                <form method="POST" action="<?php echo e(route('appointment.lookup.find')); ?>" class="mt-7 space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="reference" class="field-label">Booking reference</label>
                        <input id="reference" type="text" name="reference" required maxlength="20"
                               value="<?php echo e(old('reference', $reference)); ?>"
                               placeholder="APT-00042" autocomplete="off"
                               class="field-input font-mono uppercase"/>
                        <?php $__errorArgs = ['reference'];
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
                        <input id="phone" type="tel" name="phone" required maxlength="32"
                               value="<?php echo e(old('phone', $phone)); ?>"
                               placeholder="+964 770 123 4567" inputmode="tel"
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

                    <button type="submit" class="btn-medio w-full justify-center">
                        Find my appointment
                        <span class="btn-medio-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </button>
                </form>

                <div class="mt-6 rounded-[16px] bg-beige/60 px-4 py-3.5 text-[11px] leading-5 text-body">
                    Lost your reference? Check your WhatsApp confirmation message, or
                    <a href="<?php echo e(route('patient.login')); ?>" class="font-semibold text-terracotta underline-offset-2 hover:underline">sign in to the patient portal</a>
                    if you booked with an account.
                </div>
            </div>

            
            <div>
                <?php if($appointment): ?>
                    <div class="rounded-[24px] border border-line bg-white p-6 sm:p-8">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="eyebrow">
                                    <span class="eyebrow-mark" aria-hidden="true">//</span>
                                    Booking <?php echo e($appointment->reference); ?>

                                </p>
                                <h2 class="mt-3 font-display text-[2rem] leading-tight tracking-[-0.03em] text-ink"><?php echo e($appointment->treatment?->name); ?></h2>
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

                        <dl class="mt-6 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-[16px] bg-beige/60 px-4 py-3.5">
                                <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Date</dt>
                                <dd class="mt-1.5 text-[13px] font-semibold text-ink"><?php echo e($appointment->dateLabel('l, F j, Y')); ?></dd>
                            </div>
                            <div class="rounded-[16px] bg-beige/60 px-4 py-3.5">
                                <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Time</dt>
                                <dd class="mt-1.5 text-[13px] font-semibold text-ink"><?php echo e($appointment->timeLabel()); ?></dd>
                            </div>
                            <div class="rounded-[16px] bg-beige/60 px-4 py-3.5">
                                <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Patient</dt>
                                <dd class="mt-1.5 text-[13px] font-semibold text-ink"><?php echo e($appointment->patient_name); ?></dd>
                            </div>
                            <div class="rounded-[16px] bg-beige/60 px-4 py-3.5">
                                <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Fee at clinic</dt>
                                <dd class="mt-1.5 text-[13px] font-semibold text-ink">$<?php echo e(number_format((float) ($appointment->treatment?->cost ?? 0), 2)); ?></dd>
                            </div>
                        </dl>

                        <?php if($appointment->isCancellable()): ?>
                            <div class="mt-6 rounded-[18px] border border-line bg-cream/60 p-5">
                                <p class="text-[13px] font-semibold text-ink">Need to cancel?</p>
                                <p class="mt-1.5 text-[11px] leading-5 text-body">
                                    You can cancel online until <?php echo e($cutoffHours); ?> hours before the appointment.
                                    The slot is released for other patients immediately.
                                </p>
                                <form method="POST" action="<?php echo e(route('appointment.lookup.cancel')); ?>" class="mt-4"
                                      onsubmit="return confirm('Cancel your appointment on <?php echo e($appointment->dateLabel()); ?> at <?php echo e($appointment->timeLabel()); ?>?');">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="reference" value="<?php echo e($appointment->reference); ?>"/>
                                    <input type="hidden" name="phone" value="<?php echo e($phone); ?>"/>
                                    <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-full border border-[#e8b9aa] bg-white px-5 py-2.5 text-[12px] font-semibold text-[#963f2b] transition hover:bg-[#fdf0eb]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        Cancel this appointment
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="mt-6 rounded-[18px] border border-[#e6cfad] bg-[#f7eddf] px-5 py-4">
                                <p class="text-[13px] font-semibold text-[#7e5128]">Online changes are closed for this visit</p>
                                <p class="mt-1.5 text-[11px] leading-5 text-[#8b5a2b]">
                                    <?php if($appointment->status === \App\Enums\AppointmentStatus::Cancelled): ?>
                                        This appointment was cancelled. You can book a new visit online at any time.
                                    <?php elseif($appointment->status === \App\Enums\AppointmentStatus::Completed): ?>
                                        This visit is completed — we hope it went well! See you at your next check-up.
                                    <?php else: ?>
                                        Appointments can only be changed online until <?php echo e($cutoffHours); ?> hours before they start.
                                        Please call the clinic and we'll help you directly.
                                    <?php endif; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <p class="mt-4 text-center text-[10px] leading-5 text-muted">
                        Keep this page's link private — anyone with your reference and phone number can view this booking.
                    </p>
                <?php elseif($lookupAttempted): ?>
                    <div class="rounded-[24px] border border-dashed border-ink/20 bg-white px-8 py-14 text-center">
                        <span class="mx-auto grid size-14 place-items-center rounded-full bg-[#f9e9e4] text-[#963f2b]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </span>
                        <h2 class="mt-5 font-display text-[1.9rem] tracking-[-0.03em] text-ink">No booking found</h2>
                        <p class="mx-auto mt-2 max-w-sm text-[12px] leading-6 text-body">
                            We couldn't match that reference and phone number. Double-check both — the reference was in your
                            WhatsApp confirmation. Still stuck? Call the clinic.
                        </p>
                    </div>
                <?php else: ?>
                    <div class="overflow-hidden rounded-[24px] bg-dark text-cream">
                        <img src="<?php echo e(asset('images/site/appointment-hero.jpg')); ?>"
                             alt="A dentist ready to welcome a patient"
                             class="h-[220px] w-full object-cover object-center opacity-90" loading="lazy">
                        <div class="p-6 sm:p-8">
                            <p class="eyebrow text-cream/60">
                                <span class="eyebrow-mark text-terracotta" aria-hidden="true">//</span>
                                Your booking, in one place
                            </p>
                            <h2 class="mt-3 font-display text-[1.8rem] leading-tight tracking-[-0.03em] text-cream">Your booking status will appear here.</h2>
                            <p class="mt-3 text-[12px] leading-6 text-cream/60">
                                Fill in the form and we'll show you the appointment details, its current status, and
                                a cancel button when online cancellation is still open.
                            </p>
                            <ul class="mt-6 grid gap-3 border-t border-cream/15 pt-5 text-[11px] text-cream/70 sm:grid-cols-2">
                                <li class="flex items-center gap-2"><span class="status-dot bg-terracotta"></span> Live status</li>
                                <li class="flex items-center gap-2"><span class="status-dot bg-terracotta"></span> Visit details</li>
                                <li class="flex items-center gap-2"><span class="status-dot bg-terracotta"></span> Online cancellation</li>
                                <li class="flex items-center gap-2"><span class="status-dot bg-terracotta"></span> Reference lookup</li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\appointment-lookup.blade.php ENDPATH**/ ?>