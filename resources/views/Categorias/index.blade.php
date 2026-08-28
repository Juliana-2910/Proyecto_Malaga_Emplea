
@extends('layouts.app')

@section('title')
Crud Categorias
@endsection

@section('content')


<div class="container mx-auto mt-10">

    <div class="bg-white shadow-lg rounded-lg p-6">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-3xl font-bold text-gray-700">
                Listado de categorías
            </h2>

            <a href="{{ route('categorias.create') }}"
               class="bg-blue-700 hover:bg-blue-400 text-white px-4 py-2 rounded">
                Nueva Categoría
            </a>

        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('actualizar'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                {{ session('actualizar') }}
            </div>
        @endif

        @if (session('eliminar'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('eliminar') }}
            </div>
        @endif

        <div class="overflow-x-auto">

            <table class="min-w-full border border-gray-300">

                <thead class="bg-gray-200">

                    <tr>
                        <th class="border px-4 py-2">Id</th>
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($categorias as $categoria)

                        <tr class="text-center hover:bg-gray-50">

                            <td class="border px-4 py-2">
                                {{ $categoria->id }}
                            </td>

                            <td class="border px-4 py-2">
                                {{ $categoria->nombre }}
                            </td>

                            <td class="border px-4 py-2">

                                <div class="flex flex-col items-center gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('categorias.edit', $categoria->id) }}"
                                       class="w-28 text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg shadow transition duration-300">
                                        ✏️ Editar
                                    </a>

                                    {{-- Eliminar --}}
                                    <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="w-28 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-lg shadow transition duration-300">
                                            🗑️ Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="border px-4 py-6 text-center text-gray-500">
                                No hay categorías registradas.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
