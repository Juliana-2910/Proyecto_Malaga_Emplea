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


        {{-- MODAL COMPLETAR MI HOJA DE VIDA --}}
        @php
            $niveles = [
                'Basica Primaria'   => 'Básica primaria',
                'Basica Secundaria' => 'Básica secundaria',
                'Tecnico'           => 'Técnico',
                'Tecnologo'         => 'Tecnólogo',
                'Profesional'       => 'Profesional',
            ];

            $campoHv = 'font-family:inherit;font-size:15px;padding:12px 14px;border:1.5px solid #CBD2D9;border-radius:10px;color:#1F2933;background:#FFFFFF;width:100%;box-sizing:border-box';
            $labelHv = 'display:flex;flex-direction:column;gap:6px;font-size:13px;font-weight:500;color:#52606D';
            $errorHv = 'font-size:12px;font-weight:600;color:#B42318';

            $urlArchivoHv = !empty($hojaDeVida?->archivoCV)
                ? asset('storage/' . $hojaDeVida->archivoCV)
                : '';

            $nombreArchivoHv = !empty($hojaDeVida?->archivoCV)
                ? basename($hojaDeVida->archivoCV)
                : '';

            $fechaArchivoHv = !empty($hojaDeVida?->archivoCV) && !empty($hojaDeVida->fechaActualizacion)
                ? 'Actualizado el ' . \Carbon\Carbon::parse($hojaDeVida->fechaActualizacion)->format('d/m/Y')
                : '';
        @endphp

        <div id="modal-hoja-de-vida" hidden
            data-abrir-al-cargar="{{ $errors->any() ? '1' : '0' }}"
            style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:55;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">

            <div role="dialog" aria-modal="true" aria-labelledby="hv-titulo"
                style="width:100%;max-width:720px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

                {{-- Encabezado --}}
                <div style="padding:28px 28px 20px;display:flex;flex-direction:column;gap:18px;border-bottom:1px solid #E3E8EF">

                    <div style="display:flex;align-items:flex-start;gap:16px">

                        <span style="width:56px;height:56px;border-radius:14px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            </svg>
                        </span>

                        <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:4px">
                            <h2 id="hv-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25">
                                Mi hoja de vida
                            </h2>

                            <span style="font-size:15px;line-height:1.5;color:#52606D">
                                Quien publica una oferta la revisa cuando te postulas.
                            </span>
                        </div>

                        <button type="button" data-cerrar-hoja aria-label="Cerrar"
                            style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                    </div>

                    {{-- Progreso --}}
                    <div style="display:flex;flex-direction:column;gap:6px">

                        <span id="hv-progreso-texto" style="font-size:13px;font-weight:700;color:#52606D">
                            {{ $hojaDeVidaProgreso }}% completado
                        </span>

                        <div style="height:10px;border-radius:999px;background:#E3E8EF">
                            <div id="hv-progreso-barra"
                                style="width:{{ $hojaDeVidaProgreso }}%;height:10px;border-radius:999px;background:#4DB6E8;transition:width .2s">
                            </div>
                        </div>

                    </div>
                </div>

                <form id="hv-form" method="POST"
                    action="{{ route('Publico.guardarHojaDeVida') }}"
                    enctype="multipart/form-data"
                    style="margin:0;display:flex;flex-direction:column;min-height:0;flex:1 1 auto">

                    @csrf

                    {{-- TEMPORAL: cuando exista el login, este campo se quita y el usuario sale de la sesión --}}
                    @if (!empty($idUsuario))
                        <input type="hidden" name="idUsuario" value="{{ $idUsuario }}">
                    @endif

                    {{-- Formulario --}}
                    <div style="padding:24px 28px;display:flex;flex-direction:column;gap:20px;overflow:auto">

                        {{-- Ubicación y nivel educativo --}}
                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px">

                            <label style="{{ $labelHv }}">
                                Ubicación

                                <input type="text" name="ubicacion" data-hv-campo maxlength="255"
                                    placeholder="Ej.: Málaga, Santander"
                                    value="{{ $errors->any() ? old('ubicacion') : ($hojaDeVida->ubicacion ?? '') }}"
                                    style="{{ $campoHv }}">

                                @error('ubicacion')
                                    <span style="{{ $errorHv }}">{{ $message }}</span>
                                @enderror
                            </label>

                            <label style="{{ $labelHv }}">
                                Nivel Educativo

                                <select name="nivelEducativo" data-hv-campo
                                    style="{{ $campoHv }};min-height:46px">

                                    <option value="">Selecciona una opción</option>

                                    @foreach ($niveles as $valor => $texto)
                                        <option value="{{ $valor }}"
                                            @selected(old('nivelEducativo', $hojaDeVida->nivelEducativo ?? '') === $valor)>
                                            {{ $texto }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('nivelEducativo')
                                    <span style="{{ $errorHv }}">{{ $message }}</span>
                                @enderror
                            </label>

                        </div>

                        {{-- Perfil personal --}}
                        <label style="{{ $labelHv }}">

                            <span style="display:flex;justify-content:space-between;gap:12px">
                                <span>Perfil Personal</span>

                                <span data-hv-contador style="font-weight:600;color:#7B8794"></span>
                            </span>

                            <textarea name="perfilProfesional" data-hv-campo data-hv-max
                                rows="3" maxlength="255"
                                placeholder="Cuéntale a quien publica quién eres y qué sabes hacer"
                                style="{{ $campoHv }};line-height:1.5;resize:vertical">{{ old('perfilProfesional', $hojaDeVida->perfilProfesional ?? '') }}</textarea>

                            @error('perfilProfesional')
                                <span style="{{ $errorHv }}">{{ $message }}</span>
                            @enderror

                        </label>

                        {{-- Experiencia laboral --}}
                        <label style="{{ $labelHv }}">

                            <span style="display:flex;justify-content:space-between;gap:12px">
                                <span>Experiencia Laboral</span>

                                <span data-hv-contador style="font-weight:600;color:#7B8794"></span>
                            </span>

                            <textarea name="experienciaLaboral" data-hv-campo data-hv-max
                                rows="3" maxlength="255"
                                placeholder="Dónde has trabajado, qué hacías y por cuánto tiempo"
                                style="{{ $campoHv }};line-height:1.5;resize:vertical">{{ old('experienciaLaboral', $hojaDeVida->experienciaLaboral ?? '') }}</textarea>

                            @error('experienciaLaboral')
                                <span style="{{ $errorHv }}">{{ $message }}</span>
                            @enderror

                        </label>

                        {{-- Archivo PDF (opcional) --}}
                        <div style="display:flex;flex-direction:column;gap:8px">

                            <span style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;color:#52606D">
                                Archivo CV en PDF

                                <span style="padding:2px 8px;border-radius:999px;background:#F5F7FA;border:1px solid #E3E8EF;font-size:11px;font-weight:700;color:#7B8794">
                                    Opcional
                                </span>
                            </span>

                            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px">

                                {{-- Izquierda: elegir o arrastrar --}}
                                <label id="hv-zona"
                                    style="border:2px dashed #CBD2D9;border-radius:14px;padding:22px 18px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:8px;background:#F5F7FA;cursor:pointer">

                                    <input type="file" id="hv-archivo" name="archivoCV"
                                        accept="application/pdf,.pdf" style="display:none">

                                    <span style="width:44px;height:44px;border-radius:999px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                        </svg>
                                    </span>

                                    <span id="hv-zona-titulo"
                                        style="font-size:15px;font-weight:700;color:#12303F;word-break:break-all">
                                        Elige tu archivo o arrástralo aquí
                                    </span>

                                    <span id="hv-zona-ayuda"
                                        style="font-size:13px;color:#52606D">
                                        Solo PDF · máximo 5 MB
                                    </span>

                                </label>

                                {{-- Derecha: archivo actual o seleccionado --}}
                                <div id="hv-archivo-panel"
                                    data-archivo-url="{{ !empty($hojaDeVida?->archivoCV) ? asset('storage/' . $hojaDeVida->archivoCV) : '' }}"
                                    data-archivo-nombre="{{ !empty($hojaDeVida?->archivoCV) ? basename($hojaDeVida->archivoCV) : '' }}"
                                    data-archivo-fecha="{{ !empty($hojaDeVida?->archivoCV) ? 'Actualizado el ' . \Carbon\Carbon::parse($hojaDeVida->fechaActualizacion)->format('d/m/Y') : '' }}"
                                    style="border:1px solid #E3E8EF;border-radius:14px;padding:22px 18px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:8px;background:#FFFFFF">

                                    <span id="hv-archivo-titulo" style="font-size:12px;font-weight:800;color:#52606D;text-transform:uppercase;letter-spacing:0.04em">
                                        {{ !empty($hojaDeVida?->archivoCV) ? 'Archivo actual' : 'Vista previa' }}
                                    </span>

                                    <span id="hv-archivo-icono" style="width:44px;height:44px;border-radius:12px;background:#FEE2E2;color:#B42318;display:{{ !empty($hojaDeVida?->archivoCV) ? 'flex' : 'none' }};align-items:center;justify-content:center;font-size:12px;font-weight:800">
                                        PDF
                                    </span>

                                    <div id="hv-archivo-detalle" style="min-width:0;max-width:100%;display:{{ !empty($hojaDeVida?->archivoCV) ? 'flex' : 'none' }};flex-direction:column;gap:2px">

                                        <span id="hv-archivo-nombre" style="font-size:14px;font-weight:700;color:#1F2933;word-break:break-all">
                                            {{ !empty($hojaDeVida?->archivoCV) ? basename($hojaDeVida->archivoCV) : '' }}
                                        </span>

                                        <span id="hv-archivo-fecha" style="font-size:12px;color:#52606D">
                                            {{ !empty($hojaDeVida?->archivoCV) ? 'Actualizado el ' . \Carbon\Carbon::parse($hojaDeVida->fechaActualizacion)->format('d/m/Y') : '' }}
                                        </span>

                                    </div>

                                    <span id="hv-archivo-vacio" style="font-size:13px;color:#7B8794;display:{{ !empty($hojaDeVida?->archivoCV) ? 'none' : 'block' }}">
                                        Aún no has subido un archivo.
                                    </span>

                                    <a id="hv-archivo-ver"
                                        href="{{ !empty($hojaDeVida?->archivoCV) ? asset('storage/' . $hojaDeVida->archivoCV) : '#' }}"
                                        target="_blank" rel="noopener"
                                        style="width:38px;height:38px;border:1px solid #E3E8EF;border-radius:50%;display:{{ !empty($hojaDeVida?->archivoCV) ? 'inline-flex' : 'none' }};align-items:center;justify-content:center;background:#FFFFFF;color:#1A75A8;;text-decoration:none;transition:all 0.2s ease"
                                        title="Ver archivo PDF"
                                        aria-label="Ver archivo PDF">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"> <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                </div>
                            </div>

                            @error('archivoCV')
                                <span style="{{ $errorHv }}">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                    {{-- Botonoes --}}
                    <div style="padding:18px 28px;border-top:1px solid #E3E8EF;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;background:#FFFFFF">

                        <button type="button" data-cerrar-hoja
                            class="{{ $btnSecundario }} cursor-pointer">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="{{ $btnPrimario }} cursor-pointer">
                            Guardar
                        </button>

                    </div>

                </form>

            </div>
        </div>


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
                                'diasRestantes' => (int) \Carbon\Carbon::now('America/Bogota')->startOfDay()->diffInDays(\Carbon\Carbon::parse($oferta->fechaLimite, 'America/Bogota')->startOfDay(),false),
                                'descripcion' => $oferta->descripcion,
                                'postulacion' => $oferta->postulacion, // null si no te has postulado
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

    {{-- MODAL VER OFERTA --}}
    <div id="modal-oferta" hidden
        style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:50;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
        <div role="dialog" aria-modal="true" aria-labelledby="modal-titulo"
            style="width:100%;max-width:700px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

            {{-- Encabezado --}}
            <div style="display:flex;align-items:flex-start;gap:16px;padding:28px 28px 20px;border-bottom:1px solid #E3E8EF">
                <div style="width:64px;height:64px;flex:0 0 auto;border-radius:999px;overflow:hidden;background:#EAF6FD;border:2px solid #000000;display:flex;align-items:center;justify-content:center;color:#1A75A8">
                    <img id="modal-foto" hidden alt="Foto de perfil de quien publica" style="width:100%;height:100%;object-fit:cover">
                    <svg id="modal-foto-vacia" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0" />
                    </svg>
                </div>

                <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:6px">
                    <h2 id="modal-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25"></h2>
                    <p style="margin:0;font-size:15px;color:#52606D">Publicada por <span id="modal-publicador" style="color:#1F2933;font-weight:700"></span></p>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;padding-top:6px">
                        <span id="modal-categoria" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                        <span id="modal-contrato" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                    </div>
                </div>

                <div id="modal-tarjeta-vence" style="background:#DCFCE7;border-radius:14px;padding:10px 30px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span id="modal-titulo-vence" style="font-size:15px;font-weight:800;color:#166534 letter-spacing:0.04em">FINALIZA</span>
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
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Salario</span>
                        <span id="modal-salario" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Ubicación</span>
                        <span id="modal-ubicacion" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Publicada</span>
                        <span id="modal-publicada" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>

                    <div style="background:#EAF6FD;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#1A75A8;letter-spacing:0.04em">Postulaciones</span>
                        <span id="modal-postulaciones" style="font-size:15px;font-weight:700;color:#1A75A8"></span>
                    </div>

                </div>

                <div style="display:flex;flex-direction:column;gap:8px">
                    <h3 style="margin:0;font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Descripción</h3>
                    <p id="modal-descripcion" style="margin:0;font-size:15px;line-height:1.7;color:#3E4C59;white-space:pre-line"></p>
                </div>

                <div id="modal-bloque-requisitos" style="display:flex;flex-direction:column;gap:10px">
                    <h3 style="margin:0;font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Requisitos</h3>
                    <div id="modal-requisitos" style="display:flex;flex-direction:column;gap:10px"></div>
                </div>

                @if (! $esEmpresa && $hojaDeVidaProgreso < 100)
                    <div style="background:#EAF6FD;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px;font-size:14px;line-height:1.5;color:#12303F">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto">
                            <path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <span>
                            Quien publica la oferta verá tu hoja de vida.
                            <button type="button" data-abrir-hoja-de-vida style="border:none;background:transparent;padding:0;font:inherit;font-weight:700;color:#1A75A8;text-decoration:underline;cursor:pointer">Completala</button>
                            para tener más opciones.
                        </span>
                    </div>
                @endif
            </div>

                {{-- Botones --}}
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

    {{-- MODAL VER MI POSTULACIÓN --}}
    <div id="modal-postulacion" hidden
        style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:50;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
        <div role="dialog" aria-modal="true" aria-labelledby="mp-titulo"
            style="width:100%;max-width:660px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

            {{-- Encabezado --}}
            <div style="display:flex;align-items:flex-start;gap:16px;padding:28px 28px 20px;border-bottom:1px solid #E3E8EF">
                <div style="width:64px;height:64px;flex:0 0 auto;border-radius:999px;overflow:hidden;background:#EAF6FD;border:2px solid #000000;display:flex;align-items:center;justify-content:center;color:#1A75A8">
                    <img id="mp-foto" hidden alt="Foto de perfil de quien publica" style="width:100%;height:100%;object-fit:cover">
                    <svg id="mp-foto-vacia" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0" />
                    </svg>
                </div>

                <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:6px">
                    <span style="font-size:13px;font-weight:800;color:#1A75A8;text-transform:uppercase;letter-spacing:0.04em">Mi postulación</span>
                    <h2 id="mp-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25"></h2>
                    <p style="margin:0;font-size:15px;color:#52606D">Publicada por <span id="mp-publicador" style="color:#1F2933;font-weight:700"></span></p>
                </div>

                <button type="button" data-cerrar-postulacion aria-label="Cerrar"
                        style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Cuerpo --}}
            <div style="padding:24px 28px;display:flex;flex-direction:column;gap:24px;overflow:auto">

                {{-- Estado de la postulación --}}
                <div id="mp-estado-caja" style="border-radius:14px;padding:10px 18px;display:flex;align-items:center;gap:16px">

                    {{-- Icono del estado --}}
                    <span id="mp-estado-circulo" style="width:44px;height:44px;border-radius:999px;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                    </span>

                    {{-- Mensaje del estado --}}
                    <div style="width:fit-content;max-width:90%;background:#FFFFFF;border-radius:999px;padding:5px 18px">
                        <span id="mp-estado-mensaje" style="display:block;font-size:15px;line-height:1.5;font-weight:700"></span>
                    </div>
                </div>

                {{-- Fechas --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px">
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Te postulaste el</span>
                        <span id="mp-fecha" style="font-size:15px;font-weight:400;color:#12303F"></span>
                    </div>
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">La oferta vence el</span>
                        <span id="mp-vence" style="font-size:15px;font-weight:400;color:#12303F"></span>
                    </div>
                    
                </div>

                {{-- Resumen de la oferta --}}
                <div style="display:flex;flex-direction:column;gap:12px">
                    <h3 style="margin:0;font-size:17px;font-weight:700;color:#12303F letter-spacing:0.04em">Resumen de la oferta</h3>
                    <div style="border:1px solid #E3E8EF;border-radius:14px;padding:16px 18px;display:flex;flex-direction:column;gap:12px">
                        <div style="display:flex;flex-wrap:wrap;gap:8px">
                            <span id="mp-categoria" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                            <span id="mp-contrato" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                            <span id="mp-salario" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                            <span style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59; display:flex;align-items:center;gap:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <span id="mp-ubicacion"></span>
                        </span>
                        </div>

                        <p id="mp-descripcion" style="margin:0;font-size:14px;line-height:1.6;color:#3E4C59;white-space:pre-line"></p>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div style="margin:0;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;padding:18px 28px;border-top:1px solid #E3E8EF;background:#FFFFFF">
                <button type="button" data-cerrar-postulacion class="{{ $btnSecundario }} cursor-pointer">Cerrar</button>
                <button type="button" id="mp-btn-cancelar" data-abrir-confirmacion
                        style="font-family:inherit;font-weight:700;font-size:15px;padding:12px 24px;min-height:46px;border-radius:12px;border:2px solid #B42318;background:#B42318;color:#FFFFFF;cursor:pointer"
                        onmouseover="this.style.background='#8F1D14';this.style.borderColor='#8F1D14'"
                        onmouseout="this.style.background='#B42318';this.style.borderColor='#B42318'">

                    Cancelar postulación
                </button>
            </div>
        </div>
    </div>


    {{-- CONFIRMAR CANCELACIÓN DE LA POSTULACIÓN --}}
    <div id="modal-confirmar-cancelacion" hidden
        style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:60;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.7)">

        <div role="alertdialog" aria-modal="true" aria-labelledby="mp-confirmar-titulo"
            style="width:100%;max-width:440px;background:#FFFFFF;border-radius:20px;box-shadow:0 24px 64px rgba(18,48,63,0.35);overflow:hidden;font-family:inherit">

            {{-- Encabezado --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;padding:22px 24px;border-bottom:1px solid #E3E8EF">

                <h2 id="mp-confirmar-titulo" style="margin:0;font-size:20px;font-weight:700;color:#12303F;line-height:1.3">
                    Cancelar postulación
                </h2>

                <button type="button" data-cerrar-confirmacion aria-label="Cerrar"
                        style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>


            </div>

            {{-- Cuerpo --}}
            <div style="padding:24px;text-align:center">

                <span style="width:64px;height:64px;margin:0 auto 20px;border-radius:50%;background:#FEE2E2;color:#B42318;display:flex;align-items:center;justify-content:center">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </span>

                <p style="margin:0;font-size:15px;line-height:1.7;color:#52606D">
                    ¿Seguro que deseas eliminar tu postulación a la oferta
                    <strong id="mp-confirmar-oferta" style="color:#12303F;font-weight:700"></strong>?
                    <br>
                    Esta acción no se puede deshacer, pero podrás volver a postularte mientras la oferta siga vigente.
                </p>

            </div>

            {{-- Botones --}}
            <form id="mp-form-cancelar" method="POST" action="#" data-base="{{ url('/empleos/postulaciones') }}"
                style="margin:0;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;padding:18px 24px;border-top:1px solid #E3E8EF;background:#FFFFFF">

                @csrf
                @method('DELETE')

                {{-- TEMPORAL: cuando exista el login, este campo se quita y el usuario sale de la sesión --}}
                @if (! empty($idUsuario))
                    <input type="hidden" name="idUsuario" value="{{ $idUsuario }}">
                @endif

                <button type="button" data-cerrar-confirmacion class="{{ $btnSecundario }} cursor-pointer">
                    Volver
                </button>

                <button type="submit"
                    style="font-family:inherit;font-weight:700;font-size:15px;padding:12px 24px;min-height:46px;border-radius:12px;border:2px solid #B42318;background:#B42318;color:#FFFFFF;cursor:pointer"
                    onmouseover="this.style.background='#8F1D14';this.style.borderColor='#8F1D14'"
                    onmouseout="this.style.background='#B42318';this.style.borderColor='#B42318'">
                    Confirmar
                </button>

            </form>

        </div>
    </div>

        @push('scripts')
        <script>

            // Modal de ver oferta y postularse //

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
                        diasVence.textContent = 'Hoy';
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

            // Modal de ver mi postulación y cancelar postulación//

            (function () {
                const modal = document.getElementById('modal-postulacion');
                const confirmar = document.getElementById('modal-confirmar-cancelacion');
                const formCancelar = document.getElementById('mp-form-cancelar');

                const ESTADOS = {
                    Enviado: {
                        fondo: '#FEF3C7', circulo: '#FDE68A', color: '#7A4B00', punto: '#D69E00',
                        mensaje: 'Tu postulación fue enviada. Quien publica la oferta la revisará.',
                        icono: '<path d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />'
                    },
                    Aceptado: {
                        fondo: '#DCFCE7', circulo: '#BBF7D0', color: '#14532D', punto: '#16A34A',
                        mensaje: '¡Felicitaciones! Tu postulación fue aceptada.',
                        icono: '<path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                    },
                    Rechazado: {
                        fondo: '#FEE2E2', circulo: '#FECACA', color: '#7F1D1D', punto: '#DC2626',
                        mensaje: 'Esta vez no fuiste seleccionado/a. ¡Sigue intentando!',
                        icono: '<path d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                    }
                };

                let botonOrigen = null;
                let idPostulacion = null;

                function texto(id, valor) {
                    document.getElementById(id).textContent = valor ?? '';
                }

                function abrir(boton) {
                    const o = JSON.parse(boton.dataset.verPostulacion);
                    const p = o.postulacion;
                    if (!p) return;

                    botonOrigen = boton;
                    idPostulacion = p.id;

                    texto('mp-titulo', o.titulo);
                    texto('mp-publicador', o.publicador);
                    texto('mp-fecha', p.fecha);
                    texto('mp-vence', o.vence);
                    texto('mp-contrato', o.contrato);
                    texto('mp-salario', o.salario);
                    texto('mp-ubicacion', o.ubicacion);
                    texto('mp-descripcion', o.descripcion);

                    const categoria = document.getElementById('mp-categoria');
                    categoria.textContent = o.categoria ?? '';
                    categoria.hidden = !o.categoria;

                    const foto = document.getElementById('mp-foto');
                    const fotoVacia = document.getElementById('mp-foto-vacia');
                    if (o.foto) {
                        foto.src = o.foto;
                        foto.hidden = false;
                        fotoVacia.style.display = 'none';
                    } else {
                        foto.removeAttribute('src');
                        foto.hidden = true;
                        fotoVacia.style.display = '';
                    }

                    // Estado: colores, icono y mensaje
                    const e = ESTADOS[p.estado] || ESTADOS.Enviado;
                    document.getElementById('mp-estado-caja').style.background = e.fondo;
                    const circulo = document.getElementById('mp-estado-circulo');
                    circulo.style.background = e.circulo;
                    circulo.style.color = e.color;
                    circulo.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' + e.icono + '</svg>';
                    const mensaje = document.getElementById('mp-estado-mensaje');
                    mensaje.textContent = e.mensaje;
                    mensaje.style.color = e.color;

                    // Solo se puede cancelar mientras la postulación está "Enviado"
                    document.getElementById('mp-btn-cancelar').style.display = p.estado === 'Enviado' ? 'inline-flex' : 'none';

                    texto('mp-confirmar-oferta', o.titulo);
                    formCancelar.action = formCancelar.dataset.base + '/' + p.id;

                    modal.hidden = false;
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }

                function cerrar() {
                    modal.hidden = true;
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                    if (botonOrigen) botonOrigen.focus();
                }

                function abrirConfirmacion() {
                    confirmar.hidden = false;
                    confirmar.style.display = 'flex';
                }

                function cerrarConfirmacion() {
                    confirmar.hidden = true;
                    confirmar.style.display = 'none';
                }

                document.addEventListener('click', function (e) {
                    const boton = e.target.closest('[data-ver-postulacion]');
                    if (boton) { abrir(boton); return; }

                    if (e.target.closest('[data-abrir-confirmacion]')) { abrirConfirmacion(); return; }
                    if (e.target.closest('[data-cerrar-confirmacion]') || e.target === confirmar) { cerrarConfirmacion(); return; }
                    if (e.target.closest('[data-cerrar-postulacion]') || e.target === modal) cerrar();
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key !== 'Escape') return;
                    if (!confirmar.hidden) { cerrarConfirmacion(); return; }
                    if (!modal.hidden) cerrar();
                });
            })();

            // Modal completar mi hoja de vida //

            (function () {
                const modal = document.getElementById('modal-hoja-de-vida');
                const archivo = document.getElementById('hv-archivo');
                const zona = document.getElementById('hv-zona');
                const zonaTitulo = document.getElementById('hv-zona-titulo');
                const zonaAyuda = document.getElementById('hv-zona-ayuda');
                const campos = modal.querySelectorAll('[data-hv-campo]');
                const TEXTO_INICIAL = zonaTitulo.textContent;
                const AYUDA_INICIAL = zonaAyuda.textContent;
                const TIENE_ARCHIVO = {{ ! empty($hojaDeVida?->archivoCV) ? 'true' : 'false' }};
                let botonOrigen = null;

                // Elementos del panel derecho del archivo CV
                const panelArchivo = document.getElementById('hv-archivo-panel');
                const archivoTitulo = document.getElementById('hv-archivo-titulo');
                const archivoIcono = document.getElementById('hv-archivo-icono');
                const archivoDetalle = document.getElementById('hv-archivo-detalle');
                const archivoNombre = document.getElementById('hv-archivo-nombre');
                const archivoFecha = document.getElementById('hv-archivo-fecha');
                const archivoVacio = document.getElementById('hv-archivo-vacio');
                const archivoVer = document.getElementById('hv-archivo-ver');

                // Información del archivo que ya está guardado
                const URL_ARCHIVO_ACTUAL = panelArchivo.dataset.archivoUrl;
                const NOMBRE_ARCHIVO_ACTUAL = panelArchivo.dataset.archivoNombre;
                const FECHA_ARCHIVO_ACTUAL = panelArchivo.dataset.archivoFecha;

                // URL temporal del archivo seleccionado
                let urlVistaPrevia = null;

                // Contadores y barra de progreso (5 elementos, 20% cada uno)
                function actualizar() {
                    modal.querySelectorAll('[data-hv-max]').forEach(function (t) {
                        t.closest('label').querySelector('[data-hv-contador]').textContent = t.value.length + '/255';
                    });

                    let llenos = 0;

                    campos.forEach(function (c) {
                        if (c.value.trim() !== '') llenos++;
                    });

                    if (TIENE_ARCHIVO || archivo.files.length) llenos++;

                    const pct = Math.round(llenos * 100 / 5);

                    document.getElementById('hv-progreso-texto').textContent = pct + '% completado';
                    document.getElementById('hv-progreso-barra').style.width = pct + '%';
                }

                // Mostrar información del archivo en el panel derecho
                function mostrarArchivo(nombre, url, fecha, titulo) {
                    archivoTitulo.textContent = titulo;
                    archivoIcono.style.display = 'flex';
                    archivoDetalle.style.display = 'flex';
                    archivoVacio.style.display = 'none';

                    archivoNombre.textContent = nombre;
                    archivoFecha.textContent = fecha;

                    archivoVer.href = url;
                    archivoVer.style.display = 'inline-flex';
                }

                // Restaurar el archivo que ya estaba guardado
                function restaurarArchivoActual() {
                    if (URL_ARCHIVO_ACTUAL) {
                        mostrarArchivo(
                            NOMBRE_ARCHIVO_ACTUAL,
                            URL_ARCHIVO_ACTUAL,
                            FECHA_ARCHIVO_ACTUAL,
                            'Archivo actual'
                        );
                    } else {
                        archivoTitulo.textContent = 'Vista previa';
                        archivoIcono.style.display = 'none';
                        archivoDetalle.style.display = 'none';
                        archivoVacio.style.display = 'block';
                        archivoVer.style.display = 'none';
                        archivoVer.href = '#';
                    }
                }

                // Liberar URL temporal de vista previa
                function liberarVistaPrevia() {
                    if (urlVistaPrevia) {
                        URL.revokeObjectURL(urlVistaPrevia);
                        urlVistaPrevia = null;
                    }
                }

                // Seleccionar y validar archivo PDF
                function elegirArchivo() {
                    const f = archivo.files[0];

                    if (!f) {
                        zonaTitulo.textContent = TEXTO_INICIAL;
                        zonaAyuda.textContent = AYUDA_INICIAL;
                        zonaAyuda.style.color = '#52606D';

                        liberarVistaPrevia();
                        restaurarArchivoActual();

                        actualizar();
                        return;
                    }

                    // Validar formato y tamaño del archivo
                    const esPdf = f.type === 'application/pdf' || /\.pdf$/i.test(f.name);
                    const tamanoValido = f.size <= 5 * 1024 * 1024;

                    if (!esPdf || !tamanoValido) {
                        archivo.value = '';
                        zonaTitulo.textContent = TEXTO_INICIAL;

                        zonaAyuda.textContent = !esPdf
                            ? 'El archivo debe estar en formato PDF.'
                            : 'El archivo supera el tamaño máximo de 5 MB.';

                        zonaAyuda.style.color = '#B42318';

                        liberarVistaPrevia();
                        restaurarArchivoActual();

                        actualizar();
                        return;
                    }

                    // Liberar vista previa anterior
                    liberarVistaPrevia();

                    // Crear vista previa del PDF seleccionado
                    urlVistaPrevia = URL.createObjectURL(f);

                    // Actualizar panel derecho
                    mostrarArchivo(
                        f.name,
                        urlVistaPrevia,
                        'Pendiente de guardar',
                        'Archivo seleccionado'
                    );

                    // Actualizar zona izquierda
                    zonaTitulo.textContent = f.name;
                    zonaAyuda.textContent = 'Se guardará cuando presiones «Guardar»';
                    zonaAyuda.style.color = '#52606D';
                    actualizar();
                }

                // Evento al seleccionar un archivo
                archivo.addEventListener('change', elegirArchivo);

                ['dragenter', 'dragover'].forEach(function (ev) {
                    zona.addEventListener(ev, function (e) {
                        e.preventDefault();
                        zona.style.borderColor = '#4DB6E8';
                        zona.style.background = '#EAF6FD';
                    });
                });

                ['dragleave', 'drop'].forEach(function (ev) {
                    zona.addEventListener(ev, function (e) {
                        e.preventDefault();
                        zona.style.borderColor = '#CBD2D9';
                        zona.style.background = '#F5F7FA';
                    });
                });

                // Recibir archivo arrastrado
                zona.addEventListener('drop', function (e) {
                    if (e.dataTransfer.files.length) {
                        archivo.files = e.dataTransfer.files;
                        elegirArchivo();
                    }
                });

                modal.addEventListener('input', actualizar);

                // Abrir modal
                function abrir(boton) {
                    botonOrigen = boton || null;
                    actualizar();
                    modal.hidden = false;
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }

                // Cerrar modal
                function cerrar() {
                    modal.hidden = true;
                    modal.style.display = 'none';

                    // Descartar archivo nuevo que no se haya guardado
                    archivo.value = '';

                    // Liberar URL temporal
                    liberarVistaPrevia();

                    // Restaurar zona de selección
                    zonaTitulo.textContent = TEXTO_INICIAL;
                    zonaAyuda.textContent = AYUDA_INICIAL;
                    zonaAyuda.style.color = '#52606D';

                    // Restaurar archivo actual en el panel derecho
                    restaurarArchivoActual();

                    const ofertaAbierta = document.getElementById('modal-oferta') && !document.getElementById('modal-oferta').hidden;

                    if (!ofertaAbierta) document.body.style.overflow = '';

                    if (botonOrigen) botonOrigen.focus();

                    actualizar();
                }

                document.addEventListener('click', function (e) {
                    const boton = e.target.closest('[data-abrir-hoja-de-vida]');

                    if (boton) {
                        abrir(boton);
                        return;
                    }

                    if (e.target.closest('[data-cerrar-hoja]') || e.target === modal) {
                        cerrar();
                    }
                });

                // Escape cierra solo este modal (captura para que no cierre también el de la oferta)
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !modal.hidden) {
                        e.stopImmediatePropagation();
                        cerrar();
                    }
                }, true);

                // Si el servidor devolvió errores de validación, se abre solo
                if (modal.dataset.abrirAlCargar === '1') abrir(null);

                // Inicializar panel derecho y progreso
                restaurarArchivoActual();
                actualizar();

            })();

        </script>
    @endpush
@endsection
