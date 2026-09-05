<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'servicios';

    protected $fillable = [ 'nombre', 'descripcion',
    ];


    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria'); /*Tabla Hija con categorias*/
    }
}
