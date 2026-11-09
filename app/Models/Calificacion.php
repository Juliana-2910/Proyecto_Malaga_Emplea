<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificacion';

    protected $fillable = ['puntuacion','comentario','fecha','idUsuario','idEmpresa','idUsuarioCalificado', 'idEmpresaCalificada',
    'idPostulacion', 'tipoCalificador'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class,'idUsuario');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class,'idEmpresa');
    }

    public function usuarioCalificado()
    {
        return $this->belongsTo(Usuario::class, 'idUsuarioCalificado');
    }

    public function empresaCalificada()
    {
        return $this->belongsTo(Empresa::class, 'idEmpresaCalificada');
    }

    public function postulacion()
    {
        return $this->belongsTo(Postulacion::class, 'idPostulacion');
    }
}
