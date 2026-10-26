<?php
    use App\Enums\AppointmentStatus;
    use App\Enums\WhatsAppTemplate;
?>

<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Dashboard','heading' => 'Appointments overview','headingSub' => $date->format('l, F j, Y')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard','heading' => 'Appointments overview','headingSub' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($date->format('l, F j, Y'))]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.appointments.index')); ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm0 5.25h.007v.008H3.75V12Zm0 5.25h.007v.008H3.75v-.008Z"/>
            </svg>
            All appointments
        </a>
        <a href="<?php echo e(route('admin.reports.index')); ?>"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
            </svg>
            Reports & analytics
        </a>
     <?php $__env->endSlot(); ?>

    <?php if($queryError): ?>
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-6 text-rose-800 shadow-sm" role="alert">
            <p class="text-base font-bold">Appointments could not be loaded</p>
            <p class="mt-1 text-sm"><?php echo e($queryError); ?></p>
            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="mt-4 inline-flex rounded-xl bg-rose-700 px-4 py-2 text-sm font-bold text-white transition hover:bg-rose-600">
                Retry
            </a>
        </div>
    <?php else: ?>

    
    <?php
        $totalLabel = $date->isToday() ? "Today's appointments" : 'Appointments';
        $revenueLabel = $date->isToday() ? 'Revenue today' : 'Revenue';
    ?>

    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
        <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => $totalLabel,'value' => $stats['total']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalLabel),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['total'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Pending','value' => $stats['pending'],'tone' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Pending','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['pending']),'tone' => 'amber']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Confirmed','value' => $stats['confirmed'],'tone' => 'sky']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Confirmed','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['confirmed']),'tone' => 'sky']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Completed','value' => $stats['completed'],'tone' => 'emerald']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Completed','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['completed']),'tone' => 'emerald']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => $revenueLabel,'value' => $stats['revenue'],'tone' => 'violet']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($revenueLabel),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['revenue']),'tone' => 'violet']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
    </div>

    
    <?php if($latestBookings->isNotEmpty() && $search === '' && $status === null): ?>
        <section class="mt-6 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <header class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
                <div>
                    <h2 class="text-sm font-bold tracking-tight text-slate-900">Latest bookings</h2>
                    <p class="mt-0.5 text-xs text-slate-500">
                        Newest bookings across every date — portal bookings appear here the moment they are created.
                    </p>
                </div>
                <a href="<?php echo e(route('admin.appointments.index', ['period' => 'all'])); ?>"
                   class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50">
                    View all
                </a>
            </header>

            <ul class="divide-y divide-slate-100">
                <?php $__currentLoopData = $latestBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isNew = $booking->created_at?->greaterThan(now()->subDay()) ?? false;
                    ?>
                    <li class="flex flex-wrap items-center justify-between gap-3 px-5 py-3">
                        <div class="min-w-0">
                            <p class="flex flex-wrap items-center gap-2 text-sm font-semibold text-slate-900">
                                <?php echo e($booking->patient_name); ?>

                                <?php if($booking->patient_id): ?>
                                    <span class="rounded-full bg-teal-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-teal-700 ring-1 ring-teal-600/20">Portal account</span>
                                <?php endif; ?>
                                <?php if($isNew): ?>
                                    <span class="rounded-full bg-cyan-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-cyan-700 ring-1 ring-cyan-600/20">New</span>
                                <?php endif; ?>
                            </p>
                            <p class="mt-0.5 truncate text-xs text-slate-500">
                                <?php echo e($booking->reference); ?> · <?php echo e($booking->treatment?->name ?? 'Treatment removed'); ?>

                                · booked <?php echo e($booking->created_at?->diffForHumans()); ?>

                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-900"><?php echo e($booking->dateLabel('D, M j')); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e($booking->timeLabel()); ?></p>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal72ffe10338c4ec71bdf1582010227fb9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72ffe10338c4ec71bdf1582010227fb9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.status-badge','data' => ['status' => $booking->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($booking->status)]); ?>
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
                            <a href="<?php echo e(route('admin.dashboard', ['date' => $booking->appointment_date->format('Y-m-d')])); ?>"
                               data-open-day="<?php echo e($booking->appointment_date->format('Y-m-d')); ?>"
                               class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50">
                                Open day
                            </a>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
    <?php endif; ?>

    
    <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>"
          class="mt-6 grid gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:grid-cols-2 sm:items-end lg:grid-cols-4">
        <div>
            <label for="filter-date" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Date</label>
            <input id="filter-date" type="date" name="date" value="<?php echo e($date->toDateString()); ?>"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div>
            <label for="filter-status" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Status</label>
            <select id="filter-status" name="status"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <option value="" <?php if($status === null): echo 'selected'; endif; ?>>All statuses</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($option->value); ?>" <?php if(($status?->value ?? '') === $option->value): echo 'selected'; endif; ?>><?php echo e($option->label()); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label for="filter-q" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Search patient</label>
            <input id="filter-q" type="search" name="q" value="<?php echo e($search); ?>" placeholder="Name or phone…"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm placeholder:text-slate-400 transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                    class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
                Apply filters
            </button>
            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                Reset
            </a>
        </div>
    </form>

    
    <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="w-full min-w-[72rem] text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-4 py-3 font-semibold">Patient</th>
                <th class="px-4 py-3 font-semibold">Contact</th>
                <th class="px-4 py-3 font-semibold">Treatment</th>
                <th class="px-4 py-3 font-semibold">Scheduled</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 font-semibold">Quick actions</th>
                <th class="px-4 py-3 font-semibold">WhatsApp</th>
                <th class="px-4 py-3 font-semibold">Notes</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $nextActions = match ($appointment->status) {
                        AppointmentStatus::Pending => ['confirmed', 'cancelled'],
                        AppointmentStatus::Confirmed => ['in-clinic', 'cancelled'],
                        AppointmentStatus::InClinic => ['completed', 'cancelled'],
                        AppointmentStatus::Completed => [],
                        AppointmentStatus::Cancelled => ['pending'],
                        default => [],
                    };

                    $actionMeta = [
                        'confirmed' => ['label' => 'Confirm', 'class' => 'bg-sky-600 hover:bg-sky-500'],
                        'in-clinic' => ['label' => 'Check-In', 'class' => 'bg-violet-600 hover:bg-violet-500'],
                        'completed' => ['label' => 'Complete', 'class' => 'bg-emerald-600 hover:bg-emerald-500'],
                        'cancelled' => ['label' => 'Cancel', 'class' => 'bg-rose-600 hover:bg-rose-500'],
                        'pending' => ['label' => 'Reopen', 'class' => 'bg-amber-600 hover:bg-amber-500'],
                    ];
                ?>

                <tr class="align-top transition hover:bg-slate-50/70">
                    
                    <td class="px-4 py-3.5">
                        <button type="button" data-patient-history data-history-url="<?php echo e(route('admin.appointments.history', $appointment)); ?>"
                                class="group text-left" title="View patient history">
                            <span class="block font-semibold text-slate-900 underline-offset-2 transition group-hover:text-cyan-700 group-hover:underline">
                                <?php echo e($appointment->patient_name); ?>

                            </span>
                            <span class="block text-xs text-slate-500"><?php echo e($appointment->patient_age); ?> years old</span>
                            <span class="mt-1 flex flex-wrap items-center gap-1.5">
                                <span class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-[10px] font-semibold text-slate-600"><?php echo e($appointment->reference); ?></span>
                                <?php if($appointment->patient_id): ?>
                                    <span class="rounded-full bg-teal-50 px-1.5 py-0.5 text-[10px] font-bold text-teal-700 ring-1 ring-teal-600/20">Portal</span>
                                <?php endif; ?>
                            </span>
                        </button>
                    </td>

                    
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-1.5">
                            <button type="button" data-patient-history data-history-url="<?php echo e(route('admin.appointments.history', $appointment)); ?>"
                                    title="View patient history"
                                    class="rounded-lg px-2 py-1.5 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 transition hover:bg-slate-50 hover:text-cyan-700">
                                <?php echo e($appointment->patient_phone); ?>

                            </button>
                            <a href="<?php echo e($appointment->whatsappUrl()); ?>" target="_blank" rel="noopener noreferrer" title="Chat on WhatsApp"
                               class="grid size-7 shrink-0 place-items-center rounded-lg bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20 transition hover:bg-emerald-100">
                                <?php if (isset($component)) { $__componentOriginale389fdb35e370a49ebaee5b38d79b27b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale389fdb35e370a49ebaee5b38d79b27b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.whatsapp-icon','data' => ['class' => 'size-3.5 content-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.whatsapp-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-3.5 content-center']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale389fdb35e370a49ebaee5b38d79b27b)): ?>
<?php $attributes = $__attributesOriginale389fdb35e370a49ebaee5b38d79b27b; ?>
<?php unset($__attributesOriginale389fdb35e370a49ebaee5b38d79b27b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale389fdb35e370a49ebaee5b38d79b27b)): ?>
<?php $component = $__componentOriginale389fdb35e370a49ebaee5b38d79b27b; ?>
<?php unset($__componentOriginale389fdb35e370a49ebaee5b38d79b27b); ?>
<?php endif; ?>
                            </a>
                        </div>
                    </td>

                    
                    <td class="px-4 py-3.5">
                        <p class="font-medium text-slate-900"><?php echo e($appointment->treatment?->name); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($appointment->treatment?->duration_minutes); ?> min · $<?php echo e(number_format((float) ($appointment->treatment?->cost ?? 0), 2)); ?></p>
                    </td>

                    
                    <td class="px-4 py-3.5">
                        <p class="font-semibold text-slate-900"><?php echo e($appointment->timeLabel()); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($appointment->dateLabel()); ?></p>
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

                    
                    <td class="px-4 py-3.5">
                        <div class="flex flex-wrap items-center gap-1.5">
                            <?php if($appointment->status === AppointmentStatus::Completed): ?>
                                <a href="<?php echo e(route('admin.appointments.receipt', $appointment)); ?>" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-1.5 rounded-md bg-slate-900 px-2.5 py-1 text-xs font-bold text-white shadow-sm transition hover:bg-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Z"/>
                                    </svg>
                                    Print receipt
                                </a>
                            <?php elseif(count($nextActions) > 0): ?>
                                <?php $__currentLoopData = $nextActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <form method="POST" action="<?php echo e(route('admin.appointments.update-status', $appointment)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="status" value="<?php echo e($target); ?>">
                                        <button type="submit"
                                                class="rounded-md px-2.5 py-1 text-xs font-bold text-white shadow-sm transition focus-visible:outline-2 focus-visible:outline-offset-2 <?php echo e($actionMeta[$target]['class']); ?>">
                                            <?php echo e($actionMeta[$target]['label']); ?>

                                        </button>
                                    </form>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-xs text-slate-400">No actions</span>
                            <?php endif; ?>
                        </div>
                    </td>

                    
                    <td class="px-4 py-3.5">
                        <div class="flex flex-col items-start gap-1.5">
                            <?php if (isset($component)) { $__componentOriginal55cac7bd59abc3a9172657d33a6089bd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55cac7bd59abc3a9172657d33a6089bd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.whatsapp-button','data' => ['url' => route('admin.appointments.send-whatsapp', $appointment),'template' => WhatsAppTemplate::Confirmation->value,'label' => 'Send Confirmation']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.whatsapp-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.appointments.send-whatsapp', $appointment)),'template' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(WhatsAppTemplate::Confirmation->value),'label' => 'Send Confirmation']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55cac7bd59abc3a9172657d33a6089bd)): ?>
