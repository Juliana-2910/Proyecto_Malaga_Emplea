@extends('layouts.Publico.Usuario.usuario')

@section('title', 'Mis ofertas')

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

    // Botón redondo de acción (ojito / lápiz)
    $btnAccion = 'flex size-11 items-center justify-center rounded-full transition focus:outline-none focus-visible:ring-2 focus-visible:ring-marca';

    // Estado de la oferta -> texto y colores de la etiqueta
    $estados = [
        'activa'           => ['texto' => 'Activa',          'caja' => 'bg-green-100 text-green-800', 'punto' => 'bg-green-600'],
        'con_contratacion' => ['texto' => 'Con contratación', 'caja' => 'bg-blue-100 text-blue-800',   'punto' => 'bg-blue-600'],
        'vencida'          => ['texto' => 'Vencida',         'caja' => 'bg-slate-100 text-slate-800', 'punto' => 'bg-slate-600'],
    ];

    // Pestañas de filtro
    $pestanas = [
        'todas'        => ['texto' => 'Todas',            'punto' => null,           'contador' => 'bg-slate-200 text-slate-700'],
        'activas'      => ['texto' => 'Activas',          'punto' => 'bg-green-600', 'contador' => 'bg-green-100 text-green-800'],
        'contratacion' => ['texto' => 'Con contratación', 'punto' => 'bg-blue-600',  'contador' => 'bg-blue-100 text-blue-800'],
        'vencidas'     => ['texto' => 'Vencidas',         'punto' => 'bg-slate-500', 'contador' => 'bg-slate-100 text-slate-800'],
    ];
    $pestanaActual = request('estado', 'todas');

    // Plural simple: 1 Aceptada / 3 Aceptadas
    $plural = fn (int $n, string $singular) => $n . ' ' . ($n === 1 ? $singular : $singular . 's');

    $promedio = (float) ($calificacion['promedio'] ?? 0);
    $cuentaActual = request()->user();
    $empresa = $cuentaActual instanceof \App\Models\Empresa ? $cuentaActual : null;
    $esEmpresa = $empresa !== null;
    $puedeCrearOfertas = ! $empresa || $empresa->can('crear ofertas');
    $puedeEditarOfertas = ! $empresa || $empresa->can('editar ofertas');
    $puedeVerPostulantes = ! $empresa || $empresa->can('ver postulacion');
@endphp

{{-- ENCABEZADO + TARJETAS --}}
<section class="bg-[#EAF6FD] px-6 pb-12 pt-10">
    <div class="mx-auto flex max-w-6xl flex-col gap-7">

        @include('layouts.Publico.avisosPaginas')

        <div class="flex flex-col gap-2">
            <span class="text-base font-bold text-marca-texto">
                Hola, {{ $nombre }}
            </span>

            <h1 class="text-3xl font-extrabold text-noche md:text-4xl">
                Mis ofertas
            </h1>

            <p class="text-base text-slate-600">
                Revisa quién se postuló a tus ofertas, decide y califica a quien contrates.
            </p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            @if ($puedeCrearOfertas)
                {{-- PUBLICAR OFERTA: disponible en Mis ofertas para cuentas autorizadas. --}}
                <div class="flex flex-col gap-4 rounded-[20px] bg-noche p-6 shadow-lg shadow-noche/10">
                    <h2 class="text-[19px] font-extrabold text-white">
                        ¿Necesitas contratar a alguien?
                    </h2>

                    <p class="text-[15px] leading-relaxed text-slate-300">
                        Publica una oferta, recibe postulaciones y elige a la persona que mejor se ajuste.
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" data-abrir-crear-oferta class="{{ $btnPrimario }} cursor-pointer">
                            <svg class="size-[18px]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Publicar una oferta
                        </button>

                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-3 text-sm font-semibold text-sky-200">
                            <span class="rounded-md bg-white/15 px-2 py-0.5 text-sm">{{ $resumen['postulantesPorRevisar'] }}</span>
                            Postulantes por revisar
                        </span>
                    </div>
                </div>
            @endif

            {{-- TU RESUMEN --}}
            <div class="flex flex-col gap-5 rounded-[20px] bg-white p-6 shadow-lg shadow-noche/10">
                <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-2">
                    <h2 class="text-[19px] font-extrabold text-noche">
                    Tu resumen
                </h2>

                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="flex flex-col items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100 px-3 py-1 text-[13px] font-bold text-sky-900">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="size-6"   stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>
                            Por calificar
                        </span>
                        <span class="text-3xl font-extrabold leading-none text-noche">{{ $resumen['porCalificar'] }}</span>
                    </div>

                    <div class="flex flex-col items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-[13px] font-bold text-amber-900">
                            <svg width="18" height="18" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            Vencen pronto
                        </span>
                        <span class="text-3xl font-extrabold leading-none text-noche">{{ $resumen['vencenPronto'] }}</span>
                    </div>

                    <div class="flex flex-col items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-100 px-3 py-1 text-[13px] font-bold text-purple-900">
                            <svg width="18" height="18" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                            Sin postulantes
                        </span>
                        <span class="text-3xl font-extrabold leading-none text-noche">{{ $resumen['sinPostulantes'] }}</span>
                    </div>
                </div>


                {{-- CALIFICACIÓN --}}
                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-4">

                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-500">
                            Tu calificación
                        </span>

                        <span class="flex items-center gap-1.5"
                            aria-label="{{ round($promedio) }} de 5 estrellas">

                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="{{ $i <= round($promedio) ? '#FBBF24' : '#CBD5E1' }}" aria-hidden="true">
                                    <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" />
                                </svg>
                            @endfor
                        </span>

                        <span class="text-base font-extrabold text-noche">
                            {{ (int) round($promedio) }}/5
                        </span>
                    </div>

                    <span class="text-sm font-semibold text-slate-500">
                        {{ $calificacion['total'] }} calificaciones
                    </span>

                </div>

            </div>
        </div>
    </div>
