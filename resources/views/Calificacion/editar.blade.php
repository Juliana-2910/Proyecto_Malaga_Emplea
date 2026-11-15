
@extends('layouts.app')

@section('title', 'Editar calificación')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen py-8">

<div class="mx-auto max-w-5xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Editar calificación
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Actualiza la información de la calificación.
        </p>
    </div>


    {{-- Formulario --}}
    <div class="rounded-xl bg-white p-8 shadow">

        <form action="{{ route('calificacion.update', $calificacion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Postulación --}}
                <div class="md:col-span-2">

                    <label for="idPostulacion" class="mb-2 block text-sm font-semibold text-gray-700">
                        Postulación contratada
                    </label>

                    <select
                        name="idPostulacion"
                        id="idPostulacion"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">Seleccione una postulación</option>

                        @foreach ($postulaciones as $postulacion)

                            @php($nombreUsuario = trim(($postulacion->usuario?->nombres ?? '') . ' ' . ($postulacion->usuario?->apellidos ?? '')) ?: 'Sin usuario')
                            @php($nombrePublicador = $postulacion->oferta?->empresa?->nombreEmpresa ?? (trim(($postulacion->oferta?->usuario?->nombres ?? '') . ' ' . ($postulacion->oferta?->usuario?->apellidos ?? '')) ?: 'Sin publicador'))
                            @php($tituloOferta = $postulacion->oferta?->titulo ?? 'Sin oferta')

                            <option
                                value="{{ $postulacion->id }}"
                                data-usuario="{{ $nombreUsuario }}"
                                data-publicador="{{ $nombrePublicador }}"
                                data-oferta="{{ $tituloOferta }}"
                                {{ old('idPostulacion', $calificacion->idPostulacion) == $postulacion->id ? 'selected' : '' }}>
                                #{{ $postulacion->id }} · {{ $nombreUsuario }} · {{ $tituloOferta }}
                            </option>

                        @endforeach

                    </select>

                    @error('idPostulacion')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                </div>


                {{-- Resumen de la postulación seleccionada --}}
                <div id="resumenPostulacion" class="hidden rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 md:col-span-2">

                    <p class="mb-3 text-[10px] font-bold uppercase tracking-wider text-[#4DB6E8]">
                        Datos de la postulación
                    </p>

                    <div class="grid grid-cols-1 gap-x-5 gap-y-3 sm:grid-cols-3">

                        <div>
                            <p class="text-xs font-medium text-gray-400">Usuario</p>
                            <p id="resUsuario" class="mt-1 break-words text-sm font-medium text-gray-700"></p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-400">Publicador</p>
                            <p id="resPublicador" class="mt-1 break-words text-sm font-medium text-gray-700"></p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-400">Oferta</p>
                            <p id="resOferta" class="mt-1 break-words text-sm font-medium text-gray-700"></p>
                        </div>

                    </div>

                </div>


                {{-- Quién califica --}}
                <div>

                    <label for="tipoCalificador" class="mb-2 block text-sm font-semibold text-gray-700">
                        Quién califica
                    </label>

                    <select
                        name="tipoCalificador"
                        id="tipoCalificador"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">Seleccione quién califica</option>

                        <option value="usuario"
                            {{ old('tipoCalificador', $calificacion->tipoCalificador) == 'usuario' ? 'selected' : '' }}>
                            Usuario califica al publicador
                        </option>

                        <option value="empresa"
                            {{ old('tipoCalificador', $calificacion->tipoCalificador) == 'empresa' ? 'selected' : '' }}>
                            Publicador califica al usuario
                        </option>

                    </select>

                    <p id="hintCalifica" class="mt-1 text-xs text-gray-500"></p>

                    @error('tipoCalificador')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                </div>


                {{-- Fecha (solo lectura) --}}
                <div>

                    <label for="fechaCalificacion" class="mb-2 block text-sm font-semibold text-gray-700">
                        Fecha
                    </label>

                    <input
                        type="text"
                        id="fechaCalificacion"
                        value="{{ $calificacion->fecha ? \Carbon\Carbon::parse($calificacion->fecha)->format('d/m/Y') : 'Sin fecha' }}"
                        disabled
                        class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-4 py-2.5 text-sm text-gray-500">

                    <p class="mt-1 text-xs text-gray-500">No se puede modificar.</p>

                </div>


                {{-- Puntuación (solo lectura) --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Puntuación
                    </label>

                    <div class="flex items-center gap-1">

                        @for ($i = 1; $i <= 5; $i++)
                            <span class="text-3xl leading-none {{ $i <= $calificacion->puntuacion ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                        @endfor

                        <span class="ml-2 text-sm text-gray-500">
                            {{ $calificacion->puntuacion }} de 5 estrellas
                        </span>

                    </div>

                    <p class="mt-1 text-xs text-gray-500">La puntuación no se puede modificar.</p>

                    {{-- Se envía la puntuación actual, pero no se puede cambiar --}}
                    <input type="hidden" name="puntuacion" value="{{ $calificacion->puntuacion }}">

                    @error('puntuacion')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                </div>


                {{-- Comentario --}}
                <div class="md:col-span-2">

                    <label for="comentario" class="mb-2 block text-sm font-semibold text-gray-700">
                        Comentario
                    </label>

                    <textarea
                        name="comentario"
                        id="comentario"
                        rows="4"
                        maxlength="255"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                        placeholder="Escribe un comentario...">{{ trim(old('comentario', $calificacion->comentario)) }}</textarea>

                    <p id="contadorComentario" class="mt-1 text-right text-xs text-gray-400">0 / 100</p>

                    @error('comentario')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                </div>

            </div>


            {{-- Botones --}}
            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('calificacion.index') }}"
                    class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Cancelar
                </a>

                <button type="submit"
                    class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Actualizar
                </button>

            </div>

        </form>

    </div>

</div>

</div>


<script>

    const selPostulacion = document.getElementById('idPostulacion');
    const selTipo        = document.getElementById('tipoCalificador');
    const panel          = document.getElementById('resumenPostulacion');
    const resUsuario     = document.getElementById('resUsuario');
    const resPublicador  = document.getElementById('resPublicador');
    const resOferta      = document.getElementById('resOferta');
    const hint           = document.getElementById('hintCalifica');
    const comentario     = document.getElementById('comentario');
    const contador       = document.getElementById('contadorComentario');

    function actualizarResumen() {

        const opcion = selPostulacion.options[selPostulacion.selectedIndex];

        if (!opcion || !opcion.value) {
            panel.classList.add('hidden');
            hint.textContent = '';
            return;
        }

        const usuario    = opcion.dataset.usuario;
        const publicador = opcion.dataset.publicador;

        resUsuario.textContent    = usuario;
        resPublicador.textContent = publicador;
        resOferta.textContent     = opcion.dataset.oferta;

        panel.classList.remove('hidden');

        if (selTipo.value === 'usuario') {
            hint.textContent = 'Califica: ' + usuario + '  →  Recibe: ' + publicador;
        } else if (selTipo.value === 'empresa') {
            hint.textContent = 'Califica: ' + publicador + '  →  Recibe: ' + usuario;
        } else {
            hint.textContent = '';
        }

    }

    function actualizarContador() {
        contador.textContent = comentario.value.length + ' / 100';
    }

    selPostulacion.addEventListener('change', actualizarResumen);
    selTipo.addEventListener('change', actualizarResumen);
    comentario.addEventListener('input', actualizarContador);

    actualizarResumen();
    actualizarContador();

</script>

@endsection
