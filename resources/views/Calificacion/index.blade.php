@extends('layouts.app')

@section('title')
Crud de calificaciones
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-6xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Calificaciones
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Administración de las calificaciones
            </p>
        </div>

        <a href="{{ route('calificacion.create') }}"
            class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
            Crear calificación
        </a>

    </div>


    {{-- Tabla --}}
    <div class="overflow-hidden rounded-xl bg-white shadow">

        <div class="border-b border-gray-200 px-6 py-4">

            <h2 class="text-lg font-semibold text-gray-800">
                Lista de calificaciones
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm text-gray-600">

                <thead class="bg-[#333333] text-white">

                    <tr>

                        {{-- ID --}}
                        <th class="px-6 py-4 font-semibold">
                            ID
                        </th>

                        {{-- Usuario --}}
                        <th class="px-6 py-4 font-semibold">
                            Usuario
                        </th>

                        {{-- Empresa --}}
                        <th class="px-6 py-4 font-semibold">
                            Empresa
                        </th>

                        {{-- Puntuación --}}
                        <th class="px-6 py-4 font-semibold">
                            Puntuación
                        </th>

                        {{-- Comentario --}}
                        <th class="px-6 py-4 font-semibold">
                            Comentario
                        </th>

                        {{-- Fecha --}}
                        <th class="px-6 py-4 font-semibold">
                            Fecha
                        </th>

                        {{-- Acciones --}}
                        <th class="px-6 py-4 text-center font-semibold">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse ($calificacion as $calificacion)

                        <tr class="transition hover:bg-gray-50">

                            {{-- ID --}}
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $calificacion->id }}
                            </td>

                            {{-- Usuario --}}
                            <td class="px-6 py-4">
                                {{ $calificacion->usuario->nombres ?? 'Sin usuario' }}
                                {{ $calificacion->usuario->apellidos ?? '' }}
                            </td>

                            {{-- Empresa --}}
                            <td class="px-6 py-4">
                                {{ $calificacion->empresa->nombreEmpresa ?? 'Sin empresa' }}
                            </td>

                            {{-- Puntuación --}}
                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="flex items-center gap-1">

                                    @for ($i = 1; $i <= 5; $i++)

                                        @if ($i <= $calificacion->puntuacion)

                                            <span class="text-lg text-yellow-400">
                                                ★
                                            </span>

                                        @else

                                            <span class="text-lg text-gray-300">
                                                ★
                                            </span>

                                        @endif

                                    @endfor

                                    <span class="ml-1 text-sm text-gray-500">
                                        ({{ $calificacion->puntuacion }}/5)
                                    </span>

                                </div>

                            </td>

                            {{-- Comentario --}}
                            <td class="px-6 py-4">
                                {{ $calificacion->comentario }}
                            </td>

                            {{-- Fecha --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $calificacion->fecha }}
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('calificacion.edit', $calificacion->id) }}"
                                        class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                        Editar
                                    </a>

                                    {{-- Eliminar --}}
                                    <form action="{{ route('calificacion.destroy', $calificacion->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#333333]"
                                            onclick="return confirm('¿Está seguro de eliminar esta calificación?')">
                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="px-6 py-8 text-center text-gray-500">

                                No hay calificaciones registradas.

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
