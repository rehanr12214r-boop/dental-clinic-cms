<?php

namespace App\Models;

use Database\Factories\TreatmentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Treatment extends Model
{
    /** @use HasFactory<TreatmentFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'duration_minutes',
        'cost',
        'description',
        'whats_included',
        'pre_appointment_instructions',
        'is_active',
        'is_featured',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Generate a URL slug automatically when a treatment is created without
     * one (e.g. from the admin panel).
     */
    protected static function booted(): void
    {
        static::creating(function (Treatment $treatment): void {
            if (blank($treatment->slug)) {
                $treatment->slug = static::uniqueSlug($treatment->name);
            }
        });
    }

    /**
     * Build a unique slug for the given treatment name ("Root Canal" →
     * "root-canal", with a numeric suffix when the slug is already taken).
     */
    public static function uniqueSlug(string $name, ?Treatment $ignore = null): string
    {
        $base = Str::slug($name) ?: 'treatment';
        $slug = $base;
        $suffix = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignore?->exists, fn (Builder $query) => $query->whereKeyNot($ignore->getKey()))
            ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    /**
     * Scope a query to treatments that can currently be booked.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to treatments highlighted on the landing page.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * The "what's included" / "before your visit" rich sections as clean
     * line-per-item arrays, ready for list rendering.
     *
     * @return list<string>
     */
    public function includedItems(): array
    {
        return $this->linesOf($this->whats_included);
    }

    /**
     * @return list<string>
     */
    public function instructionItems(): array
    {
        return $this->linesOf($this->pre_appointment_instructions);
    }

    /**
     * @return list<string>
     */
    protected function linesOf(?string $text): array
    {
        if (blank($text)) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $text))
            ->map(static fn (string $line): string => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * The appointments booked for this treatment.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
