@props(['showLogout' => true])

@php
    $cuenta = request()->user();
    $nombreCuenta = $cuenta?->nombreEmpresa
        ?? trim(($cuenta?->nombres ?? '') . ' ' . ($cuenta?->apellidos ?? ''));
    $nombreCuenta = $nombreCuenta ?: 'Mi cuenta';
    $esEmpresa = $cuenta instanceof \App\Models\Empresa;
    $foto = $cuenta?->fotoPerfil
        ? asset('storage/' . ($esEmpresa ? 'empresas/' . $cuenta->fotoPerfil : $cuenta->fotoPerfil))
        : null;
    $inicial = mb_strtoupper(mb_substr($nombreCuenta, 0, 1));
    $puedeVerPerfil = ! $esEmpresa || $cuenta->can('ver perfil');
    $puedeEditarPerfil = ! $esEmpresa || $cuenta->can('editar perfil');
    $puedeVerCalificaciones = ! $esEmpresa || $cuenta->can('ver calificacion');
@endphp

<div x-data="{
    open: false,
    modalAbierto: null,
    cargandoCalificaciones: false,
    errorCalificaciones: false,
    htmlCalificaciones: '',
    async abrirCalificaciones() {
        this.open = false;
        this.modalAbierto = 'calificaciones';
        if (this.htmlCalificaciones) return;
        this.cargandoCalificaciones = true;
        this.errorCalificaciones = false;
        try {
            const respuesta = await fetch('{{ route('perfil.calificaciones') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!respuesta.ok) throw new Error('No fue posible cargar el historial.');
            this.htmlCalificaciones = await respuesta.text();
        } catch (error) {
            this.errorCalificaciones = true;
        } finally {
            this.cargandoCalificaciones = false;
        }
    }
}" x-effect="document.body.style.overflow = modalAbierto ? 'hidden' : ''" @keydown.escape.window="modalAbierto = null" class="relative">
    <button type="button" @click="open = !open" @click.outside="open = false" :aria-expanded="open.toString()" aria-haspopup="true" class="flex max-w-[min(72vw,320px)] items-center gap-2 rounded-full p-1.5 pr-3 text-left transition hover:bg-[#EAF6FD] focus:outline-none focus:ring-2 focus:ring-marca">
        @if ($foto)
            <img src="{{ $foto }}" alt="Foto de {{ $nombreCuenta }}" class="size-10 shrink-0 rounded-full border-2 border-[#EAF6FD] object-cover">
        @else
            <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-noche text-sm font-extrabold text-white">{{ $inicial }}</span>
        @endif
        <span class="min-w-0 truncate text-sm font-extrabold text-noche">{{ $nombreCuenta }}</span>
        <svg class="size-4 shrink-0 text-slate-500 transition" :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
    </button>

    <div x-show="open" x-cloak x-transition @click.outside="open = false" class="absolute right-0 z-50 mt-2 w-60 overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 shadow-xl shadow-noche/15">
        @if ($puedeVerPerfil || $puedeEditarPerfil)<button type="button" @click="open = false; modalAbierto = 'perfil'" class="block w-full rounded-xl px-4 py-3 text-left text-sm font-bold text-noche transition hover:bg-[#EAF6FD]">Mi perfil</button>@endif
        @if ($puedeVerCalificaciones)<button type="button" @click="abrirCalificaciones()" class="block w-full rounded-xl px-4 py-3 text-left text-sm font-bold text-noche transition hover:bg-[#EAF6FD]">Mis calificaciones</button>@endif
        @if ($showLogout)
            <hr class="my-1 border-slate-100">
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="block w-full rounded-xl px-4 py-3 text-left text-sm font-bold text-red-600 transition hover:bg-red-50">Cerrar sesión</button>
            </form>
        @endif
    </div>

    @if ($puedeVerPerfil || $puedeEditarPerfil)<div x-show="modalAbierto === 'perfil'" x-cloak x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center bg-noche/65 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="perfil-modal-titulo" @click.self="modalAbierto = null">
        <section x-transition class="w-full max-w-md overflow-hidden rounded-[24px] bg-white shadow-2xl">
            <div class="h-2 bg-gradient-to-r from-marca to-[#A9DDF5]"></div>
            <div class="p-6 text-center sm:p-8">
                @if ($foto)
                    <img src="{{ $foto }}" alt="Foto de {{ $nombreCuenta }}" class="mx-auto size-24 rounded-full border-4 border-[#EAF6FD] object-cover">
                @else
                    <span class="mx-auto flex size-24 items-center justify-center rounded-full bg-noche text-3xl font-extrabold text-white">{{ $inicial }}</span>
                @endif
                <h2 id="perfil-modal-titulo" class="mt-4 text-2xl font-extrabold text-noche">Mi perfil</h2>
                <p class="mt-1 font-bold text-slate-700">{{ $nombreCuenta }}</p>
                <p class="mt-1 break-all text-sm text-slate-500">{{ $cuenta?->email }}</p>
                <div class="mt-6 flex flex-col-reverse justify-center gap-3 sm:flex-row">
                    <button type="button" @click="modalAbierto = null" class="rounded-full border-2 border-slate-300 px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50">Cerrar</button>
                    @if ($puedeEditarPerfil)<a href="{{ route('perfil.editar') }}" class="rounded-full border-2 border-marca bg-marca px-5 py-3 text-sm font-extrabold text-noche transition hover:border-carbon hover:bg-carbon hover:text-white">Editar perfil</a>@endif
                </div>
            </div>
        </section>
    </div>@endif

    <div x-show="modalAbierto === 'calificaciones'" x-cloak x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center bg-noche/65 p-3 backdrop-blur-sm sm:p-6" role="dialog" aria-modal="true" aria-labelledby="calificaciones-modal-titulo" @click.self="modalAbierto = null">
        <section x-transition class="flex max-h-[92vh] w-full max-w-4xl flex-col overflow-hidden rounded-[24px] bg-[#F8FBFD] shadow-2xl">
            <header class="flex items-start justify-between gap-4 bg-noche px-5 py-5 text-white sm:px-7">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-[#A9DDF5]">Tu experiencia</p>
                    <h2 id="calificaciones-modal-titulo" class="mt-1 text-2xl font-extrabold">Mis calificaciones</h2>
                    <p class="mt-1 text-sm text-slate-300">Historial de contrataciones completadas</p>
                </div>
                <button type="button" @click="modalAbierto = null" aria-label="Cerrar calificaciones" class="flex size-10 shrink-0 items-center justify-center rounded-full text-white transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
                </button>
            </header>
            <div class="min-h-0 overflow-y-auto p-4 sm:p-6">
                <div x-show="cargandoCalificaciones" class="py-12 text-center text-sm font-semibold text-slate-500">Cargando tu historial...</div>
                <div x-show="errorCalificaciones" class="rounded-xl bg-red-50 p-4 text-sm font-semibold text-red-700">No pudimos cargar tus calificaciones. Cierra y vuelve a intentarlo.</div>
                <div x-show="!cargandoCalificaciones && !errorCalificaciones" x-html="htmlCalificaciones"></div>
            </div>
        </section>
    </div>
</div>
