
@extends('layouts.app')

@section('title')
    Roles
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-8">

<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}

    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-800 sm:text-3xl">

                Roles

            </h1>

            <p class="mt-1 text-sm text-gray-500">

                Administración y control de los roles del sistema

            </p>

        </div>

        <a
            href="{{ route('roles.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#333333]">

            @php($icon = 'plus')
            @include('layouts.partials.icons')

            Crear rol

        </a>

    </div>


    {{-- TARJETA PRINCIPAL --}}

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-[0_10px_35px_rgba(77,182,232,0.20)]">

        {{-- TÍTULO DE LA TABLA --}}

        <div class="border-b border-gray-100 px-6 py-4">

            <h2 class="text-lg font-semibold text-gray-800">

                Listado de roles

            </h2>

        </div>


        {{-- TABLA --}}

        <div class="overflow-x-auto">

            <table class="w-full text-center text-gray-600">

                <thead class="bg-[#333333] text-white">

                    <tr>

                        <th class="border-r border-gray-600 px-6 py-4 text-sm font-semibold">

                            ID

                        </th>

                        <th class="border-r border-gray-600 px-6 py-4 text-sm font-semibold">

                            Rol

                        </th>

                        <th class="px-6 py-4 text-sm font-semibold">

                            Acciones

                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200">

                    @forelse ($roles as $rol)

                        <tr class="transition hover:bg-gray-50">

                            {{-- ID --}}

                            <td class="border-r border-gray-100 px-6 py-5 text-sm font-medium text-gray-600">

                                {{ $rol->id }}

                            </td>


                            {{-- ROL --}}

                            <td class="border-r border-gray-100 px-6 py-5 text-sm font-medium text-gray-600">

                                {{ $rol->rol }}

                            </td>


                            {{-- ACCIONES --}}

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- EDITAR --}}

                                    <a
                                        href="{{ route('roles.edit', $rol->id) }}"
                                        title="Editar rol"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#4DB6E8]/10 text-[#4DB6E8] transition duration-200 hover:bg-[#4db6e8] hover:text-white">

                                        @php($icon = 'pencil')
                                        @include('layouts.partials.icons')

                                    </a>


                                    {{-- ELIMINAR --}}

                                    <button
                                        type="button"
                                        title="Eliminar rol"
                                        @click="$dispatch('open-modal', 'delete-{{ $rol->id }}')"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500 transition duration-200 hover:bg-red-500 hover:text-white">

                                        @php($icon = 'trash')
                                        @include('layouts.partials.icons')

                                    </button>

                                </div>

                            </td>

                        </tr>


                        {{-- MODAL ELIMINAR --}}

                        <x-modal
                            name="delete-{{ $rol->id }}"
                            title="Eliminar registro"
                            maxWidth="sm">

                            <div class="text-center">

                                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">

                                    @php($icon = 'exclamation-triangle')
                                    @include('layouts.partials.icons')

                                </div>

                                <p class="text-sm leading-6 text-gray-500">

                                    ¿Seguro que deseas eliminar el rol

                                    <strong class="text-gray-800">

                                        {{ $rol->rol }}

                                    </strong>?

                                    <br>

                                    Esta acción no se puede deshacer.

                                </p>

                            </div>


                            <x-slot:footer>

                                <x-button
                                    variant="secondary"
                                    @click="show = false">

                                    Cancelar

                                </x-button>


                                <form
                                    action="{{ route('roles.destroy', $rol->id) }}"
                                    method="POST">

                                    @csrf

                                    @method('DELETE')

                                    <x-button
                                        variant="danger"
                                        type="submit">

                                        Eliminar

                                    </x-button>

                                </form>

                            </x-slot:footer>

                        </x-modal>


                    @empty

                        {{-- ESTADO VACÍO --}}

                        <tr>

                            <td colspan="3">

                                <div class="px-6 py-16 text-center">

                                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#4DB6E8]/10 text-[#4DB6E8]">

                                        @php($icon = 'shield-check')
                                        @include('layouts.partials.icons')

                                    </div>


                                    <h3 class="text-lg font-semibold text-gray-800">

                                        No hay roles registrados

                                    </h3>


                                    <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">

                                        Todavía no existen roles registrados en el sistema.

                                    </p>


                                    <a
                                        href="{{ route('roles.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#333333]">

                                        @php($icon = 'plus')
                                        @include('layouts.partials.icons')

                                        Crear rol

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- CONTADOR --}}

    @if ($roles->count() > 0)

        <div class="mt-4 flex items-center justify-between px-1">

            <p class="text-sm text-gray-500">

                Mostrando

                <span class="font-semibold text-gray-800">

                    {{ $roles->count() }}

                </span>

                {{ $roles->count() == 1

                    ? 'rol registrado'

                    : 'roles registrados' }}

            </p>


            <div class="hidden items-center gap-2 text-xs text-gray-400 sm:flex">

                <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

                Málaga Emplea

            </div>

        </div>

    @endif

</div>

</div>

@endsection
