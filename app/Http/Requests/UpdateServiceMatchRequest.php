<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceMatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'scheduled_id' => 'sometimes|date|after:now',
            'session_link' => 'sometimes|url|max:255',
            'platform'    => 'sometimes|string|max:100',
            'declared_duration' => 'sometimes|numeric|min:0.25|max:8',
        ];
    }

    public function messages(): array
    {
        return[
            'declared_duration.min' => 'The declared duration must be at least 0.25 hours.',
            'declared_duration.max' => 'The declared duration may not exceed 8 hours.',
            'scheduled_id.after' => 'The scheduled date and time must be in the future.',
        ];
    }
}
