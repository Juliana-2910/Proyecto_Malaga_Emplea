@extends('layouts.Publico.Usuario.usuario')

@section('title', 'Mis postulaciones')

@section('content')

@php
    $contratos = [
        'tiempo completo' => 'Tiempo completo',
        'medio tiempo'    => 'Medio tiempo',
        'horas'           => 'Por horas',
        'porcentaje'      => 'Por porcentaje',
    ];

    $etiqueta = 'rounded-full bg-fondo px-3 py-1 text-[13px] font-semibold text-slate-600';
    $campo = 'rounded-[10px] border-[1.5px] border-slate-300 bg-white px-3.5 py-3 text-[15px] text-slate-800';
    $btnPrimario = 'inline-flex items-center justify-center gap-2 rounded-full border-2 border-marca bg-marca px-4 py-3 text-[15px] font-bold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white';
    $btnSecundario = 'inline-flex items-center justify-center rounded-full border-2 border-slate-800 bg-white px-4 py-3 text-[15px] font-bold text-slate-800 transition hover:border-carbon hover:bg-carbon hover:text-white';

    // Colores de cada estado
    $estados = [
        'Enviado'    => ['texto' => 'Enviada',    'fondo' => 'bg-amber-100', 'color' => 'text-amber-900', 'punto' => 'bg-amber-500'],
        'Aceptado'   => ['texto' => 'Aceptada',   'fondo' => 'bg-green-100', 'color' => 'text-green-900', 'punto' => 'bg-green-600'],
        'Rechazado'  => ['texto' => 'Rechazada',  'fondo' => 'bg-red-100',   'color' => 'text-red-900',   'punto' => 'bg-red-600'],
        'Contratado' => ['texto' => 'Contratada', 'fondo' => 'bg-sky-100',   'color' => 'text-sky-900',   'punto' => 'bg-sky-600'],
    ];

    // Pestañas de filtro: valor => [texto, cantidad, colores del contador]
    $pestanas = [
        ''           => ['Todas',       $conteos['todas'],     null],
        'Enviado'    => ['Enviadas',    $conteos['Enviado'],   'bg-amber-100 text-amber-900'],
        'Aceptado'   => ['Aceptadas',   $conteos['Aceptado'],  'bg-green-100 text-green-900'],
        'Rechazado'  => ['Rechazadas',  $conteos['Rechazado'], 'bg-red-100 text-red-900'],
        'Contratado' => ['Contratadas', $conteos['Contratado'], 'bg-sky-100 text-sky-700']
        ];
    $puntos = ['Enviado' => 'bg-amber-500', 'Aceptado' => 'bg-green-600', 'Rechazado' => 'bg-red-600', 'Contratado' => 'bg-sky-600'];
    $estadoActual = request('estado', '');
@endphp

{{-- ENCABEZADO --}}
<section class="bg-[#EAF6FD] px-6 pb-11 pt-10">
    <div class="mx-auto flex max-w-6xl flex-col gap-7">

        @include('layouts.Publico.avisosPaginas')

        <div class="flex flex-col gap-2">
            <span class="text-base font-bold text-marca-texto">
                Hola, {{ $nombre }}
            </span>

            <h1 class="text-3xl font-extrabold text-noche md:text-4xl">
                Mis postulaciones
            </h1>

            <p class="text-base text-slate-600">
                Aquí ves a qué ofertas te postulaste y cómo va cada una.
            </p>
        </div>
    </div>
</section>

{{-- FILTROS + LISTADO --}}
<section class="px-6 pb-16 pt-8">
    <div class="mx-auto flex max-w-6xl flex-col gap-6">

        <div class="flex flex-wrap items-center justify-between gap-4">

            {{-- Pestañas por estado --}}
            <div class="flex flex-wrap gap-2.5">
                @foreach ($pestanas as $valor => [$texto, $cantidad, $colorContador])
                    @php $activa = (string) $estadoActual === (string) $valor; @endphp

                    <a href="{{ request()->fullUrlWithQuery(['estado' => $valor ?: null, 'page' => null]) }}"
                        class="inline-flex items-center gap-2 rounded-full border-[1.5px] px-[18px] py-2.5 text-sm font-bold transition
                            {{ $activa ? 'border-noche bg-noche text-white' : 'border-slate-200 bg-white text-slate-800 hover:border-noche' }}">

                        @if ($valor !== '')
                            <span class="size-2 rounded-full {{ $puntos[$valor] }}"></span>
                        @endif

                        {{ $texto }}

                        <span class="rounded-full px-2.5 py-px text-[13px] {{ $activa && $valor === '' ? 'bg-white/20' : ($colorContador ?? 'bg-slate-100 text-slate-700') }}">
                            {{ $cantidad }}
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Orden --}}
            <form method="GET" action="{{ url('/mis-postulaciones') }}">
                @if ($estadoActual !== '')
                    <input type="hidden" name="estado" value="{{ $estadoActual }}">
                @endif

                <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-500">
                    Ordenar por

                    <select name="orden" class="{{ $campo }} min-h-11 py-2.5" onchange="this.form.submit()">
                        <option value="recientes" @selected(request('orden', 'recientes') === 'recientes')>Más recientes</option>
                        <option value="antiguas" @selected(request('orden') === 'antiguas')>Más antiguas</option>
                    </select>
                </label>
            </form>
        </div>

        <span class="text-[15px] text-slate-500">
            Mostrando {{ $postulaciones->firstItem() ?? 0 }}–{{ $postulaciones->lastItem() ?? 0 }}
            de {{ $postulaciones->total() }}
        </span>

        {{-- LISTADO --}}
        @forelse ($postulaciones as $postulacion)
            @php
                $oferta = $postulacion->oferta;
                $publicador = $oferta->usuario ?? $oferta->empresa;
                $estado = $estados[$postulacion->estado] ?? $estados['Enviado'];

                $datosModal = [
                    'id'          => $oferta->id,
                    'titulo'      => $oferta->titulo,
                    'publicador'  => $oferta->publicador,
                    'foto'        => $publicador?->fotoPerfil ? asset('storage/' . $publicador->fotoPerfil) : null,
                    'categoria'   => $oferta->categoria,
                    'contrato'    => $contratos[$oferta->tipoContrato] ?? $oferta->tipoContrato,
                    'salario'     => '$' . number_format($oferta->salario, 0, ',', '.'),
                    'ubicacion'   => $oferta->ubicacion,
                    'vence'       => \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y'),
                    'descripcion' => $oferta->descripcion,
                        'postulacion' => [
                        'id'     => $postulacion->id,
                        'estado' => $postulacion->estado,
                        'fecha'  => \Carbon\Carbon::parse($postulacion->fecha)->format('d/m/Y'),
                        ],
                    ];
                    // Datos del modal "Calificar"
                $datosCalificar = [
                        'id'     => $postulacion->id,
                        'nombre' => $oferta->publicador,
                        'tipo'   => $oferta->idEmpresa ? 'Empresa' : 'Persona natural',
                        'titulo' => $oferta->titulo,
                        'foto'   => $publicador?->fotoPerfil ? asset('storage/' . $publicador->fotoPerfil) : null,
                    ];

            @endphp

            <article class="flex flex-wrap items-center gap-5 rounded-2xl border border-slate-200 bg-white p-6 transition hover:shadow-lg hover:shadow-noche/10">

                {{-- Foto de quien publica --}}
                <div class="size-14 shrink-0 overflow-hidden rounded-full border-2 border-black bg-[#EAF6FD]">
                    @if ($publicador?->fotoPerfil)
                        <img src="{{ asset('storage/' . $publicador->fotoPerfil) }}" alt="Foto de perfil del publicador" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-marca-texto">
                            <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0" /></svg>
                        </div>
                    @endif
                </div>

                {{-- Datos --}}
                <div class="flex min-w-[240px] flex-1 flex-col gap-2">
                    <h3 class="text-[19px] font-bold">{{ $oferta->titulo }}</h3>

                    <p class="text-sm text-slate-500">{{ $oferta->publicador }}</p>

                    <div class="flex flex-wrap gap-2">
                        @if ($oferta->categoria)
                            <span class="{{ $etiqueta }}">{{ $oferta->categoria }}</span>
                        @endif

                        <span class="{{ $etiqueta }}">{{ $contratos[$oferta->tipoContrato] ?? $oferta->tipoContrato }}</span>
                        <span class="{{ $etiqueta }}">${{ number_format($oferta->salario, 0, ',', '.') }}</span>
                        <span class="inline-flex items-center gap-2 rounded-full {{ $estado['fondo'] }} px-3.5 py-1.5 text-[13px] font-bold {{ $estado['color'] }}">
                            <span class="size-2 rounded-full {{ $estado['punto'] }}"></span>
                                {{ $estado['texto'] }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-x-5 gap-y-1.5 text-sm text-slate-500">
                        <span>Te postulaste el {{ \Carbon\Carbon::parse($postulacion->fecha)->format('d/m/Y') }}</span>
                        <span>Vence: {{ \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y') }}</span>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="flex flex-col items-end gap-3">

                    <div class="flex flex-wrap items-center justify-end gap-2.5">

                        {{-- Calificación ya enviada: chip con estrellas --}}
                        @if ($postulacion->estado === 'Contratado' && $postulacion->calificacion)
                            <span class="inline-flex items-center gap-1.5 rounded-xl border border-amber-200 bg-amber-50 px-3.5 py-2 text-[13px] font-bold text-amber-800">
                                <span class="inline-flex gap-0.5" aria-hidden="true">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="size-4 {{ $i <= $postulacion->calificacion ? 'text-amber-500' : 'text-amber-300' }}"
                                            viewBox="0 0 24 24"
                                            fill="{{ $i <= $postulacion->calificacion ? 'currentColor' : 'none' }}"
                                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    @endfor
                                </span>
                                <span class="sr-only">{{ $postulacion->calificacion }} de 5 estrellas.</span>
                                Calificada · {{ $postulacion->calificacion }}/5
                            </span>
                        @endif

                        <button type="button" data-ver-postulacion="{{ json_encode($datosModal) }}"
                                class="{{ $btnSecundario }} cursor-pointer">
                            Ver mi postulación
                        </button>

                        {{-- Contratada y todavía sin calificar: botón Calificar --}}
                        @if ($postulacion->estado === 'Contratado' && ! $postulacion->calificacion)
                            <button type="button" data-calificar="{{ json_encode($datosCalificar) }}"
                                    class="{{ $btnPrimario }} cursor-pointer">
                                <svg class="size-[18px]" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                                Calificar
                            </button>
                        @endif
                    </div>
                </div>
            </article>

        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500">
                @if ($estadoActual !== '')
                    No tienes postulaciones con ese estado.
                @else
                    Aún no te has postulado a ninguna oferta.
                    <a href="{{ url('/empleos') }}" class="font-bold text-marca-texto hover:underline">Ver ofertas</a>
                @endif
            </div>
        @endforelse

        {{-- PAGINACIÓN --}}
        <div class="pt-3">
            {{ $postulaciones->links('layouts.Publico.paginacion') }}
        </div>
    </div>
</section>

{{-- MODAL VER MI POSTULACIÓN Y CANCELAR --}}
@include('layouts.Publico.Usuario.verPostulacionUsuario')

{{-- MODAL CALIFICAR --}}
@include('layouts.Publico.calificarContratacion')

@endsection
