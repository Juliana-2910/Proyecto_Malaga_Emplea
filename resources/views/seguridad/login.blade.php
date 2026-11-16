
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
    $campoRegistro = 'campo-registro w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none';
    $etiquetaRegistro = 'mb-1 block text-xs font-semibold text-noche';
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
                                        Persona natural
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

                        {{-- Ojo cerrado = contraseña oculta · ojo abierto = contraseña visible --}}
                        <button type="button" id="alternarPassword" aria-label="Mostrar contraseña"
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
                            {{ $tipo === 'usuario' ? 'Persona natural' : 'Empresa' }}
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

{{-- MODAL DE REGISTRO: primero se elige el tipo de cuenta y cada tipo tiene su formulario --}}
<div id="modalRegistro" class="fixed inset-0 z-[100] hidden items-center justify-center bg-noche/80 px-3 py-4 backdrop-blur-md">

    <div id="contenidoModal" class="relative flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl border border-white/70 bg-fondo shadow-2xl shadow-noche/40">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
            <div>
                <h2 id="tituloModal" class="text-lg font-extrabold text-noche">Crear una cuenta</h2>
                <p id="descripcionModal" class="text-xs text-slate-500">Elige cómo quieres participar en Málaga Emplea.</p>
            </div>

            <button type="button" onclick="cerrarModalRegistro()" aria-label="Cerrar modal"
                class="flex size-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-carbon">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- INDICADOR DE ETAPA --}}
        <div class="flex gap-1.5 px-5 pt-4">
            <span id="pasoUno" class="h-1 flex-1 rounded-full bg-marca transition-all"></span>
            <span id="pasoDos" class="h-1 flex-1 rounded-full bg-slate-200 transition-all"></span>
        </div>

        {{-- CONTENIDO --}}
        <div id="contenidoDesplazable" class="overflow-y-auto p-5 sm:p-6">

            {{-- SELECCIÓN DEL TIPO DE CUENTA --}}
            <div id="selectorRegistro" class="etapa-animacion">
                <div class="mb-4">
                    <p class="text-sm font-bold text-noche">¿Cómo deseas registrarte?</p>
                    <p class="mt-1 text-xs text-slate-500">Selecciona el tipo de cuenta que mejor se adapte a ti.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <button type="button" onclick="mostrarFormulario('usuario')"
                        class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 text-left transition hover:-translate-y-1 hover:border-marca hover:shadow-lg">
                        <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto transition group-hover:bg-marca group-hover:text-tinta">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/></svg>
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-bold text-noche">Persona natural</span>
                            <span class="mt-1 block text-xs leading-relaxed text-slate-500">Busca empleo y crea tu hoja de vida.</span>
                        </span>
                    </button>

                    <button type="button" onclick="mostrarFormulario('empresa')"
                        class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 text-left transition hover:-translate-y-1 hover:border-marca hover:shadow-lg">
                        <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto transition group-hover:bg-marca group-hover:text-tinta">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/></svg>
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-bold text-noche">Empresa</span>
                            <span class="mt-1 block text-xs leading-relaxed text-slate-500">Publica vacantes y encuentra talento.</span>
                        </span>
                    </button>
                </div>
            </div>

            {{-- FORMULARIOS --}}
            <div id="formulariosRegistro" class="hidden">

                <button type="button" onclick="volverSelector()"
                    class="mb-4 flex items-center gap-1.5 text-xs font-semibold text-slate-500 transition hover:text-carbon">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Cambiar tipo de cuenta
                </button>

                {{-- FORMULARIO PERSONA NATURAL --}}
                <form id="formRegistroUsuario" class="hidden space-y-4">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label for="registroNombres" class="{{ $etiquetaRegistro }}">Nombres</label>
                            <input id="registroNombres" name="nombres" type="text" required autocomplete="given-name" class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroApellidos" class="{{ $etiquetaRegistro }}">Apellidos</label>
                            <input id="registroApellidos" name="apellidos" type="text" required autocomplete="family-name" class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroFecha" class="{{ $etiquetaRegistro }}">Fecha de nacimiento</label>
                            {{-- type="date": el navegador muestra el calendario para elegir la fecha --}}
                            <input id="registroFecha" name="fechaNacimiento" type="date" required
                                min="1900-01-01" max="{{ date('Y-m-d') }}" class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroTipoDocumento" class="{{ $etiquetaRegistro }}">Tipo de documento</label>
                            <select id="registroTipoDocumento" name="tipoDocumento" required class="{{ $campoRegistro }}">
                                <option value="">Seleccionar</option>
                                <option value="CC">Cédula de ciudadanía</option>
                                <option value="CE">Cédula de extranjería</option>
                                <option value="PPT">PPT</option>
                                <option value="PEP">PEP</option>
                                <option value="PASAPORTE">Pasaporte</option>
                            </select>
                        </div>

                        <div>
                            <label for="registroDocumento" class="{{ $etiquetaRegistro }}">Número de documento</label>
                            <input id="registroDocumento" name="numeroDocumento" type="text" required class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroTelefono" class="{{ $etiquetaRegistro }}">Teléfono</label>
                            <input id="registroTelefono" name="telefono" type="tel" required autocomplete="tel" class="{{ $campoRegistro }}">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="registroEmailUsuario" class="{{ $etiquetaRegistro }}">Correo electrónico</label>
                            <input id="registroEmailUsuario" name="email" type="email" required autocomplete="email" class="{{ $campoRegistro }}">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="registroPasswordUsuario" class="{{ $etiquetaRegistro }}">Contraseña</label>
                            <div class="relative">
                                <input id="registroPasswordUsuario" name="password" type="password" minlength="8" required autocomplete="new-password" class="{{ $campoRegistro }} pr-16">
                                <button type="button" onclick="alternarPassword('registroPasswordUsuario', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-marca-texto hover:text-carbon">Mostrar</button>
                            </div>
                            <p class="mt-1 text-[11px] text-slate-500">Mínimo 8 caracteres.</p>
                        </div>
                    </div>

                    <button type="submit" class="{{ $btnPrimario }} w-full">Crear cuenta personal</button>
                </form>

                {{-- FORMULARIO EMPRESA --}}
                <form id="formRegistroEmpresa" class="hidden space-y-4">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="registroNombreEmpresa" class="{{ $etiquetaRegistro }}">Nombre de la empresa</label>
                            <input id="registroNombreEmpresa" name="nombreEmpresa" type="text" required class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroNit" class="{{ $etiquetaRegistro }}">NIT</label>
                            <input id="registroNit" name="nit" type="text" required class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroDireccion" class="{{ $etiquetaRegistro }}">Dirección</label>
                            <input id="registroDireccion" name="direccion" type="text" required class="{{ $campoRegistro }}">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="registroEmailEmpresa" class="{{ $etiquetaRegistro }}">Correo electrónico</label>
                            <input id="registroEmailEmpresa" name="email" type="email" required autocomplete="email" class="{{ $campoRegistro }}">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="registroPasswordEmpresa" class="{{ $etiquetaRegistro }}">Contraseña</label>
                            <div class="relative">
                                <input id="registroPasswordEmpresa" name="password" type="password" minlength="8" required autocomplete="new-password" class="{{ $campoRegistro }} pr-16">
                                <button type="button" onclick="alternarPassword('registroPasswordEmpresa', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-marca-texto hover:text-carbon">Mostrar</button>
                            </div>
                            <p class="mt-1 text-[11px] text-slate-500">Mínimo 8 caracteres.</p>
                        </div>
                    </div>

                    <button type="submit" class="{{ $btnPrimario }} w-full">Crear cuenta de empresa</button>
                </form>
            </div>
        </div>

        {{-- PIE --}}
        <div class="border-t border-slate-200 bg-white px-5 py-3 text-center">
            <p class="text-[11px] text-slate-500">Málaga Emplea · Conectando oportunidades en nuestra región.</p>
        </div>
    </div>
