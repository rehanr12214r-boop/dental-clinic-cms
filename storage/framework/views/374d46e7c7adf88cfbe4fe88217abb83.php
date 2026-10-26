<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Blog Posts','heading' => 'Blog / Articles management','headingSub' => 'Articles published on the public journal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Blog Posts','heading' => 'Blog / Articles management','headingSub' => 'Articles published on the public journal']); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.blog.create')); ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New article
        </a>
     <?php $__env->endSlot(); ?>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="w-full min-w-[52rem] text-left text-sm">
            <thead>
            <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                <th class="px-4 py-3 font-semibold">Article</th>
                <th class="px-4 py-3 font-semibold">Category</th>
                <th class="px-4 py-3 font-semibold">Author</th>
                <th class="px-4 py-3 font-semibold">Date</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 text-right font-semibold">Actions</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="transition hover:bg-slate-50/70">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="<?php echo e(asset('images/site/'.$post->image)); ?>"
                                 alt="<?php echo e($post->title); ?>"
                                 class="size-10 rounded-lg object-cover">
                            <div class="max-w-md">
                                <p class="font-semibold text-slate-900 truncate"><?php echo e($post->title); ?></p>
                                <p class="text-xs text-slate-400 truncate"><?php echo e($post->slug); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">
                        <span class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700">
                            <?php echo e($post->category); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600"><?php echo e($post->author); ?></td>
                    <td class="px-4 py-3.5 text-slate-600">
                        <?php echo e($post->published_at ? $post->published_at->format('M j, Y') : '—'); ?>

                    </td>

                    <td class="px-4 py-3.5">
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold',
                            'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' => $post->status === 'published',
                            'bg-slate-100 text-slate-600 ring-1 ring-slate-500/20' => $post->status === 'draft',
                        ]); ?>">
                            <?php echo e(ucfirst($post->status)); ?>

                        </span>
                    </td>

                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-end gap-3">
                            <a href="<?php echo e(route('admin.blog.edit', $post)); ?>"
                               class="text-xs font-bold text-cyan-700 underline-offset-2 transition hover:underline">
                                Edit
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.blog.destroy', $post)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        onclick="return confirm('Delete article &quot;<?php echo e(addslashes($post->title)); ?>&quot;?')"
                                        class="text-xs font-bold text-rose-600 underline-offset-2 transition hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-4 py-16 text-center">
                        <p class="text-4xl">📝</p>
                        <p class="mt-3 font-semibold text-slate-900">No blog posts yet</p>
                        <p class="mt-1 text-sm text-slate-500">Publish your first article on the dental health journal.</p>
                        <a href="<?php echo e(route('admin.blog.create')); ?>"
                           class="mt-4 inline-flex rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                            Create first article
                        </a>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
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
<?php /**PATH C:\Users\pc\OneDrive\Desktop\Dentist Appointment System\DentalAppointmentSystem\resources\views/admin/blog/index.blade.php ENDPATH**/ ?>