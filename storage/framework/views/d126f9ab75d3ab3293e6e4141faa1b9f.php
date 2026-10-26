<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Doctor Schedule','heading' => 'Doctor schedule management','headingSub' => 'Working days, hours and slot duration for the public booking portal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Doctor Schedule','heading' => 'Doctor schedule management','headingSub' => 'Working days, hours and slot duration for the public booking portal']); ?>

    <form method="POST" action="<?php echo e(route('admin.schedule.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <?php $__currentLoopData = $weekdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as ['day' => $day, 'label' => $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $schedule = $schedules->get($day);
                    $isDayOff = $schedule?->is_day_off ?? false;
                ?>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 <?php echo e($isDayOff ? 'opacity-80' : ''); ?>">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900"><?php echo e($label); ?></h3>
                            <p class="mt-0.5 text-xs text-slate-500">
                                <?php if($isDayOff): ?>
                                    Day off — not bookable
                                <?php else: ?>
                                    <?php echo e(\Carbon\CarbonImmutable::parse($schedule?->start_time ?? '17:00')->format('g:i A')); ?>

                                    –
                                    <?php echo e(\Carbon\CarbonImmutable::parse($schedule?->end_time ?? '21:00')->format('g:i A')); ?>

                                    · <?php echo e($schedule?->slot_duration_minutes ?? 30); ?>-min slots
                                <?php endif; ?>
                            </p>
                        </div>

                        
                        <label class="inline-flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="schedules[<?php echo e($day); ?>][is_day_off]" value="1"
                                   <?php if(old('schedules.'.$day.'.is_day_off', $isDayOff)): echo 'checked'; endif; ?>
                                   class="peer sr-only">
                            <span class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full bg-slate-300 transition-colors duration-200 peer-checked:bg-emerald-600 peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-cyan-700 after:absolute after:left-0.5 after:top-0.5 after:h-4 after:w-4 after:translate-x-0 after:rounded-full after:bg-white after:shadow after:transition-transform after:duration-200 peer-checked:after:translate-x-4"></span>
                            <span class="text-xs font-semibold text-slate-600 transition-colors peer-checked:text-emerald-700">Day off</span>
                        </label>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-2">
                        <div>
                            <label for="start-<?php echo e($day); ?>" class="mb-1 block text-[11px] font-semibold uppercase tracking-wide text-slate-500">Start</label>
                            <input id="start-<?php echo e($day); ?>" type="time" step="300"
                                   name="schedules[<?php echo e($day); ?>][start_time]"
                                   value="<?php echo e(old('schedules.'.$day.'.start_time', $schedule?->start_time ?? '17:00')); ?>"
                                   class="w-full rounded-lg border border-slate-300 bg-white px-2 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                        </div>
                        <div>
                            <label for="end-<?php echo e($day); ?>" class="mb-1 block text-[11px] font-semibold uppercase tracking-wide text-slate-500">End</label>
                            <input id="end-<?php echo e($day); ?>" type="time" step="300"
                                   name="schedules[<?php echo e($day); ?>][end_time]"
                                   value="<?php echo e(old('schedules.'.$day.'.end_time', $schedule?->end_time ?? '21:00')); ?>"
                                   class="w-full rounded-lg border border-slate-300 bg-white px-2 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                        </div>
                        <div>
                            <label for="slot-<?php echo e($day); ?>" class="mb-1 block text-[11px] font-semibold uppercase tracking-wide text-slate-500">Slot</label>
                            <select id="slot-<?php echo e($day); ?>" name="schedules[<?php echo e($day); ?>][slot_duration_minutes]"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-2 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                                <?php $__currentLoopData = $slotOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($option); ?>" <?php if(old('schedules.'.$day.'.slot_duration_minutes', $schedule?->slot_duration_minutes ?? 30) == $option): echo 'selected'; endif; ?>>
                                        <?php echo e($option); ?> min
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit"
                    class="rounded-xl bg-cyan-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
                Save schedule
            </button>
            <p class="text-xs text-slate-500">Changes apply immediately to the public booking portal's available slots.</p>
        </div>
    </form>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/admin/schedule.blade.php ENDPATH**/ ?>