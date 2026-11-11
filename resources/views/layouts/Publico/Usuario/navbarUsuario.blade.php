@php
    // Nombre del usuario que inició sesión (lo envía el controlador).
    $nombre = $nombre ?? 'Usuario';

    $activo = 'border-b-[3px] border-marca text-marca-texto';
    $inactivo = 'transition hover:text-marca-texto';
@endphp

{{-- NAVBAR --}}
<header class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-x-6 gap-y-3 px-6 py-2.5">

        <a href="{{ route('Publico.ofertas') }}" class="flex items-center gap-3 text-xl font-extrabold text-noche">
            <img src="{{ asset('images/Logo Malaga Emplea.png') }}" alt="Logo de Málaga Emplea" class="size-14 object-contain">
            Málaga Emplea
        </a>

        <nav class="hidden items-center gap-7 text-[15px] font-semibold md:flex">
            <a href="{{ url('/empleos') }}" class="py-3 {{ request()->is('empleos') ? $activo : $inactivo }}">Ofertas</a>
            @unless (auth('empresa')->check())
                <a href="{{ url('/mis-postulaciones') }}" class="py-3 {{ request()->is('mis-postulaciones') ? $activo : $inactivo }}">Mis postulaciones</a>
            @endunless
            <a href="{{ url('/mis-ofertas') }}" class="py-3 {{ request()->is('mis-ofertas') ? $activo : $inactivo }}">Mis ofertas</a>
        </nav>

        <div class="flex flex-wrap items-center gap-3">

            <x-header.user-dropdown :show-logout="false" />

            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" aria-label="Cerrar sesión" title="Cerrar sesión"
                        class="flex size-11 items-center justify-center rounded-xl border-2 border-slate-800 bg-white text-slate-800 transition hover:border-carbon hover:bg-carbon hover:text-white">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <details class="border-t border-slate-100 px-6 py-2 md:hidden">
        <summary class="cursor-pointer py-2 text-sm font-bold text-noche">Navegación</summary>
        <nav class="flex flex-col gap-1 pb-2 text-sm font-semibold" aria-label="Navegación móvil">
            <a href="{{ route('Publico.ofertas') }}" class="rounded-lg px-3 py-2 {{ request()->is('empleos') ? 'bg-[#EAF6FD] text-marca-texto' : 'text-slate-700' }}">Ofertas</a>
            @unless (auth('empresa')->check())
                <a href="{{ route('Publico.postulaciones') }}" class="rounded-lg px-3 py-2 {{ request()->is('mis-postulaciones') ? 'bg-[#EAF6FD] text-marca-texto' : 'text-slate-700' }}">Mis postulaciones</a>
            @endunless
            <a href="{{ route('Publico.misOfertas') }}" class="rounded-lg px-3 py-2 {{ request()->is('mis-ofertas*') ? 'bg-[#EAF6FD] text-marca-texto' : 'text-slate-700' }}">Mis ofertas</a>
        </nav>
    </details>
</header>
