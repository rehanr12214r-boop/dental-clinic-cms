<x-layouts.public :title="$treatment->name">

    @php
        $included = $treatment->includedItems();
        $instructions = $treatment->instructionItems();

        $images = [
            'teeth-cleaning' => 'service-whitening.jpg',
            'root-canal' => 'service-root-canal.jpg',
            'general-checkup' => 'benefits-smile.jpg',
            'tooth-extraction' => 'service-fillings.jpg',
            'braces-consultation' => 'service-orthodontics.jpg',
        ];

        $image = $images[$treatment->slug] ?? 'benefits-smile.jpg';
        $clinicName = \App\Models\Setting::get(\App\Models\Setting::ClinicName);
    @endphp

    <x-public.page-hero
        :title="$treatment->name"
        :description="$treatment->description"
        :breadcrumb="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Services', 'url' => route('treatments.index')],
            ['label' => $treatment->name],
        ]"
    />

    <section class="site-container pb-16">
        <div class="overflow-hidden rounded-[12px] bg-beige">
            <img src="{{ asset('images/site/'.$image) }}"
                 alt="{{ $treatment->name }}"
                 class="aspect-[1296/548] w-full object-cover"
                 loading="eager">
        </div>
    </section>

    <section class="site-container pb-20 lg:pb-24">
        <div class="mx-auto max-w-[770px]">
            <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-[14px] text-body">
                <span>{{ $treatment->duration_minutes }} minute visit</span>
                <span class="size-1 rounded-full bg-line" aria-hidden="true"></span>
                <span class="font-semibold text-ink">${{ number_format((float) $treatment->cost, 2) }}</span>
            </div>

            <article class="article-copy mt-12">
                <h2>What’s Included in This Service:</h2>

                @if ($included !== [])
                    <ul>
                        @foreach ($included as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Your appointment includes a full assessment, a clear explanation of the findings and a personalised treatment plan.</p>
                @endif

                <h2>Why This Treatment Matters</h2>
                <p>
                    Looking after this part of your oral health helps prevent discomfort, protects the teeth around it and keeps your smile functioning comfortably day to day. We focus on the cause as well as the symptom, so the result lasts.
                </p>

                <h2>Who It’s For</h2>
                <ul>
                    <li>Adults looking for preventive, restorative or cosmetic care</li>
                    <li>Patients experiencing discomfort, sensitivity or a change in their bite</li>
                    <li>Families who want a consistent, long-term dental home</li>
                </ul>

                <h2>Our Approach</h2>
                <p>
                    At {{ $clinicName }}, we use modern diagnostics and a gentle, education-first approach. We explain every option, answer your questions and agree on a plan that fits your health, timeline and budget — no pressure, no surprises.
                </p>

                @if ($instructions !== [])
                    <h2>Before Your Appointment</h2>
                    <ul>
                        @foreach ($instructions as $instruction)
                            <li>{{ $instruction }}</li>
                        @endforeach
                    </ul>
                @endif

                <h2>Book Your Appointment Today</h2>
                <p>Don’t wait for a small problem to become a bigger one. Reserve a time that works for you and let our team take care of the rest.</p>

                <div class="mt-10">
                    <a href="{{ route('book') }}" class="group inline-flex items-center gap-3.5 rounded-full bg-white py-1.5 pl-7 pr-1.5 text-[17px] font-bold text-ink shadow-[0_6px_25px_rgba(60,61,66,0.06)] transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_12px_35px_rgba(60,61,66,0.1)]">
                        Book this treatment
                        <span class="grid size-11 place-items-center rounded-full bg-terracotta text-white transition duration-200 group-hover:rotate-[-8deg]" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5 19.5 4.5m0 0h-7.5m7.5 0v7.5"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </article>
        </div>
    </section>

    @if ($relatedTreatments->isNotEmpty())
        <section class="site-container pb-20 lg:pb-24">
            <div class="border-t border-line/80 pt-12">
                <h2 class="font-display text-[30px] font-semibold leading-[1.2] text-ink sm:text-[36px]">Other treatments you may need</h2>

                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedTreatments as $related)
                        <a href="{{ route('treatments.show', ['treatment' => $related->slug]) }}"
                           class="group overflow-hidden rounded-[12px] bg-white">
                            <div class="aspect-[416/226] overflow-hidden bg-beige">
                                <img src="{{ asset('images/site/'.($images[$related->slug] ?? 'benefits-smile.jpg')) }}"
                                     alt="{{ $related->name }}"
                                     class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                                     loading="lazy">
                            </div>
                            <div class="p-6">
                                <h3 class="font-display text-[22px] font-bold leading-[1.2] text-ink transition group-hover:text-terracotta">{{ $related->name }}</h3>
                                <p class="mt-2 text-[13px] text-body">{{ $related->duration_minutes }} min visit · ${{ number_format((float) $related->cost, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-public.appointment-cta/>

</x-layouts.public>