</section>

@if ($puedeCrearOfertas)
    @include('layouts.Publico.crearOferta')
@endif

{{-- FILTROS + LISTADO --}}
<section class="px-6 pb-16 pt-8">
    <div class="mx-auto flex max-w-6xl flex-col gap-5">

                {{-- PESTAÑAS + ORDENAR --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <nav aria-label="Filtrar mis ofertas por estado" class="flex flex-wrap gap-2.5">
                @foreach ($pestanas as $clave => $p)
                    @php $activa = $pestanaActual === $clave; @endphp

                    <a href="{{ request()->fullUrlWithQuery(['estado' => $clave, 'page' => null]) }}"
                        @if ($activa) aria-current="page" @endif
                        class="inline-flex min-h-11 items-center gap-2 rounded-full border px-4 text-[15px] font-bold transition
                            {{ $activa ? 'border-noche bg-noche text-white' : 'border-slate-200 bg-white text-noche hover:border-noche' }}">

                        {{-- PUNTO INDICADOR --}}
                        @if ($clave === 'vencidas')
                            <span class="block h-2 w-2 shrink-0 rounded-full bg-gray-500"></span>
                        @elseif ($p['punto'] !== null)
                            <span class="block h-2 w-2 shrink-0 rounded-full {{ $p['punto'] }}"></span>
                        @endif

                        {{ $p['texto'] }}

                        {{-- CONTADOR REDONDO --}}
                        <span class="inline-flex size-6 shrink-0 items-center justify-center rounded-full text-xs font-bold
                            {{ $activa ? 'bg-white/20 text-white' : $p['contador'] }}">
                            {{ $conteoEstados[$clave] ?? 0 }}
                        </span>
                    </a>
                @endforeach
            </nav>

            {{-- ORDENAR --}}
            <form method="GET" action="{{ url('/mis-ofertas') }}">
                <input type="hidden" name="estado" value="{{ $pestanaActual }}">

                <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-500">
                    Ordenar por

                    <select name="orden" class="{{ $campo }} min-h-11 py-2.5"
                        onchange="this.form.submit()">
                        <option value="recientes" @selected(request('orden', 'recientes') === 'recientes')>
                            Más recientes
                        </option>
                        <option value="antiguas" @selected(request('orden') === 'antiguas')>
                            Más antiguas
                        </option>
                        <option value="vencen" @selected(request('orden') === 'vencen')>
                            Vencen primero
                        </option>
                    </select>
                </label>
            </form>
        </div>

        <span class="text-[15px] text-slate-500">
            Mostrando {{ $ofertas->firstItem() ?? 0 }}–{{ $ofertas->lastItem() ?? 0 }}
            de {{ $ofertas->total() }}
        </span>

        {{-- LISTADO --}}
        @forelse ($ofertas as $oferta)
            @php
                $estado = $estados[$oferta->estadoOferta] ?? $estados['activa'];
                $r = $oferta->resumenPostulantes;
                $totalPostulantes = array_sum($r);

                // REGLA: el lápiz solo funciona en ofertas activas
                $puedeEditar = $puedeEditarOfertas && $oferta->estadoOferta === 'activa';

                $motivoNoEditar = match ($oferta->estadoOferta) {
                    'con_contratacion' => 'Ya tiene una persona contratada',
                    'vencida'          => 'La oferta ya venció',
                    default            => null,
                };

                // Datos para el modal de editar (se conecta en el siguiente paso)
                $datosEditar = [
                    'id'           => $oferta->id,
                    'titulo'       => $oferta->titulo,
                    'descripcion'  => $oferta->descripcion,
                    'requisitos'   => $oferta->requisitos,
                    'salario'      => $oferta->salario,
                    'tipoContrato' => $oferta->tipoContrato,
                    'ubicacion'    => $oferta->ubicacion,
                    'fechaLimite'  => \Carbon\Carbon::parse($oferta->fechaLimite)->toDateString(),

                    // Categoría y servicio actuales de la oferta
                    'idCategoria'  => $oferta->ofertaServicio->first()?->servicio?->idCategoria,
                    'idServicio'   => $oferta->ofertaServicio->first()?->idServicio,
                ];

                // Datos para el modal de ver oferta
                $datosVerOferta = [
                    'titulo'           => $oferta->titulo,
                    'categoria'        => $oferta->categoria ?? '',
                    'servicio'         => $oferta->ofertaServicio->first()?->servicio?->nombre ?? '',
                    'contrato'         => $contratos[$oferta->tipoContrato] ?? $oferta->tipoContrato,
                    'estado'           => $oferta->estadoOferta,
                    'estadoTexto'      => $estado['texto'],
                    'salario'          => '$' . number_format($oferta->salario, 0, ',', '.'),
                    'ubicacion'        => $oferta->ubicacion,
                    'publicada'        => \Carbon\Carbon::parse($oferta->fechaPublicacion)->format('d/m/Y'),
                    'diasRestantes'    => max(0, \Carbon\Carbon::today('America/Bogota')->diffInDays(
                        \Carbon\Carbon::parse($oferta->fechaLimite)->startOfDay(),
                        false
                    )),
                    'vence'            => \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y'),
                    'descripcion'      => $oferta->descripcion,
                    'requisitos'       => array_values(array_filter(
                        preg_split('/\r\n|\r|\n/', $oferta->requisitos ?? '')
                    )),
                    'totalPostulantes' => $totalPostulantes,
                    'urlPostulantes'   => $puedeVerPostulantes ? route('Publico.misOfertas.postulantes', $oferta->id) : null,
                    'puedeEditar'      => $puedeEditar,
                    'motivoNoEditar'  => $motivoNoEditar,
                    'datosEditar'      => $datosEditar,
                ];

            @endphp

            <article class="flex flex-wrap items-center gap-5 rounded-2xl border border-slate-200 bg-white p-6 transition hover:shadow-lg hover:shadow-noche/10">

                {{-- Icono de la oferta --}}
                <span class="flex size-14 shrink-0 items-center justify-center self-center rounded-2xl bg-[#EAF6FD] text-marca-texto">
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" /></svg>
                </span>

                {{-- Información --}}
                <div class="flex min-w-[260px] flex-1 flex-col gap-2.5">
                    <h3 class="text-[19px] font-bold text-noche">
                        {{ $oferta->titulo }}
                    </h3>

                    <div class="flex flex-wrap gap-2">
                        @if ($oferta->categoria)
                            <span class="{{ $etiqueta }}">{{ $oferta->categoria }}</span>
                        @endif

                        <span class="{{ $etiqueta }}">{{ $contratos[$oferta->tipoContrato] ?? $oferta->tipoContrato }}</span>
                        <span class="{{ $etiqueta }}">${{ number_format($oferta->salario, 0, ',', '.') }}</span>
                        <span class="{{ $etiqueta }}">{{ $oferta->ubicacion }}</span>
                    </div>

                    <div class="flex flex-wrap gap-x-5 gap-y-1 text-sm text-slate-500">
                        <span>Publicada el {{ \Carbon\Carbon::parse($oferta->fechaPublicacion)->format('d/m/Y') }}</span>
                        <span>Vence: {{ \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y') }}</span>
                    </div>

                    {{-- Postulantes --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[13px] font-bold text-noche">Postulantes:</span>

                        @if ($totalPostulantes === 0)
                            <span class="text-[13px] text-slate-500">Aún nadie se ha postulado.</span>
                        @else
                            @if ($r['enviadas'] > 0)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-[13px] font-bold text-amber-900">{{ $plural($r['enviadas'], 'Enviada') }}</span>
                            @endif
                            @if ($r['aceptadas'] > 0)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-[13px] font-bold text-green-900">{{ $plural($r['aceptadas'], 'Aceptada') }}</span>
                            @endif
                            @if ($r['rechazadas'] > 0)
                                <span class="rounded-full bg-red-100 px-3 py-1 text-[13px] font-bold text-red-900">{{ $plural($r['rechazadas'], 'Rechazada') }}</span>
                            @endif
                            @if ($r['contratadas'] > 0)
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-[13px] font-bold text-blue-900">{{ $plural($r['contratadas'], 'Contratada') }}</span>
                            @endif
                        @endif
                    </div>

                    {{-- Aviso de contratación --}}
                    @if ($oferta->estadoOferta === 'con_contratacion' && $oferta->nombreContratado)
                        <div class="flex items-center gap-2.5 rounded-xl border border-sky-200 bg-sky-50 px-4 py-2.5 text-sm font-bold text-marca-texto font-bold">
                            <svg class="size-[18px] shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            <span>Contrataste a <strong class="text-noche">{{ $oferta->nombreContratado }}</strong></span>
                        </div>
                    @endif
                </div>


                {{-- Estado + acciones --}}
                <div class="flex flex-col items-center justify-center gap-4 self-center">
                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[13px] font-bold {{ $estado['caja'] }}">
                        <span class="size-2 rounded-full {{ $oferta->estadoOferta === 'vencida' ? 'bg-gray-500' : $estado['punto'] }}"></span>
                        {{ $estado['texto'] }}
                    </span>

                    <div class="flex items-center gap-3">

                        {{-- OJITO: ver los detalles de mi oferta --}}
                        <button type="button"
                            data-ver-mi-oferta="{{ json_encode($datosVerOferta, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}"
                            title="Ver oferta"
                            aria-label="Ver oferta"
                            class="{{ $btnAccion }} cursor-pointer bg-sky-100 text-marca-texto hover:bg-sky-200">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" fill="none"stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"> <path d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>

                        {{-- POSTULANTES: ver l de los postulantes --}}
                            @if ($puedeVerPostulantes)<a href="{{ route('Publico.misOfertas.postulantes', $oferta->id) }}"
                            title="Ver postulantes"
                            aria-label="Ver postulantes"
                            class="{{ $btnAccion }} cursor-pointer bg-purple-100 text-purple-700 hover:bg-purple-200">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </a>@endif

                        {{-- LÁPIZ: solo funciona si la oferta está activa --}}
                        @if ($puedeEditar)
                            <button type="button"
                                data-editar-oferta="{{ json_encode($datosEditar) }}"
                                title="Editar oferta"
                                aria-label="Editar"
                                class="{{ $btnAccion }} cursor-pointer bg-slate-200 text-slate-700 hover:bg-slate-300">
                                <svg width="18" height="18" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </button>
                        @else
                            <span tabindex="0" role="button" aria-disabled="true"
                                title="{{ $motivoNoEditar }}"
                                aria-label="Editar no disponible: {{ $motivoNoEditar }}"
                                class="{{ $btnAccion }} cursor-not-allowed bg-slate-100 text-slate-300">
                                <svg width="18" height="18" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </span>
                        @endif

                    </div>
                </div>

            </article>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500">
                No tienes ofertas en este estado todavía.
            </div>
        @endforelse

        {{-- PAGINACIÓN --}}
        <div class="pt-3">
            {{ $ofertas->links('layouts.Publico.paginacion') }}
        </div>
    </div>
</section>

@include('layouts.Publico.verOferta')
@include('layouts.Publico.editarOferta')

@endsection
