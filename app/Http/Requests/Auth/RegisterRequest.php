<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gerekirse policy eklenebilir
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'İsim alanı zorunludur.',
            'email.required' => 'E-posta adresi zorunludur.',
            'email.unique'   => 'Bu e-posta adresi zaten kayıtlı.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
        ];
    }
}
