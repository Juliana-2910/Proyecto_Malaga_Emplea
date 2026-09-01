
@extends('layouts.app')

@section('title', 'Empresas')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-6xl px-6">

        {{-- Encabezado --}}
        <div class="mb-6 flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Empresas
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Administración de empresas del sistema
                </p>
            </div>

            <a href="{{ route('empresas.create') }}"
               class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                Crear empresa
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


        {{-- Tabla de empresas --}}
        <div class="overflow-hidden rounded-xl bg-white shadow">

            <div class="border-b border-gray-200 px-6 py-4">

                <h2 class="text-lg font-semibold text-gray-800">
                    Lista de empresas
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
                                Empresa
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                NIT
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Dirección
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Estado
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Correo electrónico
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200">

                        @foreach ($empresas as $empresa)

                            <tr class="transition hover:bg-gray-50">

                                {{-- ID --}}
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $empresa->id }}
                                </td>


                                {{-- Nombre de empresa --}}
                                <td class="px-6 py-4">

                                    <span class="font-medium text-gray-700">
                                        {{ $empresa->nombreEmpresa }}
                                    </span>

                                </td>


                                {{-- NIT --}}
                                <td class="px-6 py-4">
                                    {{ $empresa->nit }}
                                </td>


                                {{-- Dirección --}}
                                <td class="px-6 py-4">
                                    {{ $empresa->direccion }}
                                </td>


                                {{-- Estado --}}
                                <td class="px-6 py-4">
                                    {{ $empresa->estado }}
                                </td>


                                {{-- Correo --}}
                                <td class="px-6 py-4">
                                    {{ $empresa->correoElectronico }}
                                </td>


                                {{-- Acciones --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        {{-- Editar --}}
                                        <a href="{{ route('empresas.edit', $empresa->id) }}"
                                           class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                            Editar
                                        </a>


                                        {{-- Eliminar --}}
                                        <form action="{{ route('empresas.destroy', $empresa->id) }}"
                                              method="POST">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#333333]"
                                                    onclick="return confirm('¿Está seguro de eliminar esta empresa?')">
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

