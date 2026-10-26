<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Dentist;
use App\Services\ClinicContentService;
use Illuminate\Database\Seeder;

class CmsContentSeeder extends Seeder
{
    /**
     * Seed dentists and blog posts from the static ClinicContentService data.
     * Skips rows that already exist (idempotent — safe to run multiple times).
     */
    public function run(): void
    {
        $content = new ClinicContentService;

        // ── Dentists ────────────────────────────────────────────────────────
        foreach ($content->dentists() as $index => $data) {
            Dentist::query()->firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'short_name' => $data['short_name'],
                    'role' => $data['role'],
                    'experience' => $data['experience'],
                    'image' => $data['image'],
                    'focus' => $data['focus'],
                    'bio' => $data['bio'],
                    'education' => $data['education'],
                    'languages' => $data['languages'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }

        // ── Blog posts ───────────────────────────────────────────────────────
        foreach ($content->posts() as $data) {
            BlogPost::query()->firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'category' => $data['category'],
                    'image' => $data['image'],
                    'excerpt' => $data['excerpt'],
                    'sections' => $data['sections'],
                    'quote' => $data['quote'],
                    'quote_author' => $data['quote_author'],
                    'author' => $data['author'],
                    'author_role' => $data['author_role'],
                    'author_image' => $data['author_image'],
                    'read_time' => $data['read_time'],
                    'published_at' => now()->subDays(rand(1, 120))->toDateString(),
                    'status' => 'published',
                ]
            );
        }
    }
}
