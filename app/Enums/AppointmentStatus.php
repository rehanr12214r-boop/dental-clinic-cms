<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case InClinic = 'in-clinic';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    /**
     * Human readable label of the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::InClinic => 'In Clinic',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    /**
     * Tailwind classes for the colour-coded status badge.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-100 text-amber-800 ring-1 ring-amber-600/20',
            self::Confirmed => 'bg-sky-100 text-sky-800 ring-1 ring-sky-600/20',
            self::InClinic => 'bg-violet-100 text-violet-800 ring-1 ring-violet-600/20',
            self::Completed => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-600/20',
            self::Cancelled => 'bg-rose-100 text-rose-800 ring-1 ring-rose-600/20',
        };
    }
}
