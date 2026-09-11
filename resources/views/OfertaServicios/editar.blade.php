
@extends('layouts.app')

@section('title')
    Editar Oferta Servicio
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-3xl px-6">

        {{-- Encabezado --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Editar Oferta Servicio
            </h1>

            <p class="mt-2 text-gray-600">
                Actualiza la relación entre la oferta y el servicio.
            </p>
        </div>

        {{-- Formulario --}}
        <div class="rounded-xl bg-white p-8 shadow-md">

            <form action="{{ route('ofertaServicios.update', $ofertaServicios->id) }}" method="POST">

                @csrf
                @method('PUT')

                {{-- Oferta --}}
                <div class="mb-6">
                    <label for="idOferta" class="mb-2 block font-semibold text-gray-700">
                        Oferta
                    </label>

                    <select
                        name="idOferta"
                        id="idOferta"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#4DB6E8] focus:ring-[#4DB6E8]"
                    >
                        <option value="">Seleccione una oferta</option>

                        @foreach ($ofertas as $oferta)
                            <option
                                value="{{ $oferta->id }}"
                                {{ old('idOferta', $ofertaServicios->idOferta) == $oferta->id ? 'selected' : '' }}
                            >
                                {{ $oferta->titulo }}
                            </option>
                        @endforeach
                    </select>

                    @error('idOferta')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Servicio --}}
                <div class="mb-6">
                    <label for="idServicio" class="mb-2 block font-semibold text-gray-700">
                        Servicio
                    </label>

                    <select
                        name="idServicio"
                        id="idServicio"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-[#4DB6E8] focus:ring-[#4DB6E8]"
                    >
                        <option value="">Seleccione un servicio</option>

                        @foreach ($servicios as $servicio)
                            <option
                                value="{{ $servicio->id }}"
                                {{ old('idServicio', $ofertaServicios->idServicio) == $servicio->id ? 'selected' : '' }}
                            >
                                {{ $servicio->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('idServicio')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route('ofertaServicios.index') }}"
                        class="rounded-lg bg-gray-500 px-6 py-3 font-semibold text-white transition hover:bg-gray-700"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[#4DB6E8] px-6 py-3 font-semibold text-white transition hover:bg-[#333333]"
                    >
                        Actualizar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
