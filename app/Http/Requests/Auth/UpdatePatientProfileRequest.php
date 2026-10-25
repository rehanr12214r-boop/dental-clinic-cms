<?php

namespace App\Http\Requests\Auth;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientProfileRequest extends FormRequest
{
    /**
     * The route is protected by the patient guard.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'max:32', new PhoneNumber],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
        ];
    }

    /**
     * Trim the editable fields before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(array_filter([
            'name' => is_string($this->input('name')) ? trim($this->input('name')) : null,
            'phone' => is_string($this->input('phone')) ? trim($this->input('phone')) : null,
        ], static fn (mixed $value): bool => $value !== null));
    }
}
