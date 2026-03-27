<?php

namespace App\Http\Requests\CommissionAuth;

use Illuminate\Foundation\Http\FormRequest;

class LoginCommissionClientRequest extends FormRequest {
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
            'username'           => 'required|string',
            'password'           => 'required|string',
            'keep_me_signed_in'  => 'nullable|boolean',
            'redirect'           => 'nullable|string|max:2048',
        ];
    }
}
