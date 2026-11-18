<?php

namespace Database\Factories;

use App\Models\HojaDeVida;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<HojaDeVida> */
class HojaDeVidaFactory extends Factory
{
    protected $model = HojaDeVida::class;

    public function definition(): array
    {
        return [
            'ubicacion' => fake()->city(),
            'nivelEducativo' => fake()->randomElement(['Basica Primaria', 'Basica Secundaria', 'Tecnico', 'Tecnologo', 'Profesional']),
            'perfilProfesional' => fake()->paragraph(),
            'experienciaLaboral' => fake()->paragraph(),
            'fechaActualizacion' => now(),
            'idUsuario' => Usuario::factory(),
        ];
    }
}
