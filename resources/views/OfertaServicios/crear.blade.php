
@extends('layouts.app')

@section('title')
    Crear Oferta Servicio
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-3xl px-6">

    {{-- Encabezado --}}
    <div class="mb-8">

        <h1 class="mt-4 text-3xl font-bold text-gray-800">
            Crear Oferta Servicio
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Asocia un servicio a una oferta laboral.
        </p>

    </div>


    {{-- Formulario --}}
    <div class="rounded-xl bg-white p-8 shadow">

        <form action="{{ route('ofertaServicios.store') }}" method="POST">

            @csrf

            {{-- Oferta --}}
            <div class="mb-6">

                <label for="idOferta"
                    class="mb-2 block text-sm font-semibold text-gray-700">
                    Oferta
                </label>

                <select
                    name="idOferta"
                    id="idOferta"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-2 focus:ring-[#4DB6E8]/30">

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


            {{-- Servicio --}}
            <div class="mb-6">

                <label for="idServicio"
                    class="mb-2 block text-sm font-semibold text-gray-700">
                    Servicio
                </label>

                <select
                    name="idServicio"
                    id="idServicio"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-2 focus:ring-[#4DB6E8]/30">

                    <option value="">
                        Seleccione un servicio
                    </option>

                    @foreach ($servicios as $servicio)

                        <option value="{{ $servicio->id }}"
                            {{ old('idServicio') == $servicio->id ? 'selected' : '' }}>

                            {{ $servicio->nombre }}

                        </option>

                    @endforeach

                </select>

                @error('idServicio')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Botones --}}
            <div class="flex justify-end gap-3">

                <a href="{{ route('ofertaServicios.index') }}"
                    class="rounded-lg bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-300">
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Guardar
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection
