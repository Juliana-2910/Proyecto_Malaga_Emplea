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

    protected function prepareForValidation(): void
    {
        if ($this->input('_origen') !== 'publico') {
            return; // el panel administrativo sigue funcionando igual
        }

        $this->errorBag = 'editarOferta';

        $this->merge([
            'salario'          => preg_replace('/\D/', '', (string) $this->input('salario')),
            'fechaPublicacion' => now('America/Bogota')->toDateString(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'idCategoria' => 'required|exists:categorias,id',
            'idServicio' => 'required|exists:servicios,id',
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'salario' => 'required|numeric',
            'tipoContrato' => 'required|in:tiempo completo,medio tiempo,horas,porcentaje',
            'ubicacion' => 'required|string|max:255',
            'fechaLimite' => 'required|date|after_or_equal:fechaPublicacion',
            'idEmpresa' => 'nullable|exists:empresas,id|required_without:idUsuario',
            'idUsuario' => 'nullable|exists:usuarios,id|required_without:idEmpresa',
        ];
    }

    public function messages(): array
    {
        return [

            'idCategoria.required' => 'Debe seleccionar una categoria.',
            'idCategoria.exists' => 'La categoría seleccionada no existe.',

            'idServicio.required' => 'Debe seleccionar un servicio.',
            'idServicio.exists' => 'El servicio seleccionado no existe.',

            'titulo.required' => 'El título de la oferta es obligatorio.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',

            'descripcion.required' => 'La descripción de la oferta es obligatoria.',

            'requisitos.required' => 'Los requisitos de la oferta son obligatorios.',

            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un valor numérico.',

            'tipoContrato.required' => 'El tipo de contrato es obligatorio.',
            'tipoContrato.in' => 'El tipo de contrato seleccionado no es válido.',

            'ubicacion.required' => 'La ubicación es obligatoria.',

            'fechaLimite.required' => 'La fecha límite es obligatoria.',
            'fechaLimite.date' => 'La fecha límite no es válida.',
            'fechaLimite.after_or_equal' => 'La fecha límite debe ser igual o posterior a la fecha de publicación.',

            'idEmpresa.required_without' => 'Debe seleccionar una empresa o un usuario.',
            'idEmpresa.exists' => 'La empresa seleccionada no existe.',

            'idUsuario.required_without' => 'Debe seleccionar una empresa o un usuario.',
            'idUsuario.exists' => 'El usuario seleccionado no existe.',
        ];
    }
}
