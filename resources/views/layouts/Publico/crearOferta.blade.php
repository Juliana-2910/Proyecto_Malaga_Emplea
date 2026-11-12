{{-- MODAL PUBLICAR UNA OFERTA --}}
@php
    $bolsa = $errors->getBag('crearOferta');
    $reabrir = $bolsa->any() || session('abrirCrearOferta');
    $v = fn ($campo) => $reabrir ? old($campo, '') : '';
    $err = fn ($campo) => $bolsa->first($campo);

    $campoO = 'font-family:inherit;font-size:15px;padding:12px 14px;border:1.5px solid #CBD2D9;border-radius:10px;color:#1F2933;background:#FFFFFF;width:100%;box-sizing:border-box';
    $labelO = 'display:flex;flex-direction:column;gap:6px;font-size:13px;font-weight:500;color:#52606D';
    $errorO = 'font-size:12px;font-weight:600;color:#B42318';
@endphp

<div id="modal-crear-oferta" hidden data-abrir-al-cargar="{{ $reabrir ? '1' : '0' }}"
    style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:55;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
    <div role="dialog" aria-modal="true" aria-labelledby="co-titulo"
        style="width:100%;max-width:720px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

        {{-- Encabezado --}}
        <div style="padding:28px 28px 20px;display:flex;align-items:flex-start;gap:16px;border-bottom:1px solid #E3E8EF">
            <span style="width:56px;height:56px;border-radius:14px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
            </span>
            <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:4px">
                <h2 id="co-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25">Publicar una oferta</h2>
                <span style="font-size:15px;line-height:1.5;color:#52606D">Cuéntanos qué necesitas y recibe postulaciones de personas de Málaga.</span>
            </div>
            <button type="button" data-cerrar-crear-oferta aria-label="Cerrar"
                    style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="co-form" method="POST" action="{{ route('Publico.guardarOferta') }}"
                style="margin:0;display:flex;flex-direction:column;min-height:0;flex:1 1 auto">
            @csrf
            <input type="hidden" name="_origen" value="publico">

            <div style="padding:24px 28px;display:flex;flex-direction:column;gap:20px;overflow:auto">

                @include('layouts.Publico.avisosModal')

                <label style="{{ $labelO }}">Título de la oferta
                    <input type="text" name="titulo" maxlength="150" placeholder="Ej.: Auxiliar de cocina"
                            value="{{ $v('titulo') }}" style="{{ $campoO }}">
                    @if ($err('titulo')) <span style="{{ $errorO }}">{{ $err('titulo') }}</span> @endif
                </label>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px">
                    <label style="{{ $labelO }}">Categoría
                        <select id="co-categoria" name="idCategoria" style="{{ $campoO }};min-height:46px">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                        @if ($err('idCategoria')) <span style="{{ $errorO }}">{{ $err('idCategoria') }}</span> @endif
                    </label>

                    <label style="{{ $labelO }}">Servicio
                        <select id="co-servicio" name="idServicio" style="{{ $campoO }};min-height:46px"
                                data-servicios="{{ json_encode($servicios) }}"
                                data-viejo="{{ $v('idServicio') }}">
                            <option value="">Primero elige una categoría</option>
                        </select>
                        <span style="font-weight:500;font-size:12px;color:#7B8794">Se muestran los servicios de la categoría elegida.</span>
                        @if ($err('idServicio')) <span style="{{ $errorO }}">{{ $err('idServicio') }}</span> @endif
                    </label>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px">
                    <label style="{{ $labelO }}">Salario (COP)
                        <div style="display:flex;align-items:center;border:1.5px solid #CBD2D9;border-radius:10px;background:#FFFFFF;overflow:hidden">
                            <span style="padding:0 0 0 14px;font-size:15px;font-weight:700;color:#7B8794">$</span>
                            <input type="text" id="co-salario" name="salario" inputmode="numeric" placeholder="1.300.000"
                                    value="{{ $v('salario') }}"
                                    style="flex:1 1 auto;min-width:0;font-family:inherit;font-size:15px;padding:12px 14px 12px 6px;border:none;outline:none;color:#1F2933;background:transparent">
                        </div>
                        @if ($err('salario')) <span style="{{ $errorO }}">{{ $err('salario') }}</span> @endif
                    </label>

                    <label style="{{ $labelO }}">Tipo de contrato
                        <select name="tipoContrato" style="{{ $campoO }};min-height:46px">
                            <option value="">Selecciona una opción</option>
                            @foreach ($contratos as $valor => $texto)
                                <option value="{{ $valor }}" @selected($v('tipoContrato') === $valor)>{{ $texto }}</option>
                            @endforeach
                        </select>
                        @if ($err('tipoContrato')) <span style="{{ $errorO }}">{{ $err('tipoContrato') }}</span> @endif
                    </label>
                </div>

                <label style="{{ $labelO }}">Dirección
                    <div style="display:flex;align-items:center;gap:8px;border:1.5px solid #d7d9cb;border-radius:10px;background:#FFFFFF;padding:0 14px">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7B8794" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <input type="text" name="ubicacion" maxlength="255" placeholder="Ej.: Calle 10 #5-20, Málaga"
                                value="{{ $v('ubicacion') }}"
                                style="flex:1 1 auto;min-width:0;font-family:inherit;font-size:15px;padding:12px 0;border:none;outline:none;color:#1F2933;background:transparent">
                    </div>
                    @if ($err('ubicacion')) <span style="{{ $errorO }}">{{ $err('ubicacion') }}</span> @endif
                </label>

                <label style="{{ $labelO }}">Descripción
                    <textarea name="descripcion" rows="4" placeholder="Qué hará la persona, horarios, condiciones del trabajo"
                                style="{{ $campoO }};line-height:1.5;resize:vertical">{{ $v('descripcion') }}</textarea>
                    @if ($err('descripcion')) <span style="{{ $errorO }}">{{ $err('descripcion') }}</span> @endif
                </label>

                <label style="{{ $labelO }}">
                    <span style="display:flex;justify-content:space-between;gap:12px">
                        <span>Requisitos</span>
                        <span style="font-weight:600;color:#7B8794">Escribe uno por línea</span>
                    </span>
                    <textarea name="requisitos" rows="4" placeholder="Experiencia mínima de 6 meses&#10;Disponibilidad de fines de semana"
                                style="{{ $campoO }};line-height:1.5;resize:vertical">{{ $v('requisitos') }}</textarea>
                    @if ($err('requisitos')) <span style="{{ $errorO }}">{{ $err('requisitos') }}</span> @endif
                </label>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;align-items:end">
                    <label style="{{ $labelO }}">Fecha límite para postularse
                        <input type="date" name="fechaLimite" min="{{ now('America/Bogota')->toDateString() }}"
                                value="{{ $v('fechaLimite') }}" style="{{ $campoO }}">
                        @if ($err('fechaLimite')) <span style="{{ $errorO }}">{{ $err('fechaLimite') }}</span> @endif
                    </label>

                    <div style="background:#EAF6FD;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;font-size:13px;line-height:1.45;color:#12303F">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto"><path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        <span>Se publicará hoy <strong>{{ now('America/Bogota')->format('d/m/Y') }}</strong>.</span>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div style="padding:18px 28px;border-top:1px solid #E3E8EF;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;background:#FFFFFF">
                <button type="button" data-cerrar-crear-oferta class="{{ $btnSecundario }} cursor-pointer">Cancelar</button>
                <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Publicar</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Modal publicar una oferta //

    (function () {
        const modal = document.getElementById('modal-crear-oferta');
        const categoria = document.getElementById('co-categoria');
        const servicio = document.getElementById('co-servicio');
        const salario = document.getElementById('co-salario');
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

        // Si el servidor devolvió el formulario con datos, se restauran categoría y servicio
        const viejo = servicio.dataset.viejo;
        if (viejo) {
            const s = servicios.find(function (x) { return String(x.id) === String(viejo); });
            if (s) { categoria.value = s.idCategoria; llenarServicios(s.idCategoria, viejo); }
        } else {
            llenarServicios('', '');
        }
        formatearSalario();

        function abrir(boton) {
            botonOrigen = boton || null;
            modal.hidden = false;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function cerrar() {
            modal.hidden = true;
            modal.style.display = 'none';
            document.body.style.overflow = '';
            if (botonOrigen) botonOrigen.focus();
        }

        document.addEventListener('click', function (e) {
            const boton = e.target.closest('[data-abrir-crear-oferta]');
            if (boton) { abrir(boton); return; }
            if (e.target.closest('[data-cerrar-crear-oferta]') || e.target === modal) cerrar();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) cerrar();
        });

        if (modal.dataset.abrirAlCargar === '1') abrir(null);
    })();
</script>
@endpush
