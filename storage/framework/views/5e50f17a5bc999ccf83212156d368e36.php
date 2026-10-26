<?php if (isset($component)) { $__componentOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0e86a062c1c5bb6d0e151b7076f3fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.public','data' => ['title' => 'Choose a new password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Choose a new password']); ?>

    <?php if (isset($component)) { $__componentOriginal6464ddb76fea98b5baa13f1f3586b0d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6464ddb76fea98b5baa13f1f3586b0d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.auth-shell','data' => ['compact' => true,'title' => 'Choose a new password','eyebrow' => 'Almost there','subtitle' => 'Use at least 8 characters with a letter, a number and a symbol.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.auth-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['compact' => true,'title' => 'Choose a new password','eyebrow' => 'Almost there','subtitle' => 'Use at least 8 characters with a letter, a number and a symbol.']); ?>
        <form method="POST" action="<?php echo e(route('patient.password.store')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="token" value="<?php echo e($token); ?>"/>

            <div>
                <label for="email" class="field-label">Email address</label>
                <input id="email" type="email" name="email" required autocomplete="email"
                       value="<?php echo e(old('email', $email)); ?>"
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
                <label for="password" class="field-label">New password</label>
                <input id="password" type="password" name="password" required autofocus autocomplete="new-password"
                       placeholder="At least 8 characters"
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
                <label for="password_confirmation" class="field-label">Confirm new password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="Repeat your new password"
                       class="field-input"/>
            </div>

            <button type="submit" class="btn-medio w-full justify-center">
                Save new password
                <span class="btn-medio-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                    </svg>
                </span>
            </button>
        </form>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/patient/auth/reset-password.blade.php ENDPATH**/ ?>