<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceOfferRequest extends FormRequest
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
        return[
            'skill_id'       => 'sometimes|exists:skills,id',
            'titre'          => 'sometimes|string|max:255',
            'description'    => 'sometimes|string|min:20',
            'duree_estimee'  => 'sometimes|numeric|min:0.25|max:8',
            'disponibilites' => 'nullable|array',
            'statut'         => 'sometimes|in:active,paused,archived',
        ];
    }
}
