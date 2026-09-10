<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = ['nombres', 'apellidos', 'fechaNacimiento', 'tipoDocumento',
    'numeroDocumento', 'correoElectronico', 'password', 'telefono', 'fechaRegistro',
    'estado', 'idRol'];

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'idRol'); /*Tabla Hija con roles*/
    }

    public function hojaDeVida()
    {
        return $this->hasMany(HojaDeVida::class, 'idUsuario'); /*Tabla padre con hoja de vida*/
    }
  
    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'idUsuario');
    }

    public function calificacion()
    {
        return $this->hasMany(Calificacion::class,'idUsuario');
    }
}
