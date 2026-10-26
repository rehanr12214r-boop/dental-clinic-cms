<?php
    $isUpdate = $treatment->exists;
    $formAction = $isUpdate ? route('admin.treatments.update', $treatment) : route('admin.treatments.store');
?>

<form method="POST" action="<?php echo e($formAction); ?>"
      class="mx-auto max-w-3xl space-y-5 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
    <?php echo csrf_field(); ?>
    <?php if($isUpdate): ?>
        <?php echo method_field('PATCH'); ?>
    <?php endif; ?>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Treatment name</label>
            <input id="name" type="text" name="name" required value="<?php echo e(old('name', $treatment->name)); ?>"
                   placeholder="e.g. Teeth Whitening"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
        </div>

        <div>
            <label for="slug" class="mb-1.5 block text-sm font-semibold text-slate-700">URL slug</label>
            <input id="slug" type="text" name="slug" value="<?php echo e(old('slug', $treatment->slug)); ?>"
                   placeholder="auto-generated from the name"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
            <p class="mt-1 text-xs text-slate-500">Public page: /treatments/<span class="font-mono"><?php echo e($treatment->slug ?: 'your-slug'); ?></span></p>
        </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="duration_minutes" class="mb-1.5 block text-sm font-semibold text-slate-700">Duration (minutes)</label>
            <input id="duration_minutes" type="number" name="duration_minutes" required min="5" max="480" step="5"
                   value="<?php echo e(old('duration_minutes', $treatment->duration_minutes ?? 30)); ?>"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
            <p class="mt-1 text-xs text-slate-500">Must fit inside the doctor's daily working hours.</p>
        </div>

        <div>
            <label for="cost" class="mb-1.5 block text-sm font-semibold text-slate-700">Fee ($)</label>
            <input id="cost" type="number" name="cost" required min="0" max="999999" step="0.01"
                   value="<?php echo e(old('cost', $treatment->cost ?? '')); ?>"
                   class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
            <p class="mt-1 text-xs text-slate-500">Charged to the patient; feeds the "Revenue" stat.</p>
        </div>
    </div>

    <div>
        <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Description</label>
        <textarea id="description" name="description" rows="3"
                  placeholder="Short, patient-friendly summary shown on the website."
                  class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20"><?php echo e(old('description', $treatment->description)); ?></textarea>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="whats_included" class="mb-1.5 block text-sm font-semibold text-slate-700">What's included</label>
            <textarea id="whats_included" name="whats_included" rows="4"
                      placeholder="One item per line"
                      class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20"><?php echo e(old('whats_included', $treatment->whats_included)); ?></textarea>
            <p class="mt-1 text-xs text-slate-500">One bullet per line.</p>
        </div>

        <div>
            <label for="pre_appointment_instructions" class="mb-1.5 block text-sm font-semibold text-slate-700">Pre-appointment instructions</label>
            <textarea id="pre_appointment_instructions" name="pre_appointment_instructions" rows="4"
                      placeholder="One instruction per line"
                      class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20"><?php echo e(old('pre_appointment_instructions', $treatment->pre_appointment_instructions)); ?></textarea>
            <p class="mt-1 text-xs text-slate-500">One instruction per line.</p>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
            <label class="flex items-center justify-between gap-3">
                <span>
                    <span class="block text-sm font-semibold text-slate-700">Available for booking</span>
                    <span class="mt-0.5 block text-xs text-slate-500">Inactive treatments are hidden from the public site; existing appointments are kept.</span>
                </span>
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                       <?php if(old('is_active', $treatment->is_active ?? true)): echo 'checked'; endif; ?>
                       class="size-5 rounded border-slate-300 text-cyan-700 focus:ring-cyan-700/30">
            </label>
        </div>

        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
            <label class="flex items-center justify-between gap-3">
                <span>
                    <span class="block text-sm font-semibold text-slate-700">Featured on the home page</span>
                    <span class="mt-0.5 block text-xs text-slate-500">Featured treatments appear in the landing page grid.</span>
                </span>
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1"
                       <?php if(old('is_featured', $treatment->is_featured ?? false)): echo 'checked'; endif; ?>
                       class="size-5 rounded border-slate-300 text-cyan-700 focus:ring-cyan-700/30">
            </label>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="rounded-xl bg-cyan-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            <?php echo e($isUpdate ? 'Save changes' : 'Create treatment'); ?>

        </button>
        <a href="<?php echo e(route('admin.treatments.index')); ?>"
           class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
            Cancel
        </a>
    </div>
</form>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views\admin\treatments\_form.blade.php ENDPATH**/ ?>