<?php $attributes = $__attributesOriginal55cac7bd59abc3a9172657d33a6089bd; ?>
<?php unset($__attributesOriginal55cac7bd59abc3a9172657d33a6089bd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55cac7bd59abc3a9172657d33a6089bd)): ?>
<?php $component = $__componentOriginal55cac7bd59abc3a9172657d33a6089bd; ?>
<?php unset($__componentOriginal55cac7bd59abc3a9172657d33a6089bd); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal55cac7bd59abc3a9172657d33a6089bd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55cac7bd59abc3a9172657d33a6089bd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.whatsapp-button','data' => ['url' => route('admin.appointments.send-whatsapp', $appointment),'template' => WhatsAppTemplate::Reminder->value,'label' => 'Send Reminder']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.whatsapp-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.appointments.send-whatsapp', $appointment)),'template' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(WhatsAppTemplate::Reminder->value),'label' => 'Send Reminder']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55cac7bd59abc3a9172657d33a6089bd)): ?>
<?php $attributes = $__attributesOriginal55cac7bd59abc3a9172657d33a6089bd; ?>
<?php unset($__attributesOriginal55cac7bd59abc3a9172657d33a6089bd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55cac7bd59abc3a9172657d33a6089bd)): ?>
<?php $component = $__componentOriginal55cac7bd59abc3a9172657d33a6089bd; ?>
<?php unset($__componentOriginal55cac7bd59abc3a9172657d33a6089bd); ?>
<?php endif; ?>
                            <?php if($appointment->status === AppointmentStatus::Completed): ?>
                                <?php if (isset($component)) { $__componentOriginal55cac7bd59abc3a9172657d33a6089bd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55cac7bd59abc3a9172657d33a6089bd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.whatsapp-button','data' => ['url' => route('admin.appointments.send-whatsapp', $appointment),'template' => WhatsAppTemplate::Review->value,'label' => 'Request Review']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.whatsapp-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.appointments.send-whatsapp', $appointment)),'template' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(WhatsAppTemplate::Review->value),'label' => 'Request Review']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55cac7bd59abc3a9172657d33a6089bd)): ?>
