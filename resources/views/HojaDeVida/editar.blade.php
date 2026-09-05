
@extends('layouts.app')

@section('title')
Editar hoja de vida
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-3xl px-6">


        {{-- Encabezado --}}
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Editar hoja de vida
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Actualiza la información de la hoja de vida del usuario
            </p>

        </div>


        {{-- Formulario --}}
        <div class="rounded-xl bg-white p-8 shadow">

            <form action="{{ route('hojaDeVida.update', $hojaDeVida->id) }}"
                  method="POST">

                @csrf

                @method('PUT')


                {{-- Usuario --}}
                <div class="mb-5">

                    <label for="idUsuario"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Usuario
                    </label>

                    <select name="idUsuario"
                            id="idUsuario"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                            required>

                        <option value="">
                            Seleccione un usuario
                        </option>

                        @foreach ($usuarios as $usuario)

                            <option value="{{ $usuario->id }}"
                                {{ old('idUsuario', $hojaDeVida->idUsuario) == $usuario->id ? 'selected' : '' }}>

                                {{ $usuario->nombres }}
                                {{ $usuario->apellidos }}

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
                <div class="mb-5">

                    <label for="ubicacion"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Ubicación
                    </label>

                    <input type="text"
                        name="ubicacion"
                        id="ubicacion"
                        value="{{ old('ubicacion', $hojaDeVida->ubicacion) }}"
                        placeholder="Ingrese la ubicación"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
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
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
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


                {{-- Perfil profesional --}}
                <div class="mb-5">

                    <label for="perfilProfesional"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Perfil profesional
                    </label>

                    <textarea name="perfilProfesional"
                        id="perfilProfesional"
                        rows="5"
                        placeholder="Describa el perfil profesional"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                        required>{{ old('perfilProfesional', $hojaDeVida->perfilProfesional) }}</textarea>

                    @error('perfilProfesional')

                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Experiencia laboral --}}
                <div class="mb-5">

                    <label for="experienciaLaboral"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Experiencia laboral
                    </label>

                    <textarea name="experienciaLaboral"
                        id="experienciaLaboral"
                        rows="5"
                        placeholder="Describa la experiencia laboral"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                        required>{{ old('experienciaLaboral', $hojaDeVida->experienciaLaboral) }}</textarea>

                    @error('experienciaLaboral')

                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Archivo CV --}}
                <div class="mb-6">

                    <label for="archivoCV"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Archivo CV
                    </label>

                    <input type="text"
                        name="archivoCV"
                        id="archivoCV"
                        class="w-full rounded-lg border px-4 py-2 text-sm text-gray-700"
                        placeholder="Nombre del archivo o URL del CV"
                        value="{{ old('archivoCV', $hojaDeVida->archivoCV) }}"
                        required>

                    @error('archivoCV')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('hojaDeVida.index') }}"
                        class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                        Actualizar hoja de vida
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
