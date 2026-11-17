@extends('layouts.Publico.inicio')

@section('title', 'Bienvenido')

@section('content')

@php
    // Perfiles de registro. "tipo" viaja por la URL para preseleccionar el rol en el formulario.
    $perfiles = [
        [
            'titulo' => 'Soy persona natural',
            'texto'  => 'Crea tu hoja de vida, explora vacantes y postúlate desde un solo lugar.',
            'boton'  => 'Explorar oportunidades',
            'tipo'   => 'usuario',
            'icono'  => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0',
        ],
        [
            'titulo' => 'Soy empresa',
            'texto'  => 'Publica tus vacantes y encuentra talento de tu propio municipio.',
            'boton'  => 'Publicar una oferta',
            'tipo'   => 'empresa',
            'icono'  => 'M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01',
        ],
    ];

    $beneficios = [
        'Todas las ofertas laborales con información detallada.',
        'Calificaciones entre empresas y personas para generar confianza.',
        'Gestión de tu hoja de vida y postulaciones.',
        'Publicación de vacantes para tu empresa o negocio.',
    ];

    $pasos = [
        ['titulo' => 'Crea tu cuenta',        'texto' => 'Regístrate como persona o como empresa.'],
        ['titulo' => 'Completa tu perfil',    'texto' => 'Ingresa tus datos y adjunta tu hoja de vida o registra la información de tu empresa.'],
        ['titulo' => 'Explora y conecta',     'texto' => 'Consulta ofertas laborales, presenta postulaciones o publica oportunidades.'],
    ];

    $valores = [
        ['titulo' => 'Oportunidades',      'texto' => 'Conecta con ofertas laborales disponibles en tu municipio'],
        ['titulo' => 'Confianza',          'texto' => 'Empresas y candidatos de tu región en un mismo lugar.'],
        ['titulo' => 'Todo en un lugar',   'texto' => 'Hoja de vida, ofertas y postulaciones en tu panel.'],
    ];
@endphp

{{-- NAVBAR --}}
<header class="sticky top-0 z-50 border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-6 py-3">
        <a href="{{ url('/') }}" class="flex items-center gap-3 text-xl font-extrabold text-noche">
            <img src="{{ asset('images/Logo Malaga Emplea.png') }}" alt="Logo de Málaga Emplea" class="size-14 object-contain">
            Málaga Emplea
        </a>

        <nav class="hidden items-center gap-7 text-[15px] font-semibold md:flex">
            <a href="#perfiles" class="py-3 transition hover:text-marca-texto">Perfiles</a>
            <a href="#como" class="py-3 transition hover:text-marca-texto">Cómo funciona</a>
            <a href="#nosotros" class="py-3 transition hover:text-marca-texto">Sobre nosotros</a>
        </nav>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('login') }}"
                class="self-start rounded-full border-2 border-slate-800 bg-white px-4 py-2 text-[15px] font-bold text-slate-800 transition hover:border-carbon hover:bg-carbon hover:text-white">
                Ingresar
            </a>

            <button type="button" onclick="abrirModalRegistro()"
                class="self-start rounded-full border-2 border-marca bg-marca px-4 py-2 text-[15px] font-bold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white">
                Registrarse
            </button>
        </div>
    </div>
</header>

