<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequestRequest extends FormRequest
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
        'titre' => ['required', 'string', 'max:80'],
        'description' => ['required', 'string', 'max:1000'],
        'skill_id' => ['required', 'exists:skills,id'],
        'duree_estimee' => ['required', 'numeric', 'min:0.25'],
        'urgence' => ['required', 'in:low,normal,high'],
    ];
    }

    public function messages(): array
    {
        return [
            'skill_id.required'      => 'La compétence est obligatoire.',
            'skill_id.exists'        => 'La compétence sélectionnée est invalide.',
            'titre.required'         => 'Le titre est obligatoire.',
            'description.required'   => 'La description est obligatoire.',
            'description.min'        => 'La description doit contenir au moins 20 caractères.',
            'duree_estimee.required' => 'La durée estimée est obligatoire.',
            'duree_estimee.min'      => 'La durée minimale est 15 minutes (0.25h).',
            'duree_estimee.max'      => 'La durée maximale est 8 heures.',
            'urgence.in'             => 'L urgence doit être low, normal ou high.',
        ];
    }
}
