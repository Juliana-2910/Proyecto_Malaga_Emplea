
@extends('layouts.app')

@section('title')
    Crear calificación
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-5xl px-6">

    {{-- Encabezado --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Crear calificación
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Registra la experiencia de una contratación realizada en Málaga Emplea.
        </p>
    </div>

    {{-- Formulario --}}
    <div class="rounded-xl bg-white p-8 shadow">

        <form action="{{ route('calificacion.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Postulación --}}
            <div class="md:col-span-2">
                <label for="idPostulacion" class="mb-1 block text-sm font-medium text-gray-700">
                    Postulación contratada
                </label>

                <select
                    name="idPostulacion"
                    id="idPostulacion"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                >
                    <option value="">Seleccione una postulación</option>

                    @foreach ($postulaciones as $postulacion)
                        <option
                            value="{{ $postulacion->id }}"
                            {{ old('idPostulacion') == $postulacion->id ? 'selected' : '' }}
                        >
                            Postulación #{{ $postulacion->id }}
                            - {{ $postulacion->usuario->nombres ?? 'Sin nombre' }}
                            {{ $postulacion->usuario->apellidos ?? '' }}
                            - {{ $postulacion->oferta->titulo ?? 'Sin oferta' }}
                            - Publicada por:
                            {{ $postulacion->oferta->empresa->nombreEmpresa
                                ?? ($postulacion->oferta->usuario->nombres ?? 'Sin publicador') }}
                        </option>
                    @endforeach
                </select>

                @error('idPostulacion')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>


            {{-- Tipo de calificador --}}
            <div>
                <label for="tipoCalificador" class="mb-1 block text-sm font-medium text-gray-700">
                    ¿Quién realiza la calificación?
                </label>

                <select
                    name="tipoCalificador"
                        id="tipoCalificador"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">
                        <option value="">Seleccione quién califica</option>

                        <option value="usuario"
                            {{ old('tipoCalificador') == 'usuario' ? 'selected' : '' }}>
                                El usuario califica a la empresa
                        </option>

                        <option value="empresa"
                            {{ old('tipoCalificador') == 'empresa' ? 'selected' : '' }}>
                                La empresa califica al usuario
                        </option>
                </select>

                @error('tipoCalificador')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

                {{-- Puntuación --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Puntuación
                    </label>

                    <div class="flex flex-row-reverse justify-end gap-1">

                        @for ($i = 5; $i >= 1; $i--)
                            <input
                            type="radio"
                            name="puntuacion"
                            id="estrella{{ $i }}"
                            value="{{ $i }}"
                            class="peer hidden"
                            {{ old('puntuacion') == $i ? 'checked' : '' }}>

                            <label
                                for="estrella{{ $i }}"
                                class="cursor-pointer text-3xl text-gray-300
                                transition
                                hover:text-yellow-400
                                peer-checked:text-yellow-400">
                                ★
                                </label>
                        @endfor

                    </div>

                        @error('puntuacion')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                {{-- Comentario --}}
                <div class="md:col-span-2">
                    <label for="comentario" class="mb-1 block text-sm font-medium text-gray-700">
                        Comentario
                    </label>

                    <textarea
                        name="comentario"
                        id="comentario"
                        rows="4"
                        maxlength="255"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                        placeholder="Escribe un comentario sobre la experiencia de la contratación..."
                    >{{ trim(old('comentario', '')) }}</textarea>

                    @error('comentario')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Botones --}}
            <div class="mt-8 flex justify-end gap-3">

                <a
                    href="{{ route('calificacion.index') }}"
                    class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#333333]"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#333333]"
                >
                    Guardar calificación
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection
