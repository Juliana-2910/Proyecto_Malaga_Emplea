{{-- MODAL: SELECCIÓN DEL TIPO DE CUENTA --}}
{{-- Uso: @include('layouts.Publico.modal-registro-tipo')  ·  Abrir con abrirModalRegistro() --}}
@include('layouts.Publico.registroBase')

<div id="modalRegistroTipo"
    class="modal-registro fixed inset-0 z-[100] hidden items-center justify-center bg-noche/80 px-3 py-4 backdrop-blur-md"
    role="dialog" aria-modal="true" aria-labelledby="tituloModalTipo">

    <div class="modal-registro-contenido relative flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl border border-white/70 bg-fondo shadow-2xl shadow-noche/40">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
            <div>
                <h2 id="tituloModalTipo" class="text-lg font-extrabold text-noche">Crear una cuenta</h2>
                <p class="text-xs text-slate-500">Elige cómo quieres participar en Málaga Emplea.</p>
            </div>

            <button type="button" onclick="cerrarModalRegistro()" aria-label="Cerrar modal"
                class="flex size-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-carbon">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- INDICADOR DE ETAPA --}}
        <div class="flex gap-1.5 px-5 pt-4">
            <span class="h-1 flex-1 rounded-full bg-marca transition-all"></span>
            <span class="h-1 flex-1 rounded-full bg-slate-200 transition-all"></span>
        </div>

        {{-- CONTENIDO --}}
        <div data-contenido-registro class="overflow-y-auto p-5 sm:p-6">
            <div class="etapa-animacion">
                <div class="mb-4">
                    <p class="text-sm font-bold text-noche">¿Cómo deseas registrarte?</p>
                    <p class="mt-1 text-xs text-slate-500">Selecciona el tipo de cuenta que mejor se adapte a ti.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <button type="button" onclick="abrirModalRegistro('usuario')"
                        class="tarjeta-registro group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 text-left transition">

                        {{-- ICONO ORIGINAL PERSONA NATURAL: SE CONSERVA --}}
                        <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto transition group-hover:bg-marca group-hover:text-tinta">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/></svg>
                        </span>

                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-bold text-noche">Persona Natural</span>
                            <span class="mt-1 block text-xs leading-relaxed text-slate-500">Busca empleo y crea tu hoja de vida.</span>
                        </span>

                        {{-- FLECHA --}}
                        <svg class="size-4 shrink-0 text-gray-400 transition duration-300 group-hover:translate-x-1 group-hover:text-noche"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <button type="button" onclick="abrirModalRegistro('empresa')"
                        class="tarjeta-registro group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 text-left transition">

                        {{-- ICONO ORIGINAL EMPRESA: SE CONSERVA --}}
                        <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#EAF6FD] text-marca-texto transition group-hover:bg-marca group-hover:text-tinta">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/></svg>
                        </span>

                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-bold text-noche">Empresa</span>
                            <span class="mt-1 block text-xs leading-relaxed text-slate-500">Publica vacantes y encuentra talento.</span>
                        </span>

                        {{-- FLECHA --}}
                        <svg class="size-4 shrink-0 text-gray-400 transition duration-300 group-hover:translate-x-1 group-hover:text-noche"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- PIE --}}
        <div class="border-t border-slate-200 bg-white px-5 py-3 text-center">
            <p class="text-[11px] text-slate-500">Málaga Emplea · Conectando oportunidades en nuestra región.</p>
        </div>
    </div>
</div>

<style>
    /* Tarjetas de selección de registro */
    .tarjeta-registro {
        position: relative;
        overflow: hidden;
        border: 1px solid #E2E8F0;
        transition:
            transform .3s ease,
            border-color .3s ease,
            box-shadow .3s ease;
    }

    .tarjeta-registro:hover {
        transform: translateY(-4px);
        border-color: #4DB6E8;
        box-shadow: 0 10px 25px rgba(15, 42, 61, .10);
    }

    /* Franja luminosa que cruza la tarjeta */
    .tarjeta-registro::after {
        content: "";
        position: absolute;
        top: 0;
        left: -120%;
        width: 70%;
        height: 100%;
        background: linear-gradient(
            100deg,
            transparent,
            rgba(77, 182, 232, .15),
            transparent
        );
        transition: left .6s ease;
        pointer-events: none;
    }

    .tarjeta-registro:hover::after {
        left: 140%;
    }

    .tarjeta-registro:focus-visible {
        outline: 3px solid rgba(77, 182, 232, .35);
        outline-offset: 3px;
    }

    @media (prefers-reduced-motion: reduce) {
        .tarjeta-registro {
            animation: none !important;
            transition: none !important;
        }

        .tarjeta-registro:hover {
            transform: none;
        }
    }
</style>
