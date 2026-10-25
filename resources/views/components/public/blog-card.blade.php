@props(['post'])

<article class="group">
    <a href="{{ route('blog.show', ['slug' => $post['slug']]) }}" class="block">
        <div class="aspect-[306/205] overflow-hidden rounded-[12px] bg-beige">
            <img src="{{ asset('images/site/'.$post['image']) }}"
                 alt="{{ $post['title'] }}"
                 class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                 loading="lazy">
        </div>

        <p class="mt-5 text-[16px] leading-[1.21] text-body">{{ $post['category'] }}</p>
        <h2 class="mt-2 font-display text-[20px] font-medium leading-[1.2] text-ink transition group-hover:text-terracotta">
            {{ $post['title'] }}
        </h2>
    </a>
</article>
