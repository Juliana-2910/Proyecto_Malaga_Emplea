
@extends('layouts.app')

@section('title')
Crud de usuarios
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-6xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Usuarios
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Administración de usuarios del sistema
            </p>
        </div>

        <a href="{{ route('usuarios.create') }}"
           class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
            Crear usuario
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


    {{-- Tabla de usuarios --}}
    <div class="overflow-hidden rounded-xl bg-white shadow">

        <div class="border-b border-gray-200 px-6 py-4">

            <h2 class="text-lg font-semibold text-gray-800">
                Lista de usuarios
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
                            Nombres
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Apellidos
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Tipo documento
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Número documento
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Correo electrónico
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Teléfono
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200">

                    @forelse ($usuarios as $usuario)

                        <tr class="transition hover:bg-gray-50">

                            {{-- ID --}}
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $usuario->id }}
                            </td>


                            {{-- Nombres --}}
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-700">
                                    {{ $usuario->nombres }}
                                </span>
                            </td>


                            {{-- Apellidos --}}
                            <td class="px-6 py-4">
                                {{ $usuario->apellidos }}
                            </td>


                            {{-- Tipo de documento --}}
                            <td class="px-6 py-4">
                                {{ $usuario->tipoDocumento }}
                            </td>


                            {{-- Número de documento --}}
                            <td class="px-6 py-4">
                                {{ $usuario->numeroDocumento }}
                            </td>


                            {{-- Correo electrónico --}}
                            <td class="px-6 py-4">
                                {{ $usuario->correoElectronico }}
                            </td>


                            {{-- Teléfono --}}
                            <td class="px-6 py-4">
                                {{ $usuario->telefono }}
                            </td>


                            {{-- Estado --}}
                            <td class="px-6 py-4">

                                @if ($usuario->estado === 'Activo')

                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Activo
                                    </span>

                                @else

                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Inactivo
                                    </span>

                                @endif

                            </td>


                            {{-- Acciones --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                       class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                                        Editar
                                    </a>


                                    {{-- Eliminar --}}
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}"
                                          method="POST">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-lg bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#333333]"
                                                onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                No hay usuarios registrados.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection
