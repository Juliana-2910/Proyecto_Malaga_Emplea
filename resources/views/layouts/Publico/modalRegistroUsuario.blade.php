{{-- MODAL: REGISTRO PERSONA NATURAL --}}
{{-- Uso: @include('layouts.Publico.modalRegistroUsuario')  ·  Abrir con abrirModalRegistro('usuario') --}}
@include('layouts.Publico.registroBase')

@php
    $campoRegistro = 'campo-registro w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none';
    $etiquetaRegistro = 'mb-1 block text-xs font-semibold text-noche';
    $btnPrimario = 'rounded-full border-2 border-marca bg-marca px-5 py-3 text-sm font-extrabold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white';
@endphp

<div id="modalRegistroUsuario"
    class="modal-registro fixed inset-0 z-[100] hidden items-center justify-center bg-noche/80 px-3 py-4 backdrop-blur-md"
    role="dialog" aria-modal="true" aria-labelledby="tituloModalUsuario">

    <div class="modal-registro-contenido relative flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl border border-white/70 bg-fondo shadow-2xl shadow-noche/40">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
            <div>
                <h2 id="tituloModalUsuario" class="text-lg font-extrabold text-noche">Crear Cuenta Personal</h2>
                <p class="text-xs text-slate-500">Completa tus datos para comenzar.</p>
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

                {{-- FORMULARIO PERSONA NATURAL --}}
                <form id="formRegistroUsuario" class="space-y-4">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label for="registroNombres" class="{{ $etiquetaRegistro }}">Nombres</label>
                            <input id="registroNombres" name="nombres" type="text" required autocomplete="given-name" class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroApellidos" class="{{ $etiquetaRegistro }}">Apellidos</label>
                            <input id="registroApellidos" name="apellidos" type="text" required autocomplete="family-name" class="{{ $campoRegistro }}">
                        </div>

                        {{-- FECHA DE NACIMIENTO --}}
                        <div>
                            <label for="registroFecha" class="{{ $etiquetaRegistro }}">Fecha de nacimiento</label>
                                <div class="relative flex items-center">                               <input id="registroFecha" name="fechaNacimiento" type="date" required
                                    min="1900-01-01" max="{{ date('Y-m-d') }}"
                                    class="{{ $campoRegistro }}"
                                    style="padding-right:54px">

                                <button id="registroAbrirCalendario" type="button"
                                    aria-label="Abrir calendario de fecha de nacimiento"
                                    title="Elegir fecha en el calendario"
                                    style="position:absolute;right:6px;top:50%;transform:translateY(-50%);width:40px;height:40px;border:0;border-radius:9px;background:transparent;color:#52606D;display:flex;align-items:center;justify-content:center;cursor:pointer">
                                    <svg width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                                        <path d="M16 3v4M8 3v4M3 10h18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="registroTipoDocumento" class="{{ $etiquetaRegistro }}">Tipo de documento</label>
                            <select id="registroTipoDocumento" name="tipoDocumento" required class="{{ $campoRegistro }}">
                                <option value="">Seleccionar</option>
                                <option value="CC">Cédula de ciudadanía</option>
                                <option value="CE">Cédula de extranjería</option>
                                <option value="PPT">PPT</option>
                                <option value="PEP">PEP</option>
                                <option value="PASAPORTE">Pasaporte</option>
                            </select>
                        </div>

                        <div>
                            <label for="registroDocumento" class="{{ $etiquetaRegistro }}">Número de documento</label>
                            <input id="registroDocumento" name="numeroDocumento" type="text" required class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroTelefono" class="{{ $etiquetaRegistro }}">Teléfono</label>
                            <input id="registroTelefono" name="telefono" type="tel" required autocomplete="tel" class="{{ $campoRegistro }}">
                        </div>

                        <div>
                            <label for="registroEmailUsuario" class="{{ $etiquetaRegistro }}">Correo electrónico</label>
                            <input id="registroEmailUsuario" name="email" type="email" required autocomplete="email" class="{{ $campoRegistro }}">
                        </div>

                        @include('layouts.Publico.registroCampoPassword', ['id' => 'registroPasswordUsuario'])
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
    // Abrir el calendario de fecha de nacimiento
    document.getElementById('registroAbrirCalendario').addEventListener('click', function () {
        const fechaNacimiento = document.getElementById('registroFecha');

        if (typeof fechaNacimiento.showPicker === 'function') {
            fechaNacimiento.showPicker();
        } else {
            fechaNacimiento.focus();
            fechaNacimiento.click();
        }
    });

    // Registrar persona natural
    document.getElementById('formRegistroUsuario').addEventListener('submit', function (e) {
        e.preventDefault();
        enviarRegistro(this, "{{ route('registro.usuario') }}");
    });
</script>
