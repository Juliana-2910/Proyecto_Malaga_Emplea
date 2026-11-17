
@extends('layouts.app')

@section('title', 'Calificaciones')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen py-8">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ENCABEZADO --}}
        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 sm:text-3xl">
                    Calificaciones
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Administración de las calificaciones del sistema
                </p>
            </div>

        </div>


        {{-- BUSCADOR --}}
        <form method="GET" action="{{ route('calificacion.index') }}"
            class="mb-6 flex w-full flex-wrap items-center gap-3">

            <div class="flex h-11 w-3/4 items-center gap-2.5 rounded-full border border-gray-200 bg-white pl-4 pr-1.5 shadow-sm transition focus-within:border-[#4DB6E8] focus-within:ring-[3px] focus-within:ring-[#4DB6E8]/25">

                @php($icon = 'magnifying-glass')
                @include('layouts.partials.icons')

                <input type="text" name="buscar" value="{{ request('buscar') }}" maxlength="100" autocomplete="off"
                    placeholder="Buscar por usuario, publicador, oferta o comentario..."
                    class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-0">

                <button type="submit"
                    class="h-[34px] shrink-0 rounded-full bg-[#4DB6E8] px-4 text-[13px] font-semibold text-white transition duration-200 hover:bg-[#333333]">
                    Buscar
                </button>

            </div>

            @if (request('buscar'))
                <a href="{{ route('calificacion.index') }}"
                    class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-gray-500 transition hover:text-gray-800">

                    @php($icon = 'equisfiltros')
                    @include('layouts.partials.icons')

                    Limpiar
                </a>
            @endif

            <a href="{{ route('calificacion.create') }}"
                class="ml-auto inline-flex items-center justify-center gap-2 rounded-full bg-[#4DB6E8] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#333333]">

                @php($icon = 'plus')
                @include('layouts.partials.icons')

                Nueva Calificación
            </a>

        </form>


        {{-- CONTENEDOR PRINCIPAL --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-[0_10px_35px_rgba(77,182,232,0.12)] sm:p-6">

            {{-- Encabezado de sección --}}
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Calificaciones registradas
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Consulta las calificaciones entre usuarios y publicadores.
                    </p>
                </div>

                @if ($calificacion->total() > 0)

                    <div class="inline-flex w-fit items-center gap-2 rounded-full bg-[#4DB6E8]/10 px-3 py-1.5 text-xs font-semibold text-[#3199CC]">

                        <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

                        {{ $calificacion->total() }}
                        {{ $calificacion->total() == 1 ? 'registro' : 'registros' }}

                    </div>

                @endif

            </div>


            {{-- Tarjetas --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

                @forelse ($calificacion as $cal)

                    <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:border-[#4DB6E8]/40 hover:shadow-[0_8px_25px_rgba(77,182,232,0.12)]">

                        {{-- Encabezado de tarjeta --}}
                        <div class="border-b border-gray-100 bg-gradient-to-r from-[#4DB6E8]/5 to-white px-4 py-4">

                            <div class="flex items-center gap-3">

                                {{-- Ícono --}}
                                <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full border-2 border-white bg-[#4DB6E8]/10 text-[#4DB6E8] shadow-sm">

                                    @php($icon = 'star')
                                    @include('layouts.partials.icons')

                                </div>


                                {{-- Puntuación --}}
                                <div class="min-w-0 flex-1">

                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#4DB6E8]">
                                        Usuario
                                    </p>

                                    <div>
                                        <p class="mt-1 line-clamp-2 break-words text-base font-bold text-gray-800">
                                            @if ($cal->postulacion?->usuario)
                                                {{ $cal->postulacion->usuario->nombres }}
                                                {{ $cal->postulacion->usuario->apellidos }}
                                            @else
                                                Sin usuario
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-1 flex flex-wrap items-center gap-x-1">

                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="text-lg leading-none {{ $i <= $cal->puntuacion ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor

                                        <span class="ml-1 text-sm text-gray-500">
                                            ({{ $cal->puntuacion }}/5)
                                        </span>

                                    </div>

                                </div>


                                {{-- ID --}}
                                <span class="self-start rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    #{{ $cal->id }}
                                </span>

                            </div>

                        </div>


                        {{-- Datos de la calificación --}}
                        <div class="flex-1 px-5 py-5">

                            <div class="grid grid-cols-1 gap-x-5 gap-y-4 sm:grid-cols-2">

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Publicador</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        @if ($cal->postulacion?->oferta?->empresa)
                                            {{ $cal->postulacion->oferta->empresa->nombreEmpresa }}
                                        @elseif ($cal->postulacion?->oferta?->usuario)
                                            {{ $cal->postulacion->oferta->usuario->nombres }}
                                            {{ $cal->postulacion->oferta->usuario->apellidos }}
                                        @else
                                            Sin publicador
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Oferta</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        {{ $cal->postulacion?->oferta?->titulo ?? 'Sin oferta' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Quién califica</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        @if ($cal->tipoCalificador === 'usuario')
                                            Usuario califica al publicador
                                        @elseif ($cal->tipoCalificador === 'empresa')
                                            Publicador califica al usuario
                                        @else
                                            Sin especificar
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Fecha</p>
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        {{ $cal->fecha ? \Carbon\Carbon::parse($cal->fecha)->format('d/m/Y') : '—' }}
                                    </p>
                                </div>

                            </div>


                            {{-- COMENTARIO (cajón) --}}
                            <div class="mt-4">

                                <p class="mb-1 text-xs font-medium text-gray-400">Comentario</p>

                                <div class="max-h-24 overflow-y-auto rounded-lg bg-gray-50 px-3 py-2">
                                    <p class="break-words text-xs leading-5 text-gray-700">
                                        {{ $cal->comentario ?: 'Sin comentario' }}
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- ACCIONES --}}
                        <div class="flex justify-end border-t border-gray-100 bg-gray-50/60 px-4 py-3">

                            <div class="flex items-center gap-2">

                                {{-- EDITAR --}}
                                <a
                                    href="{{ route('calificacion.edit', $cal->id) }}"
                                    title="Editar calificación"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#4DB6E8]/10 px-3 py-2 text-xs font-semibold text-[#4DB6E8] transition duration-200 hover:bg-[#4DB6E8] hover:text-white">

                                    @php($icon = 'pencil')
                                    @include('layouts.partials.icons')

                                    <span>Editar</span>

                                </a>

                                {{-- ELIMINAR --}}
                                <button
                                    type="button"
                                    title="Eliminar calificación"
                                    @click="$dispatch('open-modal', 'delete-{{ $cal->id }}')"
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
                        name="delete-{{ $cal->id }}"
                        title="Eliminar calificación"
                        maxWidth="sm">

                        <div class="text-center">

                            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                                @php($icon = 'exclamation-triangle')
                                @include('layouts.partials.icons')
                            </div>

                            <p class="text-sm leading-6 text-gray-500">

                                ¿Seguro que deseas eliminar la calificación que recibió:

                                <strong class="text-gray-800">
                                    @if ($cal->tipoCalificador === 'usuario')

                                        {{ $cal->empresaCalificada->nombreEmpresa
                                            ?? (
                                                ($cal->usuarioCalificado->nombres ?? '') . ' ' .
                                                ($cal->usuarioCalificado->apellidos ?? '')
                                            )
                                        }}

                                    @else

                                        {{ ($cal->usuarioCalificado->nombres ?? '') . ' ' .
                                        ($cal->usuarioCalificado->apellidos ?? '') }}

                                    @endif
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
                                action="{{ route('calificacion.destroy', $cal->id) }}"
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
                            @php($icon = 'star')
                            @include('layouts.partials.icons')
                        </div>

                        @if (request('buscar'))

                            <h3 class="text-lg font-semibold text-gray-800">
                                No se encontraron resultados
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                                No hay calificaciones que coincidan con «{{ request('buscar') }}».
                            </p>

                        @else

                            <h3 class="text-lg font-semibold text-gray-800">
                                No hay calificaciones registradas
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                                Todavía no existen calificaciones registradas en el sistema.
                            </p>

                            <a href="{{ route('calificacion.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#333333]">

                                @php($icon = 'plus')
                                @include('layouts.partials.icons')

                                Nueva Calificación
                            </a>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>


        {{-- CONTADOR + PAGINADO + MARCA --}}
        @include('layouts.partials.paginacion', [
            'paginador' => $calificacion,
            'singular'  => 'calificación registrada',
            'plural'    => 'calificaciones registradas',
        ])

    </div>

</div>

@endsection
