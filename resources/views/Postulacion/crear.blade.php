@extends('layouts.app')

@section('title')
    Crear postulación
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-5xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Crear postulación
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Registro de una nueva postulación
        </p>

    </div>


    {{-- Formulario --}}
    <div class="rounded-xl bg-white p-8 shadow">

        <form action="{{ route('postulacion.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Fecha --}}
                <div>
                    <label for="fecha"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Fecha
                    </label>

                    <input type="date"
                           name="fecha"
                           id="fecha"
                           value="{{ old('fecha') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('fecha')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Estado --}}
                <div>
                    <label for="estado"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Estado
                    </label>

                    <select name="estado"
                            id="estado"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione un estado
                        </option>

                        <option value="Enviado"
                            {{ old('estado') == 'Enviado' ? 'selected' : '' }}>
                            Enviado
                        </option>

                        <option value="Aceptado"
                            {{ old('estado') == 'Aceptado' ? 'selected' : '' }}>
                            Aceptado
                        </option>

                        <option value="Rechazado"
                            {{ old('estado') == 'Rechazado' ? 'selected' : '' }}>
                            Rechazado
                        </option>

                    </select>

                    @error('estado')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Usuario --}}
                <div>
                    <label for="idUsuario"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Usuario
                    </label>

                    <select name="idUsuario"
                            id="idUsuario"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione un usuario
                        </option>

                    @foreach ($usuarios as $usuario)

                        <option value="{{ $usuario->id }}"
                            {{ old('idUsuario') == $usuario->id ? 'selected' : '' }}>
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


                {{-- Oferta --}}
                <div>
                    <label for="idOferta"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Oferta
                    </label>

                    <select name="idOferta"
                            id="idOferta"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione una oferta
                        </option>

                    @foreach ($ofertas as $oferta)

                        <option value="{{ $oferta->id }}"
                            {{ old('idOferta') == $oferta->id ? 'selected' : '' }}>
                            {{ $oferta->titulo }}
                        </option>

                    @endforeach

                    </select>

                    @error('idOferta')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Botones --}}
            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('postulacion.index') }}"
                   class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Cancelar
                </a>

                <button type="submit"
                        class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Crear postulación
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection