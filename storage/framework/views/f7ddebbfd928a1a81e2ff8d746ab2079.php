<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'Create a patient account']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Create a patient account']); ?>

    <?php if (isset($component)) { $__componentOriginal6464ddb76fea98b5baa13f1f3586b0d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6464ddb76fea98b5baa13f1f3586b0d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.auth-shell','data' => ['title' => 'Create your patient account','eyebrow' => 'Join the portal','subtitle' => 'Track upcoming visits, view treatment history, download receipts and manage bookings — all in one place. Signing up is free and takes a minute.','image' => 'benefits-smile.jpg','quote' => 'A calmer way to stay on top of your care.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.auth-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Create your patient account','eyebrow' => 'Join the portal','subtitle' => 'Track upcoming visits, view treatment history, download receipts and manage bookings — all in one place. Signing up is free and takes a minute.','image' => 'benefits-smile.jpg','quote' => 'A calmer way to stay on top of your care.']); ?>
        <form method="POST" action="<?php echo e(route('patient.register.store')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <div>
                <label for="name" class="field-label">Full name</label>
                <input id="name" type="text" name="name" required autofocus autocomplete="name"
                       value="<?php echo e(old('name')); ?>"
                       placeholder="e.g. Saima Ali"
                       class="field-input"/>
                <?php $__errorArgs = ['name'];
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

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="email" class="field-label">Email address</label>
                    <input id="email" type="email" name="email" required autocomplete="email"
                           value="<?php echo e(old('email')); ?>"
                           placeholder="you@example.com"
                           class="field-input"/>
                    <?php $__errorArgs = ['email'];
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
                    <input id="phone" type="tel" name="phone" required autocomplete="tel" inputmode="tel"
                           value="<?php echo e(old('phone')); ?>"
                           placeholder="+964 770 123 4567"
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
            </div>

            <div class="sm:max-w-[10rem]">
                <label for="age" class="field-label">Age <span class="normal-case tracking-normal text-muted">(optional)</span></label>
                <input id="age" type="number" name="age" min="1" max="120" inputmode="numeric"
                       value="<?php echo e(old('age')); ?>"
                       placeholder="e.g. 32"
                       class="field-input"/>
                <?php $__errorArgs = ['age'];
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

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="field-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           placeholder="8+ chars, number &amp; symbol"
                           class="field-input"/>
                    <?php $__errorArgs = ['password'];
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
                    <label for="password_confirmation" class="field-label">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           placeholder="Repeat your password"
                           class="field-input"/>
                </div>
            </div>

            <button type="submit" class="btn-medio w-full justify-center">
                Create my account
                <span class="btn-medio-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </span>
            </button>
        </form>

         <?php $__env->slot('footer', null, []); ?> 
            Already have an account?
            <a href="<?php echo e(route('patient.login')); ?>" class="font-semibold text-terracotta underline-offset-2 hover:underline">Sign in</a>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('note', null, []); ?> 
            Already booked as a guest? Use the same WhatsApp number when signing up and your previous
            visits are linked to your account automatically.
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6464ddb76fea98b5baa13f1f3586b0d8)): ?>
<?php $attributes = $__attributesOriginal6464ddb76fea98b5baa13f1f3586b0d8; ?>
<?php unset($__attributesOriginal6464ddb76fea98b5baa13f1f3586b0d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6464ddb76fea98b5baa13f1f3586b0d8)): ?>
<?php $component = $__componentOriginal6464ddb76fea98b5baa13f1f3586b0d8; ?>
<?php unset($__componentOriginal6464ddb76fea98b5baa13f1f3586b0d8); ?>
<?php endif; ?>

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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/patient/auth/register.blade.php ENDPATH**/ ?>