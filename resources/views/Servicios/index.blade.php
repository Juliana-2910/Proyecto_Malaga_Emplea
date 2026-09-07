
@extends('layouts.app')

@section('title')
Crud de servicios
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-6xl px-6">

        {{-- Encabezado --}}
        <div class="mb-6 flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Servicios
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Administración de los servicios
                </p>
            </div>

            <a href="{{ route('servicios.create') }}"
                class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                Crear servicio
            </a>

        </div>

        {{-- Mensaje --}}
        @if (session('success'))
            <div class="mb-5 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabla --}}
        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b border-gray-200 px-6 py-4">

                <h2 class="text-lg font-semibold text-gray-800">
                    Lista de servicios
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

                            {{-- Categoría --}}
                            <th class="px-6 py-4 font-semibold">
                                Categoría
                            </th>

                            {{-- Servicio --}}
                            <th class="px-6 py-4 font-semibold">
                                Servicio
                            </th>

                            {{-- Descripción --}}
                            <th class="px-6 py-4 font-semibold">
                                Descripción
                            </th>

                            {{-- Acciones --}}
                            <th class="px-6 py-4 text-center font-semibold">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse ($servicios as $servicio)

                            <tr class="transition hover:bg-gray-50">

                                {{-- ID --}}
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $servicio->id }}
                                </td>

                                {{-- Categoría --}}
                                <td class="px-6 py-4">
                                    {{ $servicio->categoria->nombre ?? 'Sin categoría' }}
                                </td>

                                {{-- Servicio --}}
                                <td class="px-6 py-4">
                                    {{ $servicio->nombre }}
                                </td>

                                {{-- Descripción --}}
                                <td class="px-6 py-4">
                                    {{ $servicio->descripcion }}
                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        {{-- Editar --}}
                                        <a href="{{ route('servicios.edit', $servicio->id) }}"
                                            class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                            Editar
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('servicios.destroy', $servicio->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#333333]"
                                                    onclick="return confirm('¿Está seguro de eliminar este servicio?')">
                                                Eliminar
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="px-6 py-8 text-center text-gray-500">

                                    No hay servicios registrados.

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
