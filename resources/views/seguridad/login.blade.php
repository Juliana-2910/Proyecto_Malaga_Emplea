
@extends('layouts.Publico.inicio')

@section('title', 'Iniciar sesión')
@section('hide-public-footer', 'true')

@section('content')

@php
    $tiposCuenta = config('seguridad.login', []);
    $tipoSeleccionado = old('tipo', array_key_first($tiposCuenta));
@endphp

<div class="login-page relative isolate flex min-h-screen items-center justify-center overflow-hidden bg-[#F4F4F4] px-4 py-6 sm:px-6" style="--login-fondo: url('{{ asset('images/Login Malaga Emplea.jpeg') }}')">

    {{-- FONDO DECORATIVO --}}
    <div class="absolute -left-32 -top-32 -z-10 size-96 rounded-full bg-[#4DB6E8]/20 blur-3xl"></div>
    <div class="absolute -bottom-40 -right-32 -z-10 size-[450px] rounded-full bg-[#333333]/10 blur-3xl"></div>

    
    {{-- CONTENEDOR DE LA TARJETA --}}
    <div class="login-shell relative w-full max-w-sm">

    {{-- TARJETA PRINCIPAL --}}
    <div class="login-card relative mx-auto w-full overflow-hidden rounded-[2rem] border border-white/80 bg-white/95 px-5 pb-5 pt-6 shadow-2xl backdrop-blur-xl sm:px-6">


            <div class="login-return">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 font-semibold text-[#0B4F8A] transition hover:text-[#087DCA]">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h12"/></svg>
                    Volver al inicio
                </a>
            </div>

            {{-- La marca se integra al fondo fotográfico de la pantalla. --}}
        <div class="login-logo mx-auto mb-5 flex size-24 items-center justify-center rounded-[1.75rem] border border-gray-100 bg-white p-2 shadow-xl shadow-[#333333]/10">
            <img src="{{ asset('images/Logo Malaga Emplea.png') }}"
                alt="Málaga Emplea"
                class="size-full object-contain">
        </div>

            {{-- ENCABEZADO --}}
            <div class="login-header mb-4 text-center">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.25em] text-[#4DB6E8]">
                    Bienvenido de nuevo
                </p>

                <h1 class="text-3xl font-extrabold tracking-tight text-[#0B2D5C]">
                    Iniciar sesión
                </h1>

                <p class="mt-2 text-sm leading-relaxed text-gray-500">
                    Ingresa a tu cuenta y continúa conectando con nuevas oportunidades.
                </p>
            </div>

            {{-- FORMULARIO DE INICIO DE SESIÓN --}}
            <form action="{{ route('login.store') }}" method="POST" class="login-form space-y-5">
                @csrf

                {{-- TIPO DE CUENTA --}}
                <div>
                    <label class="mb-3 block text-sm font-bold text-[#333333]">
                        ¿Cómo deseas ingresar?
                    </label>

                    

    <div class="grid grid-cols-2 gap-3">
        @foreach ($tiposCuenta as $tipo => $configuracion)
            <div>
                <input
                    type="radio"
                    name="tipo"
                    id="tipo_{{ $tipo }}"
                    value="{{ $tipo }}"
                    class="sr-only"
                    @checked($tipoSeleccionado === $tipo)
                >

                <button
                    type="button"
                    data-tipo="{{ $tipo }}"
                    aria-pressed="{{ $tipoSeleccionado === $tipo ? 'true' : 'false' }}"
                    onclick="seleccionarTipoCuenta('{{ $tipo }}')"
                    class="opcion-tipo w-full rounded-xl border-2 border-gray-200 bg-white p-4 text-center transition {{ $tipoSeleccionado === $tipo ? 'seleccionado' : '' }}"
                >
                    <span class="block font-bold text-[#333333]">
                        {{ $tipo === 'usuario' ? 'Persona natural' : 'Empresa' }}
                    </span>

                    <span class="mt-1 block text-xs text-gray-500">
                        {{ $tipo === 'usuario' ? 'Ingresar como persona' : 'Ingresar como empresa' }}
                    </span>
                </button>
            </div>
        @endforeach
    </div>



                    @error('tipo')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CORREO --}}
                <div>
                    <label for="email" class="mb-2 block text-sm font-bold text-[#333333]">
                        Correo electrónico
                    </label>

                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.92l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615a2.25 2.25 0 01-1.07-1.92V6.75"/>
                            </svg>
                        </span>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="ejemplo@correo.com"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-12 pr-4 text-sm text-[#333333] outline-none transition placeholder:text-gray-400 focus:border-[#4DB6E8] focus:bg-white focus:ring-4 focus:ring-[#4DB6E8]/15"
                        >
                    </div>

                </div>

                {{-- CONTRASEÑA --}}
                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <label for="password" class="block text-sm font-bold text-[#333333]">
                            Contraseña
                        </label>

                        <button type="button" data-abrir-recuperacion
                            class="text-xs font-semibold text-[#2386B5] transition hover:text-[#333333] hover:underline">
                            ¿Olvidaste tu contraseña?
                        </button>
                    </div>

                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                        </span>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Ingresa tu contraseña"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-12 pr-14 text-sm text-[#333333] outline-none transition placeholder:text-gray-400 focus:border-[#4DB6E8] focus:bg-white focus:ring-4 focus:ring-[#4DB6E8]/15"
                        >

                        <button
                            type="button"
                            id="alternarPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-[#333333]"
                            aria-label="Mostrar contraseña"
                        >
                            <svg id="iconoMostrar" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>

                    @php
                        $mensajeAcceso = $errors->first('password') ?: $errors->first('email');
                        $intentosRestantes = session('loginIntentosRestantes');
                    @endphp
                    @if ($mensajeAcceso)
                        <p class="mt-2 text-xs font-semibold text-red-700" role="alert">{{ $mensajeAcceso }}</p>
                    @elseif (session()->has('loginBloqueoSegundos'))
                        <p class="mt-2 text-xs font-semibold text-red-700" role="alert">Acceso temporalmente bloqueado. Inténtalo de nuevo en {{ max(1, (int) session('loginBloqueoSegundos')) }} segundos.</p>
                    @elseif ($intentosRestantes !== null)
                        <p class="mt-2 text-xs font-semibold text-amber-800" role="status">
                            @if ((int) $intentosRestantes > 0)
                                Te quedan {{ $intentosRestantes }} {{ (int) $intentosRestantes === 1 ? 'intento' : 'intentos' }} antes del bloqueo temporal.
                            @else
                                Llegaste al límite de 5 intentos. Espera un minuto antes de volver a ingresar.
                            @endif
                        </p>
                    @elseif (session('statusRecuperacion') || session('successRecuperacion'))
                        <p class="mt-2 text-xs font-semibold text-emerald-800" role="status">{{ session('statusRecuperacion') ?? session('successRecuperacion') }}</p>
                    @endif
                </div>

                {{-- RECORDAR SESIÓN --}}
                <div class="flex items-center">
                    <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-600">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            @checked(old('remember'))
                            class="size-4 rounded border-gray-300 text-[#4DB6E8] focus:ring-[#4DB6E8]"
                        >
                        Recordar mi sesión
                    </label>
                </div>

                {{-- BOTÓN INGRESAR --}}
                <button
                    type="submit"
                    class="group flex w-full items-center justify-center gap-2 rounded-xl bg-[#333333] px-5 py-4 text-sm font-extrabold text-white shadow-lg shadow-[#333333]/20 transition duration-300 hover:-translate-y-1 hover:bg-[#4DB6E8] hover:text-[#333333] hover:shadow-xl hover:shadow-[#4DB6E8]/25 active:translate-y-0"
                >
                    Iniciar sesión

                    <svg class="size-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </form>

            {{-- SEPARADOR --}}
            <div class="my-6 flex items-center gap-3">
                <div class="h-px flex-1 bg-gray-200"></div>
                <span class="text-xs font-medium text-gray-400">¿Aún no tienes cuenta?</span>
                <div class="h-px flex-1 bg-gray-200"></div>
            </div>

            {{-- CREAR CUENTA --}}
                <button
                    type="button"
                    onclick="abrirModalRegistro()"
                    class="flex w-full items-center justify-center gap-2 rounded-xl border-2 border-[#4DB6E8] bg-[#4DB6E8]/10 px-5 py-3 text-sm font-extrabold text-[#333333] transition duration-300 hover:-translate-y-0.5 hover:bg-[#4DB6E8] hover:shadow-lg hover:shadow-[#4DB6E8]/20"
                    >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>

        Crear cuenta
                </button>


        </div> {{-- Cierra la tarjeta principal --}}

        {{-- PIE DE PÁGINA --}}
        <p class="login-footnote mt-6 text-center text-xs font-medium text-white">
            Conectando talento y oportunidades en nuestra región.
        </p>

    </div> {{-- Cierra el contenedor de la tarjeta --}}

</div> {{-- Cierra el fondo principal --}}

{{-- MODAL PARA SOLICITAR EL ENLACE DE RESTABLECIMIENTO --}}
<div id="modalRecuperarContrasena"
    data-abrir-al-cargar="{{ $errors->getBag('recovery')->any() ? '1' : '0' }}"
    class="fixed inset-0 z-[110] hidden items-center justify-center bg-[#17232c]/70 px-4 py-6 backdrop-blur-sm"
    role="dialog" aria-modal="true" aria-labelledby="tituloRecuperacion">
    <div class="recovery-card relative w-full max-w-md overflow-hidden rounded-[1.75rem] border border-white/80 bg-white shadow-[0_28px_90px_rgba(10,25,35,.35)]">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-5 sm:px-7">
            <div class="flex items-start gap-3">
                <span class="flex size-11 shrink-0 items-center justify-center rounded-2xl bg-[#EAF6FD] text-[#2386B5]">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                </span>
                <div>
                    <h2 id="tituloRecuperacion" class="text-lg font-extrabold text-[#333333]">Recupera tu acceso</h2>
                    <p class="mt-1 text-sm leading-relaxed text-slate-500">Te enviaremos un enlace seguro para crear una contraseña nueva.</p>
                </div>
            </div>
            <button type="button" data-cerrar-recuperacion aria-label="Cerrar ventana"
                class="flex size-9 shrink-0 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-[#333333]">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5 px-6 py-6 sm:px-7">
            @csrf
            <fieldset>
                <legend class="mb-2 block text-sm font-bold text-[#333333]">Tipo de cuenta</legend>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($tiposCuenta as $tipo => $configuracion)
                        @php $tipoRecuperacionActual = old('tipo_recuperacion', $tipoSeleccionado); @endphp
                        <input id="tipo_recuperacion_{{ $tipo }}" class="sr-only" type="radio" name="tipo_recuperacion" value="{{ $tipo }}"
                            @checked($tipoRecuperacionActual === $tipo)>
                        <button type="button" data-tipo-recuperacion="{{ $tipo }}"
                            aria-pressed="{{ $tipoRecuperacionActual === $tipo ? 'true' : 'false' }}"
                            onclick="seleccionarTipoRecuperacion('{{ $tipo }}')"
                            class="opcion-tipo w-full rounded-xl border-2 border-gray-200 bg-white p-4 text-center transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#4DB6E8]/20 {{ $tipoRecuperacionActual === $tipo ? 'seleccionado' : '' }}">
                            <span class="block font-bold text-[#333333]">{{ $tipo === 'usuario' ? 'Persona natural' : 'Empresa' }}</span>
                            <span class="mt-1 block text-xs text-gray-500">{{ $tipo === 'usuario' ? 'Ingresar como persona' : 'Ingresar como empresa' }}</span>
                        </button>
                    @endforeach
                </div>
                @error('tipo_recuperacion', 'recovery')
                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </fieldset>

            <div>
                <label for="emailRecuperacion" class="mb-2 block text-sm font-bold text-[#333333]">Correo registrado</label>
                <input id="emailRecuperacion" name="email_recuperacion" type="email" required autocomplete="email"
                    value="{{ old('email_recuperacion', old('email')) }}" placeholder="ejemplo@correo.com"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-[#333333] outline-none transition placeholder:text-slate-400 focus:border-[#4DB6E8] focus:bg-white focus:ring-4 focus:ring-[#4DB6E8]/15">
                @error('email_recuperacion', 'recovery')
                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <p class="rounded-xl bg-slate-50 px-4 py-3 text-xs leading-relaxed text-slate-500">Si el correo corresponde a una cuenta activa, recibirás un enlace válido por 60 minutos.</p>
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-cerrar-recuperacion class="rounded-xl border-2 border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">Volver al inicio</button>
                <button type="submit" class="rounded-xl bg-[#333333] px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-[#333333]/15 transition hover:-translate-y-0.5 hover:bg-[#4DB6E8] hover:text-[#333333]">Enviar enlace</button>
            </div>
        </form>
    </div>
</div>

{{-- MOSTRAR / OCULTAR CONTRASEÑA Y SELECCIONAR CUENTA --}}
<script>
    const campoPassword = document.getElementById('password');
    const botonPassword = document.getElementById('alternarPassword');

    botonPassword.addEventListener('click', function () {
        const mostrar = campoPassword.type === 'password';

        campoPassword.type = mostrar ? 'text' : 'password';

        botonPassword.setAttribute(
            'aria-label',
            mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );

        botonPassword.innerHTML = mostrar
            ? `<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 002.036 12.322a1.012 1.012 0 000 .639C3.423 17.49 7.36 20.5 12 20.5c1.564 0 3.048-.36 4.36-1"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.228 6.228A10.45 10.45 0 0112 4.5c4.638 0 8.573 3.007 9.963 7.178a1.012 1.012 0 010 .639 10.477 10.477 0 01-4.293 5.373M6.228 6.228L3 3m3.228 3.228l12.544 12.544M9.88 9.88a3 3 0 004.24 4.24"/>
            </svg>`
            : `<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>`;
    });

    // Seleccionar el tipo de cuenta
    function seleccionarTipoCuenta(tipo) {
        const radio = document.getElementById(`tipo_${tipo}`);

        if (!radio) return;

        radio.checked = true;

        document.querySelectorAll('.login-form .opcion-tipo').forEach(boton => {
            const seleccionado = boton.dataset.tipo === tipo;

            boton.classList.toggle('seleccionado', seleccionado);
            boton.setAttribute('aria-pressed', seleccionado ? 'true' : 'false');
        });
    }

    function seleccionarTipoRecuperacion(tipo) {
        const radio = document.getElementById(`tipo_recuperacion_${tipo}`);
        if (!radio) return;

        radio.checked = true;
        document.querySelectorAll('[data-tipo-recuperacion]').forEach(boton => {
            const seleccionado = boton.dataset.tipoRecuperacion === tipo;
            boton.classList.toggle('seleccionado', seleccionado);
            boton.setAttribute('aria-pressed', seleccionado ? 'true' : 'false');
        });
    }

    const modalRecuperacion = document.getElementById('modalRecuperarContrasena');
    const campoEmailRecuperacion = document.getElementById('emailRecuperacion');

    function abrirModalRecuperacion(sincronizarCuenta = true) {
        const tipoLogin = sincronizarCuenta ? document.querySelector('input[name="tipo"]:checked')?.value : null;
        if (tipoLogin) {
            seleccionarTipoRecuperacion(tipoLogin);
        }

        if (campoEmailRecuperacion && !campoEmailRecuperacion.value) {
            campoEmailRecuperacion.value = document.getElementById('email')?.value ?? '';
        }

        modalRecuperacion.classList.remove('hidden');
        modalRecuperacion.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        window.setTimeout(() => campoEmailRecuperacion?.focus(), 50);
    }

    function cerrarModalRecuperacion() {
        modalRecuperacion.classList.add('hidden');
        modalRecuperacion.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        document.querySelector('[data-abrir-recuperacion]')?.focus();
    }

    document.querySelectorAll('[data-abrir-recuperacion]').forEach(boton => {
        boton.addEventListener('click', abrirModalRecuperacion);
    });
    modalRecuperacion.querySelectorAll('[data-cerrar-recuperacion]').forEach(boton => {
        boton.addEventListener('click', cerrarModalRecuperacion);
    });
    modalRecuperacion.addEventListener('click', evento => {
        if (evento.target === modalRecuperacion) cerrarModalRecuperacion();
    });
    document.addEventListener('keydown', evento => {
        if (evento.key === 'Escape' && !modalRecuperacion.classList.contains('hidden')) {
            cerrarModalRecuperacion();
        }
    });

    if (modalRecuperacion.dataset.abrirAlCargar === '1') abrirModalRecuperacion(false);
</script>

<style>
    .opcion-tipo {
        cursor: pointer;
        min-height: 76px;
    }

    .opcion-tipo.seleccionado {
        border-color: #4DB6E8;
        background-color: rgba(77, 182, 232, 0.10);
        box-shadow: 0 0 0 2px rgba(77, 182, 232, 0.15);
    }

    .opcion-tipo:hover {
        border-color: #4DB6E8;
    }
</style>

{{-- MODAL DE REGISTRO --}}
<div id="modalRegistro"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-[#17232c]/80 px-3 py-4 backdrop-blur-md">

    <div id="contenidoModal"
        class="modal-contenido relative flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl border border-white/70 bg-[#F4F4F4] shadow-[0_28px_90px_rgba(10,25,35,0.45)]">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between border-b border-gray-200 bg-white px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex size-10 items-center justify-center rounded-xl bg-[#4DB6E8]/20 text-[#333333]">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M18 9a3 3 0 11-6 0 3 3 0 016 0ZM6 20a6 6 0 0112 0M5 8a3 3 0 100 6m-2 6a5 5 0 014-4.9"/>
                    </svg>
                </div>

                <div>
                    <h2 id="tituloModal" class="text-lg font-extrabold text-[#333333]">
                        Crear una cuenta
                    </h2>
                    <p id="descripcionModal" class="text-xs text-gray-500">
                        Elige cómo quieres participar en Málaga Emplea.
                    </p>
                </div>
            </div>

            <button type="button" onclick="cerrarModalRegistro()"
                class="flex size-9 items-center justify-center rounded-full text-gray-500 transition hover:rotate-90 hover:bg-gray-100 hover:text-[#333333]"
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
                    <p class="text-sm font-bold text-[#333333]">¿Cómo deseas registrarte?</p>
                    <p class="mt-1 text-xs text-gray-500">Selecciona el tipo de cuenta que mejor se adapte a ti.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">

                    {{-- PERSONA --}}
                    <button type="button" onclick="mostrarFormulario('usuario')"
                        class="tarjeta-registro group flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 text-left transition duration-300 hover:-translate-y-1 hover:border-[#4DB6E8] hover:shadow-lg">

                        <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#4DB6E8]/15 text-[#333333] transition group-hover:scale-110 group-hover:bg-[#4DB6E8]">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.37 9.37 0 004.125-.95M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 8.25a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                            </svg>
                        </span>

                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-bold text-[#333333]">Persona natural</span>
                            <span class="mt-1 block text-xs leading-relaxed text-gray-500">
                                Busca empleo y crea tu hoja de vida.
                            </span>
                        </span>

                        <svg class="size-4 shrink-0 text-gray-400 transition group-hover:translate-x-1 group-hover:text-[#333333]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    {{-- EMPRESA --}}
                    <button type="button" onclick="mostrarFormulario('empresa')"
                        class="tarjeta-registro group flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 text-left transition duration-300 hover:-translate-y-1 hover:border-[#4DB6E8] hover:shadow-lg">

                        <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#333333]/10 text-[#333333] transition group-hover:scale-110 group-hover:bg-[#4DB6E8]">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01M14 9v.01M14 12v.01M14 15v.01M14 18v.01"/>
                            </svg>
                        </span>

                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-bold text-[#333333]">Empresa</span>
                            <span class="mt-1 block text-xs leading-relaxed text-gray-500">
                                Publica vacantes y encuentra talento.
                            </span>
                        </span>

                        <svg class="size-4 shrink-0 text-gray-400 transition group-hover:translate-x-1 group-hover:text-[#333333]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- FORMULARIOS --}}
            <div id="formulariosRegistro" class="hidden">

                <button type="button" onclick="volverSelector()"
                    class="mb-4 flex items-center gap-1.5 text-xs font-semibold text-gray-500 transition hover:text-[#333333]">
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
                            <label for="registroNombres" class="mb-1 block text-xs font-semibold text-[#333333]">Nombres</label>
                            <input id="registroNombres" name="nombres" type="text" required autocomplete="given-name"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div>
                            <label for="registroApellidos" class="mb-1 block text-xs font-semibold text-[#333333]">Apellidos</label>
                            <input id="registroApellidos" name="apellidos" type="text" required autocomplete="family-name"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div>
                            <label for="registroFecha" class="mb-1 block text-xs font-semibold text-[#333333]">Fecha de nacimiento</label>
                            <input id="registroFecha" name="fechaNacimiento" type="date" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div>
                            <label for="registroTipoDocumento" class="mb-1 block text-xs font-semibold text-[#333333]">Tipo de documento</label>
                            <select id="registroTipoDocumento" name="tipoDocumento" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                                <option value="">Seleccionar</option>
                                <option value="CC">Cédula de ciudadanía</option>
                                <option value="CE">Cédula de extranjería</option>
                                <option value="PPT">PPT</option>
                                <option value="PEP">PEP</option>
                                <option value="PASAPORTE">Pasaporte</option>
                            </select>
                        </div>

                        <div>
                            <label for="registroDocumento" class="mb-1 block text-xs font-semibold text-[#333333]">Número de documento</label>
                            <input id="registroDocumento" name="numeroDocumento" type="text" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div>
                            <label for="registroTelefono" class="mb-1 block text-xs font-semibold text-[#333333]">Teléfono</label>
                            <input id="registroTelefono" name="telefono" type="tel" required autocomplete="tel"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="registroEmailUsuario" class="mb-1 block text-xs font-semibold text-[#333333]">Correo electrónico</label>
                            <input id="registroEmailUsuario" name="email" type="email" required autocomplete="email"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="registroPasswordUsuario" class="mb-1 block text-xs font-semibold text-[#333333]">Contraseña</label>
                            <div class="relative">
                                <input id="registroPasswordUsuario" name="password" type="password" minlength="8" required autocomplete="new-password"
                                    class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 pr-16 text-sm outline-none">
                                <button type="button" onclick="alternarPassword('registroPasswordUsuario', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#4DB6E8] hover:text-[#333333]">
                                    Mostrar
                                </button>
                            </div>
                            <p class="mt-1 text-[11px] text-gray-500">Mínimo 8 caracteres.</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="boton-registro w-full rounded-lg bg-[#333333] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#4DB6E8] hover:text-[#333333]">
                        Crear cuenta personal
                    </button>
                </form>

                {{-- FORMULARIO EMPRESA --}}
                <form id="formRegistroEmpresa" class="hidden space-y-4">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="registroNombreEmpresa" class="mb-1 block text-xs font-semibold text-[#333333]">Nombre de la empresa</label>
                            <input id="registroNombreEmpresa" name="nombreEmpresa" type="text" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div>
                            <label for="registroNit" class="mb-1 block text-xs font-semibold text-[#333333]">NIT</label>
                            <input id="registroNit" name="nit" type="text" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div>
                            <label for="registroDireccion" class="mb-1 block text-xs font-semibold text-[#333333]">Dirección</label>
                            <input id="registroDireccion" name="direccion" type="text" required
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="registroEmailEmpresa" class="mb-1 block text-xs font-semibold text-[#333333]">Correo electrónico</label>
                            <input id="registroEmailEmpresa" name="email" type="email" required autocomplete="email"
                                class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="registroPasswordEmpresa" class="mb-1 block text-xs font-semibold text-[#333333]">Contraseña</label>
                            <div class="relative">
                                <input id="registroPasswordEmpresa" name="password" type="password" minlength="8" required autocomplete="new-password"
                                    class="campo-registro w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 pr-16 text-sm outline-none">
                                <button type="button" onclick="alternarPassword('registroPasswordEmpresa', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#4DB6E8] hover:text-[#333333]">
                                    Mostrar
                                </button>
                            </div>
                            <p class="mt-1 text-[11px] text-gray-500">Mínimo 8 caracteres.</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="boton-registro w-full rounded-lg bg-[#333333] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#4DB6E8] hover:text-[#333333]">
                        Crear cuenta de empresa
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
    #modalRegistro {
        opacity: 0;
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
        transition: opacity .3s ease, transform .3s cubic-bezier(.2,.8,.2,1);
    }

    #modalRegistro.modal-visible #contenidoModal {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .etapa-animacion {
        animation: aparecerEtapa .35s ease both;
    }

    @keyframes aparecerEtapa {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tarjeta-registro {
        position: relative;
        overflow: hidden;
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

    .campo-registro {
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .campo-registro:focus {
        border-color: #4DB6E8;
        box-shadow: 0 0 0 3px rgba(77,182,232,.16);
    }

    .boton-registro {
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .boton-registro:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 16px rgba(51,51,51,.15);
    }

    .boton-registro:active {
        transform: scale(.98);
    }

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


/* Adaptación automática del login */
.login-page {
    min-height: 100vh;
    min-height: 100dvh;
    padding-block: clamp(0.5rem, 2dvh, 1.5rem);
}

/* Ajustes para pantallas de poca altura en cualquier dispositivo */
@media (max-height: 850px) {
    .login-page {
        overflow-x: hidden;
        overflow-y: auto;
        align-items: flex-start;
    }

    .login-card {
        padding: clamp(0.85rem, 2dvh, 1.5rem) !important;
    }

    .login-logo {
        width: clamp(4.5rem, 11dvh, 6rem);
        height: clamp(4.5rem, 11dvh, 6rem);
        margin-bottom: clamp(0.5rem, 1.5dvh, 1.25rem);
    }

    .login-logo img {
        width: 100%;
        height: 100%;
    }

    .login-header {
        margin-bottom: clamp(0.5rem, 1.5dvh, 1rem);
    }

    .login-form > :not([hidden]) ~ :not([hidden]) {
        margin-top: clamp(0.6rem, 1.4dvh, 1.25rem);
    }

    .login-form input[type="email"],
    .login-form input[type="password"] {
        padding-block: clamp(0.5rem, 1.1dvh, 0.875rem);
    }

    .login-form button[type="submit"] {
        padding-block: clamp(0.65rem, 1.3dvh, 1rem);
    }

    .login-card .my-6 {
        margin-block: clamp(0.5rem, 1.5dvh, 1.5rem);
    }
}

@media (max-height: 720px) {
    .login-page {
        padding-block: 0.5rem;
    }

    .login-card {
        padding: 0.75rem 1rem !important;
        border-radius: 1.25rem !important;
    }

    .login-logo {
        width: 4rem;
        height: 4rem;
        margin-bottom: 0.45rem;
        border-radius: 1rem;
    }

    .login-logo img {
        width: 100%;
        height: 100%;
    }

    .login-header {
        margin-bottom: 0.4rem;
    }

    .login-header > p:last-child {
        display: none;
    }

    .login-header h1 { font-size: 1.5rem; line-height: 1.9rem; }

    .login-header > p:first-child {
        margin-bottom: 0.15rem;
        font-size: 0.65rem;
    }

    .login-form > :not([hidden]) ~ :not([hidden]) {
        margin-top: 0.55rem;
    }

    .login-form > div > label,
    .login-form > div > .mb-2 {
        margin-bottom: 0.25rem;
    }

    .opcion-tipo {
        min-height: 3.25rem;
        padding: 0.5rem 0.35rem;
    }

    .login-form input[type="email"],
    .login-form input[type="password"] {
        padding-block: 0.55rem;
    }

    .login-form button[type="submit"] {
        padding-block: 0.65rem;
    }

    .login-card .my-6 {
        margin-block: 0.45rem;
    }

    .login-card > .mt-5 {
        margin-top: 0.4rem;
    }

    .login-card + p {
        margin-top: 0.35rem;
    }
}

@media (max-height: 500px) {
    .login-logo { width: 3rem; height: 3rem; margin-bottom: 0.25rem; }

    .login-card {
        padding-block: 0.5rem !important;
    }
}

/* Presentación inspirada en la referencia, conservando los formularios y sus flujos. */
.login-page {
    justify-content: flex-end;
    background-image: linear-gradient(90deg, rgba(5, 38, 72, .02), rgba(7, 74, 132, .08)), var(--login-fondo);
    background-position: center;
    background-size: cover;
    padding: clamp(.75rem, 2.5vw, 2rem);
}

.login-page > .absolute { display: none; }

.login-shell {
    width: min(100%, 450px);
    max-width: 450px;
    margin-right: clamp(0rem, 3vw, 3rem);
}

.login-card {
    border: 1px solid rgba(255, 255, 255, .82) !important;
    border-radius: 2.25rem !important;
    background: rgba(235, 247, 255, .76) !important;
    box-shadow: 0 28px 80px rgba(9, 45, 86, .24) !important;
    backdrop-filter: blur(22px);
    padding: clamp(.85rem, 1.8vw, 1.35rem) clamp(1rem, 2vw, 1.5rem) !important;
}

.login-card > .absolute { display: none; }
.login-logo { display: none; }
.login-return { display: flex; justify-content: flex-end; margin: 0 0 .8rem; font-size: .9rem; }
.login-header { margin-bottom: .9rem; }
.login-header > p:first-child { display: none; }
.login-header h1 { color: #0B2D5C !important; font-size: clamp(2rem, 3vw, 2.7rem); }
.login-header > p:last-child { color: #24496E; font-size: 1rem; }
.login-form > div > label,
.login-form > div > .mb-2 label { color: #163C69 !important; }

.login-form .opcion-tipo {
    min-height: 3.25rem;
    border-color: rgba(24, 101, 167, .18);
    border-radius: 1rem;
    background: rgba(255, 255, 255, .72);
}

.login-form .opcion-tipo.seleccionado {
    border-color: #1686D9;
    background: rgba(77, 182, 232, .17);
    box-shadow: 0 0 0 2px rgba(22, 134, 217, .12);
}

.login-form input[type="email"],
.login-form input[type="password"] {
    border-color: rgba(24, 74, 119, .16);
    border-radius: 1rem;
    background: rgba(255, 255, 255, .83);
    color: #12303F;
}

.login-form > button[type="submit"] {
    border-radius: 999px;
    background: linear-gradient(100deg, #0877D1, #078FE1) !important;
    box-shadow: 0 10px 24px rgba(8, 119, 209, .22) !important;
    padding-block: .75rem;
}

.login-form > button[type="submit"]:hover { color: white !important; }
.login-card > button[onclick="abrirModalRegistro()"] { border-radius: 999px; background: rgba(255,255,255,.45); }
.login-card .my-6 span { color: #24496E; }
.login-card .my-6 div { background: rgba(24,74,119,.22); }
.login-footnote { color: white !important; text-shadow: 0 2px 12px rgba(0,35,70,.8); }

#modalRegistro { background-color: rgba(7, 39, 68, .70); }
#contenidoModal { border-radius: 1.75rem; background: #F8FCFF; }
#modalRegistro .bg-white { background-color: #F5FAFE; }
#modalRegistro .boton-registro { border-radius: 999px; }
#modalRegistro form button[type="submit"] { background: #087DCA; color: white; }
#modalRegistro form button[type="submit"]:hover { background: #0566A8; color: white; }

#modalRecuperarContrasena { background-color: rgba(7, 39, 68, .70); }
#modalRecuperarContrasena .recovery-card { border-radius: 1.75rem; background: #F8FCFF; }
#modalRecuperarContrasena button[type="submit"] { border-radius: 999px; background: #087DCA; }
#modalRecuperarContrasena button[type="submit"]:hover { background: #0566A8; }

@media (max-width: 760px) {
    .login-page { justify-content: center; background-position: 36% center; padding: 1rem; }
    .login-shell { width: min(100%, 400px); max-width: 400px; margin: auto; }
    .login-card { border-radius: 1.5rem !important; background: rgba(245, 250, 255, .88) !important; padding: 1rem !important; }
    .login-header { margin-bottom: .65rem; }
    .login-return { margin-bottom: .65rem; }
    .login-form > :not([hidden]) ~ :not([hidden]) { margin-top: .7rem; }
}

@media (max-width: 420px) {
    .login-page { padding: .65rem; }
    .login-shell { width: 100%; }
    .login-card { border-radius: 1.35rem !important; padding: 1rem !important; }
    .login-form .opcion-tipo { min-height: 3.35rem; padding-inline: .5rem; }
    .login-header h1 { font-size: 1.8rem; }
}

@media (max-height: 720px) {
    .login-page { align-items: center; overflow-y: auto; padding-block: .5rem; }
    .login-shell { max-width: 390px; }
    .login-card { padding: .8rem 1rem !important; border-radius: 1.3rem !important; }
    .login-return { margin-bottom: .4rem; font-size: .8rem; }
    .login-header { margin-bottom: .45rem; }
    .login-header h1 { font-size: 1.7rem; line-height: 1.9rem; }
    .login-form > :not([hidden]) ~ :not([hidden]) { margin-top: .5rem; }
    .login-form .opcion-tipo { min-height: 2.75rem; }
    .login-form input[type="email"],
    .login-form input[type="password"] { padding-block: .5rem; }
    .login-form > button[type="submit"] { padding-block: .6rem; }
    .login-card .my-6 { margin-block: .35rem; }
    .login-card > button[onclick="abrirModalRegistro()"] { padding-block: .55rem; }
    .login-shell { margin-block: auto; }
    .login-footnote { margin-top: .35rem; }
}

@media (max-height: 600px) {
    .login-page { align-items: flex-start; }
    .login-header > p:last-child { display: none; }
    .login-footnote { display: none; }
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
            tipo === 'usuario' ? 'Crear cuenta personal' : 'Crear cuenta empresarial';

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

    function alternarPassword(id, boton) {
        const campo = document.getElementById(id);
        const mostrar = campo.type === 'password';

        campo.type = mostrar ? 'text' : 'password';
        boton.textContent = mostrar ? 'Ocultar' : 'Mostrar';
    }

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
