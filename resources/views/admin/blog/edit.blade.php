<x-layouts.admin
    title="Edit Blog Article"
    heading="Edit article"
    headingSub="Update &quot;{{ $post->title }}&quot;"
>
    @include('admin.blog._form', [
        'post' => $post,
        'action' => route('admin.blog.update', $post),
        'method' => 'PUT',
    ])
</x-layouts.admin>
