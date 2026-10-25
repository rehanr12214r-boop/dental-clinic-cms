<?php

namespace App\Http\Requests\Auth;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class PatientRegisterRequest extends FormRequest
{
    /**
     * Guests submit this form; authorization is handled by the guard.
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('patients', 'email'),
            ],
            'phone' => ['required', 'string', 'max:32', new PhoneNumber],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->letters()->numbers()->symbols()->max(255),
            ],
        ];
    }

    /**
     * Trim/lowercase inputs before validation so duplicate accounts and
     * login attempts cannot hide behind casing or whitespace.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(array_filter([
            'name' => is_string($this->input('name')) ? trim($this->input('name')) : null,
            'email' => is_string($this->input('email')) ? mb_strtolower(trim($this->input('email'))) : null,
            'phone' => is_string($this->input('phone')) ? trim($this->input('phone')) : null,
        ], static fn (mixed $value): bool => $value !== null));
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
