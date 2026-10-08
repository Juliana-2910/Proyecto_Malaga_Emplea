
@extends('layouts.app')

@section('title', 'Empresas')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen bg-gray-100 py-8">

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Encabezado --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">
                Empresas
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Administración de empresas registradas
            </p>

        </div>

        <a href="{{ route('empresas.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#333333]">

            @php($icon = 'plus')
            @include('layouts.partials.icons')

            Nueva Empresa

        </a>

    </div>


    {{-- Contenedor principal --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-[0_10px_35px_rgba(77,182,232,0.12)] sm:p-6">

        {{-- Encabezado de sección --}}
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-lg font-semibold text-gray-800">
                    Registradas
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Consulta la información de las empresas registradas.
                </p>

            </div>

            @if ($empresas->count() > 0)

                <div class="inline-flex w-fit items-center gap-2 rounded-full bg-[#4DB6E8]/10 px-3 py-1.5 text-xs font-semibold text-[#3199CC]">

                    <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

                    {{ $empresas->count() }}

                    {{ $empresas->count() == 1 ? 'registro' : 'registros' }}

                </div>

            @endif

        </div>


        {{-- Tarjetas --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

            @forelse ($empresas as $empresa)

                <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:border-[#4DB6E8]/40 hover:shadow-[0_8px_25px_rgba(77,182,232,0.12)]">


                    {{-- Encabezado de tarjeta --}}
                    <div class="border-b border-gray-100 bg-gradient-to-r from-[#4DB6E8]/5 to-white px-4 py-4">

                        <div class="flex items-center gap-3">


                            {{-- Foto de empresa --}}
                            <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-white bg-[#4DB6E8]/10 text-[#4DB6E8] shadow-sm">

                                @if (!empty($empresa->fotoPerfil))

                                    <img
                                        src="{{ asset('storage/empresas/' . $empresa->fotoPerfil) }}"
                                        alt="Foto de {{ $empresa->nombreEmpresa }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    @php($icon = 'building-office-2')
                                    @include('layouts.partials.icons')

                                @endif

                            </div>


                            {{-- Nombre de empresa --}}
                            <div class="min-w-0 flex-1">

                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#4DB6E8]">
                                    Empresa
                                </p>

                                <h3 class="mt-1 truncate text-base font-bold text-gray-800">
                                    {{ $empresa->nombreEmpresa }}
                                </h3>

                            </div>


                            {{-- ID --}}
                            <span class="self-start rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">

                                #{{ $empresa->id }}

                            </span>

                        </div>

                    </div>


                    {{-- Datos de la empresa --}}
                    <div class="flex-1 px-5 py-5">

                        <div class="grid grid-cols-1 gap-x-5 gap-y-4 sm:grid-cols-2">


                            {{-- NIT --}}
                            <div>

                                <p class="text-xs font-medium text-gray-400">
                                    NIT
                                </p>

                                <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                    {{ $empresa->nit }}
                                </p>

                            </div>


                            {{-- Dirección --}}
                            <div>

                                <p class="text-xs font-medium text-gray-400">
                                    Dirección
                                </p>

                                <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                    {{ $empresa->direccion }}
                                </p>

                            </div>


                            {{-- Correo electrónico --}}
                            <div>

                                <p class="text-xs font-medium text-gray-400">
                                    Correo electrónico
                                </p>

                                <p class="mt-1 break-all text-sm font-medium text-gray-700">
                                    {{ $empresa->correoElectronico }}
                                </p>

                            </div>


                            {{-- Fecha de registro --}}
                            <div>

                                <p class="text-xs font-medium text-gray-400">
                                    Fecha de registro
                                </p>

                                <p class="mt-1 text-sm font-medium text-gray-700">
                                    {{ $empresa->created_at ? $empresa->created_at->format('d/m/Y') : 'No registrada' }}
                                </p>

                            </div>

                        </div>


                        {{-- Estado --}}
                        <div class="mt-5 border-t border-gray-100 pt-4">

                            <p class="mb-2 text-xs font-medium text-gray-400">
                                Estado
                            </p>

                            @if ($empresa->estado === 'activo')

                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Activo
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Inactivo
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- ACCIONES --}}
                    <div class="flex justify-end border-t border-gray-100 bg-gray-50/60 px-4 py-3">

                        <div class="flex items-center justify-center gap-2">


                            {{-- EDITAR --}}
                            <a
                                href="{{ route('empresas.edit', $empresa->id) }}"
                                title="Editar empresa"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-[#4DB6E8]/10 px-3 py-2 text-xs font-semibold text-[#4DB6E8] transition duration-200 hover:bg-[#4DB6E8] hover:text-white">

                                @php($icon = 'pencil')
                                @include('layouts.partials.icons')

                                <span>Editar</span>

                            </a>


                            {{-- ELIMINAR --}}
                            <button
                                type="button"
                                title="Eliminar empresa"
                                @click="$dispatch('open-modal', 'delete-{{ $empresa->id }}')"
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
                    name="delete-{{ $empresa->id }}"
                    title="Eliminar empresa"
                    maxWidth="sm"
                >

                    <div class="text-center">

                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">

                            @php($icon = 'exclamation-triangle')
                            @include('layouts.partials.icons')

                        </div>

                        <p class="text-sm leading-6 text-gray-500">

                            ¿Seguro que deseas eliminar la empresa de

                            <strong class="text-gray-800">
                                {{ $empresa->nombreEmpresa }}
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
                            action="{{ route('empresas.destroy', $empresa->id) }}"
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

                        @php($icon = 'building')
                        @include('layouts.partials.icons')

                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        No hay empresas registradas
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                        Aún no se han registrado empresas en Málaga Emplea.
                    </p>

                    <a href="{{ route('empresas.create') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#333333]">

                        @php($icon = 'plus')
                        @include('layouts.partials.icons')

                        Registrar Empresa

                    </a>

                </div>

            @endforelse

        </div>


        {{-- Contador --}}
        @if ($empresas->count() > 0)

            <div class="mt-6 border-t border-gray-100 pt-4">

                <p class="text-sm text-gray-500">

                    Mostrando

                    <span class="font-semibold text-gray-700">
                        {{ $empresas->count() }}
                    </span>

                    {{ $empresas->count() == 1 ? 'empresa' : 'empresas' }}
                    registrada(s).

                </p>

            </div>

        @endif

    </div>

</div>
```

</div>

@endsection
