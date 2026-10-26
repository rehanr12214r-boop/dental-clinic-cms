<?php
    use Carbon\CarbonInterface;
?>

<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'My dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'My dashboard']); ?>

    <section class="bg-cream">
        <div class="site-container pb-10 pt-10 lg:pb-14 lg:pt-14">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <div>
                    <p class="eyebrow">
                        <span class="eyebrow-mark" aria-hidden="true">//</span>
                        Patient portal
                    </p>
                    <h1 class="display-title mt-4 text-[2.7rem] leading-[1.02] sm:text-[3.4rem]">
                        Welcome back, <em><?php echo e(explode(' ', $patient->name)[0]); ?>.</em>
                    </h1>
                    <p class="mt-4 max-w-xl text-[12px] leading-6 text-body">
                        Manage your upcoming visits, review your treatment history and print receipts.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2.5">
                    <a href="<?php echo e(route('patient.profile.edit')); ?>" class="btn-medio-light">Profile settings</a>
                    <a href="<?php echo e(route('book')); ?>" class="btn-medio">
                        Book new appointment
                        <span class="btn-medio-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            <dl class="mt-10 grid gap-3 sm:grid-cols-3">
                <div class="rounded-[20px] border border-line bg-white p-5">
                    <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Upcoming visits</dt>
                    <dd class="mt-2 font-display text-[2.4rem] leading-none tracking-[-0.04em] text-ink"><?php echo e($stats['upcoming']); ?></dd>
                </div>
                <div class="rounded-[20px] border border-line bg-white p-5">
                    <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Completed visits</dt>
                    <dd class="mt-2 font-display text-[2.4rem] leading-none tracking-[-0.04em] text-ink"><?php echo e($stats['completed']); ?></dd>
                </div>
                <div class="rounded-[20px] bg-terracotta p-5 text-white">
                    <dt class="text-[10px] font-semibold uppercase tracking-[0.14em] text-white/60">Total paid</dt>
                    <dd class="mt-2 font-display text-[2.4rem] leading-none tracking-[-0.04em]">$<?php echo e(number_format((float) $stats['total_paid'], 2)); ?></dd>
                </div>
            </dl>
        </div>
    </section>

    <section class="site-container pb-20">
        <div class="space-y-12">

            
            <div>
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <h2 class="font-display text-[1.7rem] tracking-[-0.03em] text-ink">Upcoming appointments</h2>
                    <p class="text-[10px] font-medium text-muted">Cancel or reschedule online until <?php echo e($cutoffHours); ?> hours before the visit</p>
                </div>

                <?php if($upcomingAppointments->isEmpty()): ?>
                    <div class="mt-5 rounded-[24px] border border-dashed border-ink/20 bg-white px-8 py-14 text-center">
                        <span class="mx-auto grid size-14 place-items-center rounded-full bg-beige text-terracotta">
                            <?php if (isset($component)) { $__componentOriginal2b2c843ed63e331ce4f4d735166615e0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b2c843ed63e331ce4f4d735166615e0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.tooth-icon','data' => ['class' => 'size-7']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.tooth-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-7']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b2c843ed63e331ce4f4d735166615e0)): ?>
