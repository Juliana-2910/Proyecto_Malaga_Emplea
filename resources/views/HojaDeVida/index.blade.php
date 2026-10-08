
@extends('layouts.app')

@section('title', 'Hoja de Vida')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen bg-gray-100 py-8">

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

        <a
            href="{{ route('hojaDeVida.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#333333]">
            @php($icon = 'plus')
            @include('layouts.partials.icons')

            Nueva Hoja de Vida
        </a>

    </div>


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

            @if ($hojaDeVida->count() > 0)

                <div class="inline-flex w-fit items-center gap-2 rounded-full bg-[#4DB6E8]/10 px-3 py-1.5 text-xs font-semibold text-[#3199CC]">

                    <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

                    {{ $hojaDeVida->count() }}
                    {{ $hojaDeVida->count() == 1 ? 'registro' : 'registros' }}

                </div>

            @endif

        </div>


        {{-- GRID DE TARJETAS --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

            @forelse ($hojaDeVida as $hojaDeVida)

                {{-- TARJETA --}}
                <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:border-[#4DB6E8]/40 hover:shadow-[0_8px_25px_rgba(77,182,232,0.12)]">

                    {{-- ENCABEZADO DE LA TARJETA --}}
                    <div class="border-b border-gray-100 bg-gradient-to-r from-[#4DB6E8]/5 to-white px-4 py-4">

                        <div class="flex items-center justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">


                                {{-- Foto de perfil --}}
                                <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-white bg-[#4DB6E8]/10 shadow-sm text-[#4DB6E8]">

                                    @if (!empty($hojaDeVida->usuario->fotoPerfil))

                                        <img
                                            src="{{ asset('storage/' . $hojaDeVida->usuario->fotoPerfil) }}"
                                            alt="Foto de {{ $hojaDeVida->usuario->nombres }} {{ $hojaDeVida->usuario->apellidos }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        @php($icon = 'user-circle')
                                        @include('layouts.partials.icons')

                                    @endif

                                </div>

                                <div class="min-w-0">

                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#4DB6E8]">
                                        Hoja de vida
                                    </p>

                                    <h3 class="mt-1 truncate text-base font-bold text-gray-800">
                                        {{ $hojaDeVida->usuario->nombres }}
                                    </h3>

                                    <h3 class="mt-1 truncate text-base font-bold text-gray-800">
                                        {{ $hojaDeVida->usuario->apellidos }}
                                    </h3>

                                </div>

                            </div>

                            {{-- ID --}}
                            <span class="self-start rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                #{{ $hojaDeVida->id }}
                            </span>

                        </div>

                    </div>


                    {{-- INFORMACIÓN DE LA TARJETA --}}
                    <div class="flex-1 px-4 py-4">

                        <div class="space-y-4">


                            {{-- UBICACIÓN --}}
                            <div>

                                <div class="mb-1 flex items-center gap-2">

                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#4DB6E8]/10 text-[#4DB6E8]">

                                        @php($icon = 'map-pin')
                                        @include('layouts.partials.icons')

                                    </div>

                                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                                        Ubicación
                                    </p>

                                </div>

                                <p class="pl-8 text-xs font-medium text-gray-700">
                                    {{ $hojaDeVida->ubicacion }}
                                </p>

                            </div>


                            {{-- NIVEL EDUCATIVO --}}
                            <div>

                                <div class="mb-1 flex items-center gap-2">

                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#4DB6E8]/10 text-[#4DB6E8]">

                                        @php($icon = 'academic-cap')
                                        @include('layouts.partials.icons')

                                    </div>

                                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                                        Nivel Educativo
                                    </p>

                                </div>

                                <p class="pl-8 text-xs font-medium text-gray-700">
                                    {{ $hojaDeVida->nivelEducativo }}
                                </p>

                            </div>


                            {{-- PERFIL PROFESIONAL --}}
                            <div>

                                <div class="mb-1 flex items-center gap-2">

                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#4DB6E8]/10 text-[#4DB6E8]">

                                        @php($icon = 'briefcase')
                                        @include('layouts.partials.icons')

                                    </div>

                                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                                        Perfil Profesional
                                    </p>

                                </div>

                                    <div class="max-h-24 overflow-y-auto rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-xs leading-5 text-gray-700 break-words">
                                            {{ $hojaDeVida->perfilProfesional }}
                                        </p>
                                    </div>

                            </div>


                            {{-- EXPERIENCIA LABORAL --}}
                            <div>

                                <div class="mb-1 flex items-center gap-2">

                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#4DB6E8]/10 text-[#4DB6E8]">

                                        @php($icon = 'paper-clip')
                                        @include('layouts.partials.icons')

                                    </div>

                                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                                        Experiencia Laboral
                                    </p>

                                </div>

                                <div class="max-h-24 overflow-y-auto rounded-lg bg-gray-50 px-3 py-2">

                                    <p class="text-xs leading-5 text-gray-700 break-words">
                                        {{ $hojaDeVida->experienciaLaboral }}
                                    </p>

                                </div>

                            </div>


                            {{-- FECHA DE ACTUALIZACIÓN --}}
                            <div>

                                <div class="mb-1 flex items-center gap-2">

                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#4DB6E8]/10 text-[#4DB6E8]">

                                        @php($icon = 'calendar-days')
                                        @include('layouts.partials.icons')

                                    </div>

                                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                                        Fecha de Actualización
                                    </p>

                                </div>

                                <p class="pl-8 text-xs font-medium text-gray-700">
                                    {{ $hojaDeVida->fechaActualizacion }}
                                </p>

                            </div>


                            {{-- ARCHIVO CV --}}
                            <div>

                                <div class="mb-1 flex items-center gap-2">

                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#4DB6E8]/10 text-[#4DB6E8]">

                                        @php($icon = 'arrow-down-circle')
                                        @include('layouts.partials.icons')

                                    </div>

                                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-500">
                                        Archivo CV
                                    </p>

                                </div>

                                <div class="pl-8">

                                    <a
                                        href="{{ asset('storage/' . $hojaDeVida->archivoCV) }}"
                                        target="_blank"
                                        title="Ver hoja de vida"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#4DB6E8]/10 text-[#4DB6E8] transition duration-200 hover:bg-[#4DB6E8] hover:text-white">

                                        @php($icon = 'eye')
                                        @include('layouts.partials.icons')

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ACCIONES --}}
                    <div class="flex justify-end border-t border-gray-100 bg-gray-50/60 px-4 py-3">

                        <div class="flex items-center justify-center gap-2">

                            {{-- EDITAR --}}
                            <a
                                href="{{ route('hojaDeVida.edit', $hojaDeVida->id) }}"
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
                                @click="$dispatch('open-modal', 'delete-{{ $hojaDeVida->id }}')"
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
                    name="delete-{{ $hojaDeVida->id }}"
                    title="Eliminar hoja de vida"
                    maxWidth="sm"
                >

                    <div class="text-center">

                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">

                            @php($icon = 'exclamation-triangle')
                            @include('layouts.partials.icons')

                        </div>

                        <p class="text-sm leading-6 text-gray-500">

                            ¿Seguro que deseas eliminar la hoja de vida de

                            <strong class="text-gray-800">
                                {{ $hojaDeVida->usuario->nombres }}
                                {{ $hojaDeVida->usuario->apellidos }}
                            </strong>?

                            <br>

                            Esta acción no se puede deshacer.

                        </p>

                    </div>


                    <x-slot:footer>

                        <x-button
                            variant="secondary"
                            @click="show = false"
                        >
                            Cancelar
                        </x-button>

                        <form
                            action="{{ route('hojaDeVida.destroy', $hojaDeVida->id) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <x-button
                                variant="danger"
                                type="submit"
                            >
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

                    <h3 class="text-lg font-semibold text-gray-800">
                        No hay hojas de vida registradas
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                        Todavía no existen hojas de vida registradas en el sistema.
                    </p>

                    <a
                        href="{{ route('hojaDeVida.create') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#333333]">

                        @php($icon = 'plus')
                        @include('layouts.partials.icons')

                        Registrar Hoja de Vida

                    </a>

                </div>

            @endforelse

        </div>

    </div>


    {{-- CONTADOR --}}
    @if ($hojaDeVida->count() > 0)

        <div class="mt-4 flex items-center justify-between px-1">

            <p class="text-sm text-gray-500">

                Mostrando

                <span class="font-semibold text-gray-800">
                    {{ $hojaDeVida->count() }}
                </span>

                {{ $hojaDeVida->count() == 1
                    ? 'hoja de vida registrada'
                    : 'hojas de vida registradas' }}

            </p>

            <div class="hidden items-center gap-2 text-xs text-gray-400 sm:flex">

                <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

                Málaga Emplea

            </div>

        </div>

    @endif

</div>

</div>

@endsection
