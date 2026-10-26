<?php

namespace App\Http\Controllers;

use App\Services\ClinicContentService;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private readonly ClinicContentService $content) {}

    /**
     * The public journal index.
     */
    public function index(): View
    {
        return view('blog.index', [
            'posts' => $this->content->posts(),
        ]);
    }

    /**
     * A single journal article.
     */
    public function show(string $slug): View
    {
        $post = $this->content->post($slug);

        abort_if($post === null, 404);

        return view('blog.show', [
            'post' => $post,
        ]);
    }
}