<?php $attributes = $__attributesOriginal55cac7bd59abc3a9172657d33a6089bd; ?>
<?php unset($__attributesOriginal55cac7bd59abc3a9172657d33a6089bd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55cac7bd59abc3a9172657d33a6089bd)): ?>
<?php $component = $__componentOriginal55cac7bd59abc3a9172657d33a6089bd; ?>
<?php unset($__componentOriginal55cac7bd59abc3a9172657d33a6089bd); ?>
<?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </td>

                    
                    <td class="px-4 py-3.5">
                        <details class="group">
                            <summary class="inline-flex cursor-pointer list-none items-center gap-1.5 rounded-md bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-200">
                                <?php echo e($appointment->notes ? 'View notes' : 'Add note'); ?>

                            </summary>
                            <form method="POST" action="<?php echo e(route('admin.appointments.update-notes', $appointment)); ?>" class="mt-2 w-64">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <textarea name="notes" rows="3" placeholder="Doctor / staff remarks…"
                                          class="w-full rounded-lg border border-slate-300 bg-white px-2.5 py-2 text-xs transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20"><?php echo e(old('notes', $appointment->notes)); ?></textarea>
                                <button type="submit"
                                        class="mt-1.5 w-full rounded-md bg-slate-900 py-1.5 text-xs font-bold text-white transition hover:bg-slate-700">
                                    Save
                                </button>
                            </form>
                        </details>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <?php if($search !== '' || $status !== null): ?>
                        <td colspan="8" class="px-4 py-16 text-center">
                            <p class="text-4xl">🔍</p>
                            <p class="mt-3 font-semibold text-slate-900">No appointments match your filters</p>
                            <p class="mt-1 text-sm text-slate-500">Try a different search term, or clear the filters to see the full day.</p>
                            <a href="<?php echo e(route('admin.dashboard', ['date' => $date->toDateString()])); ?>"
                               class="mt-4 inline-flex rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                Clear filters
                            </a>
                        </td>
                    <?php else: ?>
                        <td colspan="8" class="px-4 py-16 text-center">
                            <p class="text-4xl">🦷</p>
                            <p class="mt-3 font-semibold text-slate-900">No appointments for <?php echo e($date->format('l, F j, Y')); ?></p>
                            <p class="mt-1 text-sm text-slate-500">
                                This day is currently empty — it is not a loading or database error.
                                <?php if($upcomingCount > 0): ?>
                                    There <?php echo e($upcomingCount === 1 ? 'is' : 'are'); ?> <?php echo e($upcomingCount); ?> upcoming <?php echo e($upcomingCount === 1 ? 'appointment' : 'appointments'); ?> on other dates.
                                <?php endif; ?>
                            </p>
                            <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                                <a href="<?php echo e(route('admin.dashboard')); ?>"
                                   class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                    Back to today
                                </a>
                                <a href="<?php echo e(route('admin.appointments.index')); ?>"
                                   class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                    View all appointments
                                </a>
                                <?php if($nextAppointmentDate !== null): ?>
                                    <a href="<?php echo e(route('admin.dashboard', ['date' => $nextAppointmentDate->toDateString()])); ?>"
                                       class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                                        Next booking: <?php echo e($nextAppointmentDate->format('D, M j')); ?>

                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('home')); ?>" target="_blank"
                                       class="rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                                        Open booking portal
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <p class="mt-4 text-xs text-slate-500">
        Showing <?php echo e($appointments->count()); ?> appointment(s)
        <?php echo e($status ? ' · status: '.$status->label() : ''); ?>

        <?php echo e($search !== '' ? ' · search: "'.$search.'"' : ''); ?>

    </p>

    <?php endif; ?>

    
    <div id="patient-history-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="patient-history-title">
        <div data-history-backdrop class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="relative flex max-h-[85vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200">
            <header class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-4">
                <div class="min-w-0">
                    <h2 id="patient-history-title" data-history-name class="truncate text-lg font-bold tracking-tight text-slate-900">Patient history</h2>
                    <p data-history-subtitle class="mt-0.5 truncate text-sm text-slate-500">Loading…</p>
                </div>
                <button type="button" data-history-close
                        class="grid size-8 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                    <span class="sr-only">Close</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </header>

            <div data-history-body class="flex-1 overflow-y-auto px-6 py-5">
                <div class="flex items-center justify-center gap-3 py-10 text-sm text-slate-500">
                    <span class="inline-block size-4 animate-spin rounded-full border-2 border-current border-t-transparent"></span>
                    Loading patient history…
                </div>
            </div>
        </div>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>