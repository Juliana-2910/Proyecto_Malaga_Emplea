<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'servicios';

    protected $fillable = [ 'nombre', 'descripcion','idCategoria'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria'); /*Tabla Hija con categorias*/
    }

    public function ofertaServicio()
    {
        return $this->hasMany(OfertaServicio::class,'idServicio'); /*Relación con la tabla ofertaServicios*/
    }
}
