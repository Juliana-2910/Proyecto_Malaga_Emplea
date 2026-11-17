<?php

namespace App\Http\Requests\Seguridad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tipos = array_keys(config('seguridad.login') ?? ['usuario' => true]);

        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'tipo' => ['nullable', Rule::in($tipos)],
        ];
    }
}

