<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Servicios;

class ServiciosSeeder extends Seeder
{
    
    public function run(): void
    {
        $servicios = [
            'Hogar y limpieza' => [
                ['nombre' => 'Limpieza de casas', 'descripcion' => 'Servicio de limpieza general para viviendas.'],
                ['nombre' => 'Lavado y planchado de ropa', 'descripcion' => 'Servicio de lavado y planchado de prendas.'],
                ['nombre' => 'Limpieza de muebles', 'descripcion' => 'Limpieza de muebles y tapizados del hogar.'],
                ['nombre' => 'Limpieza de patios', 'descripcion' => 'Limpieza y organización de patios y espacios exteriores.'],
            ],

            'Construcción y obra' => [
                ['nombre' => 'Albañilería', 'descripcion' => 'Trabajos básicos de construcción y albañilería.'],
                ['nombre' => 'Pintura de viviendas', 'descripcion' => 'Pintura de paredes y espacios interiores o exteriores.'],
                ['nombre' => 'Enchape', 'descripcion' => 'Instalación y reparación de enchapes.'],
                ['nombre' => 'Ayudante de construcción', 'descripcion' => 'Apoyo en diferentes actividades de construcción.'],
            ],

            'Reparaciones y mantenimiento' => [
                ['nombre' => 'Electricidad', 'descripcion' => 'Trabajos básicos de instalaciones y reparaciones eléctricas.'],
                ['nombre' => 'Plomería', 'descripcion' => 'Reparación y mantenimiento de instalaciones de agua.'],
                ['nombre' => 'Reparación de electrodomésticos', 'descripcion' => 'Revisión y reparación básica de electrodomésticos.'],
                ['nombre' => 'Mantenimiento general', 'descripcion' => 'Trabajos generales de mantenimiento y reparación.'],
            ],

            'Belleza y cuidado personal' => [
                ['nombre' => 'Barbería', 'descripcion' => 'Corte y arreglo de cabello y barba.'],
                ['nombre' => 'Peluquería', 'descripcion' => 'Corte, peinado y cuidado del cabello.'],
                ['nombre' => 'Manicure y pedicure', 'descripcion' => 'Cuidado y arreglo de uñas de manos y pies.'],
                ['nombre' => 'Maquillaje', 'descripcion' => 'Servicio de maquillaje para diferentes ocasiones.'],
            ],

            'Cuidado de personas' => [
                ['nombre' => 'Cuidado de niños', 'descripcion' => 'Acompañamiento y cuidado de niños.'],
                ['nombre' => 'Cuidado de adultos mayores', 'descripcion' => 'Acompañamiento y cuidado de adultos mayores.'],
                ['nombre' => 'Acompañamiento', 'descripcion' => 'Acompañamiento y apoyo durante actividades cotidianas.'],
                ['nombre' => 'Apoyo en actividades del hogar', 'descripcion' => 'Apoyo en actividades básicas del hogar.'],
            ],

            'Cuidado de mascotas' => [
                ['nombre' => 'Paseo de mascotas', 'descripcion' => 'Servicio de paseo y acompañamiento de mascotas.'],
                ['nombre' => 'Baño de mascotas', 'descripcion' => 'Baño y limpieza básica de mascotas.'],
                ['nombre' => 'Cuidado de mascotas', 'descripcion' => 'Cuidado de mascotas durante periodos cortos.'],
                ['nombre' => 'Alimentación de mascotas', 'descripcion' => 'Alimentación y cuidado básico de mascotas.'],
            ],

            'Alimentación y cocina' => [
                ['nombre' => 'Preparación de comidas', 'descripcion' => 'Preparación de comidas para hogares o clientes.'],
                ['nombre' => 'Repostería', 'descripcion' => 'Elaboración de tortas, postres y productos de repostería.'],
                ['nombre' => 'Comidas para eventos', 'descripcion' => 'Preparación de alimentos para reuniones y eventos.'],
                ['nombre' => 'Venta de comidas caseras', 'descripcion' => 'Preparación y venta de comidas caseras.'],
            ],

            'Agricultura y campo' => [
                ['nombre' => 'Siembra', 'descripcion' => 'Apoyo en actividades de siembra y cultivo.'],
                ['nombre' => 'Cosecha', 'descripcion' => 'Apoyo en actividades de recolección y cosecha.'],
                ['nombre' => 'Limpieza de terrenos', 'descripcion' => 'Limpieza y adecuación de terrenos.'],
                ['nombre' => 'Cuidado de animales', 'descripcion' => 'Alimentación y cuidado básico de animales de campo.'],
            ],

            'Transporte y domicilios' => [
                ['nombre' => 'Domicilios', 'descripcion' => 'Entrega de productos y pedidos a domicilio.'],
                ['nombre' => 'Mensajería', 'descripcion' => 'Entrega y recepción de documentos y paquetes.'],
                ['nombre' => 'Transporte de objetos', 'descripcion' => 'Transporte de objetos y mercancías.'],
                ['nombre' => 'Acarreos', 'descripcion' => 'Traslado de muebles, objetos y elementos del hogar.'],
            ],

            'Educación y clases' => [
                ['nombre' => 'Refuerzo escolar', 'descripcion' => 'Apoyo académico para estudiantes.'],
                ['nombre' => 'Clases particulares', 'descripcion' => 'Clases personalizadas en diferentes áreas.'],
                ['nombre' => 'Ayuda con tareas', 'descripcion' => 'Apoyo en la realización y comprensión de tareas escolares.'],
                ['nombre' => 'Clases de informática', 'descripcion' => 'Enseñanza básica de informática y herramientas digitales.'],
            ],

            'Tecnología e informática' => [
                ['nombre' => 'Reparación de computadores', 'descripcion' => 'Revisión y reparación de computadores.'],
                ['nombre' => 'Instalación de programas', 'descripcion' => 'Instalación y configuración de programas.'],
                ['nombre' => 'Mantenimiento de computadores', 'descripcion' => 'Mantenimiento preventivo de equipos de cómputo.'],
                ['nombre' => 'Soporte tecnológico', 'descripcion' => 'Ayuda y soporte en problemas tecnológicos básicos.'],
            ],

            'Comercio y ventas' => [
                ['nombre' => 'Ventas', 'descripcion' => 'Apoyo en actividades de venta de productos o servicios.'],
                ['nombre' => 'Atención al cliente', 'descripcion' => 'Atención y orientación a clientes.'],
                ['nombre' => 'Impulso de productos', 'descripcion' => 'Promoción e impulso de productos en establecimientos.'],
                ['nombre' => 'Organización de mercancía', 'descripcion' => 'Organización y distribución de productos y mercancía.'],
            ],

            'Eventos y entretenimiento' => [
                ['nombre' => 'Decoración de eventos', 'descripcion' => 'Decoración y organización de espacios para eventos.'],
                ['nombre' => 'Fotografía', 'descripcion' => 'Servicio de fotografía para eventos y ocasiones especiales.'],
                ['nombre' => 'Animación de eventos', 'descripcion' => 'Animación y entretenimiento para diferentes eventos.'],
                ['nombre' => 'Sonido para eventos', 'descripcion' => 'Apoyo con sonido y equipos para eventos.'],
            ],

            'Confección y manualidades' => [
                ['nombre' => 'Arreglos de ropa', 'descripcion' => 'Ajustes y modificaciones de prendas de vestir.'],
                ['nombre' => 'Costura', 'descripcion' => 'Elaboración y reparación de prendas mediante costura.'],
                ['nombre' => 'Tejido', 'descripcion' => 'Elaboración de productos mediante diferentes técnicas de tejido.'],
                ['nombre' => 'Manualidades', 'descripcion' => 'Elaboración de productos y trabajos manuales.'],
            ],

            'Servicios profesionales' => [
                ['nombre' => 'Contabilidad', 'descripcion' => 'Apoyo en actividades contables básicas.'],
                ['nombre' => 'Diseño gráfico', 'descripcion' => 'Diseño de piezas gráficas y contenido visual.'],
                ['nombre' => 'Digitación de documentos', 'descripcion' => 'Digitación y organización de documentos.'],
                ['nombre' => 'Asesorías', 'descripcion' => 'Asesorías en diferentes áreas de conocimiento.'],
            ],

            'Otros servicios' => [
                ['nombre' => 'Servicios generales', 'descripcion' => 'Realización de diferentes actividades de apoyo.'],
                ['nombre' => 'Ayudante general', 'descripcion' => 'Apoyo en diferentes trabajos y actividades.'],
                ['nombre' => 'Trabajo por horas', 'descripcion' => 'Servicios realizados bajo modalidad de trabajo por horas.'],
                ['nombre' => 'Otros servicios', 'descripcion' => 'Servicios que no pertenecen a las demás categorías.'],
            ],
        ];

        foreach ($servicios as $nombreCategoria => $listaServicios) {

            $categoria = Categoria::where('nombre', $nombreCategoria)->first();

            foreach ($listaServicios as $servicio) {

                Servicios::create([
                    'nombre' => $servicio['nombre'],
                    'descripcion' => $servicio['descripcion'],
                    'idCategoria' => $categoria->id,
                ]);
            }
        }
    }
}