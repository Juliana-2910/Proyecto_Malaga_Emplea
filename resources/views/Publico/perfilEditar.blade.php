@extends('layouts.Publico.Usuario.usuario')

@section('title', 'Mi perfil')

@section('content')
<section class="bg-[#EAF6FD] px-4 py-8 sm:px-6 sm:py-12">
    <div class="mx-auto max-w-4xl">
        <a href="{{ route('Publico.ofertas') }}" class="text-sm font-bold text-marca-texto hover:underline">← Volver</a>
        <div class="mb-6 mt-4">
            <p class="text-sm font-bold uppercase tracking-wide text-marca-texto">Tu cuenta</p>
            <h1 class="mt-1 text-3xl font-extrabold text-noche">Editar perfil</h1>
            <p class="mt-2 text-slate-600">Actualiza tus datos y tu foto de perfil.</p>
        </div>

        @if (session('success'))
            <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <form action="{{ route('perfil.actualizar') }}" method="POST" enctype="multipart/form-data" class="rounded-[20px] border border-slate-100 bg-white p-5 shadow-lg shadow-noche/10 sm:p-8">
            @csrf
            @method('PUT')
            @php
                $rutaFoto = $cuenta->fotoPerfil
                    ? asset('storage/' . ($esEmpresa ? 'empresas/' . $cuenta->fotoPerfil : $cuenta->fotoPerfil))
                    : null;
                $nombre = $esEmpresa ? $cuenta->nombreEmpresa : trim($cuenta->nombres . ' ' . $cuenta->apellidos);
            @endphp

            <div class="grid gap-7 sm:grid-cols-[180px_1fr]">
                <div class="flex flex-col items-center gap-3">
                    <div class="flex size-32 items-center justify-center overflow-hidden rounded-full border-4 border-[#EAF6FD] bg-noche text-3xl font-extrabold text-white">
                        @if ($rutaFoto)
                            <img src="{{ $rutaFoto }}" alt="Foto de {{ $nombre }}" class="size-full object-cover">
                        @else
                            {{ mb_strtoupper(mb_substr($nombre, 0, 1)) }}
                        @endif
                    </div>
                    <label for="fotoPerfil" class="cursor-pointer rounded-full border-2 border-marca px-4 py-2 text-sm font-bold text-noche transition hover:bg-[#EAF6FD]">Cambiar foto</label>
                    <input id="fotoPerfil" name="fotoPerfil" type="file" accept="image/jpeg,image/png" class="sr-only">
                    <span class="text-center text-xs text-slate-500">JPG o PNG · máximo 2 MB</span>
                    @error('fotoPerfil') <p class="text-center text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid content-start gap-4 sm:grid-cols-2">
                    @if ($esEmpresa)
                        <div class="sm:col-span-2">
                            <label for="nombreEmpresa" class="mb-1 block text-sm font-bold text-noche">Nombre de la empresa</label>
                            <input id="nombreEmpresa" name="nombreEmpresa" value="{{ old('nombreEmpresa', $cuenta->nombreEmpresa) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                            @error('nombreEmpresa') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nit" class="mb-1 block text-sm font-bold text-noche">NIT</label>
                            <input id="nit" name="nit" value="{{ old('nit', $cuenta->nit) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                            @error('nit') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="direccion" class="mb-1 block text-sm font-bold text-noche">Dirección</label>
                            <input id="direccion" name="direccion" value="{{ old('direccion', $cuenta->direccion) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                            @error('direccion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @else
                        <div>
                            <label for="nombres" class="mb-1 block text-sm font-bold text-noche">Nombres</label>
                            <input id="nombres" name="nombres" value="{{ old('nombres', $cuenta->nombres) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                            @error('nombres') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="apellidos" class="mb-1 block text-sm font-bold text-noche">Apellidos</label>
                            <input id="apellidos" name="apellidos" value="{{ old('apellidos', $cuenta->apellidos) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                            @error('apellidos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="fechaNacimiento" class="mb-1 block text-sm font-bold text-noche">Fecha de nacimiento</label>
                            <input id="fechaNacimiento" name="fechaNacimiento" type="date" value="{{ substr((string) old('fechaNacimiento', $cuenta->fechaNacimiento), 0, 10) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                            @error('fechaNacimiento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="tipoDocumento" class="mb-1 block text-sm font-bold text-noche">Tipo de documento</label>
                            <select id="tipoDocumento" name="tipoDocumento" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                                @foreach (['CC' => 'Cédula de ciudadanía', 'CE' => 'Cédula de extranjería', 'PPT' => 'PPT', 'PEP' => 'PEP', 'PASAPORTE' => 'Pasaporte'] as $valor => $etiqueta)
                                    <option value="{{ $valor }}" @selected(old('tipoDocumento', $cuenta->tipoDocumento) === $valor)>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                            @error('tipoDocumento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="numeroDocumento" class="mb-1 block text-sm font-bold text-noche">Número de documento</label>
                            <input id="numeroDocumento" name="numeroDocumento" value="{{ old('numeroDocumento', $cuenta->numeroDocumento) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                            @error('numeroDocumento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="telefono" class="mb-1 block text-sm font-bold text-noche">Teléfono</label>
                            <input id="telefono" name="telefono" value="{{ old('telefono', $cuenta->telefono) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                            @error('telefono') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif
                    <div class="sm:col-span-2">
                        <label for="email" class="mb-1 block text-sm font-bold text-noche">Correo electrónico</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $cuenta->email) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-marca focus:outline-none focus:ring-2 focus:ring-marca/20">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                <a href="{{ route('Publico.ofertas') }}" class="rounded-full border-2 border-slate-800 px-6 py-3 text-center text-sm font-bold text-slate-800 transition hover:bg-slate-800 hover:text-white">Cancelar</a>
                <button type="submit" class="rounded-full border-2 border-marca bg-marca px-6 py-3 text-sm font-extrabold text-noche transition hover:border-carbon hover:bg-carbon hover:text-white">Guardar cambios</button>
            </div>
        </form>
    </div>
</section>
@endsection
