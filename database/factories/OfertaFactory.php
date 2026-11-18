<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Oferta> */
class OfertaFactory extends Factory
{
    protected $model = Oferta::class;

    public function definition(): array
    {
        $fechaPublicacion = now()->toDateString();

        return [
            'titulo' => fake()->jobTitle(),
            'descripcion' => fake()->paragraph(),
            'requisitos' => fake()->paragraph(),
            'salario' => fake()->numberBetween(500000, 8000000),
            'tipoContrato' => fake()->randomElement(['tiempo completo', 'medio tiempo', 'horas', 'porcentaje']),
            'ubicacion' => fake()->city(),
            'fechaPublicacion' => $fechaPublicacion,
            'fechaLimite' => now()->addDays(30)->toDateString(),
            'idEmpresa' => Empresa::factory(),
            'idUsuario' => null,
        ];
    }

    public function publicadaPorUsuario(): static
    {
        return $this->state(fn () => [
            'idEmpresa' => null,
            'idUsuario' => Usuario::factory(),
        ]);
    }

    public function publicadaPorEmpresa(): static
    {
        return $this->state(fn () => [
            'idEmpresa' => Empresa::factory(),
            'idUsuario' => null,
        ]);
    }
}
