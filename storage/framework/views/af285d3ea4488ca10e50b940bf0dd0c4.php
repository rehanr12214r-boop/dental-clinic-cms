<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'All appointments','heading' => 'All appointments','headingSub' => $appointments->total().' booking(s) match the current filters · clinic timezone: '.config('app.timezone')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'All appointments','heading' => 'All appointments','headingSub' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointments->total().' booking(s) match the current filters · clinic timezone: '.config('app.timezone'))]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.dashboard')); ?>"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Today's dashboard
        </a>
     <?php $__env->endSlot(); ?>

    
    <nav class="flex flex-wrap gap-1 rounded-2xl bg-white p-1.5 shadow-sm ring-1 ring-slate-200" aria-label="Appointment period">
        <?php $__currentLoopData = ['upcoming' => 'Upcoming', 'today' => 'Today', 'past' => 'Past', 'all' => 'All dates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.appointments.index', array_filter([
                    'period' => $value,
                    'status' => $status?->value,
                    'q' => $search !== '' ? $search : null,
                ]))); ?>"
               class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                   'rounded-xl px-4 py-2 text-sm font-semibold transition',
                   'bg-slate-900 text-white shadow-sm' => $period === $value && $from === null && $to === null,
                   'text-slate-600 hover:bg-slate-100' => ! ($period === $value && $from === null && $to === null),
               ]); ?>">
                <?php echo e($label); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    
    <form method="GET" action="<?php echo e(route('admin.appointments.index')); ?>"
          class="mt-4 grid gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:grid-cols-2 lg:grid-cols-6">
        <input type="hidden" name="period" value="<?php echo e($period); ?>"/>

        <div class="lg:col-span-2">
            <label for="appointments-q" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Search</label>
            <input id="appointments-q" type="search" name="q" value="<?php echo e($search); ?>" placeholder="Name, phone or APT-00042…"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div>
            <label for="appointments-status" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Status</label>
            <select id="appointments-status" name="status"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <option value="" <?php if($status === null): echo 'selected'; endif; ?>>All statuses</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($option->value); ?>" <?php if(($status?->value ?? '') === $option->value): echo 'selected'; endif; ?>><?php echo e($option->label()); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label for="appointments-from" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">From</label>
            <input id="appointments-from" type="date" name="from" value="<?php echo e($from?->toDateString()); ?>"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div>
            <label for="appointments-to" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">To</label>
            <input id="appointments-to" type="date" name="to" value="<?php echo e($to?->toDateString()); ?>"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div class="flex items-end gap-2">
            <button type="submit"
                    class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                Apply
            </button>
            <a href="<?php echo e(route('admin.appointments.index')); ?>"
               class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                Reset
            </a>
        </div>
    </form>

    <?php if($search !== '' || $status !== null || $from !== null || $to !== null): ?>
        <p class="mt-3 text-xs font-medium text-slate-500">
            Filters active — the table shows matching bookings from the selected period only.
        </p>
    <?php endif; ?>

    
    <div class="mt-4 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="w-full min-w-[68rem] text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-4 py-3 font-semibold">Reference</th>
                <th class="px-4 py-3 font-semibold">Patient</th>
                <th class="px-4 py-3 font-semibold">Contact</th>
                <th class="px-4 py-3 font-semibold">Treatment</th>
                <th class="px-4 py-3 font-semibold">Scheduled</th>
                <th class="px-4 py-3 font-semibold">Booked</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 font-semibold"></th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="align-top transition hover:bg-slate-50/70">
                    <td class="px-4 py-3.5">
                        <span class="rounded bg-slate-100 px-2 py-0.5 font-mono text-xs font-semibold text-slate-700"><?php echo e($appointment->reference); ?></span>
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="font-semibold text-slate-900"><?php echo e($appointment->patient_name); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($appointment->patient_age); ?> years old</p>
                        <?php if($appointment->patient_id): ?>
                            <span class="mt-1 inline-block rounded-full bg-teal-50 px-1.5 py-0.5 text-[10px] font-bold text-teal-700 ring-1 ring-teal-600/20">Portal account</span>
                        <?php endif; ?>
                    </td>

                    <td class="px-4 py-3.5">
                        <a href="<?php echo e($appointment->whatsappUrl()); ?>" target="_blank" rel="noopener noreferrer"
                           class="text-xs font-semibold text-slate-700 underline-offset-2 hover:text-emerald-700 hover:underline">
                            <?php echo e($appointment->patient_phone); ?>

                        </a>
                        <?php if($appointment->patient?->email): ?>
                            <p class="mt-0.5 truncate text-xs text-slate-400"><?php echo e($appointment->patient->email); ?></p>
                        <?php endif; ?>
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="font-medium text-slate-900"><?php echo e($appointment->treatment?->name ?? '—'); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($appointment->treatment?->duration_minutes ?? 0); ?> min · $<?php echo e(number_format((float) ($appointment->treatment?->cost ?? 0), 2)); ?></p>
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="font-semibold text-slate-900"><?php echo e($appointment->dateLabel('D, M j, Y')); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($appointment->timeLabel()); ?></p>
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="text-xs text-slate-600"><?php echo e($appointment->created_at?->format('M j, Y') ?? '—'); ?></p>
                        <p class="text-[11px] text-slate-400"><?php echo e($appointment->created_at?->diffForHumans() ?? ''); ?></p>
                    </td>

                    <td class="px-4 py-3.5">
                        <?php if (isset($component)) { $__componentOriginal72ffe10338c4ec71bdf1582010227fb9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72ffe10338c4ec71bdf1582010227fb9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.status-badge','data' => ['status' => $appointment->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($appointment->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal72ffe10338c4ec71bdf1582010227fb9)): ?>
<?php $attributes = $__attributesOriginal72ffe10338c4ec71bdf1582010227fb9; ?>
<?php unset($__attributesOriginal72ffe10338c4ec71bdf1582010227fb9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal72ffe10338c4ec71bdf1582010227fb9)): ?>
<?php $component = $__componentOriginal72ffe10338c4ec71bdf1582010227fb9; ?>
<?php unset($__componentOriginal72ffe10338c4ec71bdf1582010227fb9); ?>
<?php endif; ?>
                    </td>

                    <td class="px-4 py-3.5 text-right">
                        <a href="<?php echo e(route('admin.dashboard', ['date' => $appointment->appointment_date->toDateString()])); ?>"
                           class="inline-flex whitespace-nowrap rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50">
                            Open day
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="px-4 py-16 text-center">
                        <?php if($search !== '' || $status !== null || $from !== null || $to !== null): ?>
                            <p class="text-4xl">🔍</p>
                            <p class="mt-3 font-semibold text-slate-900">No appointments match your filters</p>
                            <p class="mt-1 text-sm text-slate-500">Try a different search term, status or date range — or reset the filters.</p>
                            <a href="<?php echo e(route('admin.appointments.index')); ?>"
                               class="mt-4 inline-flex rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                Clear filters
                            </a>
                        <?php else: ?>
                            <p class="text-4xl">🦷</p>
                            <p class="mt-3 font-semibold text-slate-900">No appointments in this period</p>
                            <p class="mt-1 text-sm text-slate-500">This is an empty result, not a system error. New portal bookings will appear here immediately.</p>
                            <a href="<?php echo e(route('admin.appointments.index', ['period' => 'all'])); ?>"
                               class="mt-4 inline-flex rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                                Show all dates
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($appointments->hasPages()): ?>
        <div class="mt-4"><?php echo e($appointments->links()); ?></div>
    <?php endif; ?>

    <p class="mt-4 text-xs text-slate-500">
        <?php if($appointments->total() > 0): ?>
            Showing <?php echo e($appointments->firstItem()); ?>–<?php echo e($appointments->lastItem()); ?> of <?php echo e($appointments->total()); ?> appointment(s).
        <?php else: ?>
            No appointments to show.
        <?php endif; ?>
        Times are displayed in the clinic timezone (<?php echo e(config('app.timezone')); ?>).
    </p>

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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/admin/appointments/index.blade.php ENDPATH**/ ?>