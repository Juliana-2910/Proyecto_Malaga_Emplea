<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OfertaUpdateRequest extends FormRequest
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
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'salario' => 'required|numeric|min:0',
            'tipoContrato' => 'required|in:tiempo completo,medio tiempo,horas',
            'ubicacion' => 'required|string|max:255',
            'fechaPublicacion' => 'required|date',
            'fechaLimite' => 'required|date|after_or_equal:fechaPublicacion',
            'idEmpresa' => 'required|exists:empresas,id',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título de la oferta es obligatorio.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',

            'descripcion.required' => 'La descripción de la oferta es obligatoria.',

            'requisitos.required' => 'Los requisitos de la oferta son obligatorios.',

            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un valor numérico.',
            'salario.min' => 'El salario no puede ser negativo.',

            'tipoContrato.required' => 'El tipo de contrato es obligatorio.',
            'tipoContrato.in' => 'El tipo de contrato seleccionado no es válido.',

            'ubicacion.required' => 'La ubicación es obligatoria.',

            'fechaPublicacion.required' => 'La fecha de publicación es obligatoria.',
            'fechaPublicacion.date' => 'La fecha de publicación no es válida.',

            'fechaLimite.required' => 'La fecha límite es obligatoria.',
            'fechaLimite.date' => 'La fecha límite no es válida.',
            'fechaLimite.after_or_equal' => 'La fecha límite debe ser igual o posterior a la fecha de publicación.',

            'idEmpresa.required' => 'Debe seleccionar una empresa.',
            'idEmpresa.exists' => 'La empresa seleccionada no existe.',
        ];
    }
}
