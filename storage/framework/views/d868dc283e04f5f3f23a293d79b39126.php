<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['post', 'action', 'method' => 'POST']));

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

foreach (array_filter((['post', 'action', 'method' => 'POST']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<form method="POST" action="<?php echo e($action); ?>" class="max-w-4xl space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($method !== 'POST'): ?>
        <?php echo method_field($method); ?>
    <?php endif; ?>

    
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Article Details</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="title" class="mb-1.5 block text-sm font-semibold text-slate-700">Article Title <span class="text-rose-500">*</span></label>
                <input id="title" type="text" name="title" required
                       value="<?php echo e(old('title', $post->title)); ?>"
                       placeholder="e.g. Benefits of Early Orthodontic Checkups for Kids."
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="slug" class="mb-1.5 block text-sm font-semibold text-slate-700">URL Slug</label>
                <input id="slug" type="text" name="slug"
                       value="<?php echo e(old('slug', $post->slug)); ?>"
                       placeholder="article-slug (auto-generated if empty)"
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
                <label for="category" class="mb-1.5 block text-sm font-semibold text-slate-700">Category</label>
                <input id="category" type="text" name="category"
                       value="<?php echo e(old('category', $post->category ?? 'General')); ?>"
                       placeholder="Orthodontics, Dental Implants, Cosmetic..."
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="sm:col-span-2">
                <label for="excerpt" class="mb-1.5 block text-sm font-semibold text-slate-700">Short Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          placeholder="Brief summary displayed on cards and search results..."
                          class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20"><?php echo e(old('excerpt', $post->excerpt)); ?></textarea>
                <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="sm:col-span-2">
                <label for="content" class="mb-1.5 block text-sm font-semibold text-slate-700">Full Content / Article Body</label>
                <textarea id="content" name="content" rows="8"
                          placeholder="Write the full article content here..."
                          class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20"><?php echo e(old('content', $post->content)); ?></textarea>
                <?php $__errorArgs = ['content'];
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
        <h2 class="text-base font-bold text-slate-900">Media, Author & Pull Quote</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="image" class="mb-1.5 block text-sm font-semibold text-slate-700">Featured Image filename</label>
                <input id="image" type="text" name="image"
                       value="<?php echo e(old('image', $post->image ?? 'blog-1.jpg')); ?>"
                       placeholder="blog-1.jpg"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <p class="mt-1 text-xs text-slate-500">File located in <code class="rounded bg-slate-100 px-1 font-mono text-[11px]">public/images/site/</code></p>
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
                <label for="read_time" class="mb-1.5 block text-sm font-semibold text-slate-700">Read Time</label>
                <input id="read_time" type="text" name="read_time"
                       value="<?php echo e(old('read_time', $post->read_time ?? '4 min read')); ?>"
                       placeholder="4 min read"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['read_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="author" class="mb-1.5 block text-sm font-semibold text-slate-700">Author Name</label>
                <input id="author" type="text" name="author"
                       value="<?php echo e(old('author', $post->author ?? 'The Clinic Team')); ?>"
                       placeholder="James Anderson"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['author'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="author_role" class="mb-1.5 block text-sm font-semibold text-slate-700">Author Role</label>
                <input id="author_role" type="text" name="author_role"
                       value="<?php echo e(old('author_role', $post->author_role ?? 'Story Teller')); ?>"
                       placeholder="Dentist & Founder"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['author_role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="quote" class="mb-1.5 block text-sm font-semibold text-slate-700">Pull Quote</label>
                <input id="quote" type="text" name="quote"
                       value="<?php echo e(old('quote', $post->quote)); ?>"
                       placeholder="Key quote highlight..."
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['quote'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="quote_author" class="mb-1.5 block text-sm font-semibold text-slate-700">Quote Attribution</label>
                <input id="quote_author" type="text" name="quote_author"
                       value="<?php echo e(old('quote_author', $post->quote_author)); ?>"
                       placeholder="Dr. Nadal James"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['quote_author'];
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
        <h2 class="text-base font-bold text-slate-900">Publishing Status</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="status" class="mb-1.5 block text-sm font-semibold text-slate-700">Status <span class="text-rose-500">*</span></label>
                <select id="status" name="status" required
                        class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    <option value="published" <?php if(old('status', $post->status ?? 'published') === 'published'): echo 'selected'; endif; ?>>Published (visible on website)</option>
                    <option value="draft" <?php if(old('status', $post->status) === 'draft'): echo 'selected'; endif; ?>>Draft (hidden from public)</option>
                </select>
                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-medium text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="published_at" class="mb-1.5 block text-sm font-semibold text-slate-700">Publish Date</label>
                <input id="published_at" type="date" name="published_at"
                       value="<?php echo e(old('published_at', $post->published_at ? $post->published_at->format('Y-m-d') : now()->format('Y-m-d'))); ?>"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <?php $__errorArgs = ['published_at'];
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

    <div class="flex items-center gap-3">
        <button type="submit"
                class="rounded-xl bg-cyan-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            Save article
        </button>
        <a href="<?php echo e(route('admin.blog.index')); ?>" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
            Cancel
        </a>
    </div>
</form>
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/admin/blog/_form.blade.php ENDPATH**/ ?>