{{-- ============ HERO (banner con imagen) ============ --}}
<section class="relative isolate overflow-hidden">
    <img src="{{ asset('images/Malaga Fondo.png') }}" alt=""
        class="absolute inset-0 -z-20 h-full w-full object-cover">
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-slate-950/90 via-slate-950/65 to-slate-950/40"></div>

    <div class="mx-auto grid max-w-6xl items-center gap-14 px-6 py-24 lg:grid-cols-2">

        {{-- Texto principal --}}
        <div class="flex flex-col gap-6">
            <span class="self-start rounded-full bg-white px-4 py-1.5 text-[13px] font-bold text-marca-texto">
                "Oportunidades que transforman"
            </span>

            <h1 class="text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-[56px]">
                Tu próxima oportunidad de empleo comienza aquí
            </h1>

            <p class="max-w-xl text-lg leading-relaxed text-slate-200">
                Crea tu cuenta, conecta con empresas y oportunidades de trabajo en tu municipio.
            </p>

            <div class="flex flex-wrap gap-1">
            </div>
        </div>

        {{-- Tarjeta: qué se desbloquea al registrarse --}}
        <div class="flex flex-col gap-5 rounded-3xl bg-white p-7 shadow-xl">
            <div class="flex items-center gap-3">
                <span class="flex size-11 items-center justify-center rounded-xl bg-sky-50 text-marca-texto">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </span>
                <h2 class="text-xl font-extrabold text-noche">Al registrarte accedes a</h2>
            </div>

            <ul class="flex flex-col gap-3.5 text-base text-slate-600">
                @foreach ($beneficios as $beneficio)
                    <li class="flex items-center gap-3">
                        <svg class="size-5 shrink-0 text-marca-texto" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        {{ $beneficio }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- ============ PERFILES ============ --}}
<section id="perfiles" class="scroll-mt-4 px-6 pb-12 pt-20">
    <div class="mx-auto flex max-w-6xl flex-col gap-9">
        <div class="space-y-2">
            <h2 class="text-3xl font-extrabold text-noche sm:text-4xl">Únete a nosotros</h2>
            <p class="text-[17px] text-slate-500">Elige cómo quieres participar.</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-2">
            @foreach ($perfiles as $perfil)
                <article class="flex flex-col gap-3.5 rounded-2xl border border-slate-200 bg-white p-7 transition hover:shadow-lg">
                    <span class="flex size-[52px] items-center justify-center rounded-2xl bg-[#EAF6FD] text-marca-texto">
                        <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $perfil['icono'] }}" />
                        </svg>
                    </span>
                    <h3 class="text-[21px] font-bold">{{ $perfil['titulo'] }}</h3>
                    <p class="leading-relaxed text-slate-500">{{ $perfil['texto'] }}</p>
                    <button type="button"
                        onclick="abrirModalRegistro('{{ $perfil['tipo'] }}')"
                        class="self-start rounded-full border-2 border-marca bg-marca px-4 py-2 text-[15px] font-bold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white">
                        {{ $perfil['boton'] }}
                    </button>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ CÓMO FUNCIONA ============ --}}
