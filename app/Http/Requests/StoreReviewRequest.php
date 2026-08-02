<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'service_match_id' => 'required|exists:service_matches,id',
            \Illuminate\Validation\Rule::unique('reviews')->where(function($query) {
                return $query->where('reviewer_id', $this->user()->id);
            }),
        ];
    }

    public function messages(): array
    {
        return[
            'service_match_id.required' => 'Le match est obligatoire.',
            'service_match_id.exists'   => 'Le match sélectionné est invalide.',
            'service_match_id.unique'   => 'Vous avez déjà laissé une review pour ce match.',
            'note.required'             => 'La note est obligatoire.',
            'note.min'                  => 'La note minimale est 1.',
            'note.max'                  => 'La note maximale est 5.',
            'tags.*.in'                 => 'Un tag sélectionné est invalide.',
        ];
    }
}
