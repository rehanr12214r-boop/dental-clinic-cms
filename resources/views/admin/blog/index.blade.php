<x-layouts.admin
    title="Blog Posts"
    heading="Blog / Articles management"
    headingSub="Articles published on the public journal"
>
    <x-slot name="actions">
        <a href="{{ route('admin.blog.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New article
        </a>
    </x-slot>

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
            @forelse ($posts as $post)
                <tr class="transition hover:bg-slate-50/70">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/site/'.$post->image) }}"
                                 alt="{{ $post->title }}"
                                 class="size-10 rounded-lg object-cover">
                            <div class="max-w-md">
                                <p class="font-semibold text-slate-900 truncate">{{ $post->title }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ $post->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">
                        <span class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700">
                            {{ $post->category }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-slate-600">{{ $post->author }}</td>
                    <td class="px-4 py-3.5 text-slate-600">
                        {{ $post->published_at ? $post->published_at->format('M j, Y') : '—' }}
                    </td>

                    <td class="px-4 py-3.5">
                        <span @class([
                            'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold',
                            'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' => $post->status === 'published',
                            'bg-slate-100 text-slate-600 ring-1 ring-slate-500/20' => $post->status === 'draft',
                        ])>
                            {{ ucfirst($post->status) }}
                        </span>
                    </td>

                    <td class="px-4 py-3.5">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.blog.edit', $post) }}"
                               class="text-xs font-bold text-cyan-700 underline-offset-2 transition hover:underline">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.blog.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Delete article &quot;{{ addslashes($post->title) }}&quot;?')"
                                        class="text-xs font-bold text-rose-600 underline-offset-2 transition hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-16 text-center">
                        <p class="text-4xl">📝</p>
                        <p class="mt-3 font-semibold text-slate-900">No blog posts yet</p>
                        <p class="mt-1 text-sm text-slate-500">Publish your first article on the dental health journal.</p>
                        <a href="{{ route('admin.blog.create') }}"
                           class="mt-4 inline-flex rounded-xl bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600">
                            Create first article
                        </a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.admin>
