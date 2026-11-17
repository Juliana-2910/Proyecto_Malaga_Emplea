
@extends('layouts.Publico.inicio')

@section('title', 'Iniciar sesión')
@section('hide-public-footer', 'true')

@section('content')

@php
    $tiposCuenta = config('seguridad.login', []);
    $tipoSeleccionado = old('tipo', array_key_first($tiposCuenta));
    $mensajeAcceso = $errors->first('password') ?: $errors->first('email');
    $intentosRestantes = session('loginIntentosRestantes');

    $campoLogin = 'w-full rounded-2xl border border-white/70 bg-white/90 py-3.5 pl-12 text-[15px] text-noche outline-none transition placeholder:text-slate-400 focus:border-marca focus:bg-white focus:ring-4 focus:ring-marca/20';
    $btnPrimario = 'rounded-full border-2 border-marca bg-marca px-5 py-3 text-sm font-extrabold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white';
@endphp

{{-- PÁGINA: foto de fondo + tarjeta de vidrio a la derecha --}}
<div class="login-page flex min-h-screen items-center justify-center px-4 py-6 lg:justify-end lg:px-16">

    {{-- CONTENEDOR DE TARJETA Y FRASE --}}
    <div class="w-full max-w-[440px]">

        {{-- TARJETA DE LOGIN --}}
        <div class="w-full rounded-[2rem] border border-white/85 bg-white/75 px-6 py-8 shadow-2xl shadow-noche/25 backdrop-blur-xl sm:px-8">

            <a href="{{ url('/') }}" class="ml-auto flex w-fit items-center gap-2 text-sm font-bold text-marca-texto transition hover:text-noche">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h12"/></svg>
                Volver al inicio
            </a>

            {{-- ENCABEZADO --}}
            <div class="mb-5 mt-2 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-noche">Iniciar sesión</h1>
                <p class="mt-1.5 text-base font-semibold text-noche">Ingresa con tu cuenta para continuar</p>
            </div>

            {{-- FORMULARIO DE INICIO DE SESIÓN --}}
            <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- TIPO DE CUENTA --}}
                <fieldset>
                    <legend class="sr-only">Tipo de cuenta</legend>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($tiposCuenta as $tipo => $configuracion)
                            <div>
                                <input type="radio" name="tipo" id="tipo_{{ $tipo }}" value="{{ $tipo }}" class="sr-only" @checked($tipoSeleccionado === $tipo)>

                                <button type="button" data-tipo="{{ $tipo }}"
                                    aria-pressed="{{ $tipoSeleccionado === $tipo ? 'true' : 'false' }}"
                                    onclick="seleccionarTipoCuenta('{{ $tipo }}')"
                                    class="opcion-tipo flex min-h-[54px] w-full items-center justify-center gap-2.5 rounded-2xl border-2 border-transparent bg-white/80 px-3 text-[15px] font-bold text-slate-600 transition {{ $tipoSeleccionado === $tipo ? 'seleccionado' : '' }}">
                                    @if ($tipo === 'usuario')
                                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/></svg>
                                        Persona Natural
                                    @else
                                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/></svg>
                                        Empresa
                                    @endif
                                </button>
                            </div>
                        @endforeach
                    </div>

                    @error('tipo')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>

                {{-- CORREO --}}
                <div class="relative">
                    <label for="email" class="sr-only">Correo electrónico</label>
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-marca-texto">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.92l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615a2.25 2.25 0 01-1.07-1.92V6.75"/></svg>
                    </span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username" placeholder="Correo electrónico" class="{{ $campoLogin }} pr-4">
                </div>

                {{-- CONTRASEÑA --}}
                <div>
                    <div class="relative">
                        <label for="password" class="sr-only">Contraseña</label>
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-marca-texto">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </span>

                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            placeholder="Contraseña" class="{{ $campoLogin }} pr-14">

                        <button type="button" id="alternarPassword" aria-label="Mostrar contraseña"
                            title="Mostrar contraseña"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 transition hover:text-carbon">
                            <svg id="iconoOculta" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10c2.5 4 6 6 9 6s6.5-2 9-6M12 16v3M7 14.5l-1.5 2.5M17 14.5l1.5 2.5"/></svg>
                            <svg id="iconoVisible" class="hidden size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>

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

                {{-- RECORDAR SESIÓN + OLVIDÉ MI CONTRASEÑA --}}
                <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-2">
                    <label class="flex cursor-pointer items-center gap-2.5 text-sm font-semibold text-noche">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember'))
                            class="size-5 rounded-md border-2 border-marca-texto text-marca-texto focus:ring-marca">
                        Recordar mi sesión
                    </label>

                    <button type="button" data-abrir-recuperacion
                        class="text-sm font-bold text-marca-texto underline transition hover:text-noche">
                        ¿Olvidaste tu contraseña?
                    </button>
                </div>

                {{-- BOTÓN INGRESAR --}}
                <button type="submit"
                    class="flex min-h-[56px] w-full items-center justify-center rounded-full border-2 border-marca bg-marca text-lg font-extrabold text-tinta shadow-lg shadow-marca/40 transition hover:border-carbon hover:bg-carbon hover:text-white">
                    Iniciar sesión
                </button>
            </form>

            {{-- REGISTRO --}}
            <p class="mt-5 border-t border-noche/15 pt-5 text-center text-base font-semibold text-noche">
                ¿Aún no tienes cuenta?
                <button type="button" onclick="abrirModalRegistro()" class="font-extrabold text-marca-texto underline transition hover:text-noche">Regístrate</button>
            </p>
        </div>

        {{-- FRASE FUERA DE LA TARJETA --}}
        <p class="login-footnote mt-6 text-center text-xs font-medium text-white">
            Conectando talento y oportunidades en nuestra región.
        </p>

    </div>
</div>

{{-- MODAL PARA SOLICITAR EL ENLACE DE RESTABLECIMIENTO --}}
<div id="modalRecuperarContrasena"
    data-abrir-al-cargar="{{ $errors->getBag('recovery')->any() ? '1' : '0' }}"
    class="fixed inset-0 z-[110] hidden items-center justify-center bg-noche/70 px-4 py-6 backdrop-blur-sm"
    role="dialog" aria-modal="true" aria-labelledby="tituloRecuperacion">
    <div class="relative w-full max-w-md overflow-hidden rounded-[1.75rem] border border-white/80 bg-white shadow-2xl shadow-noche/40">
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-5 sm:px-7">
            <div class="flex items-start gap-3">
                <span class="flex size-11 shrink-0 items-center justify-center rounded-2xl bg-[#EAF6FD] text-marca-texto">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                </span>
                <div>
                    <h2 id="tituloRecuperacion" class="text-lg font-extrabold text-noche">Recupera tu acceso</h2>
                    <p class="mt-1 text-sm leading-relaxed text-slate-500">Te enviaremos un enlace seguro para crear una contraseña nueva.</p>
                </div>
            </div>
            <button type="button" data-cerrar-recuperacion aria-label="Cerrar ventana"
                class="flex size-9 shrink-0 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-carbon">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5 px-6 py-6 sm:px-7">
            @csrf
            <fieldset>
                <legend class="mb-2 block text-sm font-bold text-noche">Tipo de cuenta</legend>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($tiposCuenta as $tipo => $configuracion)
                        @php $tipoRecuperacionActual = old('tipo_recuperacion', $tipoSeleccionado); @endphp
                        <input id="tipo_recuperacion_{{ $tipo }}" class="sr-only" type="radio" name="tipo_recuperacion" value="{{ $tipo }}"
                            @checked($tipoRecuperacionActual === $tipo)>
                        <button type="button" data-tipo-recuperacion="{{ $tipo }}"
                            aria-pressed="{{ $tipoRecuperacionActual === $tipo ? 'true' : 'false' }}"
                            onclick="seleccionarTipoRecuperacion('{{ $tipo }}')"
                            class="opcion-tipo flex min-h-[54px] w-full items-center justify-center rounded-2xl border-2 border-slate-200 bg-white px-3 text-[15px] font-bold text-slate-600 transition {{ $tipoRecuperacionActual === $tipo ? 'seleccionado' : '' }}">
                            {{ $tipo === 'usuario' ? 'Persona Natural' : 'Empresa' }}
                        </button>
                    @endforeach
                </div>
                @error('tipo_recuperacion', 'recovery')
                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </fieldset>

            <div>
                <label for="emailRecuperacion" class="mb-2 block text-sm font-bold text-noche">Correo registrado</label>
                <input id="emailRecuperacion" name="email_recuperacion" type="email" required autocomplete="email"
                    value="{{ old('email_recuperacion', old('email')) }}" placeholder="ejemplo@correo.com"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-noche outline-none transition placeholder:text-slate-400 focus:border-marca focus:bg-white focus:ring-4 focus:ring-marca/15">
                @error('email_recuperacion', 'recovery')
                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <p class="rounded-xl bg-slate-50 px-4 py-3 text-xs leading-relaxed text-slate-500">Si el correo corresponde a una cuenta activa, recibirás un enlace válido por 60 minutos.</p>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-cerrar-recuperacion class="rounded-full border-2 border-slate-300 px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-carbon hover:bg-carbon hover:text-white">Volver al inicio</button>
                <button type="submit" class="{{ $btnPrimario }}">Enviar enlace</button>
            </div>
        </form>
    </div>
