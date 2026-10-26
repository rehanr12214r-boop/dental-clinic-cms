<x-layouts.public title="Our Blog">

    <x-public.page-hero
        title="Our Blog"
        description="Simple cosmetic dentistry options designed to enhance your everyday smile with natural, confident results."
        :breadcrumb="[['label' => 'Home', 'url' => route('home')], ['label' => 'Blog']]"
    />

    <section class="site-container pb-20 lg:pb-24">
        <div class="grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($posts as $post)
                <x-public.blog-card :post="$post"/>
            @endforeach
        </div>
    </section>

</x-layouts.public>
