<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates a human-entered phone number without forcing a single display
 * format. Spaces, dashes, dots, parentheses and an optional leading "+" are
 * accepted; the underlying number must contain 7–15 digits (the ITU E.164
 * range) and must not be a dummy/placeholder sequence.
 */
class PhoneNumber implements ValidationRule
{
    /**
     * Obvious placeholder numbers that should never reach the database.
     *
     * @var list<string>
     */
    private const DummyNumbers = [
        '0000000',
        '00000000',
        '000000000',
        '0000000000',
        '1111111',
        '11111111',
        '111111111',
        '1111111111',
        '1234567',
        '12345678',
        '123456789',
        '1234567890',
        '0123456789',
        '9876543210',
    ];

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || trim($value) === '') {
            $fail('Please enter a valid phone number, e.g. +964 770 123 4567.');

            return;
        }

        $phone = trim($value);

        // Only phone-shaped characters are allowed. A "+" is only valid as
        // the very first character (the international dialling prefix).
        if (preg_match('/^\+?[0-9\s().-]+$/', $phone) !== 1) {
            $fail('Please enter a valid phone number, e.g. +964 770 123 4567.');

            return;
        }

        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if (strlen($digits) < 7 || strlen($digits) > 15) {
            $fail('The phone number must contain between 7 and 15 digits, including the country code.');

            return;
        }

        // E.164 numbers never start with a zero after the "+" prefix.
        if (str_starts_with($phone, '+') && $digits[0] === '0') {
            $fail('An international phone number must not start with a zero after the "+" prefix.');

            return;
        }

        if (preg_match('/^(\d)\1+$/', $digits) === 1 || in_array($digits, self::DummyNumbers, true)) {
            $fail('Please enter a real phone number — dummy sequences are not accepted.');
        }
    }
}
