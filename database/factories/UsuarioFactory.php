<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Usuario> */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nombres' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'fechaNacimiento' => fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'tipoDocumento' => fake()->randomElement(['CC', 'CE', 'PPT', 'PEP', 'PASAPORTE']),
            'numeroDocumento' => fake()->unique()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'telefono' => fake()->numerify('3#########'),
            'fechaRegistro' => now(),
            'estado' => 'activo',
        ];
    }
}
