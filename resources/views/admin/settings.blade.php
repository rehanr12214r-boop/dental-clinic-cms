<x-layouts.admin
    title="Settings"
    heading="Clinic settings"
    headingSub="Clinic details, Google review link and WhatsApp message templates"
>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-4xl space-y-6">
        @csrf
        @method('PUT')

        {{-- Clinic details --}}
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-base font-bold text-slate-900">Clinic details</h2>
            <p class="mt-1 text-sm text-slate-500">Used across the admin, the booking portal and every WhatsApp message.</p>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="clinic_name" class="mb-1.5 block text-sm font-semibold text-slate-700">Clinic name</label>
                    <input id="clinic_name" type="text" name="clinic_name" required
                           value="{{ old('clinic_name', $settings['clinic_name']) }}"
                           class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    @error('clinic_name')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="doctor_name" class="mb-1.5 block text-sm font-semibold text-slate-700">Doctor name</label>
                    <input id="doctor_name" type="text" name="doctor_name" required
                           value="{{ old('doctor_name', $settings['doctor_name']) }}"
                           placeholder="Dr. Sara Mahmoud"
                           class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    @error('doctor_name')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="clinic_phone" class="mb-1.5 block text-sm font-semibold text-slate-700">Clinic phone</label>
                    <input id="clinic_phone" type="tel" name="clinic_phone" required
                           value="{{ old('clinic_phone', $settings['clinic_phone']) }}"
                           placeholder="+964 770 123 4567"
                           class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    @error('clinic_phone')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="clinic_email" class="mb-1.5 block text-sm font-semibold text-slate-700">Clinic email</label>
                    <input id="clinic_email" type="email" name="clinic_email"
                           value="{{ old('clinic_email', $settings['clinic_email']) }}"
                           placeholder="info@brightsmileclinic.com"
                           class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    @error('clinic_email')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="clinic_address" class="mb-1.5 block text-sm font-semibold text-slate-700">Clinic address</label>
                    <input id="clinic_address" type="text" name="clinic_address" required
                           value="{{ old('clinic_address', $settings['clinic_address']) }}"
                           placeholder="Street, district, city"
                           class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    @error('clinic_address')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stat_happy_patients" class="mb-1.5 block text-sm font-semibold text-slate-700">Happy patients (landing page stat)</label>
                    <input id="stat_happy_patients" type="text" name="stat_happy_patients"
                           value="{{ old('stat_happy_patients', $settings['stat_happy_patients']) }}"
                           placeholder="1200"
                           class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    @error('stat_happy_patients')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stat_years_experience" class="mb-1.5 block text-sm font-semibold text-slate-700">Years of experience (landing page stat)</label>
                    <input id="stat_years_experience" type="text" name="stat_years_experience"
                           value="{{ old('stat_years_experience', $settings['stat_years_experience']) }}"
                           placeholder="12"
                           class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    @error('stat_years_experience')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="hero_title" class="mb-1.5 block text-sm font-semibold text-slate-700">Hero banner headline</label>
                    <input id="hero_title" type="text" name="hero_title"
                           value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                           placeholder="Thoughtful Dental Care for Everyday Smiles."
                           class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                    @error('hero_title')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="hero_subtitle" class="mb-1.5 block text-sm font-semibold text-slate-700">Hero banner sub-headline</label>
                    <textarea id="hero_subtitle" name="hero_subtitle" rows="2"
                              placeholder="Calm, transparent dental care built around your schedule and your comfort..."
                              class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                    @error('hero_subtitle')
                        <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Google review link --}}
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-base font-bold text-slate-900">Google review link</h2>
            <p class="mt-1 text-sm text-slate-500">Included in review requests via the <code class="rounded bg-slate-100 px-1 py-0.5 font-mono text-[11px] text-cyan-700">{review_link}</code> placeholder.</p>

            <div class="mt-5">
                <label for="google_review_link" class="mb-1.5 block text-sm font-semibold text-slate-700">Review URL</label>
                <input id="google_review_link" type="url" name="google_review_link"
                       value="{{ old('google_review_link', $settings['google_review_link']) }}"
                       placeholder="https://g.page/r/your-clinic/review"
                       class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">
                @error('google_review_link')
                    <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </section>

        {{-- WhatsApp templates --}}
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-base font-bold text-slate-900">WhatsApp message templates</h2>
            <p class="mt-1 text-sm text-slate-500">Every template is prefilled per patient when the dashboard WhatsApp buttons are clicked. Leave a template unchanged to keep the clinic default.</p>

            <div class="mt-5 space-y-5">
                @foreach ($templates as $template)
                    <div>
                        <label for="{{ $template->settingKey() }}" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            {{ $template->label() }}
                        </label>
                        <textarea id="{{ $template->settingKey() }}" name="{{ $template->settingKey() }}" rows="4" required
                                  class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-relaxed transition focus:border-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700/20">{{ old($template->settingKey(), $settings[$template->settingKey()]) }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">{{ $template->description() }}</p>
                        @error($template->settingKey())
                            <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            {{-- Placeholder reference --}}
            <div class="mt-6 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Available placeholders</p>
                <div class="mt-3 grid gap-2 sm:grid-cols-2">
                    @foreach ($placeholders as $placeholder => $description)
                        <p class="flex items-baseline gap-2 text-xs text-slate-600">
                            <code class="shrink-0 rounded bg-white px-1.5 py-0.5 font-mono text-[11px] text-cyan-700 ring-1 ring-slate-200">{{ $placeholder }}</code>
                            <span>{{ $description }}</span>
                        </p>
                    @endforeach
                </div>
            </div>
        </section>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="rounded-xl bg-cyan-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-cyan-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-700">
                Save settings
            </button>
            <p class="text-xs text-slate-500">Changes apply to new WhatsApp messages immediately.</p>
        </div>
    </form>

</x-layouts.admin>
