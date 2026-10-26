<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    /**
     * List all blog posts.
     */
    public function index(): View
    {
        $posts = BlogPost::query()->orderByDesc('published_at')->orderByDesc('id')->get();

        return view('admin.blog.index', ['posts' => $posts]);
    }

    /**
     * Show the "new post" form.
     */
    public function create(): View
    {
        return view('admin.blog.create', [
            'post' => new BlogPost(['status' => 'published']),
        ]);
    }

    /**
     * Store a new blog post.
     */
    public function store(Request $request): RedirectResponse
    {
        BlogPost::query()->create($this->validatePost($request));

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog post created.');
    }

    /**
     * Show the "edit post" form.
     */
    public function edit(BlogPost $blogPost): View
    {
        return view('admin.blog.edit', ['post' => $blogPost]);
    }

    /**
     * Update an existing post.
     */
    public function update(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $blogPost->update($this->validatePost($request, $blogPost));

        return redirect()
            ->route('admin.blog.index')
            ->with('status', "Post \"{$blogPost->title}\" updated.");
    }

    /**
     * Delete a blog post.
     */
    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        $title = $blogPost->title;
        $blogPost->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('status', "Post \"{$title}\" deleted.");
    }

    /**
     * Shared validation for store/update.
     *
     * @return array<string, mixed>
     */
    protected function validatePost(Request $request, ?BlogPost $post = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable', 'string', 'max:255',
                $post?->exists
                    ? Rule::unique('blog_posts', 'slug')->ignore($post)
                    : Rule::unique('blog_posts', 'slug'),
            ],
            'category' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'quote' => ['nullable', 'string', 'max:500'],
            'quote_author' => ['nullable', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'author_role' => ['nullable', 'string', 'max:255'],
            'author_image' => ['nullable', 'string', 'max:255'],
            'read_time' => ['nullable', 'string', 'max:50'],
            'published_at' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);

        // Auto-generate slug from title when not provided.
        if (blank($validated['slug'] ?? null)) {
            $base = Str::slug($validated['title']) ?: 'post';
            $slug = $base;
            $i = 2;
            while (BlogPost::query()
                ->where('slug', $slug)
                ->when($post?->exists, fn ($q) => $q->whereKeyNot($post->getKey()))
                ->exists()
            ) {
                $slug = $base.'-'.$i++;
            }
            $validated['slug'] = $slug;
        }

        return $validated;
    }
}
