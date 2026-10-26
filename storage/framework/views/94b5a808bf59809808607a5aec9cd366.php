<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => 'Dashboard', 'heading' => $title, 'headingSub' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title' => 'Dashboard', 'heading' => $title, 'headingSub' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    use App\Models\Setting;

    $clinicName = Setting::get(Setting::ClinicName);
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title); ?> · BrightSmile Clinic Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-full bg-slate-100 font-sans text-slate-900 antialiased">

<div id="admin-shell" class="min-h-full">
    
    <aside id="admin-sidebar" data-admin-sidebar
           class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-white/5 bg-slate-900 text-slate-200 transition-transform duration-200 lg:translate-x-0">
        <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
            <span class="grid size-10 place-items-center rounded-xl bg-linear-to-br from-sky-600 to-teal-500 text-xl shadow ring-1 ring-white/15">🦷</span>
            <div class="leading-tight">
                <p class="truncate text-sm font-bold tracking-tight text-white"><?php echo e($clinicName); ?></p>
                <p class="text-xs text-slate-400">Clinic Admin</p>
            </div>
        </div>

        <nav class="mt-6 flex-1 space-y-1 px-3">
            <p class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Manage</p>

            <?php if (isset($component)) { $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.nav-link','data' => ['href' => route('admin.dashboard'),'label' => 'Dashboard','active' => request()->routeIs('admin.dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.dashboard')),'label' => 'Dashboard','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.dashboard'))]); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $attributes = $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $component = $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.nav-link','data' => ['href' => route('admin.appointments.index'),'label' => 'All Appointments','active' => request()->routeIs('admin.appointments.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.appointments.index')),'label' => 'All Appointments','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.appointments.index'))]); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z"/>
                </svg>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $attributes = $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $component = $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.nav-link','data' => ['href' => route('admin.schedule.index'),'label' => 'Doctor Schedule','active' => request()->routeIs('admin.schedule.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.schedule.index')),'label' => 'Doctor Schedule','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.schedule.*'))]); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $attributes = $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $component = $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.nav-link','data' => ['href' => route('admin.treatments.index'),'label' => 'Treatments','active' => request()->routeIs('admin.treatments.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.treatments.index')),'label' => 'Treatments','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.treatments.*'))]); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
                </svg>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $attributes = $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $component = $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.nav-link','data' => ['href' => route('admin.reports.index'),'label' => 'Reports & Analytics','active' => request()->routeIs('admin.reports.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.reports.index')),'label' => 'Reports & Analytics','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.reports.*'))]); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                </svg>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $attributes = $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $component = $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.nav-link','data' => ['href' => route('admin.settings.index'),'label' => 'Settings','active' => request()->routeIs('admin.settings.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.settings.index')),'label' => 'Settings','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.settings.*'))]); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $attributes = $__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__attributesOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9)): ?>
<?php $component = $__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9; ?>
<?php unset($__componentOriginal2a216ff9e9eb80e1c598e0a42b5b7ec9); ?>
<?php endif; ?>
        </nav>

        <div class="border-t border-white/10 p-4">
            
            <div class="rounded-xl bg-white/5 p-3">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Today</p>
                <p class="mt-0.5 text-sm font-semibold text-white"><?php echo e(now()->format('l, F j, Y')); ?></p>
                <p class="mt-0.5 text-xs text-slate-400"><?php echo e(now()->format('g:i A · d/m/Y')); ?></p>
            </div>

            
            <div class="mt-4 flex items-center gap-3">
                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-sky-600/90 text-sm font-bold text-white uppercase">
                    <?php echo e(mb_substr(auth()->user()?->name ?? 'A', 0, 2)); ?>

                </span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-white"><?php echo e(auth()->user()?->name); ?></p>
                    <p class="truncate text-xs text-slate-400"><?php echo e(auth()->user()?->email); ?></p>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-4">
                <?php echo csrf_field(); ?>
                <button type="submit"
                        class="w-full rounded-lg bg-white/10 py-2 text-sm font-semibold text-slate-200 transition hover:bg-rose-500/80 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-400">
                    Sign out
                </button>
            </form>
        </div>
    </aside>

    
    <div data-admin-backdrop class="fixed inset-0 z-30 bg-slate-900/60 lg:hidden" hidden></div>

    <div class="lg:pl-64">
        
        <header class="sticky top-0 z-20 flex h-14 items-center justify-between gap-3 border-b border-slate-200 bg-white/90 px-4 backdrop-blur lg:hidden">
            <button type="button" data-admin-sidebar-toggle
                    class="grid size-10 place-items-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-cyan-600">
                <span class="sr-only">Open menu</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
            <span class="text-sm font-bold tracking-tight"><?php echo e($clinicName); ?></span>
            <span class="text-xs font-medium text-slate-500"><?php echo e(now()->format('M j, Y')); ?></span>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-10">
            <?php if (isset($component)) { $__componentOriginalddb84e6737e16df2461928a0d75a21ae = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalddb84e6737e16df2461928a0d75a21ae = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.flash-toasts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flash-toasts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalddb84e6737e16df2461928a0d75a21ae)): ?>
<?php $attributes = $__attributesOriginalddb84e6737e16df2461928a0d75a21ae; ?>
<?php unset($__attributesOriginalddb84e6737e16df2461928a0d75a21ae); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalddb84e6737e16df2461928a0d75a21ae)): ?>
<?php $component = $__componentOriginalddb84e6737e16df2461928a0d75a21ae; ?>
<?php unset($__componentOriginalddb84e6737e16df2461928a0d75a21ae); ?>
<?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-6 rounded-xl bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 ring-1 ring-rose-600/20" role="alert">
                    <ul class="list-inside list-disc space-y-0.5">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <header class="mb-8 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight"><?php echo e($heading); ?></h1>
                    <?php if($headingSub): ?>
                        <p class="mt-1 text-sm text-slate-500"><?php echo e($headingSub); ?></p>
                    <?php endif; ?>
                </div>
                <?php if(isset($actions)): ?>
                    <div class="flex items-center gap-3"><?php echo e($actions); ?></div>
                <?php endif; ?>
            </header>

            <?php echo e($slot); ?>

        </main>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\layouts\admin.blade.php ENDPATH**/ ?>