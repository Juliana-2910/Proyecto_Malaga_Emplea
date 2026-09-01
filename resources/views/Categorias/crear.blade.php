
@extends('layouts.app')

@section('title')
Crear Categoría
@endsection

@section('content')


<div class="container mx-auto mt-10">

    <div class="max-w-2xl mx-auto">

        <div class="bg-white shadow-lg rounded-lg p-6">

            {{-- Encabezado --}}
            <div class="mb-6">

                <h2 class="text-3xl font-bold text-gray-700">
                    Crear Categoría
                </h2>

                <p class="text-gray-500 mt-2">
                    Registra una nueva categoría.
                </p>

            </div>

            {{-- Errores de validación --}}
            @if ($errors->any())

                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">

                    <p class="font-semibold mb-2">
                        Por favor corrige los siguientes errores:
                    </p>

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- Formulario --}}
            <form action="{{ route('categorias.store') }}" method="POST">

                @csrf

                {{-- Nombre --}}
                <div class="mb-5">

                    <label
                        for="nombre"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Nombre de la categoría
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        placeholder="Ingrese el nombre de la categoría"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >

                    @error('nombre')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-3 mt-6">

                    <a
                        href="{{ route('categorias.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-300"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-300"
                    >
                        Guardar Categoría
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


@endsection
