@extends('layouts.app')

@section('title', 'Editar empresa')

@section('page-title', 'Panel Administrativo')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="mx-auto max-w-5xl px-6">

{{-- Encabezado --}}
<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Editar empresa
    </h1>

    <p class="mt-1 text-sm text-gray-500">
        Actualización de la información de la empresa
    </p>

</div>


{{-- Formulario --}}
<div class="rounded-xl bg-white p-8 shadow">

    <form action="{{ route('empresas.update', $empresa->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        @method('PUT')


{{-- Información principal --}}
<div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">


    {{-- FOTO DE PERFIL --}}
    <div class="flex flex-col items-center justify-center">

        <label class="mb-3 block text-sm font-semibold text-gray-700">
            Foto de perfil
        </label>


        {{-- Vista previa --}}
        <div class="h-32 w-32 overflow-hidden rounded-full border-2 border-[#4DB6E8] bg-gray-100 shadow-sm">

            @if($empresa->fotoPerfil)

                <img id="previewFoto"
                    src="{{ asset('storage/empresas/' . $empresa->fotoPerfil) }}"
                    alt="Foto de perfil"
                    class="h-full w-full object-cover">

                <div id="placeholderFoto"
                    class="hidden h-full w-full items-center justify-center text-gray-400">

                    @php($icon = 'building-office-2')
                    @include('layouts.partials.icons')

                </div>

            @else

                <img id="previewFoto"
                    src=""
                    alt="Vista previa de la foto"
                    class="hidden h-full w-full object-cover">

                <div id="placeholderFoto"
                    class="flex h-full w-full items-center justify-center text-gray-400">

                    @php($icon = 'building-office-2')
                    @include('layouts.partials.icons')

                </div>

            @endif

        </div>


        {{-- Botón cambiar foto --}}
        <label for="fotoPerfil"
            class="mt-4 cursor-pointer rounded-lg bg-[#4DB6E8] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">

            Cambiar foto

        </label>


        {{-- Nombre del archivo --}}
        <p id="nombreFoto"
            class="mt-2 max-w-[220px] truncate text-center text-sm text-gray-600">

            @if($empresa->fotoPerfil)
                {{ basename($empresa->fotoPerfil) }}
            @endif

        </p>


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


    {{-- DOS COLUMNAS AL LADO DE LA FOTO --}}
    <div class="md:col-span-2 grid grid-cols-1 gap-5 md:grid-cols-2">


        {{-- Nombre de empresa --}}
        <div>

            <label for="nombreEmpresa"
                class="mb-2 block text-sm font-semibold text-gray-700">

                Nombre de la empresa

            </label>

            <input type="text"
                name="nombreEmpresa"
                id="nombreEmpresa"
                value="{{ old('nombreEmpresa', $empresa->nombreEmpresa) }}"
                placeholder="Ingrese el nombre de la empresa"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

            @error('nombreEmpresa')

                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- NIT --}}
        <div>

            <label for="nit"
                class="mb-2 block text-sm font-semibold text-gray-700">

                NIT

            </label>

            <input type="text"
                name="nit"
                id="nit"
                value="{{ old('nit', $empresa->nit) }}"
                placeholder="Ingrese el NIT"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

            @error('nit')

                <p class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Dirección --}}
        <div>

            <label for="direccion"
                class="mb-2 block text-sm font-semibold text-gray-700">

                Dirección

            </label>

            <input type="text"
                name="direccion"
                id="direccion"
                value="{{ old('direccion', $empresa->direccion) }}"
                placeholder="Ingrese la dirección"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

            @error('direccion')

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
        <div>

            <label for="correoElectronico"
                class="mb-2 block text-sm font-semibold text-gray-700">

                Correo electrónico

            </label>

            <input type="email"
                name="correoElectronico"
                id="correoElectronico"
                value="{{ old('correoElectronico', $empresa->correoElectronico) }}"
                placeholder="ejemplo@correo.com"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-[#4DB6E8] focus:outline-none focus:ring-1 focus:ring-[#4DB6E8]">

            @error('correoElectronico')

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

    </div>

</div>


{{-- Botones --}}
<div class="mt-8 flex justify-end gap-3">

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


{{-- Vista previa de la foto --}}

<script>

    document.getElementById('fotoPerfil').addEventListener('change', function(event) {

        const archivo = event.target.files[0];

        const preview = document.getElementById('previewFoto');

        const placeholder = document.getElementById('placeholderFoto');

        const nombreFoto = document.getElementById('nombreFoto');


        if (archivo) {

            const lector = new FileReader();


            lector.onload = function(e) {

                preview.src = e.target.result;

                preview.classList.remove('hidden');

                placeholder.classList.add('hidden');

            };


            lector.readAsDataURL(archivo);

            nombreFoto.textContent = archivo.name;


        } else {

            @if($empresa->fotoPerfil)

                preview.src = "{{ asset('storage/empresas/' . $empresa->fotoPerfil) }}";

                preview.classList.remove('hidden');

                placeholder.classList.add('hidden');

            @else

                preview.src = '';

                preview.classList.add('hidden');

                placeholder.classList.remove('hidden');

            @endif

            nombreFoto.textContent = '';

        }

    });

</script>

@endsection