<section id="como" class="scroll-mt-4 bg-white px-6 py-20">
    <div class="mx-auto flex max-w-6xl flex-col gap-10">
        <div class="space-y-2">
            <h2 class="text-3xl font-extrabold text-noche sm:text-4xl">Empezar es muy fácil</h2>
            <p class="text-[17px] text-slate-500">En tres pasos, conecta con nuevas oportunidades.</p>
        </div>

        <div class="grid gap-8 md:grid-cols-3">
            @foreach ($pasos as $i => $paso)
                <div class="flex flex-col gap-3.5">
                    <span class="flex size-12 items-center justify-center rounded-full bg-marca text-xl font-extrabold text-tinta">
                        {{ $i + 1 }}
                    </span>
                    <h3 class="text-xl font-bold">{{ $paso['titulo'] }}</h3>
                    <p class="leading-relaxed text-slate-500">{{ $paso['texto'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ SOBRE NOSOTROS ============ --}}
<section id="nosotros" class="scroll-mt-4 px-6 py-20">
    <div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:items-start">
        <div class="space-y-3.5">
            <h2 class="text-3xl font-extrabold text-noche sm:text-4xl">Conectamos oportunidades en Garcia Rovira</h2>
            <p class="text-[17px] leading-relaxed text-slate-600">
                Málaga Emplea complementa los servicios de intermediación laboral existentes y facilita la conexión entre quienes buscan empleo y las empresas de la región.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-3">
            @foreach ($valores as $valor)
                <div class="space-y-2 rounded-2xl border border-slate-200 bg-white p-6">
                    <h3 class="text-lg font-bold text-noche">{{ $valor['titulo'] }}</h3>
                    <p class="leading-relaxed text-slate-500">{{ $valor['texto'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- MODAL DE REGISTRO --}}
<div id="modalRegistro"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-[#17232c]/80 px-3 py-4 backdrop-blur-md">

    <div id="contenidoModal"
        class="modal-contenido relative flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl border border-white/70 bg-[#F5F7FA] shadow-[0_28px_90px_rgba(10,25,35,0.45)]">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between border-b border-gray-200 bg-white px-5 py-4">
            <div>
                <h2 id="tituloModal" class="text-lg font-extrabold text-noche">
                    Crear una cuenta
                </h2>
                <p id="descripcionModal" class="text-xs text-gray-500">
                    Elige cómo quieres participar en Málaga Emplea.
                </p>
            </div>

            <button type="button" onclick="cerrarModalRegistro()"
                class="flex size-9 items-center justify-center rounded-full text-gray-500 transition hover:rotate-90 hover:bg-gray-100 hover:text-carbon"
                aria-label="Cerrar modal">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- INDICADOR DE ETAPA --}}
        <div class="flex gap-1.5 px-5 pt-4">
            <span id="pasoUno" class="h-1 flex-1 rounded-full bg-[#4DB6E8] transition-all"></span>
            <span id="pasoDos" class="h-1 flex-1 rounded-full bg-gray-200 transition-all"></span>
        </div>

        {{-- CONTENIDO --}}
        <div id="contenidoDesplazable" class="overflow-y-auto p-5 sm:p-6">

            {{-- SELECCIÓN --}}
            <div id="selectorRegistro" class="etapa-animacion">
                <div class="mb-4">
                    <p class="text-sm font-bold text-noche">¿Cómo deseas registrarte?</p>
                    <p class="mt-1 text-xs text-gray-500">Selecciona el tipo de cuenta que mejor se adapte a ti.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">

                    {{-- PERSONA --}}
                    <button type="button" onclick="mostrarFormulario('usuario')"
                        class="tarjeta-registro group flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 text-left transition duration-300 hover:-translate-y-1 hover:border-[#4DB6E8] hover:shadow-lg">

                        <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto transition group-hover:scale-110 group-hover:bg-marca group-hover:text-tinta">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/>
                            </svg>
                        </span>

                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-bold text-noche">Persona Natural</span>
                            <span class="mt-1 block text-xs leading-relaxed text-gray-500">
                                Busca empleo y crea tu hoja de vida.
                            </span>
                        </span>

                        <svg class="size-4 shrink-0 text-gray-400 transition group-hover:translate-x-1 group-hover:text-noche"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    {{-- EMPRESA --}}
                    <button type="button" onclick="mostrarFormulario('empresa')"
                        class="tarjeta-registro group flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 text-left transition duration-300 hover:-translate-y-1 hover:border-[#4DB6E8] hover:shadow-lg">

                        <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto transition group-hover:scale-110 group-hover:bg-marca group-hover:text-tinta">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/>
                            </svg>
                        </span>

                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-bold text-noche">Empresa</span>
                            <span class="mt-1 block text-xs leading-relaxed text-gray-500">
                                Publica vacantes y encuentra talento.
                            </span>
                        </span>

                        <svg class="size-4 shrink-0 text-gray-400 transition group-hover:translate-x-1 group-hover:text-noche"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- FORMULARIOS --}}
            <div id="formulariosRegistro" class="hidden">

                <button type="button" onclick="volverSelector()"
                    class="mb-4 flex items-center gap-1.5 text-xs font-semibold text-gray-500 transition hover:text-noche">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Cambiar tipo de cuenta
                </button>

                {{-- FORMULARIO PERSONA NATURAL --}}
                <form id="formRegistroUsuario" class="hidden space-y-4">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">

                        <div>
                            <label for="registroNombres" class="mb-1 block text-xs font-semibold text-noche">Nombres</label>
                            <input id="registroNombres" name="nombres" type="text" required autocomplete="given-name"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        <div>
                            <label for="registroApellidos" class="mb-1 block text-xs font-semibold text-noche">Apellidos</label>
                            <input id="registroApellidos" name="apellidos" type="text" required autocomplete="family-name"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        {{-- FECHA DE NACIMIENTO CON BOTÓN DE CALENDARIO --}}
                        <div>
                            <label for="registroFecha" class="mb-1 block text-xs font-semibold text-noche">
                                Fecha de nacimiento
                            </label>

                            <div style="position:relative;display:flex;align-items:center">
                                <input id="registroFecha" name="fechaNacimiento" type="date" required
                                    min="1900-01-01" max="{{ date('Y-m-d') }}"
                                    class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 pr-12 text-sm text-slate-800 outline-none"
                                    style="padding-right:54px">

                                <button id="registroAbrirCalendario" type="button"
                                    aria-label="Abrir calendario de fecha de nacimiento"
                                    title="Elegir fecha en el calendario"
                                    style="position:absolute;right:6px;top:50%;transform:translateY(-50%);width:40px;height:40px;border:0;border-radius:9px;background:transparent;color:#52606D;display:flex;align-items:center;justify-content:center;cursor:pointer">
                                    <svg width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                                        <path d="M16 3v4M8 3v4M3 10h18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="registroTipoDocumento" class="mb-1 block text-xs font-semibold text-noche">Tipo de documento</label>
                            <select id="registroTipoDocumento" name="tipoDocumento" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                                <option value="">Seleccionar</option>
                                <option value="CC">Cédula de ciudadanía</option>
                                <option value="CE">Cédula de extranjería</option>
                                <option value="PPT">PPT</option>
                                <option value="PEP">PEP</option>
                                <option value="PASAPORTE">Pasaporte</option>
                            </select>
                        </div>

                        <div>
                            <label for="registroDocumento" class="mb-1 block text-xs font-semibold text-noche">Número de documento</label>
                            <input id="registroDocumento" name="numeroDocumento" type="text" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        <div>
                            <label for="registroTelefono" class="mb-1 block text-xs font-semibold text-noche">Teléfono</label>
                            <input id="registroTelefono" name="telefono" type="tel" required autocomplete="tel"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        {{-- CORREO PERSONA NATURAL --}}
                        <div>
                            <label for="registroEmailUsuario" class="mb-1 block text-xs font-semibold text-noche">Correo electrónico</label>
                            <input id="registroEmailUsuario" name="email" type="email" required autocomplete="email"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        {{-- CONTRASEÑA PERSONA NATURAL --}}
                        <div>
                            <label for="registroPasswordUsuario" class="mb-1 block text-xs font-semibold text-noche">Contraseña</label>
                            <div class="relative">
                                <input id="registroPasswordUsuario" name="password" type="password" minlength="8" required autocomplete="new-password"
                                    class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 pr-11 text-sm text-slate-800 outline-none">

                                <button type="button" onclick="alternarPassword('registroPasswordUsuario', this)"
                                    aria-label="Mostrar contraseña"
                                    title="Mostrar contraseña"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 transition hover:text-marca-texto">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 10.5c2.1 3 4.8 4.5 8 4.5s5.9-1.5 8-4.5M7 12.5l-1.5 2M12 15v2M17 12.5l1.5 2"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-1 text-[11px] text-gray-500">Mínimo 8 caracteres.</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="boton-registro w-full rounded-full border-2 border-marca bg-marca px-5 py-3 text-sm font-extrabold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white">
                        Crear cuenta
                    </button>
                </form>

                {{-- FORMULARIO EMPRESA --}}
                <form id="formRegistroEmpresa" class="hidden space-y-4">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">

                        <div class="sm:col-span-2">
                            <label for="registroNombreEmpresa" class="mb-1 block text-xs font-semibold text-noche">Nombre de la empresa</label>
                            <input id="registroNombreEmpresa" name="nombreEmpresa" type="text" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        <div>
                            <label for="registroNit" class="mb-1 block text-xs font-semibold text-noche">NIT</label>
                            <input id="registroNit" name="nit" type="text" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        <div>
                            <label for="registroDireccion" class="mb-1 block text-xs font-semibold text-noche">Dirección</label>
                            <input id="registroDireccion" name="direccion" type="text" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        {{-- CORREO EMPRESA --}}
                        <div>
                            <label for="registroEmailEmpresa" class="mb-1 block text-xs font-semibold text-noche">Correo electrónico</label>
                            <input id="registroEmailEmpresa" name="email" type="email" required autocomplete="email"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none">
                        </div>

                        {{-- CONTRASEÑA EMPRESA --}}
                        <div>
                            <label for="registroPasswordEmpresa" class="mb-1 block text-xs font-semibold text-noche">Contraseña</label>
                            <div class="relative">
                                <input id="registroPasswordEmpresa" name="password" type="password" minlength="8" required autocomplete="new-password"
                                    class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 pr-11 text-sm text-slate-800 outline-none">

                                <button type="button" onclick="alternarPassword('registroPasswordEmpresa', this)"
                                    aria-label="Mostrar contraseña"
                                    title="Mostrar contraseña"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 transition hover:text-marca-texto">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 10.5c2.1 3 4.8 4.5 8 4.5s5.9-1.5 8-4.5M7 12.5l-1.5 2M12 15v2M17 12.5l1.5 2"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-1 text-[11px] text-gray-500">Mínimo 8 caracteres.</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="boton-registro w-full rounded-full border-2 border-marca bg-marca px-5 py-3 text-sm font-extrabold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white">
                        Crear cuenta
                    </button>
                </form>
            </div>
        </div>

        {{-- PIE --}}
        <div class="border-t border-gray-200 bg-white px-5 py-3 text-center">
            <p class="text-[11px] text-gray-500">
                Málaga Emplea · Conectando oportunidades en nuestra región.
            </p>
        </div>
    </div>
