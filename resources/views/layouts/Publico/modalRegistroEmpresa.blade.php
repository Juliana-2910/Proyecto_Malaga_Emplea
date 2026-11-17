{{-- MODAL: REGISTRO EMPRESA --}}
{{-- Uso: @include('layouts.Publico.modalRegistroEmpresa')  ·  Abrir con abrirModalRegistro('empresa') --}}
@include('layouts.Publico.registroBase')

@php
    $campoRegistro = 'campo-registro w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none';
    $etiquetaRegistro = 'mb-1 block text-xs font-semibold text-noche';
    $btnPrimario = 'rounded-full border-2 border-marca bg-marca px-5 py-3 text-sm font-extrabold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white';
@endphp

<div id="modalRegistroEmpresa"
    class="modal-registro fixed inset-0 z-[100] hidden items-center justify-center bg-noche/80 px-3 py-4 backdrop-blur-md"
    role="dialog" aria-modal="true" aria-labelledby="tituloModalEmpresa">

    <div class="modal-registro-contenido relative flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl border border-white/70 bg-fondo shadow-2xl shadow-noche/40">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
            <div>
                <h2 id="tituloModalEmpresa" class="text-lg font-extrabold text-noche">Crear Cuenta Empresarial</h2>
                <p class="text-xs text-slate-500">Registra tu negocio y conecta con nuevos talentos.</p>
            </div>

            <button type="button" onclick="cerrarModalRegistro()" aria-label="Cerrar modal"
                class="flex size-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-carbon">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- INDICADOR DE ETAPA --}}
        <div class="flex gap-1.5 px-5 pt-4">
            <span class="h-1 flex-1 rounded-full bg-slate-200 transition-all"></span>
            <span class="h-1 flex-1 rounded-full bg-marca transition-all"></span>
        </div>

        {{-- CONTENIDO --}}
        <div data-contenido-registro class="overflow-y-auto p-5 sm:p-6">
            <div class="etapa-animacion">

                <button type="button" onclick="abrirModalRegistro()"
                    class="mb-4 flex items-center gap-1.5 text-xs font-semibold text-slate-500 transition hover:text-carbon">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Cambiar tipo de cuenta
                </button>

                {{-- FORMULARIO EMPRESA --}}
                <form id="formRegistroEmpresa" class="space-y-4">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="registroNombreEmpresa" class="{{ $etiquetaRegistro }}">Nombre de la empresa</label>
                            <input id="registroNombreEmpresa" name="nombreEmpresa" type="text" required class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroNit" class="{{ $etiquetaRegistro }}">NIT</label>
                            <input id="registroNit" name="nit" type="text" required class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroDireccion" class="{{ $etiquetaRegistro }}">Dirección</label>
                            <input id="registroDireccion" name="direccion" type="text" required class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroEmailEmpresa" class="{{ $etiquetaRegistro }}">Correo electrónico</label>
                            <input id="registroEmailEmpresa" name="email" type="email" required autocomplete="email" class="{{ $campoRegistro }}">
                        </div>

                        @include('layouts.Publico.registroCampoPassword', ['id' => 'registroPasswordEmpresa'])
                    </div>

                    <button type="submit" class="{{ $btnPrimario }} w-full">Crear cuenta</button>
                </form>
            </div>
        </div>

        {{-- PIE --}}
        <div class="border-t border-slate-200 bg-white px-5 py-3 text-center">
            <p class="text-[11px] text-slate-500">Málaga Emplea · Conectando oportunidades en nuestra región.</p>
        </div>
    </div>
</div>

<script>
    // Registrar empresa
    document.getElementById('formRegistroEmpresa').addEventListener('submit', function (e) {
        e.preventDefault();
        enviarRegistro(this, "{{ route('registro.empresa') }}");
    });
</script>