<?php $attributes = $__attributesOriginal2b2c843ed63e331ce4f4d735166615e0; ?>
<?php unset($__attributesOriginal2b2c843ed63e331ce4f4d735166615e0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b2c843ed63e331ce4f4d735166615e0)): ?>
<?php $component = $__componentOriginal2b2c843ed63e331ce4f4d735166615e0; ?>
<?php unset($__componentOriginal2b2c843ed63e331ce4f4d735166615e0); ?>
<?php endif; ?>
                        </span>
                        <h3 class="mt-5 font-display text-[1.85rem] tracking-[-0.03em] text-ink">No upcoming appointments</h3>
                        <p class="mx-auto mt-2 max-w-sm text-[12px] leading-6 text-body">
                            Ready for your next check-up? Pick a treatment and a time that suits you — booking
                            takes less than a minute.
                        </p>
                        <a href="<?php echo e(route('book')); ?>" class="btn-medio mt-6">
                            Book an appointment
                            <span class="btn-medio-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                <?php else: ?>
                    <ul class="mt-5 space-y-4">
                        <?php $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="rounded-[24px] border border-line bg-white p-5 sm:p-6">
                                <div class="flex flex-wrap items-start gap-5">
                                    
                                    <div class="grid w-16 shrink-0 place-items-center rounded-[18px] bg-beige py-3">
                                        <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-terracotta"><?php echo e($appointment->startsAt()->format('M')); ?></span>
                                        <span class="font-display text-[2rem] leading-none tracking-[-0.04em] text-ink"><?php echo e($appointment->startsAt()->format('j')); ?></span>
                                        <span class="mt-1 text-[9px] font-semibold uppercase tracking-[0.12em] text-muted"><?php echo e($appointment->startsAt()->format('D')); ?></span>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2.5">
                                            <h3 class="font-display text-[1.4rem] leading-tight tracking-[-0.03em] text-ink"><?php echo e($appointment->treatment?->name); ?></h3>
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
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-beige/60 px-3 py-1 text-[10px] font-semibold text-ink">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5 text-terracotta">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <span data-countdown-to="<?php echo e($appointment->startsAt()->toIso8601String()); ?>">in <?php echo e($appointment->startsAt()->diffForHumans(now(), ['parts' => 2, 'syntax' => CarbonInterface::DIFF_ABSOLUTE, 'short' => true])); ?></span>
                                            </span>
                                        </div>

                                        <p class="mt-2 text-[12px] font-medium text-body">
                                            <?php echo e($appointment->dateLabel('l, F j, Y')); ?> · <?php echo e($appointment->timeLabel()); ?>

                                            <span class="text-muted">· <?php echo e((int) ($appointment->treatment?->duration_minutes ?? 0)); ?> min · <?php echo e($appointment->reference); ?></span>
                                        </p>

                                        <div class="mt-4 flex flex-wrap items-center gap-2.5">
                                            <?php if($appointment->isCancellable()): ?>
                                                <a href="<?php echo e(route('patient.appointments.reschedule', $appointment)); ?>"
                                                   class="inline-flex items-center gap-1.5 rounded-full border border-ink/15 bg-white px-4 py-2 text-[11px] font-semibold text-ink transition hover:border-terracotta hover:text-terracotta">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                                    </svg>
                                                    Reschedule
                                                </a>
                                                <form method="POST" action="<?php echo e(route('patient.appointments.cancel', $appointment)); ?>"
                                                      onsubmit="return confirm('Cancel your <?php echo e($appointment->treatment?->name); ?> appointment on <?php echo e($appointment->dateLabel()); ?> at <?php echo e($appointment->timeLabel()); ?>?');">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 rounded-full border border-[#e8b9aa] bg-white px-4 py-2 text-[11px] font-semibold text-[#963f2b] transition hover:bg-[#fdf0eb]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-3.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                        </svg>
                                                        Cancel
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <p class="rounded-full bg-[#f7eddf] px-4 py-2 text-[10px] font-semibold text-[#8b5a2b]">
                                                    Online changes close <?php echo e($cutoffHours); ?> hours before the visit — call the clinic for urgent changes.
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <p class="shrink-0 text-right">
                                        <span class="block font-display text-[1.45rem] tracking-[-0.03em] text-ink">$<?php echo e(number_format((float) ($appointment->treatment?->cost ?? 0), 2)); ?></span>
                                        <span class="mt-0.5 block text-[9px] font-semibold uppercase tracking-[0.1em] text-muted">fee at clinic</span>
                                    </p>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>

            
            <div>
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <h2 class="font-display text-[1.7rem] tracking-[-0.03em] text-ink">Treatment history</h2>
                    <p class="text-[10px] font-medium text-muted">A record of every completed visit</p>
                </div>

                <?php if($pastAppointments->isEmpty()): ?>
                    <div class="mt-5 rounded-[24px] border border-dashed border-ink/20 bg-white px-8 py-12 text-center">
                        <h3 class="font-display text-[1.6rem] tracking-[-0.03em] text-ink">Your visit history is empty</h3>
                        <p class="mx-auto mt-2 max-w-sm text-[12px] leading-6 text-body">
                            Once you complete your first appointment it will appear here, together with a
                            printable digital receipt.
                        </p>
                    </div>
                <?php else: ?>
                    <div class="mt-5 overflow-hidden rounded-[20px] border border-line bg-white">
                        <table class="portal-table">
                            <thead>
                            <tr>
                                <th scope="col">Treatment</th>
                                <th scope="col" class="hidden sm:table-cell">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="hidden text-right sm:table-cell">Fee</th>
                                <th scope="col" class="text-right">Receipt</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $pastAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <p class="font-semibold text-ink"><?php echo e($appointment->treatment?->name); ?></p>
                                        <p class="mt-0.5 text-[10px] text-muted sm:hidden"><?php echo e($appointment->dateLabel()); ?> · <?php echo e($appointment->timeLabel()); ?></p>
                                        <p class="mt-0.5 font-mono text-[10px] text-muted"><?php echo e($appointment->reference); ?></p>
                                    </td>
                                    <td class="hidden sm:table-cell">
                                        <p class="font-medium text-ink"><?php echo e($appointment->dateLabel()); ?></p>
                                        <p class="mt-0.5 text-[10px] text-muted"><?php echo e($appointment->timeLabel()); ?></p>
                                    </td>
                                    <td>
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
                                    </td>
                                    <td class="hidden text-right font-medium text-ink sm:table-cell">
                                        $<?php echo e(number_format((float) ($appointment->treatment?->cost ?? 0), 2)); ?>

                                    </td>
                                    <td class="text-right">
                                        <?php if($appointment->status === \App\Enums\AppointmentStatus::Completed): ?>
                                            <a href="<?php echo e(route('patient.appointments.receipt', $appointment)); ?>" target="_blank"
                                               class="inline-flex items-center gap-1.5 rounded-full border border-ink/15 px-3 py-1.5 text-[10px] font-semibold text-terracotta transition hover:border-terracotta/40 hover:bg-beige/60">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Z"/>
                                                </svg>
                                                Receipt
                                            </a>
                                        <?php else: ?>
                                            <span class="text-[10px] font-semibold text-ink/25">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/patient/dashboard.blade.php ENDPATH**/ ?>