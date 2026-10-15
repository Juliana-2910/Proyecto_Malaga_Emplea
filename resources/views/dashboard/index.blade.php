
@extends('layouts.app')

@section('title', 'Inicio')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="space-y-6">

    {{-- ENCABEZADO DEL DASHBOARD --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>

            <h1 class="text-2xl sm:text-3xl font-semibold text-[#4DB6E8]">
                Bienvenido a Málaga Emplea
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Consulta el estado de las oportunidades y servicios de la plataforma.
            </p>

        </div>

        {{-- FECHA --}}

        <div class="bg-white border border-gray-100 rounded-2xl px-5 py-3 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#4DB6E8]">

                    @php($icon = 'calendar-days')
                    @include('layouts.partials.icons')

                </div>

                <div>

                    <p class="text-xs text-gray-400">
                        Fecha actual
                    </p>

                    <p class="text-sm font-semibold text-gray-700">
                        {{ now('America/Bogota')->locale('es')->translatedFormat('d \d\e F \d\e Y') }}
                    </p>

                </div>

            </div>

        </div>

    </div>



    {{--INDICADORES PRINCIPALES --}}

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

        <div class="grid grid-cols-2 lg:grid-cols-4">


            {{-- USUARIOS --}}

            <div class="p-5 sm:p-6 border-b lg:border-b-0 lg:border-r border-gray-100">

                <div class="flex items-center gap-3 mb-3">

                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#4DB6E8]">

                        @php($icon = 'user-group')
                        @include('layouts.partials.icons')

                    </div>

                    <span class="text-sm text-gray-500">
                        Usuarios
                    </span>

                </div>

                <p class="text-2xl sm:text-3xl font-semibold text-gray-800">
                    {{ $totalUsers }}
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    Personas registradas
                </p>

            </div>



            {{-- EMPRESAS --}}

            <div class="p-5 sm:p-6 border-b lg:border-b-0 lg:border-r border-gray-100">

                <div class="flex items-center gap-3 mb-3">

                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-500">

                        @php($icon = 'building')
                        @include('layouts.partials.icons')

                    </div>

                    <span class="text-sm text-gray-500">
                        Empresas
                    </span>

                </div>

                <p class="text-2xl sm:text-3xl font-semibold text-gray-800">
                    {{ $totalCompanies }}
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    Empresas registradas
                </p>

            </div>



            {{-- OFERTAS --}}

            <div class="p-5 sm:p-6 border-b lg:border-b-0 lg:border-r border-gray-100">

                <div class="flex items-center gap-3 mb-3">

                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-500">

                        @php($icon = 'briefcase')
                        @include('layouts.partials.icons')

                    </div>

                    <span class="text-sm text-gray-500">
                        Ofertas
                    </span>

                </div>

                <p class="text-2xl sm:text-3xl font-semibold text-gray-800">
                    {{ $totalOffers }}
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    Oportunidades publicadas
                </p>

            </div>



            {{-- SERVICIOS --}}

            <div class="p-5 sm:p-6">

                <div class="flex items-center gap-3 mb-3">

                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500">

                        @php($icon = 'chart-bar')
                        @include('layouts.partials.icons')

                    </div>

                    <span class="text-sm text-gray-500">
                        Servicios
                    </span>

                </div>

                <p class="text-2xl sm:text-3xl font-semibold text-gray-800">
                    {{ $totalServices }}
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    Servicios publicados
                </p>

            </div>

        </div>

    </div>



    {{-- INFORMACIÓN GENERAL + POSTULACIONES --}}

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


        {{-- LO QUE ESTÁ PASANDO --}}

        <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">

            <div class="p-6 border-b border-gray-100">

                <h2 class="text-lg font-semibold text-gray-800">
                    Lo que está pasando
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    Estado actual de la plataforma
                </p>

            </div>



            <div class="p-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


                    {{-- OFERTAS --}}

                    <div class="flex items-center gap-4 p-4 rounded-xl bg-blue-50/50">

                        <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center">

                            <span class="w-3 h-3 rounded-full bg-[#4DB6E8]"></span>

                        </div>

                        <div>

                            <p class="text-2xl font-semibold text-gray-800">
                                {{ $activeUsers }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Usuarios activos
                            </p>

                        </div>

                    </div>



                    {{-- EMPRESAS --}}

                    <div class="flex items-center gap-4 p-4 rounded-xl bg-purple-50/50">

                        <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center">

                            <span class="w-3 h-3 rounded-full bg-purple-500"></span>

                        </div>

                        <div>

                            <p class="text-2xl font-semibold text-gray-800">
                                {{ $activeCompanies }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Empresas activas
                            </p>

                        </div>

                    </div>



                    {{-- HOJAS DE VIDA --}}

                    <div class="flex items-center gap-4 p-4 rounded-xl bg-pink-50/50">

                        <div class="w-11 h-11 rounded-xl bg-pink-100 flex items-center justify-center">

                            <span class="w-3 h-3 rounded-full bg-pink-500"></span>

                        </div>

                        <div>

                            <p class="text-2xl font-semibold text-gray-800">
                                {{ $totalCV }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Hojas de vida registradas
                            </p>

                        </div>

                    </div>



                    {{-- SERVICIOS --}}

                    <div class="flex items-center gap-4 p-4 rounded-xl bg-yellow-50/50">

                        <div class="w-11 h-11 rounded-xl bg-yellow-100 flex items-center justify-center">

                            <span class="w-3 h-3 rounded-full bg-yellow-500"></span>

                        </div>

                        <div>

                            <p class="text-2xl font-semibold text-gray-800">
                                {{ $totalCategories }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Categorias Registrados
                            </p>

                        </div>

                    </div>

                </div>


                <div class="mt-5 flex items-center justify-center gap-2">

                    <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

                    <span class="text-sm font-medium text-green-600">
                        Plataforma activa
                    </span>

                </div>

            </div>

        </div>



        {{-- POSTULACIONES --}}

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

            <div class="p-6 border-b border-gray-100">

                <div class="flex items-start justify-between gap-3">

                    <div>

                        <h2 class="text-lg font-semibold text-gray-800">
                            Postulaciones
                        </h2>

                        <p class="text-sm text-gray-400 mt-1">
                            Estado de las postulaciones
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6 space-y-5">


                {{-- ENVIADAS --}}

                <div>

                    <div class="flex items-center justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>

                            <span class="text-sm text-gray-600">
                                Enviadas
                            </span>

                        </div>

                        <span class="font-semibold text-gray-800">
                            {{ $postulacionesEnviadas }}
                        </span>

                    </div>

                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">

                        <div
                            class="h-full bg-yellow-400 rounded-full"
                            style="width: {{ $porcentajeEnviadas }}%">
                        </div>

                    </div>

                </div>


                {{-- ACEPTADAS --}}

                <div>

                    <div class="flex items-center justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

                            <span class="text-sm text-gray-600">
                                Aceptadas
                            </span>

                        </div>

                        <span class="font-semibold text-gray-800">
                            {{ $postulacionesAceptadas }}
                        </span>

                    </div>

                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">

                        <div
                            class="h-full bg-green-500 rounded-full"
                            style="width: {{ $porcentajeAceptadas }}%">
                        </div>

                    </div>

                </div>


                {{-- RECHAZADAS --}}

                <div>

                    <div class="flex items-center justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>

                            <span class="text-sm text-gray-600">
                                Rechazadas
                            </span>

                        </div>

                        <span class="font-semibold text-gray-800">
                            {{ $postulacionesRechazadas }}
                        </span>

                    </div>

                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">

                        <div
                            class="h-full bg-red-500 rounded-full"
                            style="width: {{ $porcentajeRechazadas }}%">
                        </div>

                    </div>

                </div>



                {{-- TOTAL + VER MÁS --}}

                <div class="pt-4 mt-2 border-t border-gray-100">

                    <div class="flex items-end justify-between">

                        <div>

                            <p class="text-xs text-gray-400">
                                Total
                            </p>

                            <p class="text-2xl font-semibold text-gray-800">
                                {{ $totalPostulaciones }}
                            </p>

                        </div>

                        <a href="{{ route('postulacion.index') }}"
                            class="text-xs font-medium text-[#4DB6E8] hover:text-[#333333]">

                            Ver más →

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ÚLTIMAS OFERTAS + SERVICIOS --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">


        {{-- OFERTAS --}}

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

            <div class="p-6 border-b border-gray-100 flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800">
                        Últimas ofertas laborales
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                        Oportunidades publicadas recientemente
                    </p>

                </div>

                <a href="{{ route('ofertas.index') }}"
                    class="text-sm font-medium text-[#4DB6E8] hover:text-[#333333]">

                    Ver todas →

                </a>

            </div>


            <div class="divide-y divide-gray-100">

                @forelse($recentOffers as $offer)

                    <div class="p-5 flex items-center gap-4">

                        <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center text-green-500">

                            @php($icon = 'box')
                            @include('layouts.partials.icons')
                        </div>

                        <div class="flex-1 min-w-0">

                            <p class="text-sm font-medium text-gray-800 truncate">
                                {{ $offer->titulo }}
                            </p>

                            <p class="text-xs text-gray-400 mt-1">
                                {{ $offer->nombreEmpresa }}
                            </p>

                        </div>


                        <span class="text-xs text-gray-400 whitespace-nowrap">

                            {{ $offer->created_at
                                ? \Carbon\Carbon::parse($offer->created_at)->locale('es')->diffForHumans()
                                : ''
                            }}

                        </span>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <p class="text-sm text-gray-400">
                            No hay ofertas laborales recientes.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>



        {{-- SERVICIOS --}}

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

            <div class="p-6 border-b border-gray-100 flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800">
                        Servicios recientes
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                        Últimos servicios publicados
                    </p>

                </div>

                <a href="{{ route('servicios.index') }}"
                    class="text-sm font-medium text-[#4DB6E8] hover:text-[#333333]">

                    Ver todos →

                </a>

            </div>


            <div class="divide-y divide-gray-100">

                @forelse($recentServices as $service)

                    <div class="p-5 flex items-center gap-4">

                        <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500">

                            @php($icon = 'plus')
                            @include('layouts.partials.icons')

                        </div>

                        <div class="flex-1 min-w-0">

                            <p class="text-sm font-medium text-gray-800 truncate">
                                {{ $service->nombre }}
                            </p>

                            <p class="text-xs text-gray-400 mt-1">
                                {{ $service->categoria }}
                            </p>

                        </div>

                        <span class="text-xs text-gray-400 whitespace-nowrap">

                            {{ $service->created_at
                                ? \Carbon\Carbon::parse($service->created_at)->locale('es')->diffForHumans()
                                : ''
                            }}

                        </span>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <p class="text-sm text-gray-400">
                            No hay servicios recientes.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>



    {{-- ACTIVIDAD RECIENTE --}}

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

        <div class="p-6 border-b border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800">
                Actividad reciente
            </h2>

            <p class="text-sm text-gray-400 mt-1">
                Últimos movimientos registrados en la plataforma
            </p>

        </div>


        <div class="p-6">

            @forelse($recentActivity as $activity)

                <div class="flex items-center gap-4 py-4 border-b border-gray-100 last:border-0">

                    <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center ">

                        <span class="w-2.5 h-2.5 rounded-full bg-[#4DB6E8]"></span>

                    </div>

                    <div class="flex-1 min-w-0">

                        <p class="text-sm text-gray-600">

                            <span class="font-medium text-gray-800">
                                {{ $activity['name'] }}
                            </span>

                            {{ $activity['action'] }}

                        </p>

                    </div>

                    <span class="text-xs text-gray-400 whitespace-nowrap">
                        {{ $activity['time'] }}
                    </span>

                </div>

            @empty

                <div class="py-8 text-center">

                    <p class="text-sm text-gray-400">
                        No hay actividad reciente.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
