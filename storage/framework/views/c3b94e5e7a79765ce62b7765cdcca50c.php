<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Treatments','heading' => 'Treatments management','headingSub' => 'Services offered at the clinic, with fees and durations']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Treatments','heading' => 'Treatments management','headingSub' => 'Services offered at the clinic, with fees and durations']); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.treatments.create')); ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New treatment
        </a>
     <?php $__env->endSlot(); ?>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="w-full min-w-[48rem] text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-4 py-3 font-semibold">Treatment</th>
                <th class="px-4 py-3 font-semibold">Duration</th>
                <th class="px-4 py-3 font-semibold">Fee</th>
                <th class="px-4 py-3 font-semibold">Bookings</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 text-right font-semibold">Actions</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="transition hover:bg-slate-50/70">
                    <td class="px-4 py-3.5">
                        <p class="font-semibold text-slate-900"><?php echo e($treatment->name); ?></p>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600"><?php echo e($treatment->duration_minutes); ?> min</td>
                    <td class="px-4 py-3.5 font-medium text-slate-900">$<?php echo e(number_format((float) $treatment->cost, 2)); ?></td>
                    <td class="px-4 py-3.5 text-slate-600"><?php echo e($treatment->appointments_count); ?></td>

                    
                    <td class="px-4 py-3.5">
                        <form method="POST" action="<?php echo e(route('admin.treatments.toggle', $treatment)); ?>" class="flex items-center gap-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="inline-flex cursor-pointer items-center transition hover:opacity-80"
                                    title="<?php echo e($treatment->is_active ? 'Deactivate (hide from public booking)' : 'Activate'); ?>">
                                <span class="relative inline-flex h-5 w-9 items-center rounded-full"
                                      class="<?php echo \Illuminate\Support\Arr::toCssClasses(['bg-emerald-600' => $treatment->is_active, 'bg-slate-300' => ! $treatment->is_active]); ?>">
                                    <span class="absolute left-0.5 h-4 w-4 rounded-full bg-white shadow transition"
                                          class="<?php echo \Illuminate\Support\Arr::toCssClasses(['translate-x-4' => $treatment->is_active, 'translate-x-0' => ! $treatment->is_active]); ?>"></span>
                                </span>
                            </button>
                            <span class="text-xs font-semibold <?php echo e($treatment->is_active ? 'text-emerald-700' : 'text-slate-400'); ?>">
                                <?php echo e($treatment->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </form>
                    </td>

                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-end gap-3">
                            <a href="<?php echo e(route('admin.treatments.edit', $treatment)); ?>"
                               class="text-xs font-bold text-cyan-700 underline-offset-2 transition hover:underline">
                                Edit
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.treatments.destroy', $treatment)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="text-xs font-bold text-rose-600 underline-offset-2 transition hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-4 py-16 text-center">
                        <p class="text-4xl">🦷</p>
                        <p class="mt-3 font-semibold text-slate-900">No treatments yet</p>
                        <p class="mt-1 text-sm text-slate-500">Treatments power the public booking portal — add your first service with a fee and duration.</p>
                        <a href="<?php echo e(route('admin.treatments.create')); ?>"
                           class="mt-4 inline-flex rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                            Add the first treatment
                        </a>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\admin\treatments\index.blade.php ENDPATH**/ ?>