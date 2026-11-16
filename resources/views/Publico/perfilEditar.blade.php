@extends('layouts.Publico.Usuario.usuario')

@section('title', 'Mi perfil')

@php
    // Variables que envía PerfilController::editar(): $cuenta, $esEmpresa, $hojaDeVida
    $campo      = 'w-full rounded-xl border-[1.5px] border-slate-300 bg-white px-3.5 py-3 text-[15px] font-medium text-slate-800 placeholder:text-slate-400 focus:border-marca focus:outline-none focus:ring-[3px] focus:ring-marca/25';
    $conIcono   = $campo . ' pl-11';
    $bloqueado  = 'w-full cursor-not-allowed rounded-xl border-[1.5px] border-slate-200 bg-slate-50 py-3 pl-11 pr-3.5 text-[15px] font-medium text-slate-500';
    $label      = 'flex flex-col gap-1.5 text-[13px] font-semibold text-slate-600';
    $error      = 'text-[13px] font-semibold text-red-700';
    $tarjeta    = 'rounded-2xl border border-slate-200 bg-white p-6 shadow-[0_8px_30px_rgba(18,48,63,0.07)]';
    $btnPrimario   = 'inline-flex min-h-[46px] items-center justify-center rounded-full border-2 border-marca bg-marca px-7 text-[15px] font-bold text-noche transition hover:border-carbon hover:bg-carbon hover:text-white';
    $btnSecundario = 'inline-flex min-h-[46px] items-center justify-center rounded-full border-2 border-slate-800 bg-white px-7 text-[15px] font-bold text-slate-800 transition hover:bg-slate-800 hover:text-white';

    $nombre = $esEmpresa ? $cuenta->nombreEmpresa : trim($cuenta->nombres . ' ' . $cuenta->apellidos);

    $rutaFoto = $cuenta->fotoPerfil
        ? asset('storage/' . ($esEmpresa ? 'empresas/' . $cuenta->fotoPerfil : $cuenta->fotoPerfil))
        : null;

    $iniciales = collect(explode(' ', $nombre))->filter()->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->take(2)->implode('');

    $fechaNac = substr((string) old('fechaNacimiento', $cuenta->fechaNacimiento ?? ''), 0, 10);

    // Avance de la hoja de vida (solo personas): ubicación, nivel, perfil, experiencia y PDF
    $partes = ['ubicacion', 'nivelEducativo', 'perfilProfesional', 'experienciaLaboral', 'archivoCV'];
    $llenas = count(array_filter($partes, fn ($c) => ! empty($hojaDeVida->{$c} ?? null)));
    $avance = (int) round($llenas / count($partes) * 100);

    $niveles = [
        'Basica Primaria'   => 'Básica primaria',
        'Basica Secundaria' => 'Básica secundaria',
        'Tecnico'           => 'Técnico',
        'Tecnologo'         => 'Tecnólogo',
        'Profesional'       => 'Profesional',
    ];
@endphp

@section('content')

