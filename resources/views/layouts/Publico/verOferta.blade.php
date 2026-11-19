{{-- MODAL VER OFERTA QUE YO MISMO CREE (MODULO MIS OFERTAS) --}}
<div id="modal-mi-oferta" hidden
    style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:50;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">

    <div role="dialog" aria-modal="true" aria-labelledby="mo-titulo"
        style="width:100%;max-width:650px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

        {{-- Encabezado --}}
        <div id="mo-header" style="flex:0 0 auto;padding:28px clamp(16px, 5vw, 28px) 20px;border-bottom:1px solid #E3E8EF">

            <span id="mo-icono" style="width:56px;height:56px;border-radius:14px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                </svg>
            </span>

            <div id="mo-informacion" style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:8px">
                <h2 id="mo-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25"></h2>

                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:8px">
                    <span id="mo-categoria" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>

                    <span id="mo-servicio" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>

                    <span id="mo-contrato" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>

                    <span id="mo-estado" style="display:inline-flex;align-items:center;gap:8px;padding:5px 12px;border-radius:999px;font-size:13px;font-weight:700">
                        <span id="mo-estado-punto" style="width:8px;height:8px;border-radius:999px"></span>
                        <span id="mo-estado-texto"></span>
                    </span>
                </div>
            </div>

            {{-- Tarjeta de vencimiento --}}
            <div id="mo-caja-vence"
                style="background:#EFF8FE;border-radius:14px;padding:10px 16px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:4px;flex:0 0 auto;min-width:112px">

                <span id="mo-vence-titulo"
                    style="font-size:11px;font-weight:800;color:#1A75A8;letter-spacing:0.05em">
                    VENCE EL
                </span>

                <span id="mo-vence"
                    style="font-size:17px;font-weight:800;color:#1A75A8">
                </span>

                <span id="mo-dias-restantes"
                    style="font-size:11px;font-weight:500;color:#1A75A8">
                </span>
            </div>

            {{-- Botón cerrar --}}
            <button id="mo-cerrar" type="button" data-cerrar-mi-oferta aria-label="Cerrar"
                style="width:40px;height:40px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">

                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Cuerpo --}}
        <div style="min-height:0;flex:1 1 auto;padding:24px clamp(16px, 5vw, 28px);display:flex;flex-direction:column;gap:24px;overflow:auto">

            {{-- Datos principales --}}
            <div id="mo-datos" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,140px),1fr));gap:12px">

                <div style="background:#F5F7FA;border-radius:14px;padding:14px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:6px">
                    <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Salario</span>
                    <span id="mo-salario" style="font-size:15px;font-weight:400;color: #12303F"></span>
                </div>

                <div style="background:#F5F7FA;border-radius:14px;padding:14px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:6px">
                    <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Ubicación</span>
                    <span id="mo-ubicacion" style="font-size:15px;font-weight:400;color:#12303F"></span>
                </div>

                <div style="background:#F5F7FA;border-radius:14px;padding:14px 16px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:6px">
                    <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Publicada</span>
                    <span id="mo-publicada" style="font-size:15px;font-weight:400;color:#12303F"></span>
                </div>
            </div>

            {{-- Descripción --}}
            <div style="display:flex;flex-direction:column;gap:8px">
                <h3 style="margin:0;font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Descripción</h3>
                <p id="mo-descripcion" style="margin:0;font-size:15px;line-height:1.7;color:#3E4C59;white-space:pre-line"></p>
            </div>

            {{-- Requisitos --}}
            <div id="mo-bloque-requisitos" style="display:flex;flex-direction:column;gap:10px">
                <h3 style="margin:0;font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Requisitos</h3>
                <div id="mo-requisitos" style="display:flex;flex-direction:column;gap:10px"></div>
            </div>

            {{-- Postulantes --}}
            <div id="mo-postulantes" style="background:#EAF6FD;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px;font-size:14px;line-height:1.5;color:#12303F">

                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto">
                    <path d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 01-4.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>

                <span id="mo-postulantes-texto" style="flex:1 1 auto"></span>

                <a id="mo-ver-postulantes" href="#"
                    style="font-weight:700;color:#1A75A8;text-decoration:underline;white-space:nowrap">
                    Ver postulantes
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {

        const modal = document.getElementById('modal-mi-oferta');

        if (!modal) return;

        const ICONO_CHECK =
            '<span style="width:22px;height:22px;border-radius:999px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto;margin-top:2px">' +
            '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
            '<path d="M4.5 12.75l6 6 9-13.5"/></svg></span>';

        // Colores de la etiqueta de estado
        const ESTADOS = {
            activa: {
                fondo: '#DCFCE7',
                texto: '#166534',
                punto: '#16A34A'
            },
            con_contratacion: {
                fondo: '#DBEAFE',
                texto: '#1E40AF',
                punto: '#2563EB'
            },
            vencida: {
                fondo: '#F1F5F9',
                texto: '#1E293B',
                punto: '#6B7280'
            }
        };

        let botonOrigen = null;

        function texto(id, valor) {
            const elemento = document.getElementById(id);
            if (elemento) elemento.textContent = valor ?? '';
        }

        function etiqueta(id, valor) {
            const elemento = document.getElementById(id);
            if (!elemento) return;

            elemento.textContent = valor ?? '';
            elemento.hidden = !valor;
        }

        // Fecha de vencimiento y días restantes
        function pintarVence(o) {

            const caja = document.getElementById('mo-caja-vence');
            const titulo = document.getElementById('mo-vence-titulo');
            const diasTexto = document.getElementById('mo-dias-restantes');
            const fecha = document.getElementById('mo-vence');

            const dias = Number(o.diasRestantes);

            let fondo;
            let color;

            // Oferta con contratación: azul y sin días restantes
            if (o.estado === 'con_contratacion') {

                fondo = '#DBEAFE';
                color = '#1E40AF';

                titulo.textContent = 'VENCÍA EL';
                diasTexto.textContent = '';

            } else if (dias < 0) {

                // Oferta vencida: rojo
                fondo = '#FEE2E2';
                color = '#991B1B';

                titulo.textContent = 'VENCIÓ EL';
                diasTexto.textContent = '';

            } else if (dias < 3) {

                // Menos de 3 días: rojo
                fondo = '#FEE2E2';
                color = '#991B1B';

                titulo.textContent = 'VENCE EL';

                if (dias === 0) {
                    diasTexto.textContent = 'Vence hoy';
                } else if (dias === 1) {
                    diasTexto.textContent = 'Falta 1 día';
                } else {
                    diasTexto.textContent = 'Faltan ' + dias + ' días';
                }

            } else if (dias < 7) {

                // Entre 3 y 6 días: amarillo
                fondo = '#FEF3C7';
                color = '#92400E';

                titulo.textContent = 'VENCE EL';
                diasTexto.textContent = 'Faltan ' + dias + ' días';

            } else {

                // 7 días o más: verde
                fondo = '#DCFCE7';
                color = '#166534';

                titulo.textContent = 'VENCE EL';
                diasTexto.textContent = 'Faltan ' + dias + ' días';
            }

            // Aplicar colores
            caja.style.backgroundColor = fondo;
            titulo.style.color = color;
            diasTexto.style.color = color;
            fecha.style.color = color;

            // Mostrar fecha exacta
            fecha.textContent = o.vence ?? '';
        }

        // Abrir modal con la información de la oferta
        function abrir(boton) {

            let o;

            try {
                o = JSON.parse(boton.dataset.verMiOferta);
            } catch (error) {
                console.error('No se pudo leer la información de la oferta:', error);
                return;
            }

            if (!o) return;

            botonOrigen = boton;

            texto('mo-titulo', o.titulo);

            etiqueta('mo-categoria', o.categoria);
            etiqueta('mo-servicio', o.servicio);
            etiqueta('mo-contrato', o.contrato);

            const estado = ESTADOS[o.estado] || ESTADOS.activa;

            const cajaEstado = document.getElementById('mo-estado');

            cajaEstado.style.backgroundColor = estado.fondo;
            cajaEstado.style.color = estado.texto;

            document.getElementById('mo-estado-punto').style.backgroundColor = estado.punto;

            texto('mo-estado-texto', o.estadoTexto);

            texto('mo-salario', o.salario);
            texto('mo-ubicacion', o.ubicacion);
            texto('mo-publicada', o.publicada);

            // Pintar fecha de vencimiento
            pintarVence(o);

            texto('mo-descripcion', o.descripcion);

            // Mostrar requisitos
            const lista = document.getElementById('mo-requisitos');

            lista.replaceChildren();

            const requisitos = Array.isArray(o.requisitos) ? o.requisitos : [];

            requisitos.forEach(function (requisito) {

                const item = document.createElement('div');

                item.style.cssText =
                    'display:flex;align-items:flex-start;gap:10px;font-size:15px;line-height:1.6;color:#3E4C59';

                item.innerHTML = ICONO_CHECK;

                const span = document.createElement('span');

                span.textContent = requisito;

                item.appendChild(span);

                lista.appendChild(item);
            });

            document.getElementById('mo-bloque-requisitos').style.display =
                requisitos.length ? 'flex' : 'none';

            // Cantidad de postulantes
            const total = Number(o.totalPostulantes || 0);

            const textoPostulantes = document.getElementById('mo-postulantes-texto');

            if (total > 0) {

                textoPostulantes.textContent =
                    'Esta oferta tiene ' +
                    total +
                    (total === 1 ? ' postulante.' : ' postulantes.');

            } else {

                textoPostulantes.textContent =
                    'Aún nadie se ha postulado a esta oferta.';
            }

            // Enlace para ver postulantes
            const enlacePostulantes = document.getElementById('mo-ver-postulantes');

            if (o.urlPostulantes) {
                enlacePostulantes.href = o.urlPostulantes;
                enlacePostulantes.hidden = false;

            } else {
                enlacePostulantes.removeAttribute('href');
                enlacePostulantes.hidden = true;
            }

            // Mostrar modal
            modal.hidden = false;
            modal.style.display = 'flex';

            document.body.style.overflow = 'hidden';

            modal.querySelector('[data-cerrar-mi-oferta]').focus();
        }

        // Cerrar modal
        function cerrar() {

            modal.hidden = true;
            modal.style.display = 'none';

            document.body.style.overflow = '';

            if (botonOrigen) {
                botonOrigen.focus();
            }
        }

        // Eventos de apertura y cierre
        document.addEventListener('click', function (e) {

            const boton = e.target.closest('[data-ver-mi-oferta]');

            if (boton) {
                abrir(boton);
                return;
            }

            if (
                e.target.closest('[data-cerrar-mi-oferta]') ||
                e.target === modal
            ) {
                cerrar();
            }
        });

        // Cerrar con Escape
        document.addEventListener('keydown', function (e) {

            if (e.key === 'Escape' && !modal.hidden) {
                cerrar();
            }
        });

    })();
</script>
@endpush

<style>
    #mo-header {
        display: grid !important;
        grid-template-columns: 56px minmax(0, 1fr) auto 40px;
        grid-template-areas: "icono informacion vence cerrar";
        align-items: start;
        column-gap: 16px;
    }

    #mo-icono { grid-area: icono; }
    #mo-informacion { grid-area: informacion; min-width: 0 !important; }
    #mo-caja-vence { grid-area: vence; }
    #mo-cerrar { grid-area: cerrar; }

    @media (max-width: 639px) {
        #mo-header {
            grid-template-columns: 56px minmax(112px, 1fr) 40px;
            grid-template-areas: "icono vence cerrar" "informacion informacion informacion";
            align-items: start;
            column-gap: 12px;
            row-gap: 16px;
            padding: 20px 16px 18px !important;
        }

        #mo-caja-vence {
            width: 100%;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 10px 8px !important;
        }
        #mo-cerrar { margin: 0 !important; }

        #mo-titulo { font-size: 20px !important; }

        /* Salario, Ubicación y Publicada: uno debajo del otro */
        #mo-datos { grid-template-columns: 1fr !important; }

        /* Caja de postulantes: el enlace baja a su propia linea */
        #mo-postulantes { flex-wrap: wrap !important; padding: 12px 14px !important; }
        #mo-postulantes-texto { flex: 1 1 calc(100% - 40px) !important; }
        #mo-ver-postulantes { margin-left: 34px; }
    }
</style>
