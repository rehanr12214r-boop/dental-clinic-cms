<?php
    use App\Models\Setting;

    $clinicPhone = Setting::get(Setting::ClinicPhone);
    $clinicAddress = Setting::get(Setting::ClinicAddress);
?>

<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'Contact Us']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Contact Us']); ?>

    <?php if (isset($component)) { $__componentOriginal7667e390c55120bda1fc27c0189959e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7667e390c55120bda1fc27c0189959e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.page-hero','data' => ['title' => 'Make An Appointment','description' => 'Book your appointment today and take the first step toward a healthier, brighter smile.','breadcrumb' => [['label' => 'Home', 'url' => route('home')], ['label' => 'Make An Appointment']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Make An Appointment','description' => 'Book your appointment today and take the first step toward a healthier, brighter smile.','breadcrumb' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Home', 'url' => route('home')], ['label' => 'Make An Appointment']])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7667e390c55120bda1fc27c0189959e9)): ?>
<?php $attributes = $__attributesOriginal7667e390c55120bda1fc27c0189959e9; ?>
<?php unset($__attributesOriginal7667e390c55120bda1fc27c0189959e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7667e390c55120bda1fc27c0189959e9)): ?>
<?php $component = $__componentOriginal7667e390c55120bda1fc27c0189959e9; ?>
<?php unset($__componentOriginal7667e390c55120bda1fc27c0189959e9); ?>
<?php endif; ?>

    <section class="site-container pb-16">
        <div class="grid overflow-hidden rounded-[12px] lg:grid-cols-[521fr_775fr]">
            <div class="flex min-h-[420px] flex-col justify-between bg-white p-10 lg:min-h-[713px]">
                <h2 class="max-w-md font-display text-[30px] font-semibold leading-[1.2] text-ink sm:text-[36px]">
                    Have any questions?<br>
                    We’re just a form away—<br>
                    send us now.
                </h2>

                <div class="mt-14 flex flex-col gap-4">
                    <a href="mailto:<?php echo e($clinicEmail); ?>" class="font-form text-[18px] font-semibold leading-6 text-ink transition hover:text-terracotta sm:text-[20px]">
                        <?php echo e($clinicEmail); ?>

                    </a>
                    <a href="tel:<?php echo e(preg_replace('/\s+/', '', (string) $clinicPhone)); ?>" class="font-form text-[18px] font-semibold leading-6 text-ink transition hover:text-terracotta sm:text-[20px]">
                        <?php echo e($clinicPhone); ?>

                    </a>
                    <p class="max-w-xs text-[13px] leading-6 text-body"><?php echo e($clinicAddress); ?></p>
                </div>
            </div>

            <div class="bg-terracotta p-10 text-white lg:p-14">
                <h2 class="max-w-xl font-display text-[30px] font-semibold leading-[1.2] sm:text-[36px]">
                    We will be in touch within next 24 hours!
                </h2>

                <form method="POST" action="<?php echo e(route('contact.send')); ?>" class="mt-9">
                    <?php echo csrf_field(); ?>

                    <div class="grid gap-x-8 gap-y-7 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="mb-1 block font-form text-[17px] leading-7 text-white">Full Name&nbsp; *</label>
                            <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" required autocomplete="name"
                                   class="field-input-inverse font-form text-[17px] placeholder:text-white/40">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-[12px] font-medium text-cream"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="email" class="mb-1 block font-form text-[17px] leading-7 text-white">Email&nbsp; *</label>
                            <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autocomplete="email"
                                   class="field-input-inverse font-form text-[17px] placeholder:text-white/40">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-[12px] font-medium text-cream"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="phone" class="mb-1 block font-form text-[17px] leading-7 text-white">Phone Number&nbsp; *</label>
                            <input id="phone" name="phone" type="tel" value="<?php echo e(old('phone')); ?>" required autocomplete="tel"
                                   class="field-input-inverse font-form text-[17px] placeholder:text-white/40">
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-[12px] font-medium text-cream"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="subject" class="mb-1 block font-form text-[17px] leading-7 text-white">Subject&nbsp; *</label>
                            <input id="subject" name="subject" type="text" value="<?php echo e(old('subject')); ?>" required
                                   class="field-input-inverse font-form text-[17px] placeholder:text-white/40">
                            <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-[12px] font-medium text-cream"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="message" class="mb-1 block font-form text-[17px] leading-7 text-white">Message *</label>
                            <textarea id="message" name="message" rows="3" required
                                      class="field-input-inverse resize-none font-form text-[17px] placeholder:text-white/40"><?php echo e(old('message')); ?></textarea>
                            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-[12px] font-medium text-cream"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <button type="submit" class="group mt-8 inline-flex items-center gap-3 rounded-full bg-white py-[7px] pl-6 pr-[7px] text-[16px] font-bold text-ink transition hover:-translate-y-0.5">
                        Submit Message
                        <span class="grid size-11 place-items-center rounded-full bg-terracotta text-white transition group-hover:rotate-[-8deg]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-12 overflow-hidden rounded-[12px] bg-beige">
            <img src="<?php echo e(asset('images/site/contact-hero.jpg')); ?>"
                 alt="The clinic reception and treatment space"
                 class="aspect-[1296/727] w-full object-cover"
                 loading="lazy">
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\contact.blade.php ENDPATH**/ ?>