<?php
    $toasts = [];

    if (session('status')) {
        $toasts[] = ['tone' => 'success', 'message' => session('status')];
    }

    if (session('success')) {
        $toasts[] = ['tone' => 'success', 'message' => session('success')];
    }

    if (session('error')) {
        $toasts[] = ['tone' => 'error', 'message' => session('error')];
    }
?>

<div id="flash-toasts"
     class="pointer-events-none fixed right-4 top-24 z-[100] flex w-full max-w-sm flex-col gap-2"
     aria-live="polite"
     aria-atomic="false">
    <?php $__currentLoopData = $toasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div data-flash-toast
             role="<?php echo e($toast['tone'] === 'error' ? 'alert' : 'status'); ?>"
             class="pointer-events-auto flex items-start gap-3 rounded-2xl border px-4 py-3.5 text-sm font-medium shadow-[0_18px_50px_rgba(60,61,66,0.14)] backdrop-blur transition duration-200 <?php echo e($toast['tone'] === 'error' ? 'border-[#e8b9aa] bg-[#fdf0eb] text-[#8f3e29]' : 'border-line bg-cream/95 text-ink'); ?>">
            <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full <?php echo e($toast['tone'] === 'error' ? 'bg-[#c2714d] text-white' : 'bg-ink text-cream'); ?>">
                <?php if($toast['tone'] === 'error'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
                    </svg>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/>
                    </svg>
                <?php endif; ?>
            </span>

            <p class="min-w-0 flex-1 leading-5"><?php echo e($toast['message']); ?></p>

            <button type="button" data-flash-dismiss
                    class="-mr-1 shrink-0 rounded-full p-1 opacity-50 transition hover:bg-ink/5 hover:opacity-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-current"
                    aria-label="Dismiss notification">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5" aria-hidden="true">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
                </svg>
            </button>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\components\flash-toasts.blade.php ENDPATH**/ ?>