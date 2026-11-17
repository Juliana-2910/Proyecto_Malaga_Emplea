
@extends('layouts.app')

@section('title', 'Editar usuario')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen py-10">

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

                <form action="{{ route('usuarios.update', $usuarios->id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- 1 = eliminar la foto actual al guardar --}}
                    <input type="hidden" name="eliminarFotoPerfil" id="eliminarFotoPerfil" value="0">


        {{-- Información principal --}}
            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- Foto de perfil --}}
                <div class="flex flex-col items-center justify-center">

                    <label class="mb-3 block text-sm font-semibold text-gray-700">
                        Foto de perfil
                    </label>

                    {{-- Vista previa --}}
                    <div class="h-32 w-32 overflow-hidden rounded-full border-2 border-[#4DB6E8] bg-gray-100 shadow-sm">

                        <img id="previewFoto"
                            src="{{ $usuarios->fotoPerfil ? asset('storage/' . $usuarios->fotoPerfil) : '' }}"
                            alt="Foto de perfil"
                            class="{{ $usuarios->fotoPerfil ? '' : 'hidden' }} h-full w-full object-cover">

                        <div id="placeholderFoto"
                            class="{{ $usuarios->fotoPerfil ? 'hidden' : 'flex' }} h-full w-full items-center justify-center text-gray-400">

                            @php($icon ='user')
                            @include('layouts.partials.icons')

                        </div>

                    </div>


                    {{-- Botón cambiar foto --}}
                    <label for="fotoPerfil"
                        class="mt-4 cursor-pointer rounded-lg bg-[#4DB6E8] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">

                        Cambiar foto

                    </label>


                    {{-- Nombre del archivo --}}
                    <p id="nombreFoto"
                        class="mt-2 max-w-[220px] truncate text-center text-sm text-gray-600">
                        @if($usuarios->fotoPerfil)
                            {{ basename($usuarios->fotoPerfil) }}
                        @endif
                    </p>


                    {{-- Eliminar foto --}}
                    <button type="button"
                        id="btnEliminarFoto"
                        class="{{ $usuarios->fotoPerfil ? '' : 'hidden' }} mt-1 text-xs font-semibold text-red-500 transition hover:text-red-700 hover:underline">
                        Eliminar foto
                    </button>


                    <input type="file"
                        name="fotoPerfil"
                        id="fotoPerfil"
                        accept="image/jpeg,image/png,image/jpg"
                        class="hidden">


                    <p class="mt-2 text-center text-xs text-gray-500">
                        JPG, JPEG o PNG<br>
                        Máximo 2 MB
                    </p>

                    @error('fotoPerfil')
                        <p class="mt-1 text-center text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Datos personales --}}
                <div class="md:col-span-2 flex flex-col gap-5">

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

                </div>

            </div>


            {{-- Resto del formulario --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


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

                        <option value="CC"
                            {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'CC' ? 'selected' : '' }}>
                            Cédula de ciudadanía (CC)
                        </option>

                        <option value="CE"
                            {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'CE' ? 'selected' : '' }}>
                            Cédula de extranjería (CE)
                        </option>

                        <option value="PPT"
                            {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'PPT' ? 'selected' : '' }}>
                            Permiso por Protección Temporal (PPT)
                        </option>

                        <option value="PEP"
                            {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'PEP' ? 'selected' : '' }}>
                            Permiso Especial de Permanencia (PEP)
                        </option>

                        <option value="PASAPORTE"
                            {{ old('tipoDocumento', $usuarios->tipoDocumento) == 'PASAPORTE' ? 'selected' : '' }}>
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

                    <label for="email"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Correo electrónico
                    </label>

                    <input type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $usuarios->email) }}"
                        placeholder="ejemplo@correo.com"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('email')
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
                        autocomplete="new-password"
                        placeholder="Deje vacío si no desea cambiarla"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

                    @error('password')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Fecha de registro (solo lectura) --}}
                <div>

                    <label for="fechaRegistro"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Fecha de registro
                    </label>

                    <input type="text"
                        id="fechaRegistro"
                        value="{{ $usuarios->fechaRegistro ? \Carbon\Carbon::parse($usuarios->fechaRegistro)->format('d/m/Y') : 'Sin registro' }}"
                        disabled
                        class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-4 py-2.5 text-sm text-gray-500">

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

                        <option value="activo"
                            {{ strtolower(old('estado', $usuarios->estado)) === 'activo' ? 'selected' : '' }}>
                            Activo
                        </option>

                        <option value="inactivo"
                            {{ strtolower(old('estado', $usuarios->estado)) === 'inactivo' ? 'selected' : '' }}>
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
                    Actualizar
                </button>

            </div>


        </form>

    </div>

</div>

</div>



{{-- Vista previa y eliminación de la foto --}}
<script>

    const inputFoto      = document.getElementById('fotoPerfil');
    const preview        = document.getElementById('previewFoto');
    const placeholder    = document.getElementById('placeholderFoto');
    const nombreFoto     = document.getElementById('nombreFoto');
    const btnEliminar    = document.getElementById('btnEliminarFoto');
    const flagEliminar   = document.getElementById('eliminarFotoPerfil');

    // Foto que el usuario tiene guardada actualmente (null si no tiene)
    const fotoOriginal   = @json($usuarios->fotoPerfil ? asset('storage/' . $usuarios->fotoPerfil) : null);
    const nombreOriginal = @json($usuarios->fotoPerfil ? basename($usuarios->fotoPerfil) : '');

    function mostrarFoto(src, nombre) {
        preview.src = src;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        placeholder.classList.remove('flex');
        nombreFoto.textContent = nombre;
        btnEliminar.classList.remove('hidden');
    }

    function mostrarPlaceholder() {
        preview.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        placeholder.classList.add('flex');
        nombreFoto.textContent = '';
        btnEliminar.classList.add('hidden');
    }

    // Al elegir una foto nueva
    inputFoto.addEventListener('change', function (event) {

        const archivo = event.target.files[0];

        if (archivo) {

            const lector = new FileReader();

            lector.onload = function (e) {
                mostrarFoto(e.target.result, archivo.name);
            };

            lector.readAsDataURL(archivo);

            flagEliminar.value = '0'; // la foto nueva reemplaza a la anterior

        } else if (fotoOriginal && flagEliminar.value === '0') {

            mostrarFoto(fotoOriginal, nombreOriginal); // canceló la selección: vuelve la actual

        } else {

            mostrarPlaceholder();

        }

    });

    // Al presionar "Eliminar foto"
    btnEliminar.addEventListener('click', function () {

        inputFoto.value = '';                       // descarta cualquier foto recién elegida
        flagEliminar.value = fotoOriginal ? '1' : '0'; // si había foto guardada, se borra al guardar
        mostrarPlaceholder();

    });

</script>

@endsection
