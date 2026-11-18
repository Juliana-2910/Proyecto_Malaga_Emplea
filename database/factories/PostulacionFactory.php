<?php

namespace Database\Factories;

use App\Models\Oferta;
use App\Models\Postulacion;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/** @extends Factory<Postulacion> */
class PostulacionFactory extends Factory
{
    protected $model = Postulacion::class;

    public function definition(): array
    {
        return [
            'fecha' => now()->toDateString(),
            'estado' => 'Enviado',
            'idUsuario' => Usuario::factory(),
            'idOferta' => Oferta::factory(),
        ];
    }

    public function contratada(): static
    {
        return $this->state(fn () => ['estado' => 'Contratado']);
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Postulacion $postulacion): void {
            $esPropia = DB::table('ofertas')
                ->where('id', $postulacion->idOferta)
                ->whereNotNull('idUsuario')
                ->where('idUsuario', $postulacion->idUsuario)
                ->exists();

            if ($esPropia) {
                throw new InvalidArgumentException('Una persona no puede postularse a una oferta publicada por ella misma.');
            }
        });
    }
}