</div>

<style>
    /* Foto de fondo (ya oscurecida). Si no carga, se ve el azul de respaldo. */
    .login-page {
        background-color: #6FB4EE;
        background-image: url('{{ asset('images/fondo-malaga-login-oscurecido.jpg') }}');
        background-size: cover;
        background-position: left center;
    }

    @media (max-width: 760px) {
        .login-page { background-position: 30% center; }
    }

    /* Botones de tipo de cuenta (login y recuperación) */
    .opcion-tipo { cursor: pointer; }
    .opcion-tipo:hover { border-color: #4DB6E8; }
    .opcion-tipo.seleccionado {
        border-color: #4DB6E8;
        background-color: #EAF6FD;
        color: #1A75A8;
    }

    /* Modal de registro: aparición suave */
    #modalRegistro { opacity: 0; transition: opacity .25s ease; }
    #modalRegistro.modal-visible { opacity: 1; }
    #contenidoModal {
        max-height: 90dvh;
        opacity: 0;
        transform: translateY(18px) scale(.97);
        transition: opacity .3s ease, transform .3s cubic-bezier(.2, .8, .2, 1);
    }
    #modalRegistro.modal-visible #contenidoModal { opacity: 1; transform: translateY(0) scale(1); }

    .etapa-animacion { animation: aparecerEtapa .35s ease both; }
    @keyframes aparecerEtapa {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .campo-registro { transition: border-color .2s ease, box-shadow .2s ease; }
    .campo-registro:focus { border-color: #4DB6E8; box-shadow: 0 0 0 3px rgba(77, 182, 232, .2); }

    @media (prefers-reduced-motion: reduce) {
        #modalRegistro, #contenidoModal, .etapa-animacion { animation: none !important; transition: none !important; }
    }
</style>

<script>
    // ---------- Mostrar / ocultar contraseña (ojo cerrado = oculta, ojo abierto = visible) ----------
    const campoPassword = document.getElementById('password');
    const botonPassword = document.getElementById('alternarPassword');

    botonPassword.addEventListener('click', function () {
        const mostrar = campoPassword.type === 'password';

        campoPassword.type = mostrar ? 'text' : 'password';
        botonPassword.setAttribute('aria-label', mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña');
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

    // ---------- Modal de registro ----------
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

        selector.classList.add('hidden');
        selector.classList.remove('etapa-animacion');

        formularios.classList.remove('hidden');
        document.getElementById('formRegistroUsuario').classList.toggle('hidden', tipo !== 'usuario');
        document.getElementById('formRegistroEmpresa').classList.toggle('hidden', tipo !== 'empresa');

        document.getElementById('tituloModal').textContent =
            tipo === 'usuario' ? 'Crear cuenta personal' : 'Crear cuenta empresarial';

        document.getElementById('descripcionModal').textContent =
            tipo === 'usuario'
                ? 'Completa tus datos para comenzar.'
                : 'Registra tu negocio y conecta con nuevos talentos.';

        document.getElementById('pasoUno').classList.replace('bg-marca', 'bg-slate-200');
        document.getElementById('pasoDos').classList.replace('bg-slate-200', 'bg-marca');

        formularios.classList.remove('etapa-animacion');
        void formularios.offsetWidth;
        formularios.classList.add('etapa-animacion');

        document.getElementById('contenidoDesplazable').scrollTo({ top: 0, behavior: 'smooth' });
    }

    function volverSelector() {
        document.getElementById('selectorRegistro').classList.remove('hidden');
        document.getElementById('selectorRegistro').classList.add('etapa-animacion');

        document.getElementById('formulariosRegistro').classList.add('hidden');
        document.getElementById('formRegistroUsuario').classList.add('hidden');
        document.getElementById('formRegistroEmpresa').classList.add('hidden');

        document.getElementById('tituloModal').textContent = 'Crear una cuenta';
        document.getElementById('descripcionModal').textContent = 'Elige cómo quieres participar en Málaga Emplea.';

        document.getElementById('pasoUno').classList.replace('bg-slate-200', 'bg-marca');
        document.getElementById('pasoDos').classList.replace('bg-marca', 'bg-slate-200');

        document.getElementById('contenidoDesplazable').scrollTo({ top: 0, behavior: 'smooth' });
    }

    function alternarPassword(id, boton) {
        const campo = document.getElementById(id);
        const mostrar = campo.type === 'password';

        campo.type = mostrar ? 'text' : 'password';
        boton.textContent = mostrar ? 'Ocultar' : 'Mostrar';
    }

    modalRegistro.addEventListener('click', function (evento) {
        if (evento.target === modalRegistro) cerrarModalRegistro();
    });

    // Escape cierra el modal que esté abierto
    document.addEventListener('keydown', function (evento) {
        if (evento.key !== 'Escape') return;

        if (!modalRecuperacion.classList.contains('hidden')) cerrarModalRecuperacion();
        if (!modalRegistro.classList.contains('hidden')) cerrarModalRegistro();
    });

    // ---------- Enviar el registro (persona natural y empresa) ----------
    document.getElementById('formRegistroUsuario').addEventListener('submit', function (e) {
        e.preventDefault();
        enviarRegistro(this, "{{ route('registro.usuario') }}");
    });

    document.getElementById('formRegistroEmpresa').addEventListener('submit', function (e) {
        e.preventDefault();
        enviarRegistro(this, "{{ route('registro.empresa') }}");
    });

    async function enviarRegistro(formulario, ruta) {
        const boton = formulario.querySelector('[type="submit"]');
        const textoOriginal = boton.textContent;

        boton.disabled = true;
        boton.textContent = 'Registrando...';

        limpiarErrores(formulario);

        try {
            const respuesta = await fetch(ruta, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
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

            mostrarMensajeRegistro('No fue posible conectar con el servidor. Inténtalo nuevamente.', 'error');

        } finally {
            boton.disabled = false;
            boton.textContent = textoOriginal;
        }
    }

    function limpiarErrores(formulario) {
        formulario.querySelectorAll('.error-registro').forEach(error => error.remove());

        formulario.querySelectorAll('.campo-registro').forEach(campo => {
            campo.classList.remove('campo-error', 'border-red-500');
        });

        document.getElementById('mensajeRegistro')?.remove();
    }

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

    function mostrarMensajeRegistro(mensaje, tipo) {
        let contenedor = document.getElementById('mensajeRegistro');

        if (!contenedor) {
            contenedor = document.createElement('div');
            contenedor.id = 'mensajeRegistro';
            document.getElementById('contenidoDesplazable').prepend(contenedor);
        }

        contenedor.className = tipo === 'exito'
            ? 'mb-4 rounded-xl border border-green-300 bg-green-50 p-3 text-sm font-medium text-green-800'
            : 'mb-4 rounded-xl border border-red-300 bg-red-50 p-3 text-sm font-medium text-red-800';

        contenedor.textContent = mensaje;
    }
</script>

@endsection
