<?php

namespace Modules\Town\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TownUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'district_id' => 'required|exists:districts,id',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('Town name is required!'),
            'district_id.required' => __('District is required!')
        ];
    }
}
