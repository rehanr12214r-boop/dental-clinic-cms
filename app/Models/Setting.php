<?php

namespace App\Models;

use App\Enums\WhatsAppTemplate;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public const ClinicName = 'clinic_name';

    public const ClinicAddress = 'clinic_address';

    public const ClinicPhone = 'clinic_phone';

    public const ClinicEmail = 'clinic_email';

    public const DoctorName = 'doctor_name';

    public const ReviewLink = 'google_review_link';

    public const StatHappyPatients = 'stat_happy_patients';

    public const StatYearsExperience = 'stat_years_experience';

    public const HeroTitle = 'hero_title';

    public const HeroSubtitle = 'hero_subtitle';

    /**
     * @var list<string>
     */
    protected $fillable = ['key', 'value'];

    /**
     * Default values used until the admin saves their own via the
     * settings page.
     *
     * @return array<string, string>
     */
    public static function defaults(): array
    {
        $defaults = [
            self::ClinicName => 'BrightSmile Dental Clinic',
            self::ClinicAddress => '123 Main Street, City Center',
            self::ClinicPhone => '+964 770 123 4567',
            self::ClinicEmail => 'info@brightsmileclinic.com',
            self::DoctorName => 'Dr. Sara Mahmoud',
            self::ReviewLink => 'https://g.page/r/your-clinic/review',
            self::StatHappyPatients => '1200',
            self::StatYearsExperience => '12',
            self::HeroTitle => 'Thoughtful Dental Care for Everyday Smiles.',
            self::HeroSubtitle => 'Calm, transparent dental care built around your schedule and your comfort. Book in a few taps and receive every reminder directly on WhatsApp.',
        ];

        foreach (WhatsAppTemplate::cases() as $template) {
            $defaults[$template->settingKey()] = $template->defaultTemplate();
        }

        return $defaults;
    }

    /**
     * All stored settings keyed by their name (overrides only).
     *
     * @return array<string, string|null>
     */
    public static function allKeyed(): array
    {
        return static::query()->pluck('value', 'key')->all();
    }

    /**
     * Stored value for a key, falling back to the built-in default.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        return static::query()->where('key', $key)->value('value')
            ?? static::defaults()[$key]
            ?? $default;
    }

    /**
     * Store (or overwrite) a setting value.
     */
    public static function put(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
