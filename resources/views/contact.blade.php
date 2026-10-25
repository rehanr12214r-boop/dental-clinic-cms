@php
    use App\Models\Setting;

    $clinicPhone = Setting::get(Setting::ClinicPhone);
    $clinicAddress = Setting::get(Setting::ClinicAddress);
@endphp

<x-layouts.public title="Contact Us">

    <x-public.page-hero
        title="Make An Appointment"
        description="Book your appointment today and take the first step toward a healthier, brighter smile."
        :breadcrumb="[['label' => 'Home', 'url' => route('home')], ['label' => 'Make An Appointment']]"
    />

    <section class="site-container pb-16">
        <div class="grid overflow-hidden rounded-[12px] lg:grid-cols-[521fr_775fr]">
            <div class="flex min-h-[420px] flex-col justify-between bg-white p-10 lg:min-h-[713px]">
                <h2 class="max-w-md font-display text-[30px] font-semibold leading-[1.2] text-ink sm:text-[36px]">
                    Have any questions?<br>
                    We’re just a form away—<br>
                    send us now.
                </h2>

                <div class="mt-14 flex flex-col gap-4">
                    <a href="mailto:{{ $clinicEmail }}" class="font-form text-[18px] font-semibold leading-6 text-ink transition hover:text-terracotta sm:text-[20px]">
                        {{ $clinicEmail }}
                    </a>
                    <a href="tel:{{ preg_replace('/\s+/', '', (string) $clinicPhone) }}" class="font-form text-[18px] font-semibold leading-6 text-ink transition hover:text-terracotta sm:text-[20px]">
                        {{ $clinicPhone }}
                    </a>
                    <p class="max-w-xs text-[13px] leading-6 text-body">{{ $clinicAddress }}</p>
                </div>
            </div>

            <div class="bg-terracotta p-10 text-white lg:p-14">
                <h2 class="max-w-xl font-display text-[30px] font-semibold leading-[1.2] sm:text-[36px]">
                    We will be in touch within next 24 hours!
                </h2>

                <form method="POST" action="{{ route('contact.send') }}" class="mt-9">
                    @csrf

                    <div class="grid gap-x-8 gap-y-7 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="mb-1 block font-form text-[17px] leading-7 text-white">Full Name&nbsp; *</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name"
                                   class="field-input-inverse font-form text-[17px] placeholder:text-white/40">
                            @error('name')
                                <p class="mt-1 text-[12px] font-medium text-cream">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-1 block font-form text-[17px] leading-7 text-white">Email&nbsp; *</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                                   class="field-input-inverse font-form text-[17px] placeholder:text-white/40">
                            @error('email')
                                <p class="mt-1 text-[12px] font-medium text-cream">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="mb-1 block font-form text-[17px] leading-7 text-white">Phone Number&nbsp; *</label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required autocomplete="tel"
                                   class="field-input-inverse font-form text-[17px] placeholder:text-white/40">
                            @error('phone')
                                <p class="mt-1 text-[12px] font-medium text-cream">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="subject" class="mb-1 block font-form text-[17px] leading-7 text-white">Subject&nbsp; *</label>
                            <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required
                                   class="field-input-inverse font-form text-[17px] placeholder:text-white/40">
                            @error('subject')
                                <p class="mt-1 text-[12px] font-medium text-cream">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="message" class="mb-1 block font-form text-[17px] leading-7 text-white">Message *</label>
                            <textarea id="message" name="message" rows="3" required
                                      class="field-input-inverse resize-none font-form text-[17px] placeholder:text-white/40">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-[12px] font-medium text-cream">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="group mt-8 inline-flex items-center gap-3 rounded-full bg-white py-[7px] pl-6 pr-[7px] text-[16px] font-bold text-ink transition hover:-translate-y-0.5">
                        Submit Message
                        <span class="grid size-11 place-items-center rounded-full bg-terracotta text-white transition group-hover:rotate-[-8deg]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-12 overflow-hidden rounded-[12px] bg-beige">
            <img src="{{ asset('images/site/contact-hero.jpg') }}"
                 alt="The clinic reception and treatment space"
                 class="aspect-[1296/727] w-full object-cover"
                 loading="lazy">
        </div>
    </section>

</x-layouts.public>
