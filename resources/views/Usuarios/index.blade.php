
@extends('layouts.app')

@section('title', 'Usuarios')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen py-8">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ENCABEZADO --}}
        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 sm:text-3xl">
                    Usuarios
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Administración de usuarios registrados
                </p>
            </div>

        </div>

        {{-- BUSCADOR --}}
        <form method="GET" action="{{ route('usuarios.index') }}"
            class="mb-6 flex w-full flex-wrap items-center gap-3">

            <div class="flex h-11 w-3/4 items-center gap-2.5 rounded-full border border-gray-200 bg-white pl-4 pr-1.5 shadow-sm transition focus-within:border-[#4DB6E8] focus-within:ring-[3px] focus-within:ring-[#4DB6E8]/25">

                @php($icon = 'magnifying-glass')
                @include('layouts.partials.icons')

                <input type="text" name="buscar" value="{{ request('buscar') }}" maxlength="100" autocomplete="off"
                    placeholder="Buscar por nombre, documento o correo..."
                    class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-0">

                <button type="submit"
                    class="h-[34px] shrink-0 rounded-full bg-[#4DB6E8] px-4 text-[13px] font-semibold text-white transition duration-200 hover:bg-[#333333]">
                    Buscar
                </button>

            </div>

            @if (request('buscar'))
                <a href="{{ route('usuarios.index') }}"
                    class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-gray-500 transition hover:text-gray-800">

                    @php($icon = 'equisfiltros')
                    @include('layouts.partials.icons')

                    Limpiar
                </a>
            @endif

            <a href="{{ route('usuarios.create') }}"
                class="ml-auto inline-flex items-center justify-center gap-2 rounded-full bg-[#4DB6E8] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#333333]">

                @php($icon = 'plus')
                @include('layouts.partials.icons')

                Nuevo Usuario
            </a>

        </form>


        {{-- CONTENEDOR PRINCIPAL --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-[0_10px_35px_rgba(77,182,232,0.12)] sm:p-6">

            {{-- Encabezado de sección --}}
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Registrados
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Consulta la información de los usuarios registrados.
                    </p>
                </div>

                @if ($usuarios->total() > 0)

                    <div class="inline-flex w-fit items-center gap-2 rounded-full bg-[#4DB6E8]/10 px-3 py-1.5 text-xs font-semibold text-[#3199CC]">

                        <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

                        {{ $usuarios->total() }}
                        {{ $usuarios->total() == 1 ? 'registro' : 'registros' }}

                    </div>

                @endif

            </div>


            {{-- Tarjetas --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

                @forelse ($usuarios as $usuario)

                    <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:border-[#4DB6E8]/40 hover:shadow-[0_8px_25px_rgba(77,182,232,0.12)]">

                        {{-- Encabezado de tarjeta --}}
                        <div class="border-b border-gray-100 bg-gradient-to-r from-[#4DB6E8]/5 to-white px-4 py-4">

                            <div class="flex items-center gap-3">

                                {{-- Foto de perfil --}}
                                <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-white bg-[#4DB6E8]/10 text-[#4DB6E8] shadow-sm">

                                    @if (!empty($usuario->fotoPerfil))

                                        <img
                                            src="{{ asset('storage/' . $usuario->fotoPerfil) }}"
                                            alt="Foto de {{ $usuario->nombres }} {{ $usuario->apellidos }}"
                                            class="h-full w-full object-cover">

                                    @else

                                        @php($icon = 'user-circle')
                                        @include('layouts.partials.icons')

                                    @endif

                                </div>


                                {{-- Nombre del usuario --}}
                                <div class="min-w-0 flex-1">

                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#4DB6E8]">
                                        Usuario
                                    </p>

                                    <h3 class="mt-1 truncate text-base font-bold text-gray-800">
                                        {{ $usuario->nombres }}
                                    </h3>

                                    <h3 class="mt-1 truncate text-base font-bold text-gray-800">
                                        {{ $usuario->apellidos }}
                                    </h3>

                                </div>


                                {{-- ID --}}
                                <span class="self-start rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    #{{ $usuario->id }}
                                </span>

                            </div>

                        </div>


                        {{-- Datos del usuario --}}
                        <div class="flex-1 px-5 py-5">

                            <div class="grid grid-cols-1 gap-x-5 gap-y-4 sm:grid-cols-2">

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Fecha de nacimiento</p>
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        {{ $usuario->fechaNacimiento }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Tipo de documento</p>
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        {{ $usuario->tipoDocumento }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Número de documento</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        {{ $usuario->numeroDocumento }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Correo electrónico</p>
                                    <p class="mt-1 break-all text-sm font-medium text-gray-700">
                                        {{ $usuario->email }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Teléfono</p>
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        {{ $usuario->telefono ?: 'No registrado' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Fecha de registro</p>
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        {{ $usuario->fechaRegistro ? \Carbon\Carbon::parse($usuario->fechaRegistro)->format('d/m/Y') : '—' }}
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- BOTONES: ESTADO (izquierda) + ACCIONES (derecha) --}}
                        <div class="flex items-center justify-between gap-3 border-t border-gray-100 bg-gray-50/60 px-4 py-3">

                            {{-- Estado --}}
                            @if (strtolower($usuario->estado) === 'activo')

                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Activo
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Inactivo
                                </span>

                            @endif


                            {{-- Botones --}}
                            <div class="flex items-center gap-2">

                                {{-- EDITAR --}}
                                <a
                                    href="{{ route('usuarios.edit', $usuario->id) }}"
                                    title="Editar usuario"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#4DB6E8]/10 px-3 py-2 text-xs font-semibold text-[#4DB6E8] transition duration-200 hover:bg-[#4DB6E8] hover:text-white">

                                    @php($icon = 'pencil')
                                    @include('layouts.partials.icons')

                                    <span>Editar</span>

                                </a>

                                {{-- ELIMINAR --}}
                                <button
                                    type="button"
                                    title="Eliminar usuario"
                                    @click="$dispatch('open-modal', 'delete-{{ $usuario->id }}')"
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
                        name="delete-{{ $usuario->id }}"
                        title="Eliminar usuario"
                        maxWidth="sm">

                        <div class="text-center">

                            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                                @php($icon = 'exclamation-triangle')
                                @include('layouts.partials.icons')
                            </div>

                            <p class="text-sm leading-6 text-gray-500">

                                ¿Seguro que deseas eliminar el usuario de

                                <strong class="text-gray-800">
                                    {{ $usuario->nombres }}
                                    {{ $usuario->apellidos }}
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
                                action="{{ route('usuarios.destroy', $usuario->id) }}"
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
                            @php($icon = 'user-group')
                            @include('layouts.partials.icons')
                        </div>

                        @if (request('buscar'))

                            <h3 class="text-lg font-semibold text-gray-800">
                                No se encontraron resultados
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                                No hay usuarios que coincidan con «{{ request('buscar') }}».
                            </p>

                        @else

                            <h3 class="text-lg font-semibold text-gray-800">
                                No hay usuarios registrados
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                                Aún no se han registrado usuarios en Málaga Emplea.
                            </p>

                            <a href="{{ route('usuarios.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#333333]">

                                @php($icon = 'plus')
                                @include('layouts.partials.icons')

                                Registrar Usuario
                            </a>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>


        {{-- CONTADOR + PAGINADO + MARCA --}}
        @include('layouts.partials.paginacion', [
            'paginador' => $usuarios,
            'singular'  => 'usuario registrado',
            'plural'    => 'usuarios registrados',
        ])

    </div>

</div>

@endsection
