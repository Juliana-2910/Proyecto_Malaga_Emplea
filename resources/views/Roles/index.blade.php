
@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">


<div class="mx-auto max-w-6xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Roles
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Administración de roles del sistema
            </p>
        </div>

        <a href="{{ route('roles.create') }}"
           class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
            Crear rol
        </a>

    </div>


    {{-- Mensajes --}}
    @if (session('success'))

        <div class="mb-5 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    @if (session('actualizar'))

        <div class="mb-5 rounded-lg bg-blue-100 px-4 py-3 text-sm text-blue-700">
            {{ session('actualizar') }}
        </div>

    @endif


    @if (session('eliminar'))

        <div class="mb-5 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-700">
            {{ session('eliminar') }}
        </div>

    @endif


    {{-- Tabla de roles --}}
    <div class="overflow-hidden rounded-xl bg-white shadow">

        <div class="border-b border-gray-200 px-6 py-4">

            <h2 class="text-lg font-semibold text-gray-800">
                Lista de roles
            </h2>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm text-gray-600">

                <thead class="bg-[#333333] text-white">

                    <tr>

                        <th class="px-6 py-4 font-semibold">
                            ID
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Rol
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200">

                    @foreach ($roles as $rol)

                        <tr class="transition hover:bg-gray-50">

                            {{-- ID --}}
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $rol->id }}
                            </td>


                            {{-- Rol --}}
                            <td class="px-6 py-4">

                                <span class="font-medium text-gray-700">
                                    {{ $rol->rol }}
                                </span>

                            </td>


                            {{-- Acciones --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('roles.edit', $rol->id) }}"
                                       class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                        Editar
                                    </a>


                                    {{-- Eliminar --}}
                                    <form action="{{ route('roles.destroy', $rol->id) }}"
                                          method="POST">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-lg bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#333333]"
                                                onclick="return confirm('¿Está seguro de eliminar este rol?')">
                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection
