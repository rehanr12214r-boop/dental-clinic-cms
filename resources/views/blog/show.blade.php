<x-layouts.public :title="$post['title']">

    <x-public.page-hero
        :title="$post['title']"
        :description="$post['excerpt']"
        :breadcrumb="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Blog', 'url' => route('blog.index')],
            ['label' => $post['title']],
        ]"
    />

    <section class="site-container pb-16">
        <div class="overflow-hidden rounded-[12px] bg-beige">
            <img src="{{ asset('images/site/'.$post['image']) }}"
                 alt="{{ $post['title'] }}"
                 class="aspect-[1296/601] w-full object-cover"
                 loading="eager">
        </div>
    </section>

    <section class="site-container pb-20 lg:pb-24">
        <div class="grid gap-12 lg:grid-cols-[220px_minmax(0,770px)] lg:justify-between lg:gap-10">
            <aside class="lg:pt-2">
                <div class="flex items-center gap-3">
                    <div class="size-[52px] shrink-0 overflow-hidden rounded-full bg-beige">
                        <img src="{{ asset('images/site/'.$post['author_image']) }}"
                             alt="{{ $post['author'] }}"
                             class="h-full w-full object-cover"
                             loading="lazy">
                    </div>
                    <div>
                        <p class="text-[18px] font-medium leading-[1.4] text-ink">{{ $post['author'] }}</p>
                        <p class="text-[16px] leading-[1.4] text-body">{{ $post['author_role'] }}</p>
                    </div>
                </div>

                <div class="mt-9 border-t border-line/70 pt-6">
                    <p class="text-[16px] leading-[1.4] text-body">
                        Category :
                        <span class="text-ink">{{ $post['category'] }}</span>
                    </p>
                    <p class="mt-2 text-[13px] leading-[1.5] text-body">{{ $post['date'] }} · {{ $post['read_time'] }}</p>
                </div>
            </aside>

            <article class="article-copy max-w-[770px] lg:ml-auto">
                @foreach ($post['sections'] as $section)
                    <h2>{{ $section['heading'] }}</h2>

                    @foreach ($section['body'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach

                    @if ($loop->first)
                        <div class="my-10 grid gap-5 sm:grid-cols-2">
                            <div class="aspect-square overflow-hidden rounded-[4px] bg-beige">
                                <img src="{{ asset('images/site/blog-5.jpg') }}"
                                     alt="A dentist explaining a treatment plan"
                                     class="h-full w-full object-cover"
                                     loading="lazy">
                            </div>
                            <div class="aspect-square overflow-hidden rounded-[4px] bg-beige">
                                <img src="{{ asset('images/site/blog-6.jpg') }}"
                                     alt="A patient smiling after cosmetic treatment"
                                     class="h-full w-full object-cover"
                                     loading="lazy">
                            </div>
                        </div>
                    @endif

                    @if ($loop->index === 1)
                        <blockquote class="my-10 rounded-[12px] bg-white px-8 py-9 sm:px-10 sm:py-11">
                            <p class="font-display text-[22px] font-bold leading-[1.2] text-ink sm:text-[24px]">
                                “{{ $post['quote'] }}”
                            </p>
                            <footer class="mt-5 text-[14px] leading-[1.2] text-body">{{ $post['quote_author'] }}</footer>
                        </blockquote>
                    @endif
                @endforeach
            </article>
        </div>
    </section>

    <x-public.appointment-cta/>

</x-layouts.public>
