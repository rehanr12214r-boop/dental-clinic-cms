<?php

namespace App\Models;

use App\Notifications\PatientResetPassword;
use Database\Factories\PatientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    /** @use HasFactory<PatientFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'password' => 'hashed',
        ];
    }

    /**
     * Send the portal-specific password reset email.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new PatientResetPassword($token));
    }

    /**
     * Appointments linked to this patient account.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Attach previously guest-booked appointments that used the same phone
     * number (digit-by-digit) so patients see their full history after
     * signing up. Safe to call repeatedly — unlinked rows are simply adopted.
     */
    public function claimGuestAppointments(): int
    {
        $digits = $this->phoneDigits();

        if (strlen($digits) < 7) {
            return 0;
        }

        $ids = Appointment::query()
            ->whereNull('patient_id')
            ->pluck('patient_phone', 'id')
            ->filter(fn (string $phone): bool => self::digitsOf($phone) === $digits)
            ->keys()
            ->all();

        if ($ids === []) {
            return 0;
        }

        return Appointment::query()->whereIn('id', $ids)->update(['patient_id' => $this->id]);
    }

    /**
     * The patient's phone number as digits only (for safe comparison).
     */
    public function phoneDigits(): string
    {
        return self::digitsOf((string) $this->phone);
    }

    /**
     * Normalize an arbitrary phone number to digits only.
     */
    protected static function digitsOf(?string $phone): string
    {
        return preg_replace('/\D+/', '', (string) $phone) ?? '';
    }
}
