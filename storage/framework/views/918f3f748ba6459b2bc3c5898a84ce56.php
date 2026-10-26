
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['dentist', 'action', 'method' => 'POST']));

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

foreach (array_filter((['dentist', 'action', 'method' => 'POST']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<form method="POST" action="<?php echo e($action); ?>" class="max-w-3xl space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($method !== 'POST'): ?>
        <?php echo method_field($method); ?>
    <?php endif; ?>

    
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Identity</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Full name <span class="text-rose-500">*</span></label>
                <input id="name" type="text" name="name" required
                       value="<?php echo e(old('name', $dentist->name)); ?>"
                       placeholder="Dr. Jane Smith, DMD"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="short_name" class="mb-1.5 block text-sm font-semibold text-slate-700">Display name</label>
                <input id="short_name" type="text" name="short_name"
                       value="<?php echo e(old('short_name', $dentist->short_name)); ?>"
                       placeholder="Dr. Jane Smith"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['short_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="slug" class="mb-1.5 block text-sm font-semibold text-slate-700">URL slug</label>
                <input id="slug" type="text" name="slug"
                       value="<?php echo e(old('slug', $dentist->slug)); ?>"
                       placeholder="dr-jane-smith (auto-generated)"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="role" class="mb-1.5 block text-sm font-semibold text-slate-700">Role / Specialty <span class="text-rose-500">*</span></label>
                <input id="role" type="text" name="role" required
                       value="<?php echo e(old('role', $dentist->role)); ?>"
                       placeholder="Cosmetic Specialist"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="experience" class="mb-1.5 block text-sm font-semibold text-slate-700">Years of experience</label>
                <input id="experience" type="text" name="experience"
                       value="<?php echo e(old('experience', $dentist->experience)); ?>"
                       placeholder="8 years"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="sort_order" class="mb-1.5 block text-sm font-semibold text-slate-700">Sort order</label>
                <input id="sort_order" type="number" name="sort_order" min="0"
                       value="<?php echo e(old('sort_order', $dentist->sort_order ?? 0)); ?>"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </section>

    
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Photo & details</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="image" class="mb-1.5 block text-sm font-semibold text-slate-700">Image filename</label>
                <input id="image" type="text" name="image"
                       value="<?php echo e(old('image', $dentist->image)); ?>"
                       placeholder="team-jane.jpg"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <p class="mt-1 text-xs text-slate-500">Place image in <code class="rounded bg-slate-100 px-1 font-mono text-[11px]">public/images/site/</code></p>
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="focus" class="mb-1.5 block text-sm font-semibold text-slate-700">Clinical focus</label>
                <input id="focus" type="text" name="focus"
                       value="<?php echo e(old('focus', $dentist->focus)); ?>"
                       placeholder="Restorative dentistry and hygiene"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['focus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="education" class="mb-1.5 block text-sm font-semibold text-slate-700">Education</label>
                <input id="education" type="text" name="education"
                       value="<?php echo e(old('education', $dentist->education)); ?>"
                       placeholder="Doctor of Dental Medicine, XYZ University"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['education'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="languages" class="mb-1.5 block text-sm font-semibold text-slate-700">Languages</label>
                <input id="languages" type="text" name="languages"
                       value="<?php echo e(old('languages', $dentist->languages)); ?>"
                       placeholder="English, Spanish"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['languages'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="sm:col-span-2">
                <label for="bio" class="mb-1.5 block text-sm font-semibold text-slate-700">Bio</label>
                <textarea id="bio" name="bio" rows="4"
                          class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20"><?php echo e(old('bio', $dentist->bio)); ?></textarea>
                <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </section>

    
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Visibility</h2>
        <div class="mt-4 flex items-center gap-3">
            <input id="is_active" type="checkbox" name="is_active" value="1"
                   <?php if(old('is_active', $dentist->is_active ?? true)): echo 'checked'; endif; ?>
                   class="size-4 rounded border-slate-300 accent-cyan-700">
            <label for="is_active" class="text-sm font-medium text-slate-700">Show on public website</label>
        </div>
    </section>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="rounded-xl bg-cyan-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            Save dentist
        </button>
        <a href="<?php echo e(route('admin.dentists.index')); ?>" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
            Cancel
        </a>
    </div>
</form>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/admin/dentists/_form.blade.php ENDPATH**/ ?>