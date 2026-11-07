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

        @include('layouts.Publico.avisosPaginas')

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

                        <a href="{{ url('/mis-postulaciones') }}"
                            class="py-2 text-[15px] font-bold text-marca-texto hover:underline">
                            Ver mis postulaciones
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="flex flex-col items-center gap-2.5">
                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-[13px] font-bold text-amber-900">
                                <span class="size-2 rounded-full bg-amber-500"></span>
                                Enviadas
                            </span>

                            <span class="text-3xl font-extrabold leading-none text-noche">
                                {{ $resumenPostulaciones['enviadas'] }}
                            </span>
                        </div>

                        <div class="flex flex-col items-center gap-2.5">
                            <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-[13px] font-bold text-green-900">
                                <span class="size-2 rounded-full bg-green-600"></span>
                                Aceptadas
                            </span>

                            <span class="text-3xl font-extrabold leading-none text-noche">
                                {{ $resumenPostulaciones['aceptadas'] }}
                            </span>
                        </div>

                        <div class="flex flex-col items-center gap-2.5">
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-[13px] font-bold text-red-900">
                                <span class="size-2 rounded-full bg-red-600"></span>
                                Rechazadas
                            </span>

                            <span class=" text-3xl font-extrabold leading-none text-noche">
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
                    <button type="button" data-abrir-crear-oferta class="{{ $btnPrimario }} cursor-pointer">
                        <svg class="size-[18px]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round"d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Publicar una oferta
                    </button>

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

    @include('layouts.Publico.crearOferta')

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

                        <button type="button" data-abrir-hoja-de-vida class="{{ $btnSecundario }} cursor-pointer">
                            Completar
                        </button>
                    </div>
                </section>
            @endif

    @include('layouts.Publico.crearHojaDeVida')

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

                        <select name="orden" form="filtros-ofertas" class="{{ $campo }} min-h-11 py-2.5" onchange="this.form.submit()">
                            <option value="recientes" @selected(request('orden', 'recientes') === 'recientes')>Más recientes</option>
                            <option value="antiguas" @selected(request('orden') === 'antiguas')>Más antiguas</option>
                            <option value="vencen" @selected(request('orden') === 'vencen')>Vencen primero</option>
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
                                'diasRestantes' => (int) \Carbon\Carbon::now('America/Bogota')->startOfDay()->diffInDays(\Carbon\Carbon::parse($oferta->fechaLimite, 'America/Bogota')->startOfDay(),false),
                                'descripcion' => $oferta->descripcion,
                                'postulacion' => $oferta->postulacion, // null si no te has postulado
                                'requisitos'  => array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $oferta->requisitos)))),
                            ];
                        @endphp

                        <div class="size-14 shrink-0 overflow-hidden rounded-full border-2 border-black bg-[#EAF6FD]">

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
                            <button type="button" data-ver-postulacion="{{ json_encode($datosModal) }}"
                                    class="{{ $btnSecundario }} cursor-pointer">
                                Ver mi postulación
                            </button>
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

    @include('layouts.Publico.verOfertaUsuario')

    @include('layouts.Publico.verPostulacionUsuario')

@endsection
