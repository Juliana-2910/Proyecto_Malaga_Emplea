@extends('layouts.app')

@section('title')
    Postulaciones
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-5xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6 flex items-center justify-between">
        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Postulaciones
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Gestión de las postulaciones registradas
            </p>
       </div>

         <a href="{{ route('postulacion.create') }}"
            class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                Nueva postulación
        </a>

    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('actualizar'))
        <div class="mb-6 rounded-lg bg-blue-100 px-4 py-3 text-sm text-blue-700">
            {{ session('actualizar') }}
        </div>
    @endif

    @if(session('eliminar'))
        <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-700">
            {{ session('eliminar') }}
        </div>
    @endif

    {{-- Tabla --}}
     <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b border-gray-200 px-6 py-4">

                <h2 class="text-lg font-semibold text-gray-800">
                    Lista de Postulaciones
                </h2>

            </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm text-gray-600">

                <thead class="bg-[#333333] text-white">

                    <tr>

                        <th class="px-4 py-3">
                            Fecha
                        </th>

                        <th class="px-4 py-3">
                            Estado
                        </th>

                        <th class="px-4 py-3">
                            Usuario
                        </th>

                        <th class="px-4 py-3">
                            Oferta
                        </th>

                        <th class="px-4 py-3 text-center">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($postulaciones as $postulacion)

                        <tr class="border-b border-gray-200 hover:bg-gray-50">

                            <td class="px-4 py-3">
                                {{ $postulacion->fecha }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $postulacion->estado }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $postulacion->usuario->nombres }}
                                {{ $postulacion->usuario->apellidos }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $postulacion->oferta->titulo }}
                            </td>

                            <td class="px-4 py-3">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('postulacion.edit', $postulacion->id) }}"
                                        class="rounded-lg bg-[#4DB6E8] px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                        Editar
                                    </a>

                                    <form action="{{ route('postulacion.destroy', $postulacion->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('¿Está seguro de eliminar esta postulación?')"
                                            class="rounded-lg bg-gray-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection