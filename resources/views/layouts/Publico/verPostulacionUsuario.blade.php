    {{-- MODAL VER MI POSTULACIÓN --}}
    <div id="modal-postulacion" hidden
        style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:50;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
        <div role="dialog" aria-modal="true" aria-labelledby="mp-titulo"
            style="width:100%;max-width:660px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

            {{-- Encabezado --}}
            <div style="display:flex;align-items:flex-start;gap:16px;padding:28px 28px 20px;border-bottom:1px solid #E3E8EF">
                <div style="width:64px;height:64px;flex:0 0 auto;border-radius:999px;overflow:hidden;background:#EAF6FD;border:2px solid #000000;display:flex;align-items:center;justify-content:center;color:#1A75A8">
                    <img id="mp-foto" hidden alt="Foto de perfil de quien publica" style="width:100%;height:100%;object-fit:cover">
                    <svg id="mp-foto-vacia" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0" />
                    </svg>
                </div>

                <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:6px">
                    <span style="font-size:13px;font-weight:800;color:#1A75A8;text-transform:uppercase;letter-spacing:0.04em">Mi postulación</span>
                    <h2 id="mp-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25"></h2>
                    <p style="margin:0;font-size:15px;color:#52606D">Publicada por <span id="mp-publicador" style="color:#1F2933;font-weight:700"></span></p>
                </div>

                <button type="button" data-cerrar-postulacion aria-label="Cerrar"
                        style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Cuerpo --}}
            <div style="padding:24px 28px;display:flex;flex-direction:column;gap:24px;overflow:auto">

                {{-- Estado de la postulación --}}
                <div id="mp-estado-caja" style="border-radius:14px;padding:10px 18px;display:flex;align-items:center;gap:16px">

                    {{-- Icono del estado --}}
                    <span id="mp-estado-circulo" style="width:44px;height:44px;border-radius:999px;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                    </span>

                    {{-- Mensaje del estado --}}
                    <div style="width:fit-content;max-width:90%;background:#FFFFFF;border-radius:999px;padding:5px 18px">
                        <span id="mp-estado-mensaje" style="display:block;font-size:15px;line-height:1.5;font-weight:700"></span>
                    </div>
                </div>

                {{-- Fechas --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px">
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Te postulaste el</span>
                        <span id="mp-fecha" style="font-size:15px;font-weight:400;color:#12303F"></span>
                    </div>
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">La oferta vence el</span>
                        <span id="mp-vence" style="font-size:15px;font-weight:400;color:#12303F"></span>
                    </div>

                </div>

                {{-- Resumen de la oferta --}}
                <div style="display:flex;flex-direction:column;gap:12px">
                    <h3 style="margin:0;font-size:17px;font-weight:700;color:#12303F letter-spacing:0.04em">Resumen de la oferta</h3>
                    <div style="border:1px solid #E3E8EF;border-radius:14px;padding:16px 18px;display:flex;flex-direction:column;gap:12px">
                        <div style="display:flex;flex-wrap:wrap;gap:8px">
                            <span id="mp-categoria" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                            <span id="mp-contrato" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                            <span id="mp-salario" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                            <span style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59; display:flex;align-items:center;gap:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <span id="mp-ubicacion"></span>
                        </span>
                        </div>

                        <p id="mp-descripcion" style="margin:0;font-size:14px;line-height:1.6;color:#3E4C59;white-space:pre-line"></p>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div style="margin:0;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;padding:18px 28px;border-top:1px solid #E3E8EF;background:#FFFFFF">
                <button type="button" data-cerrar-postulacion class="{{ $btnSecundario }} cursor-pointer">Cerrar</button>
                <button type="button" id="mp-btn-cancelar" data-abrir-confirmacion
                        style="font-family:inherit;font-weight:700;font-size:15px;padding:12px 16px;min-height:46px;border-radius:9999px;border:2px solid #B42318;background:#B42318;color:#FFFFFF;cursor:pointer"
                        onmouseover="this.style.background='#8F1D14';this.style.borderColor='#8F1D14'"
                        onmouseout="this.style.background='#B42318';this.style.borderColor='#B42318'">

                    Cancelar postulación
                </button>
            </div>
        </div>
    </div>


    {{-- CONFIRMAR CANCELACIÓN DE LA POSTULACIÓN --}}
    <div id="modal-confirmar-cancelacion" hidden
        style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:60;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.7)">

        <div role="alertdialog" aria-modal="true" aria-labelledby="mp-confirmar-titulo"
            style="width:100%;max-width:440px;background:#FFFFFF;border-radius:20px;box-shadow:0 24px 64px rgba(18,48,63,0.35);overflow:hidden;font-family:inherit">

            {{-- Encabezado --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;padding:22px 24px;border-bottom:1px solid #E3E8EF">

                <h2 id="mp-confirmar-titulo" style="margin:0;font-size:20px;font-weight:700;color:#12303F;line-height:1.3">
                    Cancelar postulación
                </h2>

                <button type="button" data-cerrar-confirmacion aria-label="Cerrar"
                        style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>


            </div>

            {{-- Cuerpo --}}
            <div style="padding:24px;text-align:center">

                <span style="width:64px;height:64px;margin:0 auto 20px;border-radius:50%;background:#FEE2E2;color:#B42318;display:flex;align-items:center;justify-content:center">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </span>

                <p style="margin:0;font-size:15px;line-height:1.7;color:#52606D">
                    ¿Seguro que deseas eliminar tu postulación a la oferta
                    <strong id="mp-confirmar-oferta" style="color:#12303F;font-weight:700"></strong>?
                    <br>
                    Esta acción no se puede deshacer, pero podrás volver a postularte mientras la oferta siga vigente.
                </p>

            </div>

            {{-- Botones --}}
            <form id="mp-form-cancelar" method="POST" action="#" data-base="{{ url('/empleos/postulaciones') }}"
                style="margin:0;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;padding:18px 24px;border-top:1px solid #E3E8EF;background:#FFFFFF">

                @csrf
                @method('DELETE')

                {{-- TEMPORAL: cuando exista el login, este campo se quita y el usuario sale de la sesión --}}
                @if (! empty($idUsuario))
                    <input type="hidden" name="idUsuario" value="{{ $idUsuario }}">
                @endif

                <button type="button" data-cerrar-confirmacion class="{{ $btnSecundario }} cursor-pointer">
                    Volver
                </button>

                <button type="submit"
                    style="font-family:inherit;font-weight:700;font-size:15px;padding:12px 16px;min-height:46px;border-radius:9999px;border:2px solid #B42318;background:#B42318;color:#FFFFFF;cursor:pointer"
                    onmouseover="this.style.background='#8F1D14';this.style.borderColor='#8F1D14'"
                    onmouseout="this.style.background='#B42318';this.style.borderColor='#B42318'">
                    Confirmar
                </button>

            </form>

        </div>
    </div>

    @push('scripts')
        <script>
        // Modal de ver mi postulación y cancelar postulación//

            (function () {
                const modal = document.getElementById('modal-postulacion');
                const confirmar = document.getElementById('modal-confirmar-cancelacion');
                const formCancelar = document.getElementById('mp-form-cancelar');

                const ESTADOS = {
                    Enviado: {
                        fondo: '#FEF3C7', circulo: '#FDE68A', color: '#7A4B00', punto: '#D69E00',
                        mensaje: 'Tu postulación fue enviada. Quien publica la oferta la revisará.',
                        icono: '<path d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />'
                    },
                    Aceptado: {
                        fondo: '#DCFCE7', circulo: '#BBF7D0', color: '#14532D', punto: '#16A34A',
                        mensaje: '¡Felicitaciones! Tu postulación fue aceptada.',
                        icono: '<path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                    },
                    Rechazado: {
                        fondo: '#FEE2E2', circulo: '#FECACA', color: '#7F1D1D', punto: '#DC2626',
                        mensaje: 'Esta vez no fuiste seleccionado/a. ¡Sigue intentando!',
                        icono: '<path d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                    },
                    Contratado: {
                        fondo: '#E0F2FE', circulo: '#BAE6FD', color: '#075985', punto: '#0284C7',
                        mensaje: '¡Felicitaciones! Has sido contratado/a. Ahora puedes calificar tu experiencia.',
                        icono: '<rect x="3" y="7" width="18" height="14" rx="2" /><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M3 12h18M10 12v2h4v-2" />'
                    }
                };

                let botonOrigen = null;
                let idPostulacion = null;

                function texto(id, valor) {
                    document.getElementById(id).textContent = valor ?? '';
                }

                function abrir(boton) {
                    const o = JSON.parse(boton.dataset.verPostulacion);
                    const p = o.postulacion;
                    if (!p) return;

                    botonOrigen = boton;
                    idPostulacion = p.id;

                    texto('mp-titulo', o.titulo);
                    texto('mp-publicador', o.publicador);
                    texto('mp-fecha', p.fecha);
                    texto('mp-vence', o.vence);
                    texto('mp-contrato', o.contrato);
                    texto('mp-salario', o.salario);
                    texto('mp-ubicacion', o.ubicacion);
                    texto('mp-descripcion', o.descripcion);

                    const categoria = document.getElementById('mp-categoria');
                    categoria.textContent = o.categoria ?? '';
                    categoria.hidden = !o.categoria;

                    const foto = document.getElementById('mp-foto');
                    const fotoVacia = document.getElementById('mp-foto-vacia');
                    if (o.foto) {
                        foto.src = o.foto;
                        foto.hidden = false;
                        fotoVacia.style.display = 'none';
                    } else {
                        foto.removeAttribute('src');
                        foto.hidden = true;
                        fotoVacia.style.display = '';
                    }

                    // Estado: colores, icono y mensaje
                    const e = ESTADOS[p.estado] || ESTADOS.Enviado;
                    document.getElementById('mp-estado-caja').style.background = e.fondo;
                    const circulo = document.getElementById('mp-estado-circulo');
                    circulo.style.background = e.circulo;
                    circulo.style.color = e.color;
                    circulo.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' + e.icono + '</svg>';
                    const mensaje = document.getElementById('mp-estado-mensaje');
                    mensaje.textContent = e.mensaje;
                    mensaje.style.color = e.color;

                    // Solo se puede cancelar mientras la postulación está "Enviado"
                    document.getElementById('mp-btn-cancelar').style.display = p.estado === 'Enviado' ? 'inline-flex' : 'none';

                    texto('mp-confirmar-oferta', o.titulo);
                    formCancelar.action = formCancelar.dataset.base + '/' + p.id;

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

                function abrirConfirmacion() {
                    confirmar.hidden = false;
                    confirmar.style.display = 'flex';
                }

                function cerrarConfirmacion() {
                    confirmar.hidden = true;
                    confirmar.style.display = 'none';
                }

                document.addEventListener('click', function (e) {
                    const boton = e.target.closest('[data-ver-postulacion]');
                    if (boton) { abrir(boton); return; }

                    if (e.target.closest('[data-abrir-confirmacion]')) { abrirConfirmacion(); return; }
                    if (e.target.closest('[data-cerrar-confirmacion]') || e.target === confirmar) { cerrarConfirmacion(); return; }
                    if (e.target.closest('[data-cerrar-postulacion]') || e.target === modal) cerrar();
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key !== 'Escape') return;
                    if (!confirmar.hidden) { cerrarConfirmacion(); return; }
                    if (!modal.hidden) cerrar();
                });
            })();

        </script>
    @endpush

