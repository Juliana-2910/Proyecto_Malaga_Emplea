
@extends('layouts.app')

@section('title', 'Editar hoja de vida')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen bg-[#F5F7FA] py-8">

    <div class="mx-auto max-w-4xl px-6">

        {{-- Encabezado --}}
        <div class="mb-6">

            <h1 class="text-2xl font-bold text-gray-800">
                Editar hoja de vida
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Actualiza la información de la hoja de vida del usuario
            </p>

        </div>


        {{-- Formulario --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-7 shadow-sm">

            <form action="{{ route('hojaDeVida.update', $hojaDeVida->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')


                {{-- Usuario + Ubicación + Nivel educativo --}}
                <div class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-3">

                    {{-- Usuario --}}
                    <div>

                        <label for="idUsuario"
                            class="mb-2 block text-sm font-semibold text-gray-700">
                            Usuario
                        </label>

                        <select name="idUsuario"
                            id="idUsuario"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 transition focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                            required>

                            <option value="">
                                Seleccione un usuario
                            </option>

                            @foreach ($usuarios as $usuario)

                                <option value="{{ $usuario->id }}"
                                    {{ old('idUsuario', $hojaDeVida->idUsuario) == $usuario->id ? 'selected' : '' }}>

                                    {{ $usuario->nombres }} {{ $usuario->apellidos }}

                                </option>

                            @endforeach

                        </select>

                        @error('idUsuario')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Ubicación --}}
                    <div>

                        <label for="ubicacion"
                            class="mb-2 block text-sm font-semibold text-gray-700">
                            Ubicación
                        </label>

                        <input type="text"
                            name="ubicacion"
                            id="ubicacion"
                            value="{{ old('ubicacion', $hojaDeVida->ubicacion) }}"
                            placeholder="Ingrese la ubicación"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 transition focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                            required>

                        @error('ubicacion')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Nivel educativo --}}
                    <div class="mb-5">

                        <label for="nivelEducativo"
                            class="mb-2 block text-sm font-semibold text-gray-700">
                            Nivel educativo
                        </label>

                        <select name="nivelEducativo"
                            id="nivelEducativo"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 transition focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                            required>

                            <option value="">
                                Seleccione un nivel educativo
                            </option>

                            <option value="Basica Primaria"
                                {{ old('nivelEducativo', $hojaDeVida->nivelEducativo) == 'Basica Primaria' ? 'selected' : '' }}>
                                Básica Primaria
                            </option>

                            <option value="Basica Secundaria"
                                {{ old('nivelEducativo', $hojaDeVida->nivelEducativo) == 'Basica Secundaria' ? 'selected' : '' }}>
                                Básica Secundaria
                            </option>

                            <option value="Tecnico"
                                {{ old('nivelEducativo', $hojaDeVida->nivelEducativo) == 'Tecnico' ? 'selected' : '' }}>
                                Técnico
                            </option>

                            <option value="Tecnologo"
                                {{ old('nivelEducativo', $hojaDeVida->nivelEducativo) == 'Tecnologo' ? 'selected' : '' }}>
                                Tecnólogo
                            </option>

                            <option value="Profesional"
                                {{ old('nivelEducativo', $hojaDeVida->nivelEducativo) == 'Profesional' ? 'selected' : '' }}>
                                Profesional
                            </option>

                        </select>

                        @error('nivelEducativo')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                </div>


                {{-- Archivo CV --}}
                <div class="mb-5">

                    <label for="archivoCV"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Archivo CV
                    </label>

                    <input type="file"
                        name="archivoCV"
                        id="archivoCV"
                        accept=".pdf"
                        class="hidden">


                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                        {{-- Documento actual --}}
                        @if ($hojaDeVida->archivoCV)

                            <div class="rounded-xl border border-green-200 bg-green-50 p-4">

                                <div class="flex h-full items-center gap-3">

                                    {{-- Icono --}}
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#4DB6E8] shadow-sm">

                                        @php($icon = 'clipboard-document-check')
                                        @include('layouts.partials.icons')

                                    </div>


                                    {{-- Información --}}
                                    <div class="min-w-0 flex-1">

                                        <p class="text-sm font-semibold text-gray-700">
                                            Documento actual
                                        </p>

                                        <p class="truncate text-xs text-gray-500">
                                            {{ basename($hojaDeVida->archivoCV) }}
                                        </p>

                                    </div>


                                    {{-- Ver documento --}}
                                    <a href="{{ asset('storage/' . $hojaDeVida->archivoCV) }}"
                                        target="_blank"
                                        title="Ver hoja de vida"
                                        class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-[#4DB6E8] bg-white px-3 py-2 text-xs font-semibold text-[#4DB6E8] transition hover:bg-[#4DB6E8] hover:text-white">
                                        @php($icon = 'eye') @include('layouts.partials.icons')
                                    </a>

                                </div>

                            </div>

                        @endif


                        {{-- Cambiar archivo --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                            <div class="flex h-full items-center justify-between gap-3">

                                <div class="min-w-0">

                                    <p class="text-sm font-semibold text-gray-700">
                                        Cambiar archivo
                                    </p>

                                    <p id="nombreArchivo"
                                        class="mt-1 truncate text-xs text-gray-500">
                                        Ningún archivo seleccionado
                                    </p>

                                </div>


                                <label for="archivoCV"
                                    class="inline-flex shrink-0 cursor-pointer items-center gap-2 rounded-lg bg-[#4DB6E8] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#333333]">

                                    @php($icon = 'arrow-up-tray')
                                    @include('layouts.partials.icons')

                                    Seleccionar

                                </label>

                            </div>

                        </div>

                    </div>


                    <p class="mt-2 text-xs text-gray-500">
                        Si no seleccionas un nuevo archivo, se conservará el documento actual.
                    </p>


                    @error('archivoCV')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Perfil profesional --}}
                <div class="mb-5">

                    <label for="perfilProfesional"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Perfil profesional
                    </label>

                    <textarea name="perfilProfesional"
                        id="perfilProfesional"
                        rows="4"
                        placeholder="Describa el perfil profesional"
                        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 transition focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                        required>{{ old('perfilProfesional', $hojaDeVida->perfilProfesional) }}</textarea>

                    @error('perfilProfesional')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Experiencia laboral --}}
                <div class="mb-6">

                    <label for="experienciaLaboral"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Experiencia laboral
                    </label>

                    <textarea name="experienciaLaboral"
                        id="experienciaLaboral"
                        rows="4"
                        placeholder="Describa la experiencia laboral"
                        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 transition focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                        required>{{ old('experienciaLaboral', $hojaDeVida->experienciaLaboral) }}</textarea>

                    @error('experienciaLaboral')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Botones --}}
                <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">

                    <a href="{{ route('hojaDeVida.index') }}"
                        class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#333333]">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#333333]">
                        Actualizar hoja de vida
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- Mostrar nombre del nuevo archivo seleccionado --}}
<script>
    document.getElementById('archivoCV').addEventListener('change', function () {

        document.getElementById('nombreArchivo').textContent =
            this.files.length > 0
                ? '✓ ' + this.files[0].name
                : 'Ningún archivo seleccionado';

    });
</script>

@endsection

