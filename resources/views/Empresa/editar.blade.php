@extends('layouts.app')

@section('title', 'Editar empresa')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-3xl px-6">

        {{-- Encabezado --}}
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Editar empresa
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Actualiza la información de la empresa registrada.
            </p>

        </div>


        {{-- Formulario --}}
        <div class="rounded-xl bg-white p-6 shadow">

            <form action="{{ route('empresas.update', $empresa->id) }}"
                  method="POST">

                @csrf
                @method('PUT')


                {{-- Nombre de empresa --}}
                <div class="mb-5">

                    <label for="nombreEmpresa"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Nombre de la empresa
                    </label>

                    <input type="text"
                           id="nombreEmpresa"
                           name="nombreEmpresa"
                           value="{{ old('nombreEmpresa', $empresa->nombreEmpresa) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:ring-[#4DB6E8]">

                    @error('nombreEmpresa')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- NIT --}}
                <div class="mb-5">

                    <label for="nit"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        NIT
                    </label>

                    <input type="text"
                           id="nit"
                           name="nit"
                           value="{{ old('nit', $empresa->nit) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:ring-[#4DB6E8]">

                    @error('nit')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Dirección --}}
                <div class="mb-5">

                    <label for="direccion"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Dirección
                    </label>

                    <input type="text"
                           id="direccion"
                           name="direccion"
                           value="{{ old('direccion', $empresa->direccion) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:ring-[#4DB6E8]">

                    @error('direccion')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Estado --}}
                <div class="mb-5">

                    <label for="estado"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Estado
                    </label>

                    <select id="estado"
                            name="estado"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:ring-[#4DB6E8]">

                        <option value="activo"
                            {{ old('estado', $empresa->estado) == 'activo' ? 'selected' : '' }}>
                            Activo
                        </option>

                        <option value="inactivo"
                            {{ old('estado', $empresa->estado) == 'inactivo' ? 'selected' : '' }}>
                            Inactivo
                        </option>

                    </select>

                    @error('estado')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Correo electrónico --}}
                <div class="mb-5">

                    <label for="correoElectronico"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Correo electrónico
                    </label>

                    <input type="email"
                           id="correoElectronico"
                           name="correoElectronico"
                           value="{{ old('correoElectronico', $empresa->correoElectronico) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:ring-[#4DB6E8]">

                    @error('correoElectronico')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Contraseña --}}
                <div class="mb-6">

                    <label for="password"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Nueva contraseña
                    </label>

                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Ingrese una nueva contraseña"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:ring-[#4DB6E8]">

                    @error('password')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Botones --}}
                <div class="flex justify-end gap-3">

                    <a href="{{ route('empresas.index') }}"
                       class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                        Actualizar empresa
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection