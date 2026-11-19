@extends('layouts.Publico.Usuario.usuario')

@section('title', 'Ofertas')

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
    $visor = request()->user();
    $empresaVisora = $visor instanceof \App\Models\Empresa ? $visor : null;
    $puedeVerCalificaciones = ! $empresaVisora || $empresaVisora->can('ver calificacion');
@endphp

{{-- ENCABEZADO + TARJETAS --}}
<section class="bg-[#EAF6FD] px-4 pb-8 pt-7 sm:px-6 sm:pb-12 sm:pt-10">
    <div class="mx-auto flex max-w-6xl flex-col gap-6 sm:gap-7">

        @include('layouts.Publico.avisosPaginas')

        <div class="flex flex-col gap-1.5 sm:gap-2">
            <span class="text-[15px] font-bold text-marca-texto sm:text-base">
                Hola, {{ $nombre }}
            </span>

            <h1 class="text-3xl font-extrabold leading-tight text-noche md:text-4xl">
                Ofertas de empleo
            </h1>

            <p class="text-[15px] text-slate-600 sm:text-base">
                {{ $totalOfertas }} ofertas activas en Málaga, Santander
            </p>
        </div>

        <div class="grid gap-5 {{ $esEmpresa ? '' : 'md:grid-cols-2' }}">

            {{-- TUS POSTULACIONES --}}
            @unless ($esEmpresa)
                <div class="flex flex-col gap-5 rounded-[20px] bg-white p-5 shadow-lg shadow-noche/10 sm:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-1 sm:gap-y-2">
                        <h2 class="text-[19px] font-extrabold text-noche">
                            Tus postulaciones
                        </h2>

                        <a href="{{ url('/mis-postulaciones') }}"
                            class="py-2 text-[15px] font-bold text-marca-texto hover:underline">
                            Ver mis postulaciones
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 sm:gap-4">
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

            @unless ($esEmpresa)
                {{-- PUBLICAR OFERTA: disponible en la interfaz de Usuario. --}}
                <div class="flex flex-col gap-4 rounded-[20px] bg-noche p-5 shadow-lg shadow-noche/10 sm:p-6">
                    <h2 class="text-[19px] font-extrabold text-white">
                        ¿Necesitas contratar a alguien?
                    </h2>

                    <p class="text-[15px] leading-relaxed text-slate-300">
                        Publica una oferta, recibe postulaciones y elige a la persona que mejor se ajuste.
                    </p>

                    <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                        <button type="button" data-abrir-crear-oferta class="{{ $btnPrimario }} w-full cursor-pointer sm:w-auto">
                            <svg class="size-[18px]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Publicar una oferta
                        </button>

                        <a href="{{ url('/mis-ofertas') }}"
                            class="inline-flex w-full items-center justify-center rounded-full border-2 border-white px-4 py-3 text-center text-[15px] font-bold text-white transition hover:border-carbon hover:bg-carbon sm:w-auto">
                            Ver mis ofertas y postulantes
                        </a>
                    </div>

                </div>
            @endunless
        </div>
    </div>
</section>

@unless ($esEmpresa)
    @include('layouts.Publico.crearOferta')
@endunless

        {{-- AVISO HOJA DE VIDA --}}
            @if (! $esEmpresa && $hojaDeVidaProgreso < 100)
                <section class="px-4 pt-5 sm:px-6 sm:pt-6">
                    <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-x-4 gap-y-4 rounded-2xl border border-slate-200 bg-white p-4 sm:gap-x-7 sm:px-6 sm:py-4">
                        <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        </span>

                        <div class="min-w-0 flex-1 sm:min-w-[240px]">
                            <p class="text-[17px] font-extrabold text-noche">
                                Completa tu hoja de vida
                            </p>

                            <p class="text-sm text-slate-500">
                                Quien publica una oferta la revisa cuando te postulas.
                            </p>
                        </div>

                        <div class="w-full sm:w-auto sm:min-w-[200px] sm:flex-1">
                            <p class="mb-1.5 text-[13px] font-bold text-slate-500">
                                {{ $hojaDeVidaProgreso }}% completado
                            </p>

                            <div class="h-2.5 rounded-full bg-slate-200">
                                <div class="h-2.5 rounded-full bg-marca"
                                    style="width: {{ $hojaDeVidaProgreso }}%"></div>
                            </div>
                        </div>

                        <button type="button" data-abrir-hoja-de-vida class="{{ $btnSecundario }} w-full cursor-pointer sm:w-auto">
                            Completar
                        </button>
                    </div>
                </section>
            @endif

    @include('layouts.Publico.usuario.crearHojaDeVida')

{{-- FILTROS + LISTADO --}}
<section class="px-4 pb-12 pt-6 sm:px-6 sm:pb-16 sm:pt-8">
    <div class="mx-auto flex max-w-6xl flex-wrap items-start gap-5 lg:gap-8">

        {{-- FILTROS --}}
        <form id="filtros-ofertas" method="GET" action="{{ url('/empleos') }}"
            class="flex w-full flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 sm:p-6 lg:w-72 lg:shrink-0">

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
                        Empresa
                    </option>

                    <option value="personas"
                        @selected(request('publica') === 'personas')>
                        Persona Natural
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
        <div class="flex min-w-0 flex-1 basis-full flex-col gap-4 lg:basis-[520px]">

            <div class="flex flex-col gap-2.5 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between sm:gap-3">
                <span class="text-[15px] text-slate-500">
                    Mostrando {{ $ofertas->firstItem() ?? 0 }}–{{ $ofertas->lastItem() ?? 0 }}
                    de {{ $ofertas->total() }}
                </span>

                <label class="flex w-full flex-col gap-1.5 text-sm font-semibold text-slate-500 sm:w-auto sm:flex-row sm:items-center sm:gap-2.5">
                    Ordenar por

                    <select name="orden" form="filtros-ofertas" class="{{ $campo }} min-h-11 w-full py-2.5 sm:w-auto" onchange="this.form.submit()">
                        <option value="recientes" @selected(request('orden', 'recientes') === 'recientes')>Más recientes</option>
                        <option value="antiguas" @selected(request('orden') === 'antiguas')>Más antiguas</option>
                        <option value="vencen" @selected(request('orden') === 'vencen')>Vencen primero</option>
                    </select>
                </label>
            </div>

            @forelse ($ofertas as $oferta)
                <article class="flex flex-wrap items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 transition hover:shadow-lg hover:shadow-noche/10 sm:gap-5 sm:p-6">

                    @php
                        $publicador = $oferta->usuario ?? $oferta->empresa;
                        $fotoPublicador = $publicador?->fotoPerfil
                            ? asset('storage/' . ($oferta->idEmpresa ? 'empresas/' . $publicador->fotoPerfil : $publicador->fotoPerfil))
                            : null;
                        $reputacionPublicador = $oferta->reputacionPublicador;
                        $promedioPublicadorTexto = rtrim(rtrim(number_format($reputacionPublicador['promedio'], 2, '.', ''), '0'), '.');

                        $datosModal = [
                            'id'          => $oferta->id,
                            'titulo'      => $oferta->titulo,
                            'publicador'  => $oferta->publicador,
                            'telefono'    => $publicador?->telefono,
                            'foto'        => $fotoPublicador,
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

                        @if ($fotoPublicador)
                            <img
                                src="{{ $fotoPublicador }}"
                                alt="Foto de perfil del publicador"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center text-marca-texto">
                                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0" />
                                </svg>
                            </div>
                        @endif

                    </div>

                    <div class="flex min-w-0 flex-1 flex-col gap-2 sm:min-w-[240px]">
                        <h3 class="text-[18px] font-bold leading-snug sm:text-[19px]">
                            {{ $oferta->titulo }}
                        </h3>

                        {{-- NOMBRE Y CALIFICACIÓN EN LA MISMA LÍNEA --}}
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5">

                            <p class="text-sm text-slate-500">
                                {{ $oferta->publicador }}
                            </p>

                            @if ($puedeVerCalificaciones)
                                <button type="button"
                                    @click="$dispatch('abrir-calificaciones', { url: '{{ route('perfil.calificaciones.publicas', [$oferta->idEmpresa ? 'empresa' : 'usuario', $oferta->idEmpresa ?: $oferta->idUsuario]) }}' })"
                                    class="inline-flex w-fit items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-800 hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-400"
                                    aria-label="{{ $reputacionPublicador['total'] > 0 ? $promedioPublicadorTexto . ' de 5, ' . $reputacionPublicador['total'] . ' calificaciones' : 'Sin calificaciones' }}">
                            @else
                                <span
                                    class="inline-flex w-fit items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-800"
                                    aria-label="{{ $reputacionPublicador['total'] > 0 ? $promedioPublicadorTexto . ' de 5, ' . $reputacionPublicador['total'] . ' calificaciones' : 'Sin calificaciones' }}">
                            @endif

                                <svg class="size-4 text-amber-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" />
                                </svg>

                                @if ($reputacionPublicador['total'] > 0)
                                    {{ $promedioPublicadorTexto }}/5
                                    <span class="text-amber-700">
                                        · {{ $reputacionPublicador['total'] }}
                                        {{ $reputacionPublicador['total'] === 1 ? 'calificación' : 'calificaciones' }}
                                    </span>
                                @else
                                    Sin calificaciones
                                @endif

                            @if ($puedeVerCalificaciones)
                                </button>
                            @else
                                </span>
                            @endif

                        </div>

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

                        </div>

                        <div class="flex flex-col gap-1.5 text-sm text-slate-500 sm:flex-row sm:flex-wrap sm:gap-x-5">
                            <span class="flex items-center gap-1.5">
                                <svg class="size-[18px] shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>

                                {{ $oferta->ubicacion }}
                            </span>

                            <span class="flex items-center gap-1.5">
                                <svg class="size-[18px] shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                                Vence: {{ \Carbon\Carbon::parse($oferta->fechaLimite)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>

                    @if ($oferta->postulado)
                        <button type="button" data-ver-postulacion="{{ json_encode($datosModal) }}"
                            class="{{ $btnSecundario }} basis-full cursor-pointer sm:basis-auto">
                            Ver mi postulación
                        </button>
                    @else
                        <button type="button" data-ver-oferta="{{ json_encode($datosModal) }}"
                            class="{{ $btnPrimario }} basis-full cursor-pointer sm:basis-auto">
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

@include('layouts.Publico.Usuario.verOfertaUsuario')

@include('layouts.Publico.Usuario.verPostulacionUsuario')

@endsection
