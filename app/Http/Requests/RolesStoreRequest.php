<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RolesStoreRequest extends FormRequest
{
    
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
            'rol' => ['required', 'in:usuario,administrador',],
        ];
    }

    public function messages(): array
    {
        return [
            'rol.required' => 'El campo rol es obligatorio.',
            'rol.in' => 'El valor del campo rol debe ser "usuario" o "administrador".',
        ];
    }
}
