<?php

namespace App\Models;

use App\Models\Concerns\TieneRolesActivos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, TieneRolesActivos;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombres',
        'apellidos',
        'fotoPerfil',
        'fechaNacimiento',
        'tipoDocumento',
        'numeroDocumento',
        'email',
        'password',
        'telefono',
        'fechaRegistro',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hojaDeVida()
    {
        return $this->hasMany(HojaDeVida::class, 'idUsuario');
    }

    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'idUsuario');
    }

    public function calificacion()
    {
        return $this->hasMany(Calificacion::class, 'idUsuario');
    }

}
