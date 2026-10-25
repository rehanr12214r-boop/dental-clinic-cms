<x-layouts.public title="Expert Doctors">

    <x-public.page-hero
        title="Expert Doctors"
        description="Our expert doctors deliver skilled, compassionate care to ensure the best outcomes for every smile."
        :breadcrumb="[['label' => 'Home', 'url' => route('home')], ['label' => 'Doctors']]"
    />

    <section class="site-container pb-20 lg:pb-24">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 stagger-cards">
            @foreach ($dentists as $dentist)
                <div class="stagger-card">
                    <x-public.dentist-card :dentist="$dentist"/>
                </div>
            @endforeach
        </div>
    </section>

    <x-public.appointment-cta/>

</x-layouts.public>
