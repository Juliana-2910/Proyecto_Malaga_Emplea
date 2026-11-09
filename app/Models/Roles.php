<?php

namespace App\Models;

use Spatie\Permission\Models\Role;

class Roles extends Role
{
    protected $table = 'spatie_roles';

    protected $fillable = [
        'name',
        'guard_name',
        'estado',
        'modulo',
    ];

    public function getRolAttribute(): ?string
    {
        return $this->name;
    }

    public function setRolAttribute(string $valor): void
    {
        $this->attributes['name'] = $valor;
    }
}