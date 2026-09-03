@extends('layouts.app')

@section('title')
    Crear oferta
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-5xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Crear oferta
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Registro de una nueva oferta laboral en el sistema
        </p>

    </div>


    {{-- Formulario --}}
    <div class="rounded-xl bg-white p-8 shadow">

        <form action="{{ route('ofertas.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Título --}}
                <div>
                    <label for="titulo"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Título
                    </label>

                    <input type="text"
                           name="titulo"
                           id="titulo"
                           value="{{ old('titulo') }}"
                           placeholder="Ingrese el título de la oferta"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('titulo')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Salario --}}
                <div>
                    <label for="salario"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Salario
                    </label>

                    <input type="number"
                           name="salario"
                           id="salario"
                           value="{{ old('salario') }}"
                           placeholder="Ingrese el salario"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('salario')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label for="descripcion"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Descripción
                    </label>

                    <textarea name="descripcion"
                              id="descripcion"
                              rows="4"
                              placeholder="Ingrese la descripción de la oferta"
                              class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Requisitos --}}
                <div class="md:col-span-2">
                    <label for="requisitos"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Requisitos
                    </label>

                    <textarea name="requisitos"
                              id="requisitos"
                              rows="4"
                              placeholder="Ingrese los requisitos de la oferta"
                              class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">{{ old('requisitos') }}</textarea>

                    @error('requisitos')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Tipo de contrato --}}
                <div>
                    <label for="tipoContrato"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Tipo de contrato
                    </label>

                    <select name="tipoContrato"
                            id="tipoContrato"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione un tipo de contrato
                        </option>

                        <option value="tiempo completo"
                            {{ old('tipoContrato') == 'tiempo completo' ? 'selected' : '' }}>
                            Tiempo completo
                        </option>

                        <option value="medio tiempo"
                            {{ old('tipoContrato') == 'medio tiempo' ? 'selected' : '' }}>
                            Medio tiempo
                        </option>

                        <option value="horas"
                            {{ old('tipoContrato') == 'horas' ? 'selected' : '' }}>
                            Por horas
                        </option>

                    </select>

                    @error('tipoContrato')
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
                           value="{{ old('ubicacion') }}"
                           placeholder="Ingrese la ubicación"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('ubicacion')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Fecha de publicación --}}
                <div>
                    <label for="fechaPublicacion"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Fecha de publicación
                    </label>

                    <input type="date"
                           name="fechaPublicacion"
                           id="fechaPublicacion"
                           value="{{ old('fechaPublicacion', date('Y-m-d')) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('fechaPublicacion')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Fecha límite --}}
                <div>
                    <label for="fechaLimite"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Fecha límite
                    </label>

                    <input type="date"
                           name="fechaLimite"
                           id="fechaLimite"
                           value="{{ old('fechaLimite') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('fechaLimite')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Empresa --}}
                <div>
                    <label for="idEmpresa"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Empresa
                    </label>

                    <select name="idEmpresa"
                            id="idEmpresa"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione una empresa
                        </option>

                        @foreach ($empresas as $empresa)

                            <option value="{{ $empresa->id }}"
                                {{ old('idEmpresa') == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->nombreEmpresa }}
                            </option>

                        @endforeach

                    </select>

                    @error('idEmpresa')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>


            {{-- Botones --}}
            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('ofertas.index') }}"
                   class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Cancelar
                </a>

                <button type="submit"
                        class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Guardar oferta
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection