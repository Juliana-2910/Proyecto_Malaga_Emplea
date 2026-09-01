
@extends('layouts.app')

@section('title', 'Crear Empresa')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="mx-auto max-w-3xl px-6">

        {{-- Encabezado --}}
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Crear empresa
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Registra una nueva empresa en el sistema.
            </p>

        </div>


        {{-- Formulario --}}
        <div class="rounded-xl bg-white p-6 shadow">

            <form action="{{ route('empresas.store') }}" method="POST">

                @csrf


                {{-- Nombre de empresa --}}
                <div class="mb-6">

                    <label for="nombreEmpresa"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Nombre de la empresa
                    </label>

                    <input type="text"
                           name="nombreEmpresa"
                           id="nombreEmpresa"
                           value="{{ old('nombreEmpresa') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#4DB6E8] focus:ring-2 focus:ring-[#4DB6E8]"
                           required>

                    @error('nombreEmpresa')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- NIT --}}
                <div class="mb-6">

                    <label for="nit"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        NIT
                    </label>

                    <input type="text"
                           name="nit"
                           id="nit"
                           value="{{ old('nit') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#4DB6E8] focus:ring-2 focus:ring-[#4DB6E8]"
                           required>

                    @error('nit')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Dirección --}}
                <div class="mb-6">

                    <label for="direccion"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Dirección
                    </label>

                    <input type="text"
                           name="direccion"
                           id="direccion"
                           value="{{ old('direccion') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#4DB6E8] focus:ring-2 focus:ring-[#4DB6E8]"
                           required>

                    @error('direccion')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Estado --}}
                <div class="mb-6">

                    <label for="estado"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Estado
                    </label>

                    <select name="estado"
                            id="estado"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#4DB6E8] focus:ring-2 focus:ring-[#4DB6E8]"
                            required>

                        <option value="">
                            Seleccione un estado
                        </option>

                        <option value="activo">
                            Activo
                        </option>

                        <option value="inactivo">
                            Inactivo
                        </option>

                    </select>

                    @error('estado')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Correo electrónico --}}
                <div class="mb-6">

                    <label for="correoElectronico"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Correo electrónico
                    </label>

                    <input type="email"
                           name="correoElectronico"
                           id="correoElectronico"
                           value="{{ old('correoElectronico') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#4DB6E8] focus:ring-2 focus:ring-[#4DB6E8]"
                           required>

                    @error('correoElectronico')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Contraseña --}}
                <div class="mb-6">

                    <label for="password"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Contraseña
                    </label>

                    <input type="password"
                           name="password"
                           id="password"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#4DB6E8] focus:ring-2 focus:ring-[#4DB6E8]"
                           required>

                    @error('password')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('empresas.index') }}"
                       class="rounded-lg bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-300">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                        Guardar empresa
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

