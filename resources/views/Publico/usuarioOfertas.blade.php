@extends('layouts.Publico.usuario')

@section('title', 'Ofertas')

@section('content')
@php
    $contratos = [
        'tiempo completo' => 'Tiempo completo',
        'medio tiempo'    => 'Medio tiempo',
        'horas'           => 'Por horas',
    ];

    $etiqueta = 'rounded-full bg-fondo px-3 py-1 text-[13px] font-semibold text-slate-600';
    $campo = 'rounded-[10px] border-[1.5px] border-slate-300 bg-white px-3.5 py-3 text-[15px] text-slate-800';
    $btnPrimario = 'inline-flex items-center justify-center gap-2 rounded-xl border-2 border-marca bg-marca px-5 py-3 text-[15px] font-bold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white';
    $btnSecundario = 'inline-flex items-center justify-center rounded-xl border-2 border-slate-800 bg-white px-5 py-3 text-[15px] font-bold text-slate-800 transition hover:border-carbon hover:bg-carbon hover:text-white';
@endphp

{{-- ENCABEZADO + TARJETAS --}}
<section class="bg-[#EAF6FD] px-6 pb-12 pt-10">
    <div class="mx-auto flex max-w-6xl flex-col gap-7">

        {{-- AVISO DE ÉXITO --}}
        @if (session('success'))
            <div role="alert"
                style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:12px 16px;border-radius:12px;border:1px solid #BBF7D0;background:#F0FDF4;color:#15803D;font-size:14px;box-shadow:0 1px 2px rgba(0,0,0,0.05)">
                <div style="display:flex;align-items:center;gap:12px">
                    <span style="width:32px;height:32px;border-radius:999px;background:#DCFCE7;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.75l6 6 9-13.5" /></svg>
                    </span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" aria-label="Cerrar aviso" onclick="this.closest('[role=alert]').remove()"
                        style="border:none;background:transparent;color:#16A34A;cursor:pointer;display:flex;padding:4px">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        {{-- AVISO AMARILLO: Restricciones de postulación --}}
        @if (session('error'))
            <div role="alert"
                style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:12px 16px;border-radius:12px;border:1px solid #FEF08A;background:#FEFCE8;color:#A16207;font-size:14px;box-shadow:0 1px 2px rgba(0,0,0,0.05)">
                <div style="display:flex;align-items:center;gap:12px">
                    <span style="width:32px;height:32px;border-radius:999px;background:#FEF9C3;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                    </span>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" aria-label="Cerrar aviso" onclick="this.closest('[role=alert]').remove()"
                        style="border:none;background:transparent;color:#CA8A04;cursor:pointer;display:flex;padding:4px">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        <div class="flex flex-col gap-2">
            <span class="text-base font-bold text-marca-texto">
                Hola, {{ $nombre }}
            </span>

            <h1 class="text-3xl font-extrabold text-noche md:text-4xl">
                Ofertas de empleo
            </h1>

            <p class="text-base text-slate-600">
                {{ $totalOfertas }} ofertas activas en Málaga, Santander
            </p>
        </div>

        <div class="grid gap-5 {{ $esEmpresa ? '' : 'md:grid-cols-2' }}">

            {{-- TUS POSTULACIONES --}}
            @unless ($esEmpresa)
                <div class="flex flex-col gap-5 rounded-[20px] bg-white p-6 shadow-lg shadow-noche/10">
                    <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-2">
                        <h2 class="text-[19px] font-extrabold text-noche">
                            Tus postulaciones
                        </h2>

                        <a href="{{ url('/mis-postulaciones') }}"                            class="py-2 text-[15px] font-bold text-marca-texto hover:underline">
                            Ver mis postulaciones
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="flex flex-col items-start gap-2.5">
                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-[13px] font-bold text-amber-900">
                                <span class="size-2 rounded-full bg-amber-500"></span>
                                Enviadas
                            </span>

                            <span class="text-3xl font-extrabold leading-none text-noche">
                                {{ $resumenPostulaciones['enviadas'] }}
                            </span>
                        </div>

                        <div class="flex flex-col items-start gap-2.5">
                            <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-[13px] font-bold text-green-900">
                                <span class="size-2 rounded-full bg-green-600"></span>
                                Aceptadas
                            </span>

                            <span class="text-3xl font-extrabold leading-none text-noche">
                                {{ $resumenPostulaciones['aceptadas'] }}
                            </span>
                        </div>

                        <div class="flex flex-col items-start gap-2.5">
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-[13px] font-bold text-red-900">
                                <span class="size-2 rounded-full bg-red-600"></span>
                                Rechazadas
                            </span>

                            <span class="text-3xl font-extrabold leading-none text-noche">
                                {{ $resumenPostulaciones['rechazadas'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @endunless

            {{-- PUBLICAR OFERTA --}}
            <div class="flex flex-col gap-4 rounded-[20px] bg-noche p-6 shadow-lg shadow-noche/10">
                <h2 class="text-[19px] font-extrabold text-white">
                    ¿Necesitas contratar a alguien?
                </h2>

                <p class="text-[15px] leading-relaxed text-slate-300">
                    Publica una oferta, recibe postulaciones y elige a la persona que mejor se ajuste.
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ url('/crear-oferta') }}" class="{{ $btnPrimario }}">
                        <svg class="size-[18px]" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Publicar una oferta
                    </a>

                    <a href="{{ url('/mis-ofertas') }}"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-white px-5 py-3 text-[15px] font-bold text-white transition hover:border-carbon hover:bg-carbon">
                        Ver mis ofertas y postulantes
                    </a>
                </div>

                <span class="text-sm font-semibold text-sky-200">
                    {{ $postulantesPorRevisar }} postulantes por revisar
                </span>
            </div>
        </div>
    </div>
</section>

    {{-- AVISO HOJA DE VIDA --}}
@if (! $esEmpresa && $hojaDeVidaProgreso < 100)
    <section class="px-6 pt-6">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-x-7 gap-y-4 rounded-2xl border border-slate-200 bg-white px-6 py-4">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
            </span>

            <div class="min-w-[240px] flex-1">
                    <p class="text-[17px] font-extrabold text-noche">
                        Completa tu hoja de vida
                    </p>

                    <p class="text-sm text-slate-500">
                        Quien publica una oferta la revisa cuando te postulas.
                    </p>
            </div>

            <div class="min-w-[200px] flex-1">
                    <p class="mb-1.5 text-[13px] font-bold text-slate-500">
                        {{ $hojaDeVidaProgreso }}% completado
                    </p>

                    <div class="h-2.5 rounded-full bg-slate-200">
                        <div class="h-2.5 rounded-full bg-marca"
                            style="width: {{ $hojaDeVidaProgreso }}%"></div>
                    </div>
            </div>

            <a href="{{ url('/hojaDeVida') }}" class="{{ $btnSecundario }}">
                Completar mi hoja de vida
            </a>
        </div>
    </section>
@endif

    {{-- FILTROS + LISTADO --}}
    <section class="px-6 pb-16 pt-8">
        <div class="mx-auto flex max-w-6xl flex-wrap items-start gap-8">

            {{-- FILTROS --}}
            <form id="filtros-ofertas" method="GET" action="{{ url('/empleos') }}"
                    class="flex w-full flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 lg:w-72 lg:shrink-0">

                <h2 class="text-lg font-bold text-noche">
                    Filtrar ofertas
                </h2>

                <label class="flex flex-col gap-1.5 text-[13px] font-bold text-slate-500">
                    Palabra clave
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cargo u oficio" class="{{ $campo }}">
                </label>

                <label class="flex flex-col gap-1.5 text-[13px] font-bold text-slate-500">
                    Categoría

                    <select name="categoria" class="{{ $campo }}">
                        <option value="">Todas las categorías</option>

                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                @selected((string) request('categoria') === (string) $categoria->id)>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-1.5 text-[13px] font-bold text-slate-500">
                    Tipo de contrato

                    <select name="contrato" class="{{ $campo }}">
                        <option value="">Todos</option>

                        @foreach ($contratos as $valor => $texto)
                            <option value="{{ $valor }}"
                                @selected(request('contrato') === $valor)>
                                {{ $texto }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-1.5 text-[13px] font-bold text-slate-500">
                    Publicada por

                    <select name="publica" class="{{ $campo }}">
                        <option value="">Todos</option>

                        <option value="empresas"
                            @selected(request('publica') === 'empresas')>
                            Empresas
                        </option>

                        <option value="personas"
                            @selected(request('publica') === 'personas')>
                            Personas
                        </option>
                    </select>
                </label>

                <div class="flex flex-col gap-2.5">
                    <button type="submit" class="{{ $btnPrimario }} cursor-pointer">
                        Aplicar filtros
                    </button>

                    <a href="{{ url('/empleos') }}" class="{{ $btnSecundario }}">
                        Limpiar
                    </a>
                </div>
            </form>

            {{-- LISTADO --}}
            <div class="flex min-w-0 flex-1 basis-[520px] flex-col gap-4">

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <span class="text-[15px] text-slate-500">
                        Mostrando {{ $ofertas->firstItem() ?? 0 }}–{{ $ofertas->lastItem() ?? 0 }}
                        de {{ $ofertas->total() }}
                    </span>

                    <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-500">
                        Ordenar por

                        <select name="orden"
                                form="filtros-ofertas"
                                class="{{ $campo }} min-h-11 py-2.5"
                                onchange="this.form.submit()">

                            <option value="recientes"
                                @selected(request('orden', 'recientes') === 'recientes')>
                                Más recientes
                            </option>

                            <option value="antiguas"
                                @selected(request('orden') === 'antiguas')>
                                Más antiguas
                            </option>

                            <option value="vencen"
                                @selected(request('orden') === 'vencen')>
                                Vencen primero
                            </option>
                        </select>
                    </label>
                </div>

                @forelse ($ofertas as $oferta)
                    <article class="flex flex-wrap items-center gap-5 rounded-2xl border border-slate-200 bg-white p-6 transition hover:shadow-lg hover:shadow-noche/10">

                        @php
                            $publicador = $oferta->usuario ?? $oferta->empresa;

                            $datosModal = [
                                'id'          => $oferta->id,
                                'titulo'      => $oferta->titulo,
                                'publicador'  => $oferta->publicador,
                                'foto'        => $publicador?->fotoPerfil ? asset('storage/' . $publicador->fotoPerfil) : null,
                                'categoria'   => $oferta->categoria,
                                'contrato'    => $contratos[$oferta->tipoContrato] ?? $oferta->tipoContrato,
                                'salario'     => '$' . number_format($oferta->salario, 0, ',', '.'),
                                'ubicacion'   => $oferta->ubicacion,
                                'publicada'   => \Carbon\Carbon::parse($oferta->fechaPublicacion)->format('d/m/Y'),
                                'postulaciones' => $oferta->postulaciones->count(),
                                'vence'       => \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y'),
                                'diasRestantes' => (int) \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($oferta->fechaLimite)->startOfDay(), false),
                                'descripcion' => $oferta->descripcion,
                                'requisitos'  => array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $oferta->requisitos)))),
                            ];
                        @endphp

                        <div class="size-14 shrink-0 overflow-hidden rounded-full border-2 border-[#EAF6FD] bg-[#EAF6FD]">

                            @if ($publicador?->fotoPerfil)
                                <img
                                    src="{{ asset('storage/' . $publicador->fotoPerfil) }}"
                                    alt="Foto de perfil del publicador"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center text-marca-texto">
                                    <svg class="size-7" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0" />
                                    </svg>
                                </div>
                            @endif

                        </div>

                        <div class="flex min-w-[240px] flex-1 flex-col gap-2">
                            <h3 class="text-[19px] font-bold">
                                {{ $oferta->titulo }}
                            </h3>

                            <p class="text-sm text-slate-500">
                                {{ $oferta->publicador }}
                            </p>

                            <div class="flex flex-wrap gap-2">
                                @if ($oferta->categoria)
                                    <span class="{{ $etiqueta }}">
                                        {{ $oferta->categoria }}
                                    </span>
                                @endif

                                <span class="{{ $etiqueta }}">
                                    {{ $contratos[$oferta->tipoContrato] ?? $oferta->tipoContrato }}
                                </span>

                                <span class="{{ $etiqueta }}">
                                    ${{ number_format($oferta->salario, 0, ',', '.') }}
                                </span>

                                @if ($oferta->postulado)
                                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-[13px] font-bold text-amber-900">
                                        <span class="size-2 rounded-full bg-amber-500"></span>
                                        Ya te postulaste
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-x-5 gap-y-1.5 text-sm text-slate-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="size-[18px]" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>

                                    {{ $oferta->ubicacion }}
                                </span>

                                <span class="flex items-center gap-1.5">
                                    <svg class="size-[18px]" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                    Vence: {{ \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>

                        @if ($oferta->postulado)
                            <a href="{{ url('/mis-postulaciones') }}" class="{{ $btnSecundario }}">
                                Ver mi postulación
                            </a>
                        @else
                            <button type="button" data-ver-oferta="{{ json_encode($datosModal) }}"
                                    class="{{ $btnPrimario }} cursor-pointer">
                                Ver oferta
                            </button>
                        @endif
                    </article>
                @empty
                    <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-500">
                        No encontramos ofertas con esos filtros.
                    </div>
                @endforelse

            {{-- PAGINACIÓN --}}
            <div class="pt-3">
                {{ $ofertas->links('layouts.Publico.paginacion') }}
            </div>
        </div>
    </div>
</section>

    {{-- MODAL VER OFERTA --}}
    <div id="modal-oferta" hidden
        style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:50;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
        <div role="dialog" aria-modal="true" aria-labelledby="modal-titulo"
            style="width:100%;max-width:720px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

            {{-- Encabezado --}}
            <div style="display:flex;align-items:flex-start;gap:16px;padding:28px 28px 20px;border-bottom:1px solid #E3E8EF">
                <div style="width:64px;height:64px;flex:0 0 auto;border-radius:999px;overflow:hidden;background:#EAF6FD;border:2px solid #000000;display:flex;align-items:center;justify-content:center;color:#1A75A8">
                    <img id="modal-foto" hidden alt="Foto de perfil de quien publica" style="width:100%;height:100%;object-fit:cover">
                    <svg id="modal-foto-vacia" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0" />
                    </svg>
                </div>

                <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:6px">
                    <h2 id="modal-titulo" style="margin:0;font-size:24px;font-weight:800;color:#12303F;line-height:1.25"></h2>
                    <p style="margin:0;font-size:15px;color:#52606D">Publicada por <span id="modal-publicador" style="color:#1F2933;font-weight:700"></span></p>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;padding-top:6px">
                        <span id="modal-categoria" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                        <span id="modal-contrato" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                    </div>
                </div>

                <div id="modal-tarjeta-vence" style="background:#DCFCE7;border-radius:14px;padding:14px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span id="modal-titulo-vence" style="font-size:15px;font-weight:800;color:#166534">FINALIZA</span>
                        <span id="modal-dias-restantes"style="font-size:15px;font-weight:700;color: #166534"></span>
                        <span id="modal-vence"style="font-size:15px;font-weight:400;color: #166534"></span>
                    </div>

                <button type="button" data-cerrar-modal aria-label="Cerrar"
                        style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Cuerpo --}}
            <div style="padding:24px 28px;display:flex;flex-direction:column;gap:24px;overflow:auto">

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px">
                    <div style="background:#F5F7FA;border-radius:14px;padding:14px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;text-transform:uppercase;letter-spacing:0.04em">Salario</span>
                        <span id="modal-salario" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>
                    <div style="background:#F5F7FA;border-radius:14px;padding:14px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;text-transform:uppercase;letter-spacing:0.04em">Ubicación</span>
                        <span id="modal-ubicacion" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>
                    <div style="background:#F5F7FA;border-radius:14px;padding:14px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;text-transform:uppercase;letter-spacing:0.04em">Publicada</span>
                        <span id="modal-publicada" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>

                    <div style="background:#EAF6FD;border-radius:14px;padding:14px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#1A75A8;text-transform:uppercase;letter-spacing:0.04em">Postulaciones</span>
                        <span id="modal-postulaciones" style="font-size:15px;font-weight:700;color:#1A75A8"></span>
                    </div>

                </div>

                <div style="display:flex;flex-direction:column;gap:8px">
                    <h3 style="margin:0;font-size:15px;font-weight:800;color:#52606D">DESCRIPCIÓN</h3>
                    <p id="modal-descripcion" style="margin:0;font-size:15px;line-height:1.7;color:#3E4C59;white-space:pre-line"></p>
                </div>

                <div id="modal-bloque-requisitos" style="display:flex;flex-direction:column;gap:10px">
                    <h3 style="margin:0;font-size:15px;font-weight:800;color:#52606D">REQUISITOS</h3>
                    <div id="modal-requisitos" style="display:flex;flex-direction:column;gap:10px"></div>
                </div>

                @if (! $esEmpresa && $hojaDeVidaProgreso < 100)
                    <div style="background:#EAF6FD;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px;font-size:14px;line-height:1.5;color:#12303F">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto">
                            <path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <span>
                            Quien publica la oferta verá tu hoja de vida.
                            <a href="{{ url('/hojaDeVida') }}" style="font-weight:700;color:#1A75A8;text-decoration:underline">Completa tu hoja de vida</a>
                            para tener más opciones.
                        </span>
                    </div>
                @endif
            </div>

                {{-- Pie --}}
                <form id="modal-form-postular" method="POST" action="#" data-base="{{ url('/empleos') }}"
                    style="margin:0;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;padding:18px 28px;border-top:1px solid #E3E8EF;background:#FFFFFF">
                    @csrf
                    {{-- TEMPORAL: cuando exista el login, este campo se quita y el usuario sale de la sesión --}}
                    @if (! empty($idUsuario))
                        <input type="hidden" name="idUsuario" value="{{ $idUsuario }}">
                    @endif

                    <button type="button" data-cerrar-modal class="{{ $btnSecundario }} cursor-pointer">Cerrar</button>
                    <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Postularme</button>
                </form>
            </div>
        </div>

        @push('scripts')
        <script>
            (function () {
                const modal = document.getElementById('modal-oferta');
                const formPostular = document.getElementById('modal-form-postular');
                const ICONO_CHECK =
                    '<span style="width:22px;height:22px;border-radius:999px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto;margin-top:2px">' +
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
                    '<path d="M4.5 12.75l6 6 9-13.5" /></svg></span>';
                let botonOrigen = null;

                function texto(id, valor) {
                    document.getElementById(id).textContent = valor ?? '';
                }

                function abrir(boton) {
                    const o = JSON.parse(boton.dataset.verOferta);
                    botonOrigen = boton;

                    texto('modal-titulo', o.titulo);
                    texto('modal-publicador', o.publicador);
                    texto('modal-contrato', o.contrato);
                    texto('modal-salario', o.salario);
                    texto('modal-ubicacion', o.ubicacion);
                    texto('modal-publicada', o.publicada);
                    texto('modal-vence', o.vence);
                    texto('modal-descripcion', o.descripcion);
                    texto('modal-postulaciones', o.postulaciones);
                    // Estado visual de la fecha de finalización
                    const tarjetaVence = document.getElementById('modal-tarjeta-vence');
                    const tituloVence = document.getElementById('modal-titulo-vence');
                    const diasVence = document.getElementById('modal-dias-restantes');
                    const fechaVence = document.getElementById('modal-vence');

                    const dias = Number(o.diasRestantes);

                    let fondo;
                    let color;

                    if (dias < 3) {
                        fondo = '#FEE2E2';
                        color = '#991B1B';
                    } else if (dias < 7) {
                        fondo = '#FEF3C7';
                        color = '#92400E';
                    } else {
                        fondo = '#DCFCE7';
                        color = '#166534';
                    }

                    tarjetaVence.style.backgroundColor = fondo;
                    tituloVence.style.color = color;
                    diasVence.style.color = color;
                    fechaVence.style.color = color;

                    if (dias === 0) {
                        diasVence.textContent = 'Finaliza hoy';
                    } else if (dias === 1) {
                        diasVence.textContent = '1 día';
                    } else if (dias > 1) {
                        diasVence.textContent = dias + ' días';
                    } else {
                        diasVence.textContent = 'Oferta vencida';
                    }

                    const categoria = document.getElementById('modal-categoria');
                    categoria.textContent = o.categoria ?? '';
                    categoria.hidden = !o.categoria;

                    // Foto de perfil de quien publica (si no tiene, se muestra el icono de persona)
                    const foto = document.getElementById('modal-foto');
                    const fotoVacia = document.getElementById('modal-foto-vacia');
                    if (o.foto) {
                        foto.src = o.foto;
                        foto.hidden = false;
                        fotoVacia.style.display = 'none';
                    } else {
                        foto.removeAttribute('src');
                        foto.hidden = true;
                        fotoVacia.style.display = '';
                    }

                    const lista = document.getElementById('modal-requisitos');
                    lista.replaceChildren();
                    o.requisitos.forEach(function (requisito) {
                        const item = document.createElement('div');
                        item.style.cssText = 'display:flex;align-items:flex-start;gap:10px;font-size:15px;line-height:1.6;color:#3E4C59';
                        item.innerHTML = ICONO_CHECK;
                        const span = document.createElement('span');
                        span.textContent = requisito;
                        item.appendChild(span);
                        lista.appendChild(item);
                    });
                    document.getElementById('modal-bloque-requisitos').style.display = o.requisitos.length ? 'flex' : 'none';

                    formPostular.action = formPostular.dataset.base + '/' + o.id + '/postular';

                    modal.hidden = false;
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    modal.querySelector('[data-cerrar-modal]').focus();
                }

                function cerrar() {
                    modal.hidden = true;
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                    if (botonOrigen) botonOrigen.focus();
                }

                document.addEventListener('click', function (e) {
                    const boton = e.target.closest('[data-ver-oferta]');
                    if (boton) { abrir(boton); return; }
                    if (e.target.closest('[data-cerrar-modal]') || e.target === modal) cerrar();
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !modal.hidden) cerrar();
                });
            })();
        </script>
    @endpush
@endsection
