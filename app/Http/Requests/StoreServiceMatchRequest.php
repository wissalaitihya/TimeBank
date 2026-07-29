<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceMatchRequest extends FormRequest
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
            'offer_id'   => 'required|exists:service_offers,id',
            'request_id' => 'required|exists:service_requests,id',
            'message'    => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return[
            'offer_id.required' => 'The offer ID is required.',
            'offer_id.exists'   => 'The selected offer is invalid.',
            'request_id.required' => 'The request ID is required.',
            'request_id.exists'   => 'The selected request is invalid.',
            'message.max'        => 'The message may not exceed 500 characters.',
        ];
    }
}
