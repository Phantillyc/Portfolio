<?php

namespace App\Http\Requests\CommissionAuth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCommissionClientRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'username'              => 'required|string|min:3|max:50|alpha_dash|unique:commission_clients,username',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'redirect'              => 'nullable|string|max:2048',
        ];
    }
}
