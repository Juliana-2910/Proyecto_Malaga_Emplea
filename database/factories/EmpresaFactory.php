<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Empresa> */
class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition(): array
    {
        return [
            'nombreEmpresa' => fake()->company(),
            'nit' => fake()->unique()->numerify('#########'),
            'direccion' => fake()->address(),
            'estado' => 'activo',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ];
    }
}
