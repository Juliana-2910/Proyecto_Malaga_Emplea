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
        @if (session('error'))
            <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">{{ session('error') }}</div>
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
                        <img id="foto-preview" data-foto-original="{{ $rutaFoto }}" src="{{ $rutaFoto ?? '' }}" alt="Foto de {{ $nombre }}" class="{{ $rutaFoto ? '' : 'hidden' }} size-full object-cover">
                        <span id="foto-inicial" class="{{ $rutaFoto ? 'hidden' : '' }}">{{ mb_strtoupper(mb_substr($nombre, 0, 1)) }}</span>
                    </div>
                    <label for="fotoPerfil" class="cursor-pointer rounded-full border-2 border-marca px-4 py-2 text-sm font-bold text-noche transition hover:bg-[#EAF6FD]">Cambiar foto</label>
                    <input id="fotoPerfil" name="fotoPerfil" type="file" accept="image/jpeg,image/png" class="sr-only">
                    <span id="foto-nombre" class="max-w-full break-all text-center text-xs font-semibold text-slate-600">{{ $cuenta->fotoPerfil ? basename($cuenta->fotoPerfil) : 'Ningún archivo seleccionado' }}</span>
                    @if ($cuenta->fotoPerfil)
                        <label id="eliminar-foto-wrap" class="flex cursor-pointer items-center gap-2 text-sm font-semibold text-red-700"><input type="checkbox" name="eliminarFotoPerfil" value="1" class="rounded border-slate-300 text-red-600"> Eliminar foto actual</label>
                    @endif
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
@if (! $esEmpresa)
<section class="bg-[#EAF6FD] px-4 pb-10 sm:px-6">
    <div class="mx-auto max-w-4xl rounded-[20px] border border-slate-100 bg-white p-5 shadow-lg shadow-noche/10 sm:p-8">
        <div class="mb-5">
            <p class="text-sm font-bold uppercase tracking-wide text-marca-texto">Perfil profesional</p>
            <h2 class="mt-1 text-2xl font-extrabold text-noche">Mi hoja de vida</h2>
            <p class="mt-1 text-sm text-slate-600">Actualiza la información y conserva el PDF actual si no eliges uno nuevo.</p>
        </div>
        <form action="{{ route('Publico.guardarHojaDeVida') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
            @csrf
            <input type="hidden" name="volverPerfil" value="1">
            <div><label class="mb-1 block text-sm font-bold text-noche" for="hv-ubicacion">Ubicación</label><input id="hv-ubicacion" name="ubicacion" required maxlength="255" value="{{ old('ubicacion', $hojaDeVida?->ubicacion) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3">@error('ubicacion')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="mb-1 block text-sm font-bold text-noche" for="hv-nivel">Nivel educativo</label><select id="hv-nivel" name="nivelEducativo" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3"><option value="">Selecciona</option>@foreach (['Basica Primaria'=>'Básica primaria','Basica Secundaria'=>'Básica secundaria','Tecnico'=>'Técnico','Tecnologo'=>'Tecnólogo','Profesional'=>'Profesional'] as $valor=>$texto)<option value="{{ $valor }}" @selected(old('nivelEducativo', $hojaDeVida?->nivelEducativo) === $valor)>{{ $texto }}</option>@endforeach</select>@error('nivelEducativo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2"><label class="mb-1 block text-sm font-bold text-noche" for="hv-perfil">Perfil profesional</label><textarea id="hv-perfil" name="perfilProfesional" required maxlength="255" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('perfilProfesional', $hojaDeVida?->perfilProfesional) }}</textarea>@error('perfilProfesional')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2"><label class="mb-1 block text-sm font-bold text-noche" for="hv-experiencia">Experiencia laboral</label><textarea id="hv-experiencia" name="experienciaLaboral" required maxlength="255" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('experienciaLaboral', $hojaDeVida?->experienciaLaboral) }}</textarea>@error('experienciaLaboral')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2"><label class="mb-1 block text-sm font-bold text-noche" for="archivoCV">Reemplazar PDF (opcional)</label><input id="archivoCV" name="archivoCV" type="file" accept="application/pdf" class="block w-full rounded-xl border border-slate-300 p-3 text-sm"><p class="mt-1 text-xs text-slate-500">PDF · máximo 5 MB</p>@error('archivoCV')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                @if ($hojaDeVida?->archivoCV)<div class="mt-3 flex flex-wrap items-center gap-3 rounded-xl bg-[#EAF6FD] p-3"><span class="min-w-0 flex-1 break-all text-sm font-semibold text-noche">{{ basename($hojaDeVida->archivoCV) }}</span><a href="{{ asset('storage/' . $hojaDeVida->archivoCV) }}" target="_blank" rel="noopener" class="rounded-full border border-marca px-4 py-2 text-sm font-bold text-marca-texto hover:bg-white">Ver PDF</a></div>@else<p class="mt-2 text-sm text-slate-500">Aún no has cargado un PDF.</p>@endif
            </div>
            <div class="sm:col-span-2 flex justify-end"><button type="submit" class="rounded-full border-2 border-marca bg-marca px-6 py-3 text-sm font-extrabold text-noche transition hover:border-carbon hover:bg-carbon hover:text-white">Guardar hoja de vida</button></div>
        </form>
    </div>
</section>
@endif
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('fotoPerfil');
    if (!input) return;
    const preview = document.getElementById('foto-preview');
    const initial = document.getElementById('foto-inicial');
    const filename = document.getElementById('foto-nombre');
    const remove = document.querySelector('input[name="eliminarFotoPerfil"]');
    const original = preview.dataset.fotoOriginal;
    input.addEventListener('change', () => {
        const file = input.files?.[0];
        if (!file) return;
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        initial?.classList.add('hidden');
        filename.textContent = file.name;
        if (remove) remove.checked = false;
    });
    remove?.addEventListener('change', () => {
        if (remove.checked) {
            input.value = '';
            preview.src = '';
            preview.classList.add('hidden');
            if (initial) initial.classList.remove('hidden');
            filename.textContent = 'La foto se eliminará al guardar';
        } else {
            preview.src = original || '';
            preview.classList.toggle('hidden', !original);
            if (initial) initial.classList.toggle('hidden', !!original);
            filename.textContent = original ? original.split('/').pop() : 'Ningún archivo seleccionado';
        }
    });
});
</script>
@endpush
@endsection
