<?php

namespace App\Enums;

enum WhatsAppTemplate: string
{
    case Confirmation = 'confirmation';
    case Reminder = 'reminder';
    case Review = 'review';

    /**
     * Settings key under which the admin can customise this template.
     */
    public function settingKey(): string
    {
        return 'whatsapp_template_'.$this->value;
    }

    /**
     * Human readable name shown in the settings page.
     */
    public function label(): string
    {
        return match ($this) {
            self::Confirmation => 'Booking Confirmation',
            self::Reminder => 'Appointment Reminder',
            self::Review => 'Post-Visit Review Request',
        };
    }

    /**
     * Hint shown under the template textarea in the settings page.
     */
    public function description(): string
    {
        return match ($this) {
            self::Confirmation => 'Sent with the "Send Confirmation" button on the appointments dashboard.',
            self::Reminder => 'Sent with the "Send Reminder" button (e.g. 2 hours or 1 day before the visit).',
            self::Review => 'Sent with the "Request Review" button after a completed visit.',
        };
    }

    /**
     * The message used when the admin has not customised the template.
     */
    public function defaultTemplate(): string
    {
        return match ($this) {
            self::Confirmation => 'Hello {patient_name}, your appointment for {treatment_name} is confirmed for {date} at {time} with {doctor_name}. Clinic Location: {clinic_address}.',
            self::Reminder => 'Reminder: Your appointment for {treatment_name} is scheduled for {date} at {time}. Please reply YES to confirm or CALL us to reschedule.',
            self::Review => 'Thank you for visiting us today, {patient_name}! Please take 30 seconds to leave us a review: {review_link}.',
        };
    }

    /**
     * Placeholders recognised in every template, with help text for the
     * settings page. They are replaced per appointment by the message service.
     *
     * @return array<string, string>
     */
    public static function placeholders(): array
    {
        return [
            '{patient_name}' => "The patient's full name",
            '{treatment_name}' => 'Name of the booked treatment',
            '{date}' => 'Appointment date (e.g. Monday, October 19, 2026)',
            '{time}' => 'Appointment time (e.g. 5:30 PM)',
            '{doctor_name}' => 'Doctor name from clinic settings',
            '{clinic_name}' => 'Clinic name from clinic settings',
            '{clinic_address}' => 'Clinic address from clinic settings',
            '{clinic_phone}' => 'Clinic phone from clinic settings',
            '{review_link}' => 'Google review link from clinic settings',
        ];
    }
}
