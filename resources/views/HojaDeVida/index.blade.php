
@extends('layouts.app')

@section('title')
Crud de hoja de vida
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-6xl px-6">

{{-- Encabezado --}}
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Hoja de vida
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Administración de hoja de vida de los usuarios
            </p>
        </div>

        <a href="{{ route('hojaDeVida.create') }}"
           class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
            Crear hoja de vida
        </a>

    </div>


    {{-- Mensajes --}}
    @if (session('success'))

        <div class="mb-5 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    @if (session('actualizar'))

        <div class="mb-5 rounded-lg bg-blue-100 px-4 py-3 text-sm text-blue-700">
            {{ session('actualizar') }}
        </div>

    @endif


    @if (session('eliminar'))

        <div class="mb-5 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-700">
            {{ session('eliminar') }}
        </div>

    @endif


{{-- Tabla de hojas de vida --}}
<div class="overflow-hidden rounded-xl bg-white shadow">

    <div class="border-b border-gray-200 px-6 py-4">

        <h2 class="text-lg font-semibold text-gray-800">
            Lista de hojas de vida
        </h2>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full text-left text-sm text-gray-600">

            <thead class="bg-[#333333] text-white">

                <tr>

                    <th class="px-6 py-4 font-semibold">
                        ID
                    </th>

                    <th class="px-6 py-4 font-semibold">
                        Usuario
                    </th>

                    <th class="px-6 py-4 font-semibold">
                        Ubicación
                    </th>

                    <th class="px-6 py-4 font-semibold">
                        Nivel Educativo
                    </th>

                    <th class="px-6 py-4 font-semibold">
                        Perfil Profesional
                    </th>

                    <th class="px-6 py-4 font-semibold">
                        Experiencia Laboral
                    </th>

                    <th class="px-6 py-4 font-semibold">
                        Fecha de Actualización
                    </th>

                    <th class="px-6 py-4 font-semibold">
                        Archivo CV
                    </th>

                    <th class="px-6 py-4 text-center font-semibold">
                        Acciones
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-200">

                @forelse ($hojaDeVida as $hojaDeVida)

                    <tr class="transition hover:bg-gray-50">

                        {{-- ID --}}
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $hojaDeVida->id }}
                        </td>


                        {{-- Usuario --}}
                        <td class="px-6 py-4">

                            <span class="font-medium text-gray-700">
                                {{ $hojaDeVida->usuario->nombres }}
                                {{ $hojaDeVida->usuario->apellidos }}
                            </span>

                        </td>


                        {{-- Ubicación --}}
                        <td class="px-6 py-4">
                            {{ $hojaDeVida->ubicacion }}
                        </td>


                        {{-- Nivel Educativo --}}
                        <td class="px-6 py-4">
                            {{ $hojaDeVida->nivelEducativo }}
                        </td>


                        {{-- Perfil Profesional --}}
                        <td class="px-6 py-4">
                            {{ $hojaDeVida->perfilProfesional }}
                        </td>


                        {{-- Experiencia Laboral --}}
                        <td class="px-6 py-4">
                            {{ $hojaDeVida->experienciaLaboral }}
                        </td>


                        {{-- Fecha de Actualización --}}
                        <td class="px-6 py-4">
                            {{ $hojaDeVida->fechaActualizacion }}
                        </td>


                        {{-- Archivo CV --}}
                        <td class="px-6 py-4">
                            @if ($hojaDeVida->archivoCV)
                                <a href="{{ $hojaDeVida->archivoCV }}"
                                    target="_blank"
                                    class="text-[#4DB6E8] hover:underline">
                                    Descargar
                                </a>
                            @else
                                <span class="text-gray-500">
                                    Sin CV
                                </span>
                            @endif
                        </td>


                        {{-- Acciones --}}
                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                {{-- Editar --}}
                                <a href="{{ route('hojaDeVida.edit', $hojaDeVida->id) }}"
                                   class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                    Editar
                                </a>


                                {{-- Eliminar --}}
                                <form action="{{ route('hojaDeVida.destroy', $hojaDeVida->id) }}"
                                      method="POST">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-lg bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#333333]"
                                            onclick="return confirm('¿Está seguro de eliminar esta hoja de vida?')">
                                        Eliminar
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                            No hay hojas de vida registradas.
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection
