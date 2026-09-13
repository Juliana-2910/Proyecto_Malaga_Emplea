
@extends('layouts.app')

@section('title')
    Editar categoría
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-5xl px-6">

        {{-- Encabezado --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Editar categoría
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Actualiza la información de la categoría.
            </p>
        </div>

        {{-- Formulario --}}
        <div class="rounded-xl bg-white p-8 shadow">

            <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">

                    {{-- Nombre --}}
                    <div>
                        <label
                            for="nombre"
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Nombre de la categoría
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre', $categoria->nombre) }}"
                            placeholder="Ingrese el nombre de la categoría"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]"
                        >

                        @error('nombre')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Botones --}}
                <div class="mt-8 flex justify-end gap-3">

                    <a
                        href="{{ route('categorias.index') }}"
                        class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#333333]"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#333333]"
                    >
                        Actualizar categoría
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
