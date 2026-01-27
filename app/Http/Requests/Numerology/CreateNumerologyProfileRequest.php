<?php

declare(strict_types=1);

namespace App\Http\Requests\Numerology;

use Illuminate\Foundation\Http\FormRequest;

final class CreateNumerologyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'full_name' => [
                'required', 
                'string', 
                'max:255', 
                'regex:/^[a-zA-Z\s\'-]+$/'
            ],
            'birth_date' => [
                'required', 
                'date', 
                'before:today',
                'date_format:Y-m-d'
            ]
        ];
    }

    /**
     * Custom error messages
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.regex' => 'The full name can only contain letters, spaces, hyphens, and apostrophes.',
            'birth_date.before' => 'Birth date must be in the past.',
            'birth_date.date_format' => 'Birth date must be in YYYY-MM-DD format.'
        ];
    }
}