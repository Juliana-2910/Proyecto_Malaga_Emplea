
@extends('layouts.app')

@section('title', 'Categorías')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-800 sm:text-3xl">
                Categorías
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Gestión de categorías laborales
            </p>
        </div>

    </div>

    {{-- BUSCADOR --}}
    <form method="GET" action="{{ route('categorias.index') }}"
        class="mb-6 flex w-full flex-wrap items-center gap-3">

        <div class="flex h-11 w-2/3 items-center gap-2.5 rounded-full border border-gray-200 bg-white pl-4 pr-1.5 shadow-sm transition focus-within:border-[#4DB6E8] focus-within:ring-[3px] focus-within:ring-[#4DB6E8]/25">

            @php( $icon = 'magnifying-glass')
            @include('layouts.partials.icons')

            <input type="text" name="buscar" value="{{ request('buscar') }}" maxlength="100" autocomplete="off" placeholder="Buscar categoría..."
                class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-0">

            <button type="submit"
                class="h-[34px] shrink-0 rounded-full bg-[#4DB6E8] px-4 text-[13px] font-semibold text-white transition duration-200 hover:bg-[#333333]">
                Buscar
            </button>

        </div>

        @if (request('buscar'))
            <a href="{{ route('categorias.index') }}"
                class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-gray-500 transition hover:text-gray-800">

                @php( $icon = 'equisfiltros')
                @include('layouts.partials.icons')

                Limpiar
            </a>
        @endif

        <a href="{{ route('categorias.create') }}"
            class="ml-auto inline-flex items-center justify-center gap-2 rounded-full bg-[#4DB6E8] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#333333]">

            @php($icon = 'plus')
            @include('layouts.partials.icons')

            Nueva Categoría
        </a>

    </form>

    {{-- TARJETA PRINCIPAL --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-[0_10px_35px_rgba(77,182,232,0.20)]">

        {{-- TÍTULO DE LA TABLA --}}
        <div class="border-b border-gray-100 px-6 py-4">

            <h2 class="text-lg font-semibold text-gray-800">
                Categorías registradas
            </h2>

        </div>

        {{-- TABLA --}}
        <div class="overflow-x-auto">

            <table class="w-full text-center text-gray-600">

                <thead class="bg-[#333333] text-white">

                    <tr>

                        <th class="border-r border-gray-600 px-6 py-4 text-sm font-semibold">
                            ID
                        </th>

                        <th class="border-r border-gray-600 px-6 py-4 text-sm font-semibold">
                            Nombre
                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse ($categorias as $categoria)

                        <tr class="transition hover:bg-gray-50">

                            {{-- ID --}}
                            <td class="border-r border-gray-100 px-6 py-5 text-sm font-medium text-gray-600">
                                {{ $categoria->id }}
                            </td>

                            {{-- NOMBRE --}}
                            <td class="border-r border-gray-100 px-6 py-5 text-sm font-medium text-gray-600">
                                {{ $categoria->nombre }}
                            </td>

                            {{-- ACCIONES --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- EDITAR --}}
                                    <a
                                        href="{{ route('categorias.edit', $categoria->id) }}"
                                        title="Editar categoría"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#4DB6E8]/10 text-[#4DB6E8] transition duration-200 hover:bg-[#4DB6E8] hover:text-white">

                                        @php($icon = 'pencil')
                                        @include('layouts.partials.icons')
                                    </a>

                                    {{-- ELIMINAR --}}
                                    <button
                                        type="button"
                                        title="Eliminar categoría"
                                        @click="$dispatch('open-modal', 'delete-{{ $categoria->id }}')"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500 transition duration-200 hover:bg-red-500 hover:text-white">

                                        @php($icon = 'trash')
                                        @include('layouts.partials.icons')
                                    </button>

                                </div>

                            </td>

                        </tr>

                        {{-- MODAL ELIMINAR --}}
                        <x-modal
                            name="delete-{{ $categoria->id }}"
                            title="Eliminar registro"
                            maxWidth="sm">

                            <div class="text-center">

                                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                                    @php($icon = 'exclamation-triangle')
                                    @include('layouts.partials.icons')
                                </div>

                                <p class="text-sm leading-6 text-gray-500">

                                    ¿Seguro que deseas eliminar la categoría

                                    <strong class="text-gray-800">
                                        {{ $categoria->nombre }}
                                    </strong>?

                                    <br>

                                    Esta acción no se puede deshacer.

                                </p>

                            </div>

                            <x-slot:footer>

                                <x-button
                                    variant="secondary"
                                    @click="show = false">

                                    Cancelar

                                </x-button>

                                <form
                                    action="{{ route('categorias.destroy', $categoria->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <x-button
                                        variant="danger"
                                        type="submit">

                                        Eliminar

                                    </x-button>

                                </form>

                            </x-slot:footer>

                        </x-modal>

                    @empty

                        {{-- ESTADO VACÍO --}}
                        <tr>

                            <td colspan="3">

                                <div class="px-6 py-16 text-center">

                                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#4DB6E8]/10 text-[#4DB6E8]">
                                        @php($icon = 'tag')
                                        @include('layouts.partials.icons')
                                    </div>

                                    @if (request('buscar'))

                                        <h3 class="text-lg font-semibold text-gray-800">
                                            No se encontraron resultados
                                        </h3>

                                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                                            No hay categorías que coincidan con «{{ request('buscar') }}».
                                        </p>

                                    @else

                                        <h3 class="text-lg font-semibold text-gray-800">
                                            No hay categorías registradas
                                        </h3>

                                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                                            Todavía no existen categorías laborales registradas en el sistema.
                                        </p>

                                        <a
                                            href="{{ route('categorias.create') }}"
                                            class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#333333]">

                                            @php($icon = 'plus')
                                            @include('layouts.partials.icons')

                                            Nueva categoría
                                        </a>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- CONTADOR + PAGINADO + MARCA --}}
    @include('layouts.partials.paginacion', [
        'paginador' => $categorias,
        'singular'  => 'categoría registrada',
        'plural'    => 'categorías registradas',
    ])

</div>

@endsection
