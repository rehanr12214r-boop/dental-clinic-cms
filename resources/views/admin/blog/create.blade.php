<x-layouts.admin
    title="Create Blog Article"
    heading="New article"
    headingSub="Publish a new dental health post to the journal"
>
    @include('admin.blog._form', [
        'post' => $post,
        'action' => route('admin.blog.store'),
        'method' => 'POST',
    ])
</x-layouts.admin>