</div>

{{-- MODALES DE REGISTRO (views/layouts/Publico) --}}
@include('layouts.Publico.modalRegistroTipo')
@include('layouts.Publico.modalRegistroUsuario')
@include('layouts.Publico.modalRegistroEmpresa')

<style>
    /* Foto de fondo */
    .login-page {
        background-color: #6FB4EE;
        background-image: url('{{ asset('images/fondo-malaga-login-oscurecido.jpg') }}');
        background-size: cover;
        background-position: left center;
    }

    @media (max-width: 760px) {
        .login-page {
            background-position: 30% center;
        }
    }

    /* Botones de tipo de cuenta (login y recuperación) */
    .opcion-tipo {
        cursor: pointer;
        transition: transform .25s ease, border-color .25s ease, background-color .25s ease, box-shadow .25s ease;
    }

    .opcion-tipo:hover {
        transform: translateY(-3px);
        border-color: #4DB6E8;
        box-shadow: 0 8px 20px rgba(77, 182, 232, .15);
    }

    .opcion-tipo.seleccionado {
        border-color: #4DB6E8;
        background-color: #EAF6FD;
        color: #1A75A8;
        box-shadow: 0 5px 15px rgba(77, 182, 232, .16);
    }

    .opcion-tipo:focus-visible {
        outline: 3px solid rgba(77, 182, 232, .35);
        outline-offset: 3px;
    }

    @media (prefers-reduced-motion: reduce) {
        .opcion-tipo {
            animation: none !important;
            transition: none !important;
        }

        .opcion-tipo:hover {
            transform: none;
        }
    }
</style>

<script>
    // ---------- Mostrar / ocultar contraseña del login ----------
    const campoPassword = document.getElementById('password');
    const botonPassword = document.getElementById('alternarPassword');

    botonPassword.addEventListener('click', function () {
        const mostrar = campoPassword.type === 'password';

        campoPassword.type = mostrar ? 'text' : 'password';
        botonPassword.setAttribute('aria-label', mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña');
        botonPassword.setAttribute('title', mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña');

        document.getElementById('iconoOculta').classList.toggle('hidden', mostrar);
        document.getElementById('iconoVisible').classList.toggle('hidden', !mostrar);
    });

    // ---------- Tipo de cuenta del login ----------
    function seleccionarTipoCuenta(tipo) {
        const radio = document.getElementById(`tipo_${tipo}`);
        if (!radio) return;

        radio.checked = true;

        document.querySelectorAll('[data-tipo]').forEach(boton => {
            const seleccionado = boton.dataset.tipo === tipo;

            boton.classList.toggle('seleccionado', seleccionado);
            boton.setAttribute('aria-pressed', seleccionado ? 'true' : 'false');
        });
    }

    // ---------- Recuperar contraseña ----------
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
        if (tipoLogin) seleccionarTipoRecuperacion(tipoLogin);

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
        boton.addEventListener('click', () => abrirModalRecuperacion());
    });

    modalRecuperacion.querySelectorAll('[data-cerrar-recuperacion]').forEach(boton => {
        boton.addEventListener('click', cerrarModalRecuperacion);
    });

    modalRecuperacion.addEventListener('click', evento => {
        if (evento.target === modalRecuperacion) cerrarModalRecuperacion();
    });

    if (modalRecuperacion.dataset.abrirAlCargar === '1') abrirModalRecuperacion(false);

    // Escape cierra la ventana de recuperación (el registro lo maneja su propio parcial)
    document.addEventListener('keydown', function (evento) {
        if (evento.key === 'Escape' && !modalRecuperacion.classList.contains('hidden')) {
            cerrarModalRecuperacion();
        }
    });
</script>

@endsection
