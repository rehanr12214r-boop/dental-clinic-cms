<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => null]));

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

foreach (array_filter((['title' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    use App\Models\DoctorSchedule;
    use App\Models\Setting;
    use Carbon\CarbonImmutable;
    use Illuminate\Support\Str;

    $clinicName = Setting::get(Setting::ClinicName);
    $clinicAddress = Setting::get(Setting::ClinicAddress);
    $clinicPhone = Setting::get(Setting::ClinicPhone);
    $clinicEmail = Setting::get(Setting::ClinicEmail);
    $doctorName = Setting::get(Setting::DoctorName);

    $brandName = Str::of($clinicName)->before(' ')->trim()->toString() ?: $clinicName;
    $wordmarkCharacters = max(6, Str::length($brandName) + 1);

    $patientUser = auth('patient')->user();

    $desktopLinks = [
        ['label' => 'Home', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'About Us', 'href' => route('about'), 'active' => request()->routeIs('about')],
        ['label' => 'Services', 'href' => route('treatments.index'), 'active' => request()->routeIs('treatments.*', 'services.*')],
    ];

    $pagesActive = request()->routeIs('book', 'appointments.*', 'appointment.lookup', 'dentists.*', 'patient.*');

    $mobileLinks = [
        ['label' => 'Home', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'About Us', 'href' => route('about'), 'active' => request()->routeIs('about')],
        ['label' => 'Services', 'href' => route('treatments.index'), 'active' => request()->routeIs('treatments.*', 'services.*')],
        ['label' => 'Dentists', 'href' => route('dentists.index'), 'active' => request()->routeIs('dentists.*')],
        ['label' => 'Blog', 'href' => route('blog.index'), 'active' => request()->routeIs('blog.*')],
        ['label' => 'Contact Us', 'href' => route('contact'), 'active' => request()->routeIs('contact')],
        ['label' => 'Book online', 'href' => route('book'), 'active' => request()->routeIs('book', 'appointments.*')],
        ['label' => 'Track appointment', 'href' => route('appointment.lookup'), 'active' => request()->routeIs('appointment.lookup')],
    ];

    // Compact working-hours line for the footer.
    $openDays = DoctorSchedule::query()
        ->where('is_day_off', false)
        ->orderBy('day_of_week')
        ->get();

    $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $footerHours = null;

    if ($openDays->isNotEmpty() && $openDays->unique('start_time')->count() === 1 && $openDays->unique('end_time')->count() === 1) {
        $footerHours = $dayNames[(int) $openDays->first()->day_of_week]
            .' – '.$dayNames[(int) $openDays->last()->day_of_week]
            .' · '.CarbonImmutable::parse($openDays->first()->start_time)->format('g:i A')
            .' – '.CarbonImmutable::parse($openDays->last()->end_time)->format('g:i A');
    }
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ? $title.' · '.$clinicName : $clinicName.' — Dental care you can trust'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600&family=Inter+Tight:wght@400;500;600;700&family=Libre+Caslon+Text:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="flex min-h-full flex-col bg-cream font-sans text-ink antialiased">

    
    <header class="sticky top-0 z-50 border-b border-line/70 bg-cream/92 backdrop-blur-xl">
        <div class="mx-auto flex h-24 w-full max-w-[1376px] items-center justify-between gap-4 px-5 sm:px-8">
            <a href="<?php echo e(route('home')); ?>" class="shrink-0" aria-label="<?php echo e($clinicName); ?> home">
                <span class="font-sans text-[26px] font-bold leading-none tracking-[-0.07em] text-ink sm:text-[28px]">
                    <?php echo e($brandName); ?><span class="text-ink">.</span>
                </span>
            </a>

            <nav class="hidden items-center gap-8 lg:flex" aria-label="Main">
                <?php $__currentLoopData = $desktopLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($link['href']); ?>"
                       <?php if($link['active']): ?> aria-current="page" <?php endif; ?>
                       class="site-header-link">
                        <?php echo e($link['label']); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <details class="relative" data-site-menu>
                    <summary class="<?php echo \Illuminate\Support\Arr::toCssClasses(['site-header-link cursor-pointer list-none marker:hidden [&::-webkit-details-marker]:hidden', 'is-active' => $pagesActive]); ?>">
                        Pages
                    </summary>
                    <div class="absolute left-1/2 top-full z-50 mt-5 w-60 -translate-x-1/2 rounded-[14px] border border-line bg-cream p-2 shadow-[0_20px_55px_rgba(60,61,66,0.12)]">
                        <a href="<?php echo e(route('book')); ?>" class="site-menu-link">Book online</a>
                        <a href="<?php echo e(route('appointment.lookup')); ?>" class="site-menu-link">Track appointment</a>
                        <a href="<?php echo e(route('dentists.index')); ?>" class="site-menu-link">Dentists</a>
                        <a href="<?php echo e($patientUser ? route('patient.dashboard') : route('patient.login')); ?>" class="site-menu-link">
                            <?php echo e($patientUser ? 'My dashboard' : 'Patient portal'); ?>

                        </a>
                    </div>
                </details>

                <a href="<?php echo e(route('blog.index')); ?>"
                   <?php if(request()->routeIs('blog.*')): ?> aria-current="page" <?php endif; ?>
                   class="site-header-link">
                    Blog
                </a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('contact')); ?>" class="btn-header-pill hidden sm:inline-flex">
                    Contact Us
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </a>

                <button type="button" data-site-nav-toggle aria-expanded="false" aria-label="Open menu"
                        class="grid size-10 place-items-center rounded-full border border-ink/15 bg-transparent text-ink transition hover:bg-beige lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5M3.75 16.5h16.5"/>
                    </svg>
                </button>
            </div>
        </div>

        
        <div data-site-nav class="hidden border-t border-line/70 bg-cream lg:hidden">
            <nav class="site-container space-y-1 py-5" aria-label="Mobile">
                <?php $__currentLoopData = $mobileLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($link['href']); ?>"
                       <?php if($link['active']): ?> aria-current="page" <?php endif; ?>
                       class="block border-b border-line/60 py-3 font-display text-2xl tracking-[-0.03em] <?php echo e($link['active'] ? 'text-terracotta' : 'text-ink'); ?>">
                        <?php echo e($link['label']); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="mt-4 flex flex-col gap-2.5">
                    <?php if($patientUser): ?>
                        <a href="<?php echo e(route('patient.dashboard')); ?>" class="btn-outline w-full">My dashboard</a>
                        <form method="POST" action="<?php echo e(route('patient.logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-outline w-full">Sign out</button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('patient.login')); ?>" class="btn-outline w-full">Patient portal</a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('contact')); ?>" class="btn-solid w-full">Contact Us</a>
                </div>
            </nav>
        </div>
    </header>

    
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

    <main class="flex-1">
        <?php echo e($slot); ?>

    </main>

    
    <footer class="mt-20 border-t border-line bg-cream">
        <div class="mx-auto w-full max-w-[1376px] px-5 pt-16 sm:px-8 lg:pt-20">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-[16px] leading-[1.4] text-ink">( Main Pages )</p>
                    <ul class="mt-8 space-y-[13px] text-[16px] leading-[1.11]">
                        <li><a href="<?php echo e(route('home')); ?>" class="footer-link">Home</a></li>
                        <li><a href="<?php echo e(route('about')); ?>" class="footer-link">About</a></li>
                        <li><a href="<?php echo e(route('treatments.index')); ?>" class="footer-link">Services</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="footer-link">Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-[16px] leading-[1.4] text-ink">( Company )</p>
                    <ul class="mt-8 space-y-[13px] text-[16px] leading-[1.11]">
                        <li><a href="<?php echo e(route('treatments.index')); ?>" class="footer-link">Service Single</a></li>
                        <li><a href="<?php echo e(route('blog.index')); ?>" class="footer-link">Blog</a></li>
                        <li><a href="<?php echo e(route('blog.index')); ?>" class="footer-link">Blog Single</a></li>
                        <li><a href="<?php echo e(route('book')); ?>" class="footer-link">Book an Appointment</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-[16px] leading-[1.4] text-ink">( Contact )</p>
                    <ul class="mt-8 space-y-[13px] text-[16px] leading-[1.11]">
                        <li><a href="mailto:<?php echo e($clinicEmail); ?>" class="footer-link"><?php echo e($clinicEmail); ?></a></li>
                        <li><a href="tel:<?php echo e(preg_replace('/\s+/', '', (string) $clinicPhone)); ?>" class="footer-link"><?php echo e($clinicPhone); ?></a></li>
                        <li>
                            <a href="https://maps.google.com/?q=<?php echo e(urlencode((string) $clinicAddress)); ?>" target="_blank" rel="noopener" class="footer-link">
                                <?php echo e($clinicAddress); ?>

                            </a>
                        </li>
                    </ul>
                    <?php if($footerHours): ?>
                        <p class="mt-4 text-[13px] leading-[1.5] text-body"><?php echo e($footerHours); ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <p class="text-[16px] leading-[1.4] text-ink">( Socials )</p>
                    <ul class="mt-8 space-y-[13px] text-[16px] leading-[1.11]">
                        <li><a href="https://www.facebook.com/" target="_blank" rel="noopener" class="footer-link">Facebook</a></li>
                        <li><a href="https://twitter.com/" target="_blank" rel="noopener" class="footer-link">Twitter</a></li>
                        <li><a href="https://www.instagram.com/" target="_blank" rel="noopener" class="footer-link">Instagram</a></li>
                        <li><a href="https://www.linkedin.com/" target="_blank" rel="noopener" class="footer-link">Linkedin</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-16 overflow-hidden" aria-hidden="true">
                <p class="whitespace-nowrap font-sans font-bold leading-[1.2] tracking-[-0.09em] text-ink"
                   style="font-size: clamp(4.5rem, <?php echo e(number_format(160 / $wordmarkCharacters, 3, '.', '')); ?>vw, 26.75rem);">
                    <?php echo e($brandName); ?>.
                </p>
            </div>

            <div class="flex flex-col gap-2 border-t border-line py-6 text-[15px] leading-7 text-ink sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; <?php echo e(now()->year); ?> Copyright — <?php echo e($clinicName); ?></p>
                <p>All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\layouts\public.blade.php ENDPATH**/ ?>