</div>

<style>
    /* APERTURA Y CIERRE DEL MODAL */
    #modalRegistro {
        opacity: 0;
        background-color: rgba(18, 48, 63, .80);
        transition: opacity .25s ease;
    }

    #modalRegistro.modal-visible {
        opacity: 1;
    }

    #contenidoModal {
        max-height: 90vh;
        max-height: 90dvh;
        opacity: 0;
        transform: translateY(18px) scale(.97);
        border-radius: 1.75rem;
        background: #F5F7FA;
        transition: opacity .3s ease, transform .3s cubic-bezier(.2,.8,.2,1);
    }

    #modalRegistro.modal-visible #contenidoModal {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* ANIMACIÓN DE LAS ETAPAS */
    .etapa-animacion {
        animation: aparecerEtapa .35s ease both;
    }

    @keyframes aparecerEtapa {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* TARJETAS DE SELECCIÓN */
    .tarjeta-registro {
        position: relative;
        overflow: hidden;
        border-color: rgba(24, 101, 167, .18);
    }

    .tarjeta-registro:hover {
        border-color: #4DB6E8;
    }

    .tarjeta-registro::after {
        content: "";
        position: absolute;
        top: 0;
        left: -120%;
        width: 70%;
        height: 100%;
        background: linear-gradient(100deg, transparent, rgba(77,182,232,.15), transparent);
        transition: left .6s ease;
        pointer-events: none;
    }

    .tarjeta-registro:hover::after {
        left: 140%;
    }

    /* CAMPOS DEL FORMULARIO */
    .campo-registro {
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .campo-registro:focus {
        border-color: #4DB6E8;
        box-shadow: 0 0 0 3px rgba(77,182,232,.2);
    }

    /* BOTÓN DEL OJITO */
    .boton-ojo {
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 4px;
    }

    .boton-ojo:focus-visible {
        outline: 2px solid #4DB6E8;
        outline-offset: 3px;
        border-radius: 5px;
    }

    /* BOTONES DEL FORMULARIO */
    .boton-registro {
        border-radius: 999px;
        border: 2px solid #4DB6E8;
        background: #4DB6E8;
        color: #0F2A3D;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .boton-registro:hover {
        transform: translateY(-2px);
        border-color: #333333;
        background: #333333;
        color: white;
        box-shadow: 0 7px 16px rgba(51,51,51,.15);
    }

    .boton-registro:active {
        transform: scale(.98);
    }

    /* RESPETAR PREFERENCIAS DE MOVIMIENTO */
    @media (prefers-reduced-motion: reduce) {
        #modalRegistro,
        #contenidoModal,
        .etapa-animacion,
        .tarjeta-registro,
        .boton-registro {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<script>
    const modalRegistro = document.getElementById('modalRegistro');

    function abrirModalRegistro(tipo = null) {
        modalRegistro.classList.remove('hidden');
        modalRegistro.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            modalRegistro.classList.add('modal-visible');

            if (tipo === 'usuario' || tipo === 'empresa') {
                mostrarFormulario(tipo);
            } else {
                volverSelector();
            }
        });
    }

    function cerrarModalRegistro() {
        modalRegistro.classList.remove('modal-visible');

        setTimeout(() => {
            modalRegistro.classList.add('hidden');
            modalRegistro.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
            volverSelector();
        }, 250);
    }

    function mostrarFormulario(tipo) {
        const selector = document.getElementById('selectorRegistro');
        const formularios = document.getElementById('formulariosRegistro');
        const usuario = document.getElementById('formRegistroUsuario');
        const empresa = document.getElementById('formRegistroEmpresa');

        selector.classList.add('hidden');
        selector.classList.remove('etapa-animacion');

        formularios.classList.remove('hidden');
        usuario.classList.toggle('hidden', tipo !== 'usuario');
        empresa.classList.toggle('hidden', tipo !== 'empresa');

        document.getElementById('tituloModal').textContent =
            tipo === 'usuario' ? 'Crear Cuenta Personal' : 'Crear Cuenta Empresarial';

        document.getElementById('descripcionModal').textContent =
            tipo === 'usuario'
                ? 'Completa tus datos para comenzar.'
                : 'Registra tu negocio y conecta con nuevos talentos.';

        document.getElementById('pasoUno').classList.replace('bg-[#4DB6E8]', 'bg-gray-200');
        document.getElementById('pasoDos').classList.replace('bg-gray-200', 'bg-[#4DB6E8]');

        formularios.classList.remove('etapa-animacion');
        void formularios.offsetWidth;
        formularios.classList.add('etapa-animacion');

        document.getElementById('contenidoDesplazable').scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function volverSelector() {
        document.getElementById('selectorRegistro').classList.remove('hidden');
        document.getElementById('selectorRegistro').classList.add('etapa-animacion');

        document.getElementById('formulariosRegistro').classList.add('hidden');
        document.getElementById('formRegistroUsuario').classList.add('hidden');
        document.getElementById('formRegistroEmpresa').classList.add('hidden');

        document.getElementById('tituloModal').textContent = 'Crear una cuenta';
        document.getElementById('descripcionModal').textContent =
            'Elige cómo quieres participar en Málaga Emplea.';

        document.getElementById('pasoUno').classList.replace('bg-gray-200', 'bg-[#4DB6E8]');
        document.getElementById('pasoDos').classList.replace('bg-[#4DB6E8]', 'bg-gray-200');

        document.getElementById('contenidoDesplazable').scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Mostrar u ocultar contraseña con el mismo ojito del login
    function alternarPassword(id, boton) {
        const campo = document.getElementById(id);
        if (!campo) return;

        const mostrar = campo.type === 'password';
        campo.type = mostrar ? 'text' : 'password';

        boton.setAttribute(
            'aria-label',
            mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );

        boton.setAttribute(
            'title',
            mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );

        boton.innerHTML = mostrar
            ? `<svg class="size-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.5 12s3.4-6.5 9.5-6.5 9.5 6.5 9.5 6.5-3.4 6.5-9.5 6.5-9.5-6.5-9.5-6.5z"/>
                    <circle cx="12" cy="12" r="3"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.5 7.5 5 5.5M12 5.5V3.5M17.5 7.5 19 5.5"/>
               </svg>`
            : `<svg class="size-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 10.5c2.1 3 4.8 4.5 8 4.5s5.9-1.5 8-4.5M7 12.5l-1.5 2M12 15v2M17 12.5l1.5 2"/>
               </svg>`;
    }

    // Abrir el calendario de fecha de nacimiento
    document.getElementById('registroAbrirCalendario').addEventListener('click', function () {
        const fechaNacimiento = document.getElementById('registroFecha');

        if (typeof fechaNacimiento.showPicker === 'function') {
            fechaNacimiento.showPicker();
        } else {
            fechaNacimiento.focus();
            fechaNacimiento.click();
        }
    });

    // Cerrar al pulsar fuera del contenido
    modalRegistro.addEventListener('click', function(event) {
        if (event.target === modalRegistro) {
            cerrarModalRegistro();
        }
    });

    // Cerrar con Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !modalRegistro.classList.contains('hidden')) {
            cerrarModalRegistro();
        }
    });

    // Registrar persona natural
    document.getElementById('formRegistroUsuario').addEventListener('submit', function (e) {
        e.preventDefault();
        enviarRegistro(this, "{{ route('registro.usuario') }}");
    });

    // Registrar empresa
    document.getElementById('formRegistroEmpresa').addEventListener('submit', function (e) {
        e.preventDefault();
        enviarRegistro(this, "{{ route('registro.empresa') }}");
    });

    // Enviar los datos del formulario
    async function enviarRegistro(formulario, ruta) {
        const boton = formulario.querySelector('[type="submit"]');
        const textoOriginal = boton.textContent;

        boton.disabled = true;
        boton.textContent = 'Registrando...';

        limpiarErrores(formulario);

        try {
            const respuesta = await fetch(ruta, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                },
                body: new FormData(formulario)
            });

            const resultado = await respuesta.json().catch(() => ({}));

            if (!respuesta.ok) {
                if (respuesta.status === 422 && resultado.errors) {
                    mostrarErrores(formulario, resultado.errors);
                } else {
                    console.error('Respuesta del servidor:', respuesta.status, resultado);

                    mostrarMensajeRegistro(
                        resultado.message || 'No fue posible completar el registro. Inténtalo nuevamente.',
                        'error'
                    );
                }

                return;
            }

            formulario.reset();
            mostrarMensajeRegistro(resultado.mensaje, 'exito');

            window.location.href = resultado.redirect;

        } catch (error) {
            console.error('Error al registrar:', error);

            mostrarMensajeRegistro(
                'No fue posible conectar con el servidor. Inténtalo nuevamente.',
                'error'
            );

        } finally {
            boton.disabled = false;
            boton.textContent = textoOriginal;
        }
    }

    // Limpiar errores anteriores
    function limpiarErrores(formulario) {
        formulario.querySelectorAll('.error-registro').forEach(error => error.remove());

        formulario.querySelectorAll('.campo-registro').forEach(campo => {
            campo.classList.remove('campo-error', 'border-red-500');
        });

        const mensaje = document.getElementById('mensajeRegistro');
        if (mensaje) {
            mensaje.remove();
        }
    }

    // Mostrar errores de validación
    function mostrarErrores(formulario, errores) {
        Object.entries(errores).forEach(([campo, mensajes]) => {
            const input = formulario.querySelector(`[name="${campo}"]`);

            if (!input) return;

            input.classList.add('campo-error', 'border-red-500');

            const mensaje = document.createElement('p');
            mensaje.className = 'error-registro mt-1 text-sm text-red-600';
            mensaje.textContent = mensajes[0];

            let contenedorCampo = input.parentElement;

            if (contenedorCampo.classList.contains('relative')) {
                contenedorCampo = contenedorCampo.parentElement;
            }

            contenedorCampo.appendChild(mensaje);
        });
    }

    // Mostrar confirmación dentro del modal
    function mostrarMensajeRegistro(mensaje, tipo) {
        let contenedor = document.getElementById('mensajeRegistro');

        if (!contenedor) {
            contenedor = document.createElement('div');
            contenedor.id = 'mensajeRegistro';

            const contenido = document.getElementById('contenidoDesplazable');
            contenido.prepend(contenedor);
        }

        contenedor.className = tipo === 'exito'
            ? 'mb-4 rounded-xl border border-green-300 bg-green-50 p-3 text-sm font-medium text-green-800'
            : 'mb-4 rounded-xl border border-red-300 bg-red-50 p-3 text-sm font-medium text-red-800';

        contenedor.textContent = mensaje;
    }
</script>

@endsection
