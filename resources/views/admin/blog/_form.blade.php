@props(['post', 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="max-w-4xl space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    {{-- Main content --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Article Details</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="title" class="mb-1.5 block text-sm font-semibold text-slate-700">Article Title <span class="text-rose-500">*</span></label>
                <input id="title" type="text" name="title" required
                       value="{{ old('title', $post->title) }}"
                       placeholder="e.g. Benefits of Early Orthodontic Checkups for Kids."
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('title') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="mb-1.5 block text-sm font-semibold text-slate-700">URL Slug</label>
                <input id="slug" type="text" name="slug"
                       value="{{ old('slug', $post->slug) }}"
                       placeholder="article-slug (auto-generated if empty)"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('slug') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category" class="mb-1.5 block text-sm font-semibold text-slate-700">Category</label>
                <input id="category" type="text" name="category"
                       value="{{ old('category', $post->category ?? 'General') }}"
                       placeholder="Orthodontics, Dental Implants, Cosmetic..."
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('category') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="excerpt" class="mb-1.5 block text-sm font-semibold text-slate-700">Short Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          placeholder="Brief summary displayed on cards and search results..."
                          class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="content" class="mb-1.5 block text-sm font-semibold text-slate-700">Full Content / Article Body</label>
                <textarea id="content" name="content" rows="8"
                          placeholder="Write the full article content here..."
                          class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">{{ old('content', $post->content) }}</textarea>
                @error('content') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- Author & Media --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Media, Author & Pull Quote</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="image" class="mb-1.5 block text-sm font-semibold text-slate-700">Featured Image filename</label>
                <input id="image" type="text" name="image"
                       value="{{ old('image', $post->image ?? 'blog-1.jpg') }}"
                       placeholder="blog-1.jpg"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <p class="mt-1 text-xs text-slate-500">File located in <code class="rounded bg-slate-100 px-1 font-mono text-[11px]">public/images/site/</code></p>
                @error('image') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="read_time" class="mb-1.5 block text-sm font-semibold text-slate-700">Read Time</label>
                <input id="read_time" type="text" name="read_time"
                       value="{{ old('read_time', $post->read_time ?? '4 min read') }}"
                       placeholder="4 min read"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('read_time') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="author" class="mb-1.5 block text-sm font-semibold text-slate-700">Author Name</label>
                <input id="author" type="text" name="author"
                       value="{{ old('author', $post->author ?? 'The Clinic Team') }}"
                       placeholder="James Anderson"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('author') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="author_role" class="mb-1.5 block text-sm font-semibold text-slate-700">Author Role</label>
                <input id="author_role" type="text" name="author_role"
                       value="{{ old('author_role', $post->author_role ?? 'Story Teller') }}"
                       placeholder="Dentist & Founder"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('author_role') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="quote" class="mb-1.5 block text-sm font-semibold text-slate-700">Pull Quote</label>
                <input id="quote" type="text" name="quote"
                       value="{{ old('quote', $post->quote) }}"
                       placeholder="Key quote highlight..."
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('quote') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="quote_author" class="mb-1.5 block text-sm font-semibold text-slate-700">Quote Attribution</label>
                <input id="quote_author" type="text" name="quote_author"
                       value="{{ old('quote_author', $post->quote_author) }}"
                       placeholder="Dr. Nadal James"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('quote_author') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- Publishing status --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Publishing Status</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="status" class="mb-1.5 block text-sm font-semibold text-slate-700">Status <span class="text-rose-500">*</span></label>
                <select id="status" name="status" required
                        class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    <option value="published" @selected(old('status', $post->status ?? 'published') === 'published')>Published (visible on website)</option>
                    <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft (hidden from public)</option>
                </select>
                @error('status') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="published_at" class="mb-1.5 block text-sm font-semibold text-slate-700">Publish Date</label>
                <input id="published_at" type="date" name="published_at"
                       value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('published_at') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="rounded-xl bg-cyan-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            Save article
        </button>
        <a href="{{ route('admin.blog.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
            Cancel
        </a>
    </div>
</form>
