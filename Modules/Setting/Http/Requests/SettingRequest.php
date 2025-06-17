<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
            'favicon' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_1' => 'nullable|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'google_map_url' => 'nullable|url|max:1000',
            'whatsapp_number' => 'nullable|string|max:20',
            'instagram_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'payment_username' => 'nullable|string|max:255',
            'payment_password' => 'nullable|string|max:255',
            'otp_login' => 'nullable|string|max:255',
            'otp_password' => 'nullable|string|max:255',
            'otp_sender_name' => 'nullable|string|max:255',
            'is_offline' => 'nullable|boolean',
            'about' => 'nullable|string',
            'terms_and_conditions' => 'nullable|string',
            'privacy_and_policy' => 'nullable|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
