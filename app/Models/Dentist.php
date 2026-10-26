<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dentist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'name',
        'short_name',
        'role',
        'experience',
        'image',
        'focus',
        'bio',
        'education',
        'languages',
        'sort_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Auto-generate a slug before creating when none is provided.
     */
    protected static function booted(): void
    {
        static::creating(function (Dentist $dentist): void {
            if (blank($dentist->slug)) {
                $base = Str::slug($dentist->name) ?: 'dentist';
                $slug = $base;
                $i = 2;
                while (static::query()->where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $dentist->slug = $slug;
            }
        });
    }

    /**
     * Scope a query to active dentists only.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Convert a Dentist model to the array shape that ClinicContentService returns.
     *
     * @return array{slug: string, name: string, short_name: string, role: string, experience: string, image: string, focus: string, bio: string, education: string, languages: string}
     */
    public function toContentArray(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'short_name' => $this->short_name,
            'role' => $this->role,
            'experience' => $this->experience,
            'image' => $this->image,
            'focus' => (string) $this->focus,
            'bio' => (string) $this->bio,
            'education' => (string) $this->education,
            'languages' => (string) $this->languages,
        ];
    }
}