<section class="bg-[#EAF6FD] px-6 pb-16 pt-9">
<div class="mx-auto max-w-6xl">

    {{-- ENCABEZADO --}}
    <a href="{{ route('Publico.ofertas') }}" class="mb-1 inline-flex items-center gap-1.5 text-sm font-bold text-marca-texto transition hover:text-carbon">
        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        Volver a ofertas
    </a>
    <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-noche">Editar perfil</h1>
    <p class="mt-1 text-base text-slate-600">
        {{ $esEmpresa ? 'Mantén los datos de tu empresa al día.' : 'Mantén tus datos al día para que quienes publican ofertas te conozcan mejor.' }}
    </p>

    {{-- AVISOS --}}
    @include('layouts.Publico.avisosPaginas')

    @if ($errors->any())
        <div role="alert" class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
            No se pudo guardar. Revisa los campos marcados en rojo:
            <ul class="mt-1 list-disc pl-5 font-medium">
                @foreach ($errors->all() as $mensaje)
                    <li>{{ $mensaje }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de perfil: los campos de la columna izquierda y derecha lo usan con form="form-perfil" --}}
    <form id="form-perfil" action="{{ route('perfil.actualizar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    </form>

    <div class="mt-7 grid items-start gap-6 lg:grid-cols-[340px_1fr]">

        {{-- ================= COLUMNA IZQUIERDA: FOTO + SEGURIDAD ================= --}}
        <div class="flex flex-col gap-6">
        <aside class="{{ $tarjeta }} text-center">

            <div class="mx-auto flex size-28 items-center justify-center overflow-hidden rounded-full border-2 border-black bg-noche text-3xl font-extrabold text-white">                <img id="foto-preview" data-foto-original="{{ $rutaFoto }}" src="{{ $rutaFoto ?? '' }}" alt="Foto de {{ $nombre }}" class="{{ $rutaFoto ? '' : 'hidden' }} size-full object-cover">
                <span id="foto-inicial" class="{{ $rutaFoto ? 'hidden' : '' }}">{{ $iniciales }}</span>
            </div>

            <h2 class="mt-4 text-xl font-extrabold text-noche">{{ $nombre }}</h2>
            <span class="mt-1.5 inline-block rounded-full bg-[#EAF6FD] px-3 py-1 text-xs font-bold text-marca-texto">
                {{ $esEmpresa ? 'Empresa' : 'Persona natural' }}
            </span>

            <div class="mt-5">
                <label for="fotoPerfil" class="inline-flex cursor-pointer items-center rounded-full border-2 border-slate-800 px-5 py-2.5 text-sm font-bold text-slate-800 transition hover:bg-slate-800 hover:text-white">
                    Cambiar foto
                </label>
                <input id="fotoPerfil" name="fotoPerfil" form="form-perfil" type="file" accept="image/jpeg,image/png" class="sr-only">

                {{-- Nombre de la foto --}}
                <p id="foto-nombre" class="mx-auto mt-3 max-w-full break-all text-xs font-semibold text-slate-600">
                    {{ $cuenta->fotoPerfil ? basename($cuenta->fotoPerfil) : 'Ningún archivo seleccionado' }}
                </p>

                {{-- Eliminar foto actual --}}
                @if ($cuenta->fotoPerfil)
                    <label class="mt-2 inline-flex cursor-pointer items-center gap-1.5 text-sm font-semibold text-red-700">
                        <input type="checkbox" name="eliminarFotoPerfil" form="form-perfil" value="1" class="peer sr-only">
                        <svg class="size-4 text-red-400 transition peer-checked:text-red-600 peer-focus-visible:text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6 6 18"/></svg>
                        Eliminar foto actual
                    </label>
                @endif

                <p class="mt-2 text-xs text-slate-500">JPG o PNG · máximo 2 MB</p>
                @error('fotoPerfil') <p class="mt-2 {{ $error }}">{{ $message }}</p> @enderror
            </div>

            @if (! $esEmpresa)
                <div class="mt-5 border-t border-slate-100 pt-4 text-left">
                    <div class="flex justify-between text-[13px] font-bold text-noche">
                        <span>Hoja de vida completa</span>
                        <span>{{ $avance }}%</span>
                    </div>
                    <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-200">
                        <div class="h-full rounded-full bg-marca" style="width: {{ $avance }}%"></div>
                    </div>
                </div>
            @endif
        </aside>

        {{-- SEGURIDAD: se despliega en esta misma página (sin modal) --}}
        <div id="seguridad" class="scroll-mt-6">
            <section id="cambiar-contrasena" class="{{ $tarjeta }} scroll-mt-6"
                    x-data="{ abierto: {{ $errors->contrasena->any() ? 'true' : 'false' }}, revisar() { if (location.hash === '#cambiar-contrasena') this.abierto = true; } }"
                    x-init="revisar()" @hashchange.window="revisar()">

                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="text-lg font-extrabold text-noche">Seguridad</h2>
                        <p class="text-xs text-slate-500">Protege el acceso a tu cuenta</p>
                    </div>
                </div>

                @include('layouts.Publico.avisosPaginas')

                <button type="button" x-show="!abierto" @click="abierto = true" class="{{ $btnSecundario }} mt-4 w-full cursor-pointer">
                    Cambiar contraseña
                </button>

                <form x-show="abierto" x-cloak x-ref="formClave" action="{{ route('perfil.contrasena') }}" method="POST" class="mt-4 flex flex-col gap-4 text-left">
                    @csrf
                    @method('PUT')

                    @if ($errors->contrasena->has('servicio'))
                        <div role="alert" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            {{ $errors->contrasena->first('servicio') }}
                        </div>
                    @endif

                    @foreach ([
                        ['contrasena_actual', 'Contraseña actual', 'current-password'],
                        ['password', 'Nueva contraseña', 'new-password'],
                        ['password_confirmation', 'Confirmar nueva contraseña', 'new-password'],
                    ] as [$nombreCampo, $etiqueta, $autocompletar])
                        <label class="{{ $label }}" x-data="{ ver: false }">{{ $etiqueta }}
                            <span class="relative block">
                                <input :type="ver ? 'text' : 'password'" name="{{ $nombreCampo }}" autocomplete="{{ $autocompletar }}" required class="{{ $campo }} pr-11">
                                <button type="button" @click="ver = !ver" :aria-label="ver ? 'Ocultar contraseña' : 'Mostrar contraseña'" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 transition hover:text-noche">
                                    {{-- Ojo cerrado: contraseña oculta --}}
                                    <svg x-show="!ver" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10c2.5 4 6 6 9 6s6.5-2 9-6M12 16v3M7 14.5l-1.5 2.5M17 14.5l1.5 2.5"/></svg>
                                    {{-- Ojo abierto: contraseña visible --}}
                                    <svg x-show="ver" x-cloak class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                </button>
                            </span>
                            @if ($errors->contrasena->has($nombreCampo)) <span class="{{ $error }}">{{ $errors->contrasena->first($nombreCampo) }}</span> @endif
                        </label>
                    @endforeach

                    <p class="text-xs text-slate-500">Mínimo 8 caracteres.</p>

                    <div class="flex flex-col gap-2">
                        <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Actualizar contraseña</button>
                        <button type="button" @click="abierto = false; $refs.formClave.reset()" class="{{ $btnSecundario }} cursor-pointer">Cancelar</button>
                    </div>
                </form>
            </section>
        </div>
        </div>

        {{-- ================= COLUMNA DERECHA ================= --}}
        <div class="flex flex-col gap-6">

            {{-- DATOS --}}
            <div class="{{ $tarjeta }}">
                <h2 class="mb-4 text-xl font-extrabold text-noche">{{ $esEmpresa ? 'Datos de la empresa' : 'Datos personales' }}</h2>

                <div class="grid gap-4 sm:grid-cols-2">

                    @if ($esEmpresa)

                        <label class="{{ $label }} sm:col-span-2">Nombre de la empresa
                            <input type="text" name="nombreEmpresa" form="form-perfil" maxlength="100" value="{{ old('nombreEmpresa', $cuenta->nombreEmpresa) }}" required class="{{ $campo }}">
                            @error('nombreEmpresa') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                        <label class="{{ $label }}">NIT
                            <input type="text" name="nit" form="form-perfil" maxlength="30" value="{{ old('nit', $cuenta->nit) }}" required class="{{ $campo }}">
                            @error('nit') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                        <label class="{{ $label }}">Dirección
                            <span class="relative block">
                                <svg class="pointer-events-none absolute left-3.5 top-1/2 size-[18px] -translate-y-1/2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                                <input type="text" name="direccion" form="form-perfil" maxlength="255" value="{{ old('direccion', $cuenta->direccion) }}" required class="{{ $conIcono }}">
                            </span>
                            @error('direccion') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                    @else

                        <label class="{{ $label }}">Nombres
                            <input type="text" name="nombres" form="form-perfil" maxlength="100" value="{{ old('nombres', $cuenta->nombres) }}" required class="{{ $campo }}">
                            @error('nombres') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                        <label class="{{ $label }}">Apellidos
                            <input type="text" name="apellidos" form="form-perfil" maxlength="100" value="{{ old('apellidos', $cuenta->apellidos) }}" required class="{{ $campo }}">
                            @error('apellidos') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                        <label class="{{ $label }}">Fecha de nacimiento
                            <input type="date" name="fechaNacimiento" form="form-perfil" value="{{ $fechaNac }}" required class="{{ $campo }}">
                            @error('fechaNacimiento') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                        <label class="{{ $label }}">Teléfono
                            <input type="tel" name="telefono" form="form-perfil" maxlength="20" value="{{ old('telefono', $cuenta->telefono) }}" placeholder="Ej.: 3001234567" required class="{{ $campo }}">
                            @error('telefono') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                        <label class="{{ $label }}">Documento
                            <span class="relative block">
                                <svg class="pointer-events-none absolute left-3.5 top-1/2 size-[18px] -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                <input type="text" value="{{ $cuenta->tipoDocumento }} {{ $cuenta->numeroDocumento }}" disabled title="El documento no se puede modificar" class="{{ $bloqueado }}">
                            </span>
                        </label>

                    @endif

                    <label class="{{ $label }} {{ $esEmpresa ? 'sm:col-span-2' : '' }}">Correo electrónico
                        <input type="email" name="email" form="form-perfil" maxlength="255" value="{{ old('email', $cuenta->email) }}" class="{{ str_replace(['pl-10', 'pl-11'], '', $conIcono) }}">
                        @error('email') <span class="{{ $error }}">{{ $message }}</span> @enderror
                    </label>

                </div>

                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('Publico.ofertas') }}" class="{{ $btnSecundario }}">Cancelar</a>
                    <button type="submit" form="form-perfil" class="{{ $btnPrimario }} cursor-pointer">Guardar cambios</button>
                </div>
            </div>

            {{-- HOJA DE VIDA (solo personas) --}}
            @if (! $esEmpresa)
                <form action="{{ route('Publico.guardarHojaDeVida') }}" method="POST" enctype="multipart/form-data" id="hoja-de-vida" class="{{ $tarjeta }} scroll-mt-6">
                    @csrf
                    <input type="hidden" name="volverPerfil" value="1">

                    <h2 class="mb-4 text-xl font-extrabold text-noche">Hoja de vida</h2>

                    <div class="flex flex-col gap-4">

                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="{{ $label }}">Ubicación
                                    <input type="text" name="ubicacion" maxlength="255" required placeholder="Ej.: Málaga, Santander" value="{{ old('ubicacion', $hojaDeVida?->ubicacion) }}" class="{{ str_replace(['pl-10', 'pl-11'], '', $conIcono) }}">
                                </span>
                                @error('ubicacion') <span class="{{ $error }}">{{ $message }}</span> @enderror
                            </label>

                            <label class="{{ $label }}">Nivel educativo
                                <select name="nivelEducativo" required class="{{ $campo }}">
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($niveles as $valor => $texto)
                                        <option value="{{ $valor }}" @selected(old('nivelEducativo', $hojaDeVida?->nivelEducativo) === $valor)>{{ $texto }}</option>
                                    @endforeach
                                </select>
                                @error('nivelEducativo') <span class="{{ $error }}">{{ $message }}</span> @enderror
                            </label>
                        </div>

                        <label class="{{ $label }}">
                            <span class="flex justify-between"><span>Perfil profesional</span><span data-contador class="font-medium text-slate-400"></span></span>
                            <textarea name="perfilProfesional" rows="3" maxlength="255" required data-max placeholder="Cuéntale a quien publica quién eres y qué sabes hacer" class="{{ $campo }} resize-y leading-6">{{ old('perfilProfesional', $hojaDeVida?->perfilProfesional) }}</textarea>
                            @error('perfilProfesional') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                        <label class="{{ $label }}">
                            <span class="flex justify-between"><span>Experiencia laboral</span><span data-contador class="font-medium text-slate-400"></span></span>
                            <textarea name="experienciaLaboral" rows="3" maxlength="255" required data-max placeholder="Dónde has trabajado, qué hacías y por cuánto tiempo" class="{{ $campo }} resize-y leading-6">{{ old('experienciaLaboral', $hojaDeVida?->experienciaLaboral) }}</textarea>
                            @error('experienciaLaboral') <span class="{{ $error }}">{{ $message }}</span> @enderror
                        </label>

                        {{-- ARCHIVO CV --}}
                        <div class="flex flex-col gap-2">
                            <span class="text-[13px] font-semibold text-slate-600">Archivo CV</span>

                            <div class="grid gap-3 sm:grid-cols-2">

                                {{-- Documento actual --}}
                                @if ($hojaDeVida?->archivoCV)
                                    <div class="flex items-center gap-3 rounded-2xl border border-green-200 bg-green-50 p-4">
                                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#4DB6E8] shadow-sm">
                                            @php($icon = 'clipboard-document-check')
                                            @include('layouts.partials.icons')
                                        </span>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-bold text-noche">Documento actual</p>
                                            <p class="truncate text-xs text-slate-600">{{ basename($hojaDeVida->archivoCV) }}</p>
                                        </div>
                                        <a href="{{ asset('storage/' . $hojaDeVida->archivoCV) }}" target="_blank" rel="noopener" title="Ver PDF" aria-label="Ver PDF"
                                            class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-[#4DB6E8] bg-white px-3 py-2 text-xs font-semibold text-[#4DB6E8] transition hover:bg-[#4DB6E8] hover:text-white">
                                            @php($icon = 'eye')
                                            @include('layouts.partials.icons')
                                        </a>
                                    </div>
                                @else
                                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#4DB6E8] shadow-sm">
                                            @php($icon = 'clipboard-document-check')
                                            @include('layouts.partials.icons')
                                        </span>
                                        <div>
                                            <p class="font-bold text-slate-600">Sin documento</p>
                                            <p class="text-xs text-slate-500">Aún no has subido tu hoja de vida</p>
                                        </div>
                                    </div>
                                @endif

                                {{-- Cambiar archivo --}}
                                <div class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="min-w-0">
                                        <p class="whitespace-nowrap font-bold text-noche">Cambiar archivo</p>
                                        <p id="cv-nombre" class="truncate text-xs text-slate-500">Ningún archivo seleccionado</p>
                                    </div>
                                    <label for="archivoCV" class="inline-flex shrink-0 cursor-pointer items-center gap-2 rounded-xl bg-marca px-4 py-2.5 text-sm font-bold text-white transition hover:bg-carbon">
                                        <svg class="size-[18px]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                                        Seleccionar
                                    </label>
                                    <input id="archivoCV" name="archivoCV" type="file" accept="application/pdf" class="sr-only">
                                </div>

                            </div>

                            <p class="text-xs leading-5 text-slate-500">
                                Formato PDF, tamaño máximo: 5 MB.<br>
                                Si no seleccionas un nuevo archivo, se conservará el documento actual.
                            </p>
                            @error('archivoCV') <span class="{{ $error }}">{{ $message }}</span> @enderror

                            {{-- Eliminar documento actual --}}
                            @if ($hojaDeVida?->archivoCV)
                                <label class="mt-1 inline-flex cursor-pointer items-center gap-1.5 text-sm font-semibold text-red-700">
                                    <input type="checkbox" name="eliminarArchivoCV" value="1" class="peer sr-only">
                                    <svg class="size-4 text-red-400 transition peer-checked:text-red-600 peer-focus-visible:text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6 6 18"/></svg>
                                    Eliminar documento actual
                                </label>
                            @endif

                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Actualizar hoja de vida</button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ---- Foto: vista previa, nombre del archivo y "eliminar foto actual" ----
    const input    = document.getElementById('fotoPerfil');
    const preview  = document.getElementById('foto-preview');
    const inicial  = document.getElementById('foto-inicial');
    const nombre   = document.getElementById('foto-nombre');
    const eliminar = document.querySelector('input[name="eliminarFotoPerfil"]');
    const original = preview?.dataset.fotoOriginal;

    input?.addEventListener('change', () => {
        const f = input.files?.[0];
        if (!f) return;
        preview.src = URL.createObjectURL(f);
        preview.classList.remove('hidden');
        inicial?.classList.add('hidden');
        nombre.textContent = f.name;
        if (eliminar) eliminar.checked = false;
    });

    eliminar?.addEventListener('change', () => {
        if (eliminar.checked) {
            input.value = '';
            preview.src = '';
            preview.classList.add('hidden');
            inicial?.classList.remove('hidden');
            nombre.textContent = 'La foto se eliminará al guardar';
        } else {
            preview.src = original || '';
            preview.classList.toggle('hidden', !original);
            inicial?.classList.toggle('hidden', !!original);
            nombre.textContent = original ? original.split('/').pop() : 'Ningún archivo seleccionado';
        }
    });

    // ---- Nombre del PDF elegido ----
    const cv = document.getElementById('archivoCV');
    const eliminarCV = document.querySelector('input[name="eliminarArchivoCV"]');
    cv?.addEventListener('change', () => {
        document.getElementById('cv-nombre').textContent = cv.files[0] ? cv.files[0].name : 'Ningún archivo seleccionado';
        if (cv.files[0] && eliminarCV) eliminarCV.checked = false;
    });
    eliminarCV?.addEventListener('change', () => {
        if (eliminarCV.checked) {
            cv.value = '';
            document.getElementById('cv-nombre').textContent = 'El documento se eliminará al guardar';
        } else {
            document.getElementById('cv-nombre').textContent = 'Ningún archivo seleccionado';
        }
    });

    // ---- Contadores de caracteres ----
    document.querySelectorAll('textarea[data-max]').forEach(t => {
        const c = t.closest('label').querySelector('[data-contador]');
        const pintar = () => c.textContent = t.value.length + '/' + t.maxLength;
        t.addEventListener('input', pintar);
        pintar();
    });
});
</script>
@endpush

@endsection
