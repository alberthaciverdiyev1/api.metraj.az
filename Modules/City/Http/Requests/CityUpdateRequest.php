<?php

namespace Modules\City\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityUpdateRequest extends FormRequest
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
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('City name is required!'),
            'is_active.required' => __('City status is required!')
        ];
    }
}
