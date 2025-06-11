<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'min:8',
                'max:100',
                Password::min(8)
                    ->mixedCase() // Harus mengandung huruf besar dan kecil
                    ->numbers() // Harus mengandung angka
                    ->symbols() // Harus mengandung karakter khusus
                    ->uncompromised(), // Mengecek apakah password pernah bocor
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal harus 8 karakter',
            'password.max' => 'Password maksimal 100 karakter',
            'password.mixed' => 'Password harus mengandung huruf besar dan huruf kecil',
            'password.numbers' => 'Password harus mengandung angka',
            'password.symbols' => 'Password harus mengandung karakter khusus',
            'password.uncompromised' => 'Password ini pernah bocor, gunakan password yang lebih aman',
        ];
    }
} 