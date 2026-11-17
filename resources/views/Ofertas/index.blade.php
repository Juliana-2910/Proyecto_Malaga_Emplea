@extends('layouts.app')

@section('title', 'Ofertas')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen py-8">

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-800 sm:text-3xl">
                Ofertas
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Administración de ofertas laborales del sistema
            </p>
        </div>

    </div>


        {{-- BUSCADOR --}}
        <form method="GET" action="{{ route('ofertas.index') }}"
            class="mb-6 flex w-full flex-wrap items-center gap-3">

            <div class="flex h-11 w-3/4 items-center gap-2.5 rounded-full border border-gray-200 bg-white pl-4 pr-1.5 shadow-sm transition focus-within:border-[#4DB6E8] focus-within:ring-[3px] focus-within:ring-[#4DB6E8]/25">

                @php($icon = 'magnifying-glass')
                @include('layouts.partials.icons')

                <input type="text" name="buscar" value="{{ request('buscar') }}" maxlength="100" autocomplete="off"
                    placeholder="Buscar por título, ubicación, contrato o publicador..."
                    class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-0">

                <button type="submit"
                    class="h-[34px] shrink-0 rounded-full bg-[#4DB6E8] px-4 text-[13px] font-semibold text-white transition duration-200 hover:bg-[#333333]">
                    Buscar
                </button>

            </div>

            @if (request('buscar'))
                <a href="{{ route('ofertas.index') }}"
                    class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-gray-500 transition hover:text-gray-800">

                    @php($icon = 'equisfiltros')
                    @include('layouts.partials.icons')

                    Limpiar
                </a>
            @endif

            <a href="{{ route('ofertas.create') }}"
                class="ml-auto inline-flex items-center justify-center gap-2 rounded-full bg-[#4DB6E8] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#333333]">

                @php($icon = 'plus')
                @include('layouts.partials.icons')

                Nueva Oferta
            </a>

        </form>


        {{-- CONTENEDOR PRINCIPAL --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-[0_10px_35px_rgba(77,182,232,0.12)] sm:p-6">

            {{-- Encabezado de sección --}}
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Ofertas registradas
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Consulta la información de las ofertas laborales publicadas.
                    </p>
                </div>

                @if ($ofertas->total() > 0)

                    <div class="inline-flex w-fit items-center gap-2 rounded-full bg-[#4DB6E8]/10 px-3 py-1.5 text-xs font-semibold text-[#3199CC]">

                        <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

                        {{ $ofertas->total() }}
                        {{ $ofertas->total() == 1 ? 'registro' : 'registros' }}

                    </div>

                @endif

            </div>


            {{-- Tarjetas --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

                @forelse ($ofertas as $oferta)

                    @php($vencida = \Carbon\Carbon::parse($oferta->fechaLimite)->toDateString() < now('America/Bogota')->toDateString())

                    <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:border-[#4DB6E8]/40 hover:shadow-[0_8px_25px_rgba(77,182,232,0.12)]">

                        {{-- Encabezado de tarjeta --}}
                        <div class="border-b border-gray-100 bg-gradient-to-r from-[#4DB6E8]/5 to-white px-4 py-4">

                            <div class="flex items-center gap-3">

                                {{-- Ícono de la oferta --}}
                                <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full border-2 border-white bg-[#4DB6E8]/10 text-[#4DB6E8] shadow-sm">

                                    @php($icon = 'briefcase')
                                    @include('layouts.partials.icons')

                                </div>


                                {{-- Título --}}
                                <div class="min-w-0 flex-1">

                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#4DB6E8]">
                                        Oferta
                                    </p>

                                    <h3 class="mt-1 line-clamp-2 break-words text-base font-bold text-gray-800">
                                        {{ $oferta->titulo }}
                                    </h3>

                                </div>


                                {{-- ID + tipo de publicador --}}
                                <div class="flex flex-shrink-0 items-center gap-1.5 self-start">

                                    @if ($oferta->idEmpresa)
                                        <span class="rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-600">
                                            Empresa
                                        </span>
                                    @else
                                        <span class="rounded-full bg-violet-50 px-2 py-0.5 text-[10px] font-semibold text-violet-600">
                                            Persona natural
                                        </span>
                                    @endif

                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                        #{{ $oferta->id }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- Datos de la oferta --}}
                        <div class="flex-1 px-5 py-5">

                            <div class="grid grid-cols-1 gap-x-5 gap-y-4 sm:grid-cols-2">

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Salario</p>
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        ${{ number_format($oferta->salario, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Tipo de contrato</p>
                                    <p class="mt-1 text-sm font-medium capitalize text-gray-700">
                                        {{ $oferta->tipoContrato }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Ubicación</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        {{ $oferta->ubicacion }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Publicado por</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        @if ($oferta->idEmpresa)
                                            {{ $oferta->empresa->nombreEmpresa ?? 'Empresa no disponible' }}
                                        @elseif ($oferta->usuario)
                                            {{ $oferta->usuario->nombres }} {{ $oferta->usuario->apellidos }}
                                        @else
                                            —
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Fecha límite</p>
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        {{ \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium text-gray-400">Teléfono</p>
                                    <p class="mt-1 break-words text-sm font-medium text-gray-700">
                                        {{ $oferta->usuario?->telefono ?: 'No registrado' }}
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- PIE: VIGENCIA (izquierda) + ACCIONES (derecha) --}}
                        <div class="flex items-center justify-between gap-3 border-t border-gray-100 bg-gray-50/60 px-4 py-3">

                            {{-- Activa / Vencida --}}
                            @if ($vencida)

                                <span class="inline-flex items-center rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-700">
                                    Vencida
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Activa
                                </span>

                            @endif


                            {{-- Botones --}}
                            <div class="flex items-center gap-2">

                                {{-- EDITAR --}}
                                <a
                                    href="{{ route('ofertas.edit', $oferta->id) }}"
                                    title="Editar oferta"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#4DB6E8]/10 px-3 py-2 text-xs font-semibold text-[#4DB6E8] transition duration-200 hover:bg-[#4DB6E8] hover:text-white">

                                    @php($icon = 'pencil')
                                    @include('layouts.partials.icons')

                                    <span>Editar</span>

                                </a>

                                {{-- ELIMINAR --}}
                                <button
                                    type="button"
                                    title="Eliminar oferta"
                                    @click="$dispatch('open-modal', 'delete-{{ $oferta->id }}')"
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
                        name="delete-{{ $oferta->id }}"
                        title="Eliminar oferta"
                        maxWidth="sm">

                        <div class="text-center">

                            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                                @php($icon = 'exclamation-triangle')
                                @include('layouts.partials.icons')
                            </div>

                            <p class="text-sm leading-6 text-gray-500">

                                ¿Seguro que deseas eliminar la oferta

                                <strong class="text-gray-800">
                                    {{ $oferta->titulo }}
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
                                action="{{ route('ofertas.destroy', $oferta->id) }}"
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
                            @php($icon = 'briefcase')
                            @include('layouts.partials.icons')
                        </div>

                        @if (request('buscar'))

                            <h3 class="text-lg font-semibold text-gray-800">
                                No se encontraron resultados
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                                No hay ofertas que coincidan con «{{ request('buscar') }}».
                            </p>

                        @else

                            <h3 class="text-lg font-semibold text-gray-800">
                                No hay ofertas laborales registradas
                            </h3>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                                Todavía no existen ofertas laborales registradas en el sistema.
                            </p>

                            <a href="{{ route('ofertas.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#333333]">

                                @php($icon = 'plus')
                                @include('layouts.partials.icons')

                                Registrar Oferta
                            </a>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>


        {{-- CONTADOR + PAGINADO + MARCA --}}
        @include('layouts.partials.paginacion', [
            'paginador' => $ofertas,
            'singular'  => 'oferta laboral registrada',
            'plural'    => 'ofertas laborales registradas',
        ])
    </div>
    
</div>

@endsection
