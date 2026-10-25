<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'title',
        'category',
        'image',
        'excerpt',
        'content',
        'sections',
        'quote',
        'quote_author',
        'author',
        'author_role',
        'author_image',
        'read_time',
        'published_at',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sections' => 'array',
            'published_at' => 'date',
        ];
    }

    /**
     * Auto-generate a unique slug before creating.
     */
    protected static function booted(): void
    {
        static::creating(function (BlogPost $post): void {
            if (blank($post->slug)) {
                $base = Str::slug($post->title) ?: 'post';
                $slug = $base;
                $i = 2;
                while (static::query()->where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $post->slug = $slug;
            }
        });
    }

    /**
     * Scope to published posts only.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * Convert to the array shape that ClinicContentService returns.
     *
     * @return array<string, mixed>
     */
    public function toContentArray(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category,
            'image' => $this->image,
            'excerpt' => (string) $this->excerpt,
            'date' => $this->published_at
                ? $this->published_at->format('d F Y')
                : now()->format('d F Y'),
            'read_time' => $this->read_time,
            'author' => $this->author,
            'author_role' => $this->author_role,
            'author_image' => $this->author_image,
            'sections' => $this->sections ?? [],
            'quote' => (string) $this->quote,
            'quote_author' => (string) $this->quote_author,
        ];
    }
}
