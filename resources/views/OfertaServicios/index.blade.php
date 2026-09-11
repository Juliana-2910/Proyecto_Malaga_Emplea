
@extends('layouts.app')

@section('title')
    Crud de oferta Servicios
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-6xl px-6">

        {{-- Encabezado --}}
        <div class="mb-6 flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Ofertas y Servicios
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Administración de los servicios asociados a las ofertas
                </p>
            </div>

            <a href="{{ route('ofertaServicios.create') }}"
                class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                + Crear Relación
            </a>

        </div>


        {{-- Tabla --}}
        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b border-gray-200 px-6 py-4">

                <h2 class="text-lg font-semibold text-gray-800">
                    Lista de ofertas y servicios
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

                            {{-- Oferta --}}
                            <th class="px-6 py-4 font-semibold">
                                Oferta
                            </th>

                            {{-- Servicio --}}
                            <th class="px-6 py-4 font-semibold">
                                Servicio
                            </th>

                            {{-- Acciones --}}
                            <th class="px-6 py-4 text-center font-semibold">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse ($ofertaServicios as $ofertaServicio)

                            <tr class="transition hover:bg-gray-50">

                                {{-- ID --}}
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $ofertaServicio->id }}
                                </td>

                                {{-- Oferta --}}
                                <td class="px-6 py-4">

                                    {{ $ofertaServicio->oferta->titulo ?? 'Sin oferta' }}

                                </td>

                                {{-- Servicio --}}
                                <td class="px-6 py-4">

                                    {{ $ofertaServicio->servicio->nombre ?? 'Sin servicio' }}

                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        {{-- Editar --}}
                                        <a href="{{ route('ofertaServicios.edit', $ofertaServicio->id) }}"
                                            class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                            Editar
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('ofertaServicios.destroy', $ofertaServicio->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#333333]"
                                                onclick="return confirm('¿Está seguro de eliminar esta relación?')">
                                                Eliminar
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="px-6 py-8 text-center text-gray-500">

                                    No hay relaciones entre ofertas y servicios registradas.

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
