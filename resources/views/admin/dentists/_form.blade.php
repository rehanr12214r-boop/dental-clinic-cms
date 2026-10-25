{{-- Reusable form partial for create/edit dentist --}}
@props(['dentist', 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="max-w-3xl space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    {{-- Identity --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Identity</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Full name <span class="text-rose-500">*</span></label>
                <input id="name" type="text" name="name" required
                       value="{{ old('name', $dentist->name) }}"
                       placeholder="Dr. Jane Smith, DMD"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('name') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="short_name" class="mb-1.5 block text-sm font-semibold text-slate-700">Display name</label>
                <input id="short_name" type="text" name="short_name"
                       value="{{ old('short_name', $dentist->short_name) }}"
                       placeholder="Dr. Jane Smith"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('short_name') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="mb-1.5 block text-sm font-semibold text-slate-700">URL slug</label>
                <input id="slug" type="text" name="slug"
                       value="{{ old('slug', $dentist->slug) }}"
                       placeholder="dr-jane-smith (auto-generated)"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('slug') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="role" class="mb-1.5 block text-sm font-semibold text-slate-700">Role / Specialty <span class="text-rose-500">*</span></label>
                <input id="role" type="text" name="role" required
                       value="{{ old('role', $dentist->role) }}"
                       placeholder="Cosmetic Specialist"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('role') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="experience" class="mb-1.5 block text-sm font-semibold text-slate-700">Years of experience</label>
                <input id="experience" type="text" name="experience"
                       value="{{ old('experience', $dentist->experience) }}"
                       placeholder="8 years"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('experience') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="sort_order" class="mb-1.5 block text-sm font-semibold text-slate-700">Sort order</label>
                <input id="sort_order" type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $dentist->sort_order ?? 0) }}"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('sort_order') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- Photo & details --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Photo & details</h2>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="image" class="mb-1.5 block text-sm font-semibold text-slate-700">Image filename</label>
                <input id="image" type="text" name="image"
                       value="{{ old('image', $dentist->image) }}"
                       placeholder="team-jane.jpg"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                <p class="mt-1 text-xs text-slate-500">Place image in <code class="rounded bg-slate-100 px-1 font-mono text-[11px]">public/images/site/</code></p>
                @error('image') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="focus" class="mb-1.5 block text-sm font-semibold text-slate-700">Clinical focus</label>
                <input id="focus" type="text" name="focus"
                       value="{{ old('focus', $dentist->focus) }}"
                       placeholder="Restorative dentistry and hygiene"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('focus') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="education" class="mb-1.5 block text-sm font-semibold text-slate-700">Education</label>
                <input id="education" type="text" name="education"
                       value="{{ old('education', $dentist->education) }}"
                       placeholder="Doctor of Dental Medicine, XYZ University"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('education') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="languages" class="mb-1.5 block text-sm font-semibold text-slate-700">Languages</label>
                <input id="languages" type="text" name="languages"
                       value="{{ old('languages', $dentist->languages) }}"
                       placeholder="English, Spanish"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('languages') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="bio" class="mb-1.5 block text-sm font-semibold text-slate-700">Bio</label>
                <textarea id="bio" name="bio" rows="4"
                          class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">{{ old('bio', $dentist->bio) }}</textarea>
                @error('bio') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- Visibility --}}
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-base font-bold text-slate-900">Visibility</h2>
        <div class="mt-4 flex items-center gap-3">
            <input id="is_active" type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $dentist->is_active ?? true))
                   class="size-4 rounded border-slate-300 accent-cyan-700">
            <label for="is_active" class="text-sm font-medium text-slate-700">Show on public website</label>
        </div>
    </section>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="rounded-xl bg-cyan-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
            Save dentist
        </button>
        <a href="{{ route('admin.dentists.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
            Cancel
        </a>
    </div>
</form>
