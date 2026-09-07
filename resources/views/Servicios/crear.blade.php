
@extends('layouts.app')

@section('title')
Crear servicio
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-4xl px-6">

        {{-- Encabezado --}}
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Crear servicio
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Registre la información del nuevo servicio
            </p>

        </div>

        {{-- Formulario --}}
        <div class="rounded-xl bg-white p-8 shadow">

            <form action="{{ route('servicios.store') }}" method="POST">

                @csrf

                {{-- Categoría --}}
                <div class="mb-5">

                    <label for="idCategoria"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Categoría
                    </label>

                    <select id="idCategoria"
                            name="idCategoria"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione una categoría
                        </option>

                        @foreach ($categorias as $categoria)

                            <option value="{{ $categoria->id }}"
                                {{ old('idCategoria') == $categoria->id ? 'selected' : '' }}>

                                {{ $categoria->nombre }}

                            </option>

                        @endforeach

                    </select>

                    @error('idCategoria')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Servicio --}}
                <div class="mb-5">

                    <label for="nombre"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Servicio
                    </label>

                    <input type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                        placeholder="Ingrese el nombre del servicio">

                    @error('nombre')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Descripción --}}
                <div class="mb-6">

                    <label for="descripcion"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Descripción
                    </label>

                    <textarea id="descripcion"
                            name="descripcion"
                            rows="5"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                            placeholder="Ingrese la descripción del servicio">{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-3">

                    <a href="{{ route('servicios.index') }}"
                        class="rounded-lg bg-gray-400 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#333333]">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                        Guardar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
