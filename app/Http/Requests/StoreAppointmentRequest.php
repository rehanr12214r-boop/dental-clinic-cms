<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use App\Services\SlotAvailabilityService;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * The booking portal is public: anyone may request an appointment.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Merge the validation rules applied to the booking request.
     *
     * @return array<string, list<int|string>>
     */
    public function rules(): array
    {
        $today = CarbonImmutable::today();
        $maxBookingDate = $today->addDays(SlotAvailabilityService::BOOKING_WINDOW_DAYS)->toDateString();

        return [
            'patient_name' => ['required', 'string', 'min:2', 'max:255'],
            'patient_phone' => ['required', 'string', 'max:32', new PhoneNumber],
            'patient_age' => ['required', 'integer', 'min:1', 'max:120'],
            'treatment_id' => [
                'required',
                'integer',
                Rule::exists('treatments', 'id')->where('is_active', true),
            ],
            'appointment_date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
                'before_or_equal:'.$maxBookingDate,
            ],
            'appointment_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * Custom validation messages for friendlier booking errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'patient_phone.required' => 'A WhatsApp number is required so the clinic can confirm your visit.',
        ];
    }

    /**
     * Normalize user input and the slot time ("17:30", "17:30:00", …) to
     * "HH:MM" before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(array_filter([
            'patient_name' => is_string($this->input('patient_name')) ? trim($this->input('patient_name')) : null,
            'patient_phone' => is_string($this->input('patient_phone')) ? trim($this->input('patient_phone')) : null,
        ], static fn (mixed $value): bool => $value !== null));

        $time = (string) $this->input('appointment_time', '');

        if (preg_match('/^(\d{1,2}):(\d{2})(?::\d{2})?$/', $time, $matches) === 1) {
            $this->merge([
                'appointment_time' => sprintf('%02d:%02d', $matches[1], $matches[2]),
            ]);
        }
    }
}
