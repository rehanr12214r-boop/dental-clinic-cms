<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Carbon\CarbonImmutable;
use Database\Factories\AppointmentFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    /** @use HasFactory<AppointmentFactory> */
    use HasFactory;

    /**
     * Patients may cancel or reschedule online until this many hours before
     * the appointment start time.
     */
    public const CANCELLATION_CUTOFF_HOURS = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'patient_id',
        'patient_name',
        'patient_phone',
        'patient_age',
        'treatment_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'appointment_date' => 'date:Y-m-d',
            'appointment_time' => 'datetime:H:i',
            'status' => AppointmentStatus::class,
        ];
    }

    /**
     * The patient account linked to this appointment, when it was booked
     * while signed in (guest bookings may be claimed later by phone number).
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * The treatment this appointment is booked for.
     */
    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

    /**
     * Public booking reference shown to patients, e.g. "APT-00042".
     */
    public function getReferenceAttribute(): string
    {
        return 'APT-'.str_pad((string) $this->getKey(), 5, '0', STR_PAD_LEFT);
    }

    /**
     * The exact moment the appointment starts (date + time in app timezone).
     */
    public function startsAt(): CarbonImmutable
    {
        $time = $this->appointment_time;

        return CarbonImmutable::parse(
            $this->appointment_date->toDateString().' '.($time instanceof DateTimeInterface ? $time->format('H:i') : $time),
        );
    }

    /**
     * Whether the appointment can still be cancelled or rescheduled online:
     * pending/confirmed appointments that start more than the cutoff window
     * (4 hours) from now.
     */
    public function isCancellable(): bool
    {
        return $this->isActiveStatus()
            && $this->startsAt()->greaterThan(CarbonImmutable::now()->addHours(self::CANCELLATION_CUTOFF_HOURS));
    }

    /**
     * Rescheduling follows the same cutoff as cancelling.
     */
    public function isReschedulable(): bool
    {
        return $this->isCancellable();
    }

    /**
     * Whether the appointment is still ahead of us (pending, confirmed or
     * in the chair today) — used to split the patient dashboard lists.
     */
    public function isUpcoming(): bool
    {
        return $this->isActiveStatus()
            && $this->startsAt()->greaterThanOrEqualTo(CarbonImmutable::now());
    }

    /**
     * The appointment occupies a slot in the doctor's calendar.
     */
    protected function isActiveStatus(): bool
    {
        return in_array($this->status, [AppointmentStatus::Pending, AppointmentStatus::Confirmed, AppointmentStatus::InClinic], true);
    }

    /**
     * Scope a query to appointments that still hold their time slot
     * (i.e. everything except cancelled ones).
     */
    public function scopeNotCancelled(Builder $query): Builder
    {
        return $query->where('status', '!=', AppointmentStatus::Cancelled->value);
    }

    /**
     * Formatted time label for tables/cards, e.g. "5:30 PM".
     */
    public function timeLabel(string $format = 'g:i A'): string
    {
        return CarbonImmutable::parse($this->appointment_time)->format($format);
    }

    /**
     * Formatted date label for tables/cards, e.g. "Oct 19, 2026".
     */
    public function dateLabel(string $format = 'M j, Y'): string
    {
        return CarbonImmutable::parse($this->appointment_date)->format($format);
    }

    /**
     * Click-to-WhatsApp link for the stored patient phone number.
     * wa.me requires digits only; the optional message is URL-encoded.
     */
    public function whatsappUrl(?string $message = null): string
    {
        $phone = preg_replace('/\D+/', '', (string) $this->patient_phone);

        $url = 'https://wa.me/'.$phone;

        if ($message !== null && $message !== '') {
            $url .= '?'.http_build_query(['text' => $message]);
        }

        return $url;
    }
}
