{{-- MODAL EDITAR OFERTA (MIS OFERTAS) --}}
@php
    $bolsaE = $errors->getBag('editarOferta');
    $idReabrir = old('_idOferta', session('abrirEditarOferta'));
    $reabrirE = $idReabrir && ($bolsaE->any() || session('abrirEditarOferta'));
    $vE = fn ($campo) => $reabrirE ? old($campo, '') : '';
    $errE = fn ($campo) => $bolsaE->first($campo);

    $campoE = 'font-family:inherit;font-size:15px;padding:12px 14px;border:1.5px solid #CBD2D9;border-radius:10px;color:#1F2933;background:#FFFFFF;width:100%;box-sizing:border-box';
    $labelE = 'display:flex;flex-direction:column;gap:6px;font-size:13px;font-weight:500;color:#52606D';
    $errorE = 'font-size:12px;font-weight:600;color:#B42318';
@endphp

<div id="modal-editar-oferta" hidden
    data-abrir-al-cargar="{{ $reabrirE ? '1' : '0' }}" data-id-reabrir="{{ $reabrirE ? $idReabrir : '' }}"
    style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:56;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
    <div role="dialog" aria-modal="true" aria-labelledby="eo-titulo"
        style="width:100%;max-width:720px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

        {{-- Encabezado --}}
        <div style="padding:28px 28px 20px;display:flex;align-items:flex-start;gap:16px;border-bottom:1px solid #E3E8EF">
            <span style="width:56px;height:56px;border-radius:14px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
            </span>
            <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:4px">
                <h2 id="eo-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25">Editar oferta</h2>
                <span style="font-size:15px;line-height:1.5;color:#52606D">Cambia lo que necesites. Las personas que se postulen verán la información actualizada.</span>
            </div>
            <button type="button" data-cerrar-editar-oferta aria-label="Cerrar"
                    style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="eo-form" method="POST" action="#" data-base="{{ url('/mis-ofertas') }}"
                style="margin:0;display:flex;flex-direction:column;min-height:0;flex:1 1 auto">
            @csrf
            @method('PUT')
            <input type="hidden" name="_origen" value="publico">
            <input type="hidden" name="_idOferta" value="{{ $reabrirE ? $idReabrir : '' }}">
            {{-- TEMPORAL: cuando exista el login, este campo se quita y el usuario sale de la sesión --}}
            @if (! empty($idUsuario))
                <input type="hidden" name="idUsuario" value="{{ $idUsuario }}">
            @endif

            <div style="padding:24px 28px;display:flex;flex-direction:column;gap:20px;overflow:auto">

                @include('layouts.Publico.avisosModal')

                <label style="{{ $labelE }}">Título de la oferta
                    <input type="text" name="titulo" maxlength="150" placeholder="Ej.: Auxiliar de cocina"
                            value="{{ $vE('titulo') }}" style="{{ $campoE }}">
                    @if ($errE('titulo')) <span data-eo-error style="{{ $errorE }}">{{ $errE('titulo') }}</span> @endif
                </label>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px">
                    <label style="{{ $labelE }}">Categoría
                        <select id="eo-categoria" name="idCategoria" style="{{ $campoE }};min-height:46px">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                        @if ($errE('idCategoria')) <span data-eo-error style="{{ $errorE }}">{{ $errE('idCategoria') }}</span> @endif
                    </label>

                    <label style="{{ $labelE }}">Servicio
                        <select id="eo-servicio" name="idServicio" style="{{ $campoE }};min-height:46px"
                                data-servicios="{{ json_encode($servicios) }}"
                                data-viejo="{{ $vE('idServicio') }}">
                            <option value="">Primero elige una categoría</option>
                        </select>
                        <span style="font-weight:500;font-size:12px;color:#7B8794">Se muestran los servicios de la categoría elegida.</span>
                        @if ($errE('idServicio')) <span data-eo-error style="{{ $errorE }}">{{ $errE('idServicio') }}</span> @endif
                    </label>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px">
                    <label style="{{ $labelE }}">Salario (COP)
                        <div style="display:flex;align-items:center;border:1.5px solid #CBD2D9;border-radius:10px;background:#FFFFFF;overflow:hidden">
                            <span style="padding:0 0 0 14px;font-size:15px;font-weight:700;color:#7B8794">$</span>
                            <input type="text" id="eo-salario" name="salario" inputmode="numeric" placeholder="1.300.000"
                                    value="{{ $vE('salario') }}"
                                    style="flex:1 1 auto;min-width:0;font-family:inherit;font-size:15px;padding:12px 14px 12px 6px;border:none;outline:none;color:#1F2933;background:transparent">
                        </div>
                        @if ($errE('salario')) <span data-eo-error style="{{ $errorE }}">{{ $errE('salario') }}</span> @endif
                    </label>

                    <label style="{{ $labelE }}">Tipo de contrato
                        <select name="tipoContrato" style="{{ $campoE }};min-height:46px">
                            <option value="">Selecciona una opción</option>
                            @foreach ($contratos as $valor => $texto)
                                <option value="{{ $valor }}" @selected($vE('tipoContrato') === $valor)>{{ $texto }}</option>
                            @endforeach
                        </select>
                        @if ($errE('tipoContrato')) <span data-eo-error style="{{ $errorE }}">{{ $errE('tipoContrato') }}</span> @endif
                    </label>
                </div>

                <label style="{{ $labelE }}">Dirección
                    <div style="display:flex;align-items:center;gap:8px;border:1.5px solid #d7d9cb;border-radius:10px;background:#FFFFFF;padding:0 14px">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7B8794" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <input type="text" name="ubicacion" maxlength="255" placeholder="Ej.: Calle 10 #5-20, Málaga"
                                value="{{ $vE('ubicacion') }}"
                                style="flex:1 1 auto;min-width:0;font-family:inherit;font-size:15px;padding:12px 0;border:none;outline:none;color:#1F2933;background:transparent">
                    </div>
                    @if ($errE('ubicacion')) <span data-eo-error style="{{ $errorE }}">{{ $errE('ubicacion') }}</span> @endif
                </label>

                <label style="{{ $labelE }}">Descripción
                    <textarea name="descripcion" rows="4" placeholder="Qué hará la persona, horarios, condiciones del trabajo"
                                style="{{ $campoE }};line-height:1.5;resize:vertical">{{ $vE('descripcion') }}</textarea>
                    @if ($errE('descripcion')) <span data-eo-error style="{{ $errorE }}">{{ $errE('descripcion') }}</span> @endif
                </label>

                <label style="{{ $labelE }}">
                    <span style="display:flex;justify-content:space-between;gap:12px">
                        <span>Requisitos</span>
                        <span style="font-weight:600;color:#7B8794">Escribe uno por línea</span>
                    </span>
                    <textarea name="requisitos" rows="4" placeholder="Experiencia mínima de 6 meses&#10;Disponibilidad de fines de semana"
                                style="{{ $campoE }};line-height:1.5;resize:vertical">{{ $vE('requisitos') }}</textarea>
                    @if ($errE('requisitos')) <span data-eo-error style="{{ $errorE }}">{{ $errE('requisitos') }}</span> @endif
                </label>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;align-items:end">
                    <label style="{{ $labelE }}">Fecha límite para postularse
                        <input type="date" name="fechaLimite" min="{{ now('America/Bogota')->toDateString() }}"
                                value="{{ $vE('fechaLimite') }}" style="{{ $campoE }}">
                        @if ($errE('fechaLimite')) <span data-eo-error style="{{ $errorE }}">{{ $errE('fechaLimite') }}</span> @endif
                    </label>

                    <div style="background:#EAF6FD;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;font-size:13px;line-height:1.45;color:#12303F">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto"><path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        <span>La fecha de publicación <strong>no cambia</strong> al editar.</span>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div style="padding:18px 28px;border-top:1px solid #E3E8EF;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;background:#FFFFFF">
                <button type="button" data-cerrar-editar-oferta class="{{ $btnSecundario }} cursor-pointer">Cancelar</button>
                <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Modal editar oferta //

    (function () {
        const modal = document.getElementById('modal-editar-oferta');
        const form = document.getElementById('eo-form');
        const categoria = document.getElementById('eo-categoria');
        const servicio = document.getElementById('eo-servicio');
        const salario = document.getElementById('eo-salario');
        const servicios = JSON.parse(servicio.dataset.servicios);
        let botonOrigen = null;

        // El servicio depende de la categoría elegida
        function llenarServicios(idCategoria, seleccionado) {
            const lista = servicios.filter(function (s) { return String(s.idCategoria) === String(idCategoria); });
            servicio.replaceChildren();

            const base = document.createElement('option');
            base.value = '';
            base.textContent = !idCategoria ? 'Primero elige una categoría'
                : (lista.length ? 'Selecciona un servicio' : 'Esta categoría no tiene servicios');
            servicio.appendChild(base);

            lista.forEach(function (s) {
                const op = document.createElement('option');
                op.value = s.id;
                op.textContent = s.nombre;
                if (String(s.id) === String(seleccionado)) op.selected = true;
                servicio.appendChild(op);
            });
            servicio.disabled = !lista.length;
        }

        categoria.addEventListener('change', function () { llenarServicios(categoria.value, ''); });

        // Salario con puntos de miles mientras se escribe
        function formatearSalario() {
            const digitos = salario.value.replace(/\D/g, '');
            salario.value = digitos ? Number(digitos).toLocaleString('es-CO') : '';
        }
        salario.addEventListener('input', formatearSalario);

        function poner(nombre, valor) {
            form.elements[nombre].value = valor ?? '';
        }

        function mostrar() {
            modal.hidden = false;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            form.elements['titulo'].focus();
        }

        function cerrar() {
            modal.hidden = true;
            modal.style.display = 'none';
            document.body.style.overflow = '';
            if (botonOrigen) botonOrigen.focus();
        }

        // Abre el formulario con los datos actuales de la oferta
        function abrirConDatos(o, boton) {
            botonOrigen = boton || null;

            // Quita errores de un intento anterior
            modal.querySelectorAll('[data-eo-error]').forEach(function (el) { el.remove(); });

            form.action = form.dataset.base + '/' + o.id;
            poner('_idOferta', o.id);
            poner('titulo', o.titulo);
            poner('descripcion', o.descripcion);
            poner('requisitos', o.requisitos);
            poner('tipoContrato', o.tipoContrato);
            poner('ubicacion', o.ubicacion);
            poner('fechaLimite', o.fechaLimite);

            salario.value = o.salario != null ? String(Math.round(Number(o.salario))) : '';
            formatearSalario();

            categoria.value = o.idCategoria ?? '';
            llenarServicios(o.idCategoria ?? '', o.idServicio ?? '');

            mostrar();
        }

        // Si el servidor devolvió el formulario con datos (error), se restauran categoría y servicio
        const viejo = servicio.dataset.viejo;
        if (viejo) {
            const s = servicios.find(function (x) { return String(x.id) === String(viejo); });
            if (s) { categoria.value = s.idCategoria; llenarServicios(s.idCategoria, viejo); }
        } else {
            llenarServicios('', '');
        }
        formatearSalario();

        if (modal.dataset.abrirAlCargar === '1') {
            form.action = form.dataset.base + '/' + modal.dataset.idReabrir;
            mostrar();
        }

        document.addEventListener('click', function (e) {
            const boton = e.target.closest('[data-editar-oferta]');
            if (boton) { abrirConDatos(JSON.parse(boton.dataset.editarOferta), boton); return; }
            if (e.target.closest('[data-cerrar-editar-oferta]') || e.target === modal) cerrar();
        });

        // Lo lanza el modal "Ver oferta" al pulsar "Editar oferta"
        document.addEventListener('editar-oferta', function (e) { abrirConDatos(e.detail, null); });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) cerrar();
        });
    })();
</script>
@endpush
