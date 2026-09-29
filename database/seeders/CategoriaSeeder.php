<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Hogar y limpieza',
        ]);

        Categoria::create([
            'nombre' => 'Construcción y obra',
        ]);

        Categoria::create([
            'nombre' => 'Reparaciones y mantenimiento',
        ]);

        Categoria::create([
            'nombre' => 'Belleza y cuidado personal',
        ]);

        Categoria::create([
            'nombre' => 'Cuidado de personas',
        ]);

        Categoria::create([
            'nombre' => 'Cuidado de mascotas',
        ]);

        Categoria::create([
            'nombre' => 'Alimentación y cocina',
        ]);

        Categoria::create([
            'nombre' => 'Agricultura y campo',
        ]);

        Categoria::create([
            'nombre' => 'Transporte y domicilios',
        ]);

        Categoria::create([
            'nombre' => 'Educación y clases',
        ]);

        Categoria::create([
            'nombre' => 'Tecnología e informática',
        ]);

        Categoria::create([
            'nombre' => 'Comercio y ventas',
        ]);

        Categoria::create([
            'nombre' => 'Eventos y entretenimiento',
        ]);

        Categoria::create([
            'nombre' => 'Confección y manualidades',
        ]);

        Categoria::create([
            'nombre' => 'Servicios profesionales',
        ]);

        Categoria::create([
            'nombre' => 'Otros servicios',
        ]);
    }
}
