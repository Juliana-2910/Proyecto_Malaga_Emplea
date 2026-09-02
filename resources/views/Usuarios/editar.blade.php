
@extends('layouts.app')

@section('title')
    Editar usuario
@endsection

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-5xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Editar usuario
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Actualización de la información del usuario
        </p>

    </div>


    {{-- Formulario --}}
    <div class="rounded-xl bg-white p-8 shadow">

        <form action="{{ route('usuarios.update', $usuarios->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Nombres --}}
                <div>
                    <label for="nombres"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Nombres
                    </label>

                    <input type="text"
                           name="nombres"
                           id="nombres"
                           value="{{ old('nombres', $usuarios->nombres) }}"
                           placeholder="Ingrese los nombres"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('nombres')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Apellidos --}}
                <div>
                    <label for="apellidos"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Apellidos
                    </label>

                    <input type="text"
                           name="apellidos"
                           id="apellidos"
                           value="{{ old('apellidos', $usuarios->apellidos) }}"
                           placeholder="Ingrese los apellidos"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('apellidos')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Fecha de nacimiento --}}
                <div>
                    <label for="fechaNacimiento"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Fecha de nacimiento
                    </label>

                    <input type="date"
                           name="fechaNacimiento"
                           id="fechaNacimiento"
                           value="{{ old('fechaNacimiento', $usuarios->fechaNacimiento) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('fechaNacimiento')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Tipo de documento --}}
                <div>
                    <label for="tipoDocumento"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Tipo de documento
                    </label>

                    <select name="tipoDocumento"
                            id="tipoDocumento"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione un tipo de documento
                        </option>

                        <option value="CC" {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'CC' ? 'selected' : '' }}>
                            Cédula de ciudadanía (CC)
                        </option>

                        <option value="CE" {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'CE' ? 'selected' : '' }}>
                            Cédula de extranjería (CE)
                        </option>

                        <option value="PPT" {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'PPT' ? 'selected' : '' }}>
                            Permiso por Protección Temporal (PPT)
                        </option>

                        <option value="PEP" {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'PEP' ? 'selected' : '' }}>
                            Permiso Especial de Permanencia (PEP)
                        </option>

                        <option value="PASAPORTE" {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'PASAPORTE' ? 'selected' : '' }}>
                            Pasaporte
                        </option>

                    </select>

                    @error('tipoDocumento')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Número de documento --}}
                <div>
                    <label for="numeroDocumento"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Número de documento
                    </label>

                    <input type="text"
                           name="numeroDocumento"
                           id="numeroDocumento"
                           value="{{ old('numeroDocumento', $usuarios->numeroDocumento) }}"
                           placeholder="Ingrese el número de documento"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('numeroDocumento')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Correo electrónico --}}
                <div>
                    <label for="correoElectronico"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Correo electrónico
                    </label>

                    <input type="email"
                           name="correoElectronico"
                           id="correoElectronico"
                           value="{{ old('correoElectronico', $usuarios->correoElectronico) }}"
                           placeholder="ejemplo@correo.com"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('correoElectronico')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Teléfono --}}
                <div>
                    <label for="telefono"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Teléfono
                    </label>

                    <input type="text"
                           name="telefono"
                           id="telefono"
                           value="{{ old('telefono', $usuarios->telefono) }}"
                           placeholder="Ingrese el número de teléfono"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('telefono')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Contraseña --}}
                <div>
                    <label for="password"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Contraseña
                    </label>

                    <input type="password"
                           name="password"
                           id="password"
                           placeholder="Ingrese una nueva contraseña"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('password')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Rol --}}
                <div>
                    <label for="idRol"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Rol
                    </label>

                    <select name="idRol"
                            id="idRol"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione un rol
                        </option>

                    @foreach ($roles as $rol )
                         <option value="{{$rol->id}}" {{$rol->id == $usuarios->idRol ? 'selected' : ' '; }}>
                                {{$rol->rol}}
                        </option>

                    @endforeach

                    </select>

                    @error('idRol')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Fecha de registro --}}
                <div>
                    <label for="fechaRegistro"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Fecha de registro
                    </label>

                    <input type="date"
                           name="fechaRegistro"
                           id="fechaRegistro"
                           value="{{ old('fechaRegistro', $usuarios->fechaRegistro) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('fechaRegistro')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Estado --}}
                <div>
                    <label for="estado"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Estado
                    </label>

                    <select name="estado"
                            id="estado"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                        <option value="">
                            Seleccione un estado
                        </option>

                        <option value="Activo"
                            {{ old('estado', $usuarios->estado) == 'Activo' ? 'selected' : '' }}>
                            Activo
                        </option>

                        <option value="Inactivo"
                            {{ old('estado', $usuarios->estado) == 'Inactivo' ? 'selected' : '' }}>
                            Inactivo
                        </option>

                    </select>

                    @error('estado')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>


            {{-- Botones --}}
            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('usuarios.index') }}"
                   class="rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Cancelar
                </a>

                <button type="submit"
                        class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Actualizar usuario
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection
