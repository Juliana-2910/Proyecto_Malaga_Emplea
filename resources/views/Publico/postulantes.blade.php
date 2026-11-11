@extends('layouts.Publico.Usuario.usuario')

@section('title', 'Postulantes')

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

    // Botón redondo de acción
    $btnAccion = 'flex size-11 items-center justify-center rounded-full transition focus:outline-none focus-visible:ring-2 focus-visible:ring-marca';

    // Estado de la OFERTA (etiqueta del encabezado)
    $estadosOferta = [
        'activa'           => ['texto' => 'Activa',           'caja' => 'bg-green-100 text-green-800', 'punto' => 'bg-green-600'],
        'con_contratacion' => ['texto' => 'Con contratación', 'caja' => 'bg-blue-100 text-blue-800',   'punto' => 'bg-blue-600'],
        'vencida'          => ['texto' => 'Vencida',          'caja' => 'bg-slate-100 text-slate-800', 'punto' => 'bg-gray-500'],
    ];
    $estadoOferta = $estadosOferta[$oferta->estadoOferta] ?? $estadosOferta['activa'];

    // Estado de cada POSTULACIÓN
    $estadosPost = [
        'Enviado'    => ['texto' => 'Enviada',    'caja' => 'bg-amber-100 text-amber-900', 'punto' => 'bg-amber-500'],
        'Aceptado'   => ['texto' => 'Aceptada',   'caja' => 'bg-green-100 text-green-800', 'punto' => 'bg-green-600'],
        'Rechazado'  => ['texto' => 'Rechazada',  'caja' => 'bg-red-100 text-red-800',     'punto' => 'bg-red-600'],
        'Contratado' => ['texto' => 'Contratada', 'caja' => 'bg-blue-100 text-blue-800',   'punto' => 'bg-blue-600'],
    ];

    // Pestañas (la clave vacía = Todos)
    $pestanas = [
        ''           => ['texto' => 'Todos',      'punto' => null,           'contador' => 'bg-slate-200 text-slate-700'],
        'Enviado'    => ['texto' => 'Enviados',   'punto' => 'bg-amber-500', 'contador' => 'bg-amber-100 text-amber-900'],
        'Aceptado'   => ['texto' => 'Aceptados',  'punto' => 'bg-green-600', 'contador' => 'bg-green-100 text-green-800'],
        'Contratado' => ['texto' => 'Contratado', 'punto' => 'bg-blue-600',  'contador' => 'bg-blue-100 text-blue-800'],
        'Rechazado'  => ['texto' => 'Rechazados', 'punto' => 'bg-red-600',   'contador' => 'bg-red-100 text-red-800'],
    ];
    $pestanaActual = request('estado', '');

    // Iconos redondos: texto del tooltip, colores y dibujo
    $acciones = [
        'ver' => [
            'texto' => 'Ver hoja de vida',
            'clase' => 'bg-sky-100 text-marca-texto hover:bg-sky-200',
            'ancho' => '1.8',
            'icono' => '<path class="size-6" stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z"/><circle cx="12" cy="12" r="3"/>',
        ],
        'rechazar' => [
            'texto' => 'Rechazar',
            'clase' => 'bg-red-100 text-red-700 hover:bg-red-200',
            'ancho' => '2.4',
            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>',
        ],
        'aceptar' => [
            'texto' => 'Aceptar',
            'clase' => 'bg-green-100 text-green-700 hover:bg-green-200',
            'ancho' => '2.4',
            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>',
        ],
        'contratar' => [
            'texto' => 'Contratar',
            'clase' => 'bg-noche text-white hover:bg-[#0B2230]',
            'ancho' => '1.8',
            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 17l2 2a1 1 0 1 0 3-3 M14 14l2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4 M21 3l1 11h-2 M3 3l-1 11l6.5 6.5a1 1 0 1 0 3-3 M3 4h8"/>',
        ],
        'calificar' => [
            'texto' => 'Calificar',
            'clase' => 'bg-amber-100 text-amber-700 hover:bg-amber-200',
            'ancho' => '1.8',
            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>',
        ],
    ];

    // Qué iconos se ven según el estado (el orden es el del diseño)
    $botonesPorEstado = [
        'Enviado'    => ['ver', 'rechazar', 'aceptar'],
        'Aceptado'   => ['ver', 'contratar'],
        'Contratado' => ['ver', 'calificar'],
        'Rechazado'  => ['ver'],
    ];

@endphp

{{-- ENCABEZADO --}}
<section class="bg-[#EAF6FD] px-6 pb-10 pt-8">
    <div class="mx-auto flex max-w-6xl flex-col gap-3.5">

        @include('layouts.Publico.avisosPaginas')

        <a href="{{ route('Publico.misOfertas') }}"
            class="inline-flex items-center gap-2 self-start text-[15px] font-bold text-marca-texto transition hover:text-noche">
            <svg class="size-[18px]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            Volver a mis ofertas
        </a>

        <h1 class="text-3xl font-extrabold text-noche md:text-4xl">Postulantes</h1>

        <div class="flex flex-wrap items-center gap-x-3.5 gap-y-2.5">
            <span class="text-lg font-bold text-noche">{{ $oferta->titulo }}</span>

            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[13px] font-bold {{ $estadoOferta['caja'] }}">
                <span class="size-2 rounded-full {{ $estadoOferta['punto'] }}"></span>
                {{ $estadoOferta['texto'] }}
            </span>
        </div>

        <div class="flex flex-wrap gap-x-5 gap-y-1.5 text-sm text-slate-600">
            @if ($oferta->categoria)
                <span>{{ $oferta->categoria }}</span>
            @endif
            <span>{{ $contratos[$oferta->tipoContrato] ?? $oferta->tipoContrato }}</span>
            <span>${{ number_format($oferta->salario, 0, ',', '.') }}</span>
            <span>Vence: {{ \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y') }}</span>
        </div>
    </div>
</section>

{{-- FILTROS + LISTADO --}}
<section class="px-6 pb-16 pt-8">
    <div class="mx-auto flex max-w-6xl flex-col gap-6">

        {{-- AVISO DE REGLAS --}}
        <div class="flex items-center gap-3 rounded-xl border border-l-4 border-slate-200 border-l-marca bg-white px-4 py-3.5 text-sm text-slate-600">
            <svg class="size-5 shrink-0 text-marca-texto" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
            <span>Solo puedes contratar a <strong>una persona</strong> por oferta. Una vez que aceptas o rechazas, la decisión no se puede cambiar.</span>
        </div>

        {{-- PESTAÑAS + ORDENAR --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <nav aria-label="Filtrar postulantes por estado" class="flex flex-wrap gap-2.5">
                @foreach ($pestanas as $clave => $p)
                    @php $activa = (string) $pestanaActual === (string) $clave; @endphp

                    <a href="{{ request()->fullUrlWithQuery(['estado' => $clave ?: null, 'page' => null]) }}"
                        @if ($activa) aria-current="page" @endif
                        class="inline-flex min-h-11 items-center gap-2 rounded-full border px-4 text-[15px] font-bold transition
                            {{ $activa ? 'border-noche bg-noche text-white' : 'border-slate-200 bg-white text-noche hover:border-noche' }}">

                        @if ($p['punto'] !== null)
                            <span class="block h-2 w-2 shrink-0 rounded-full {{ $p['punto'] }}"></span>
                        @endif

                        {{ $p['texto'] }}

                        <span class="inline-flex size-6 shrink-0 items-center justify-center rounded-full text-xs font-bold
                            {{ $activa ? 'bg-white/20 text-white' : $p['contador'] }}">
                            {{ $conteos[$clave === '' ? 'todos' : $clave] ?? 0 }}
                        </span>
                    </a>
                @endforeach
            </nav>

            <form method="GET" action="{{ route('Publico.misOfertas.postulantes', $oferta->id) }}">
                <input type="hidden" name="estado" value="{{ $pestanaActual }}">

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
            Mostrando {{ $postulantes->firstItem() ?? 0 }}–{{ $postulantes->lastItem() ?? 0 }}
            de {{ $postulantes->total() }}
        </span>

        {{-- LISTADO --}}
        @forelse ($postulantes as $p)
            @php
                $u = $p->usuario;
                $hoja = $p->hojaDeVida;
                $est = $estadosPost[$p->estado];
                $nombrePersona = trim(($u->nombres ?? '') . ' ' . ($u->apellidos ?? ''));
                $foto = $u?->fotoPerfil ? asset('storage/' . $u->fotoPerfil) : null;
                $contacto = collect([$u->email ?? null, $u->telefono ?? null, $hoja?->ubicacion])->filter()->implode(' · ');
                $fechaPostulo = \Carbon\Carbon::parse($p->fecha)->format('d/m/Y');

                // Datos que el modal "Hoja de vida del postulante" pinta con JS
                $datosHoja = [
                    'id'          => $p->id,
                    'nombre'      => $nombrePersona,
                    'foto'        => $foto,
                    'oferta'      => $oferta->titulo,
                    'estadoTexto' => $est['texto'],
                    'estadoCaja'  => $est['caja'],
                    'estadoPunto' => $est['punto'],
                    'fecha'       => $fechaPostulo,
                    'correo'      => $u->email ?? '',
                    'telefono'    => $u->telefono ?: 'No registrado',
                    'ubicacion'   => $hoja?->ubicacion ?: 'No registrada',
                    'perfil'      => $hoja?->perfilProfesional ?? '',
                    'experiencia' => $hoja?->experienciaLaboral ?? '',
                    'cvNombre'    => $hoja?->archivoCV ? basename($hoja->archivoCV) : '',
                    'cvFecha'     => $hoja?->fechaActualizacion ? \Carbon\Carbon::parse($hoja->fechaActualizacion)->format('d/m/Y') : '',
                    'cvUrl'       => $hoja?->archivoCV ? asset('storage/' . $hoja->archivoCV) : '',
                ];

                // Datos que el modal "Calificar" pinta con JS (el mismo modal que usa "Mis postulaciones")
                $datosCalificar = [
                    'id'        => $p->id,
                    'nombre'    => $nombrePersona,
                    'tipo'      => 'Persona contratada',
                    'titulo'    => $oferta->titulo,
                    'foto'      => $foto,
                    'url'       => route('Publico.misOfertas.calificarPostulante', $p->id),
                    'leyenda'   => 'Por su trabajo en «' . $oferta->titulo . '»',
                    'subtitulo' => 'Comparte tu experiencia con la persona que contrataste.',
                ];

                // Si ya calificaste a esta persona, la estrella se cambia por el chip
                $botones = $botonesPorEstado[$p->estado];
                if ($p->calificacion) {
                    $botones = array_values(array_diff($botones, ['calificar']));
                }
            @endphp

            <article class="flex flex-wrap items-center gap-5 rounded-2xl border border-slate-200 bg-white p-6 transition hover:shadow-lg hover:shadow-noche/10">

                {{-- Foto o icono --}}
                <div class="flex size-14 shrink-0 items-center justify-center self-center overflow-hidden rounded-full border-2 border-[#EAF6FD] bg-[#EAF6FD] text-marca-texto">
                    @if ($foto)
                        <img src="{{ $foto }}" alt="Foto de {{ $nombrePersona }}" class="size-full object-cover">
                    @else
                        <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0" /></svg>
                    @endif
                </div>

                {{-- Información --}}
                <div class="flex min-w-[260px] flex-1 flex-col gap-2">
                    <h3 class="text-[19px] font-bold text-noche">{{ $nombrePersona }}</h3>

                    <span class="text-sm text-slate-500">{{ $contacto }}</span>

                    <div class="flex flex-wrap gap-2">
                        <span class="{{ $etiqueta }} text-sm text-slate-500">Se postuló el {{ $fechaPostulo }}</span>
                    </div>

                </div>

                {{-- Estado + acciones --}}
                <div class="flex flex-col items-end gap-3 self-center">
                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[13px] font-bold {{ $est['caja'] }}">
                        <span class="size-2 rounded-full {{ $est['punto'] }}"></span>
                        {{ $est['texto'] }}
                    </span>

                    <div class="flex flex-wrap items-center justify-end gap-2.5">

                        {{-- Chip: ya calificaste a esta persona --}}
                        @if ($p->estado === 'Contratado' && $p->calificacion)
                            <span class="inline-flex items-center gap-1.5 rounded-xl border border-amber-200 bg-amber-50 px-3.5 py-2 text-[13px] font-bold text-amber-800">
                                <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="#FBBF24" aria-hidden="true"><path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" /></svg>
                                Calificado · {{ (int) $p->calificacion }}/5
                            </span>
                        @endif

                        @foreach ($botones as $clave)
                            @php $a = $acciones[$clave]; @endphp

                            <button type="button"
                                title="{{ $a['texto'] }}"
                                aria-label="{{ $a['texto'] }}"
                                @if ($clave === 'ver')
                                    data-ver-postulante="{{ json_encode($datosHoja, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}"
                                @elseif ($clave === 'calificar')
                                    data-calificar="{{ json_encode($datosCalificar, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}"
                                @else
                                    data-accion="{{ $clave }}" data-postulacion="{{ $p->id }}"
                                @endif
                                class="{{ $btnAccion }} cursor-pointer {{ $a['clase'] }}">
                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $a['ancho'] }}" aria-hidden="true">{!! $a['icono'] !!}</svg>
                            </button>
                        @endforeach
                    </div>
                </div>

            </article>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500">
                Todavía no hay postulantes en este estado.
            </div>
        @endforelse

        {{-- PAGINACIÓN --}}
        <div class="pt-3">
            {{ $postulantes->links('layouts.Publico.paginacion') }}
        </div>
    </div>
</section>

@include('layouts.Publico.verHojaPostulante')

@include('layouts.Publico.calificarContratacion')

@endsection
