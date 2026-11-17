
@extends('layouts.app')

@section('title', 'Hoja de Vida')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen py-8">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ENCABEZADO --}}
        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 sm:text-3xl">
                    Hoja de Vida
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Administración de hojas de vida de los usuarios
                </p>
            </div>

        </div>


        {{-- BUSCADOR --}}
        <form method="GET" action="{{ route('hojaDeVida.index') }}"
            class="mb-6 flex w-full flex-wrap items-center gap-3">

            <div class="flex h-11 w-2/3 items-center gap-2.5 rounded-full border border-gray-200 bg-white pl-4 pr-1.5 shadow-sm transition focus-within:border-[#4DB6E8] focus-within:ring-[3px] focus-within:ring-[#4DB6E8]/25">

                @php($icon = 'magnifying-glass')
                @include('layouts.partials.icons')

                <input type="text" name="buscar" value="{{ request('buscar') }}" maxlength="100" autocomplete="off"
                    placeholder="Buscar por nombre, ubicación, nivel educativo o perfil..."
                    class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-0">

                <button type="submit"
                    class="h-[34px] shrink-0 rounded-full bg-[#4DB6E8] px-4 text-[13px] font-semibold text-white transition duration-200 hover:bg-[#333333]">
                    Buscar
                </button>

            </div>

            @if (request('buscar'))
                <a href="{{ route('hojaDeVida.index') }}"
                    class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-gray-500 transition hover:text-gray-800">

                    @php($icon = 'equisfiltros')
                    @include('layouts.partials.icons')

                    Limpiar
                </a>
            @endif

            <a href="{{ route('hojaDeVida.create') }}"
                class="ml-auto inline-flex items-center justify-center gap-2 rounded-full bg-[#4DB6E8] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#333333]">

                @php($icon = 'plus')
                @include('layouts.partials.icons')

                Nueva Hoja de Vida
            </a>

        </form>


        {{-- CONTENEDOR PRINCIPAL --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-[0_10px_35px_rgba(77,182,232,0.12)] sm:p-6">

            {{-- ENCABEZADO DE LA SECCIÓN --}}
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Registradas
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Consulta la información profesional de los usuarios.
                    </p>
                </div>

                @if ($hojaDeVida->total() > 0)

                    <div class="inline-flex w-fit items-center gap-2 rounded-full bg-[#4DB6E8]/10 px-3 py-1.5 text-xs font-semibold text-[#3199CC]">

                        <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

                        {{ $hojaDeVida->total() }}
                        {{ $hojaDeVida->total() == 1 ? 'registro' : 'registros' }}

                    </div>

                @endif

            </div>


            {{-- GRID DE TARJETAS --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

                @forelse ($hojaDeVida as $hoja)

                    {{-- TARJETA --}}
                    <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:border-[#4DB6E8]/40 hover:shadow-[0_8px_25px_rgba(77,182,232,0.12)]">

                        {{-- ENCABEZADO DE LA TARJETA --}}
                        <div class="border-b border-gray-100 bg-gradient-to-r from-[#4DB6E8]/5 to-white px-4 py-4">

                            <div class="flex items-center gap-3">

                                {{-- Foto de perfil --}}
                                <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-white bg-[#4DB6E8]/10 text-[#4DB6E8] shadow-sm">

                                    @if (!empty($hoja->usuario?->fotoPerfil))

                                        <img
                                            src="{{ asset('storage/' . $hoja->usuario->fotoPerfil) }}"
                                            alt="Foto de {{ $hoja->usuario->nombres }} {{ $hoja->usuario->apellidos }}"
                                            class="h-full w-full object-cover">

                                    @else

                                        @php($icon = 'user-circle')
                                        @include('layouts.partials.icons')

                                    @endif

                                </div>


                                {{-- Nombre del usuario --}}
                                <div class="min-w-0 flex-1">

                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#4DB6E8]">
                                        Hoja de vida
                                    </p>

                                    <h3 class="mt-1 truncate text-base font-bold text-gray-800">
                                        {{ $hoja->usuario?->nombres }}
                                    </h3>

                                    <h3 class="mt-1 truncate text-base font-bold text-gray-800">
                                        {{ $hoja->usuario?->apellidos }}
                                    </h3>

                                </div>


                                {{-- ID --}}
                                <span class="self-start rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    #{{ $hoja->id }}
                                </span>

                            </div>

                        </div>


                        {{-- INFORMACIÓN DE LA TARJETA --}}
                        <div class="flex-1 px-5 py-5">

                            <div class="grid grid-cols-1 gap-x-5 gap-y-4 sm:grid-cols-2">

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Ubicación</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        {{ $hoja->ubicacion }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Nivel educativo</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        {{ $hoja->nivelEducativo }}
                                    </p>
                                </div>

                            </div>


                            {{-- PERFIL PERSONAL (cajón) --}}
                            <div class="mt-4">

                                <p class="mb-1 text-xs font-medium text-gray-400">Perfil personal</p>

                                <div class="max-h-24 overflow-y-auto rounded-lg bg-gray-50 px-3 py-2">
                                    <p class="break-words text-xs leading-5 text-gray-700">
                                        {{ $hoja->perfilProfesional }}
                                    </p>
                                </div>

                            </div>


                            {{-- EXPERIENCIA LABORAL (cajón) --}}
                            <div class="mt-4">

                                <p class="mb-1 text-xs font-medium text-gray-400">Experiencia laboral</p>

                                <div class="max-h-24 overflow-y-auto rounded-lg bg-gray-50 px-3 py-2">
                                    <p class="break-words text-xs leading-5 text-gray-700">
                                        {{ $hoja->experienciaLaboral }}
                                    </p>
                                </div>

                            </div>

                            {{-- FECHA DE ACTUALIZACIÓN + ARCHIVO CV --}}
                            <div class="mt-4 grid grid-cols-1 gap-x-5 gap-y-4 sm:grid-cols-2">

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Fecha de actualización</p>
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        {{ $hoja->fechaActualizacion ? \Carbon\Carbon::parse($hoja->fechaActualizacion)->format('d/m/Y') : '—' }}
                                    </p>
                                </div>

                                {{-- ARCHIVO CV (ojito) --}}
                                <div>
                                    <p class="text-xs font-medium text-gray-400">Archivo CV</p>

                                    <div class="mt-1">

                                        @if (!empty($hoja->archivoCV))

                                            <a
                                                href="{{ asset('storage/' . $hoja->archivoCV) }}"
                                                target="_blank"
                                                title="Ver hoja de vida"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#4DB6E8]/10 text-[#4DB6E8] transition duration-200 hover:bg-[#4DB6E8] hover:text-white">

                                                @php($icon = 'eye')
                                                @include('layouts.partials.icons')

                                            </a>

                                        @else

                                            <p class="text-sm font-medium text-gray-700">Sin archivo</p>

                                        @endif

                                    </div>
                                </div>

                            </div>

                        </div>


                        {{-- ACCIONES --}}
                        <div class="flex justify-end border-t border-gray-100 bg-gray-50/60 px-4 py-3">

                            <div class="flex items-center gap-2">

                                {{-- EDITAR --}}
                                <a
                                    href="{{ route('hojaDeVida.edit', $hoja->id) }}"
                                    title="Editar hoja de vida"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#4DB6E8]/10 px-3 py-2 text-xs font-semibold text-[#4DB6E8] transition duration-200 hover:bg-[#4DB6E8] hover:text-white">

                                    @php($icon = 'pencil')
                                    @include('layouts.partials.icons')

                                    <span>Editar</span>

                                </a>

                                {{-- ELIMINAR --}}
                                <button
                                    type="button"
                                    title="Eliminar hoja de vida"
                                    @click="$dispatch('open-modal', 'delete-{{ $hoja->id }}')"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-500 transition duration-200 hover:bg-red-500 hover:text-white">

                                    @php($icon = 'trash')
                                    @include('layouts.partials.icons')

                                    <span>Eliminar</span>

                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- MODAL ELIMINAR --}}
                    <x-modal
                        name="delete-{{ $hoja->id }}"
                        title="Eliminar hoja de vida"
                        maxWidth="sm">

                        <div class="text-center">

                            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                                @php($icon = 'exclamation-triangle')
                                @include('layouts.partials.icons')
                            </div>

                            <p class="text-sm leading-6 text-gray-500">

                                ¿Seguro que deseas eliminar la hoja de vida de

                                <strong class="text-gray-800">
                                    {{ $hoja->usuario?->nombres }}
                                    {{ $hoja->usuario?->apellidos }}
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
                                action="{{ route('hojaDeVida.destroy', $hoja->id) }}"
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
                    <div class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-14 text-center">

                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#4DB6E8]/10 text-[#4DB6E8]">
                            @php($icon = 'link')
                            @include('layouts.partials.icons')
                        </div>

                        @if (request('buscar'))

                            <h3 class="text-lg font-semibold text-gray-800">
                                No se encontraron resultados
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                                No hay hojas de vida que coincidan con «{{ request('buscar') }}».
                            </p>

                        @else

                            <h3 class="text-lg font-semibold text-gray-800">
                                No hay hojas de vida registradas
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                                Todavía no existen hojas de vida registradas en el sistema.
                            </p>

                            <a href="{{ route('hojaDeVida.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#333333]">

                                @php($icon = 'plus')
                                @include('layouts.partials.icons')

                                Registrar Hoja de Vida
                            </a>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>


        {{-- CONTADOR + PAGINADO + MARCA --}}
        @include('layouts.partials.paginacion', [
            'paginador' => $hojaDeVida,
            'singular'  => 'hoja de vida registrada',
            'plural'    => 'hojas de vida registradas',
        ])

    </div>

</div>

@endsection
