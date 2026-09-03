
@extends('layouts.app')

@section('title')
    Ofertas laborales
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-5xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Ofertas laborales
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Gestión de las ofertas laborales registradas
        </p>

    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('actualizar'))
        <div class="mb-6 rounded-lg bg-blue-100 px-4 py-3 text-sm text-blue-700">
            {{ session('actualizar') }}
        </div>
    @endif

    @if(session('eliminar'))
        <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-700">
            {{ session('eliminar') }}
        </div>
    @endif

    {{-- Tabla --}}
    <div class="rounded-xl bg-white p-8 shadow">

        <div class="mb-6 flex justify-end">

            <a href="{{ route('ofertas.create') }}"
                class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                Nueva oferta
            </a>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm text-gray-600">

                <thead class="bg-gray-100 text-xs uppercase text-gray-700">

                    <tr>

                        <th class="px-4 py-3">
                            Título
                        </th>

                        <th class="px-4 py-3">
                            Salario
                        </th>

                        <th class="px-4 py-3">
                            Tipo de contrato
                        </th>

                        <th class="px-4 py-3">
                            Ubicación
                        </th>

                        <th class="px-4 py-3">
                            Empresa
                        </th>

                        <th class="px-4 py-3 text-center">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($ofertas as $oferta)

                        <tr class="border-b border-gray-200 hover:bg-gray-50">

                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $oferta->titulo }}
                            </td>

                            <td class="px-4 py-3">
                                ${{ number_format($oferta->salario, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $oferta->tipoContrato }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $oferta->ubicacion }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $oferta->empresa->nombreEmpresa }}
                            </td>

                            <td class="px-4 py-3">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('ofertas.edit', $oferta->id) }}"
                                        class="rounded-lg bg-[#4DB6E8] px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                        Editar
                                    </a>

                                    <form action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('¿Está seguro de eliminar esta oferta?')"
                                            class="rounded-lg bg-gray-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-[#333333]">
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