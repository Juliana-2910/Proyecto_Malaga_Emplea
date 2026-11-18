<?php

namespace Database\Factories;

use App\Models\Calificacion;
use App\Models\Postulacion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

/** @extends Factory<Calificacion> */
class CalificacionFactory extends Factory
{
    protected $model = Calificacion::class;

    public function definition(): array
    {
        return [
            'puntuacion' => fake()->numberBetween(1, 5),
            'comentario' => Str::limit(fake()->sentence(), 100, ''),
            'fecha' => now()->toDateString(),
            'idUsuario' => null,
            'idEmpresa' => null,
            'idUsuarioCalificado' => null,
            'idEmpresaCalificada' => null,
            'idPostulacion' => Postulacion::factory()->contratada(),
            'tipoCalificador' => 'usuario',
        ];
    }

    public function calificadaPorEmpresa(): static
    {
        return $this->state(fn () => ['tipoCalificador' => 'empresa']);
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Calificacion $calificacion): void {
            // Only fetch the fields needed to set the actor and target.
            $postulacion = DB::table('postulacion as p')
                ->join('ofertas as o', 'o.id', '=', 'p.idOferta')
                ->where('p.id', $calificacion->idPostulacion)
                ->select('p.estado', 'p.idUsuario', 'o.idEmpresa', 'o.idUsuario as idUsuarioPublicador')
                ->first();

            if (!$postulacion || $postulacion->estado !== 'Contratado') {
                throw new InvalidArgumentException('Una calificación debe corresponder a una postulación contratada.');
            }

            if ($calificacion->tipoCalificador === 'empresa') {
                if (!$postulacion->idEmpresa) {
                    throw new InvalidArgumentException('La calificación de empresa requiere una oferta publicada por una empresa.');
                }

                $calificacion->idEmpresa = $postulacion->idEmpresa;
                $calificacion->idUsuarioCalificado = $postulacion->idUsuario;
                $calificacion->idUsuario = null;
                $calificacion->idEmpresaCalificada = null;
                return;
            }

            $calificacion->idUsuario = $postulacion->idUsuario;
            $calificacion->idEmpresa = null;
            $calificacion->idUsuarioCalificado = $postulacion->idUsuarioPublicador;
            $calificacion->idEmpresaCalificada = $postulacion->idEmpresa;
        });
    }
}
