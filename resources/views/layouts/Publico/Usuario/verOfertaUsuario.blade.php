    {{-- MODAL VER OFERTA (la que ve el usuario)--}}
    <div id="modal-oferta" hidden
        style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:50;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
        <div role="dialog" aria-modal="true" aria-labelledby="modal-titulo"
            style="width:100%;max-width:700px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

            {{-- Encabezado --}}
            <div style="display:flex;align-items:flex-start;gap:16px;padding:28px 28px 20px;border-bottom:1px solid #E3E8EF">
                <div style="width:64px;height:64px;flex:0 0 auto;border-radius:999px;overflow:hidden;background:#EAF6FD;border:2px solid #000000;display:flex;align-items:center;justify-content:center;color:#1A75A8">
                    <img id="modal-foto" hidden alt="Foto de perfil de quien publica" style="width:100%;height:100%;object-fit:cover">
                    <svg id="modal-foto-vacia" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0" />
                    </svg>
                </div>

                <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:6px">
                    <h2 id="modal-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25"></h2>
                    <p style="margin:0;font-size:15px;color:#52606D">Publicada por <span id="modal-publicador" style="color:#1F2933;font-weight:700"></span></p>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;padding-top:6px">
                        <span id="modal-categoria" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                        <span id="modal-contrato" style="padding:5px 12px;border-radius:999px;background:#F5F7FA;font-size:13px;font-weight:600;color:#3E4C59"></span>
                    </div>
                </div>

                <div id="modal-tarjeta-vence" style="background:#DCFCE7;border-radius:14px;padding:10px 30px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span id="modal-titulo-vence" style="font-size:15px;font-weight:800;color:#166534 letter-spacing:0.04em">FINALIZA</span>
                        <span id="modal-dias-restantes"style="font-size:15px;font-weight:700;color: #166534"></span>
                        <span id="modal-vence"style="font-size:15px;font-weight:400;color: #166534"></span>
                    </div>

                <button type="button" data-cerrar-modal aria-label="Cerrar"
                        style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Cuerpo --}}
            <div style="padding:24px 28px;display:flex;flex-direction:column;gap:24px;overflow:auto">

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px">
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Salario</span>
                        <span id="modal-salario" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Ubicación</span>
                        <span id="modal-ubicacion" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>
                    <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Publicada</span>
                        <span id="modal-publicada" style="font-size:15px;font-weight:400;color: #12303F"></span>
                    </div>

                    <div style="background:#EAF6FD;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px">
                        <span style="font-size:15px;font-weight:800;color:#1A75A8;letter-spacing:0.04em">Postulaciones</span>
                        <span id="modal-postulaciones" style="font-size:15px;font-weight:700;color:#1A75A8"></span>
                    </div>

                </div>

                <div style="display:flex;flex-direction:column;gap:8px">
                    <h3 style="margin:0;font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Descripción</h3>
                    <p id="modal-descripcion" style="margin:0;font-size:15px;line-height:1.7;color:#3E4C59;white-space:pre-line"></p>
                </div>

                <div id="modal-bloque-requisitos" style="display:flex;flex-direction:column;gap:10px">
                    <h3 style="margin:0;font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Requisitos</h3>
                    <div id="modal-requisitos" style="display:flex;flex-direction:column;gap:10px"></div>
                </div>

                @if (! $esEmpresa && $hojaDeVidaProgreso < 100)
                    <div style="background:#EAF6FD;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px;font-size:14px;line-height:1.5;color:#12303F">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto">
                            <path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <span>
                            Quien publica la oferta verá tu hoja de vida.
                            <button type="button" data-abrir-hoja-de-vida style="border:none;background:transparent;padding:0;font:inherit;font-weight:700;color:#1A75A8;text-decoration:underline;cursor:pointer">Completala</button>
                            para tener más opciones.
                        </span>
                    </div>
                @endif
            </div>

                {{-- Botones --}}
                <form id="modal-form-postular" method="POST" action="#" data-base="{{ url('/empleos') }}"
                    style="margin:0;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;padding:18px 28px;border-top:1px solid #E3E8EF;background:#FFFFFF">
                    @csrf

                    <button type="button" data-cerrar-modal class="{{ $btnSecundario }} cursor-pointer">Cerrar</button>
                    @if (! $esEmpresa)
                        <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Postularme</button>
                    @else
                        <span class="text-sm font-semibold text-slate-500">La postulación está disponible para cuentas personales.</span>
                    @endif
                </form>
            </div>
        </div>

    @push('scripts')
        <script>
                        // Modal de ver oferta y postularse //

            (function () {
                const modal = document.getElementById('modal-oferta');
                const formPostular = document.getElementById('modal-form-postular');
                const ICONO_CHECK =
                    '<span style="width:22px;height:22px;border-radius:999px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto;margin-top:2px">' +
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
                    '<path d="M4.5 12.75l6 6 9-13.5" /></svg></span>';
                let botonOrigen = null;

                function texto(id, valor) {
                    document.getElementById(id).textContent = valor ?? '';
                }

                function abrir(boton) {
                    const o = JSON.parse(boton.dataset.verOferta);
                    botonOrigen = boton;

                    texto('modal-titulo', o.titulo);
                    texto('modal-publicador', o.publicador);
                    texto('modal-contrato', o.contrato);
                    texto('modal-salario', o.salario);
                    texto('modal-ubicacion', o.ubicacion);
                    texto('modal-publicada', o.publicada);
                    texto('modal-vence', o.vence);
                    texto('modal-descripcion', o.descripcion);
                    texto('modal-postulaciones', o.postulaciones);
                    // Estado visual de la fecha de finalización
                    const tarjetaVence = document.getElementById('modal-tarjeta-vence');
                    const tituloVence = document.getElementById('modal-titulo-vence');
                    const diasVence = document.getElementById('modal-dias-restantes');
                    const fechaVence = document.getElementById('modal-vence');

                    const dias = Number(o.diasRestantes);

                    let fondo;
                    let color;

                    if (dias < 3) {
                        fondo = '#FEE2E2';
                        color = '#991B1B';
                    } else if (dias < 7) {
                        fondo = '#FEF3C7';
                        color = '#92400E';
                    } else {
                        fondo = '#DCFCE7';
                        color = '#166534';
                    }

                    tarjetaVence.style.backgroundColor = fondo;
                    tituloVence.style.color = color;
                    diasVence.style.color = color;
                    fechaVence.style.color = color;

                    if (dias === 0) {
                        diasVence.textContent = 'Hoy';
                    } else if (dias === 1) {
                        diasVence.textContent = '1 día';
                    } else if (dias > 1) {
                        diasVence.textContent = dias + ' días';
                    } else {
                        diasVence.textContent = 'Oferta vencida';
                    }

                    const categoria = document.getElementById('modal-categoria');
                    categoria.textContent = o.categoria ?? '';
                    categoria.hidden = !o.categoria;

                    // Foto de perfil de quien publica (si no tiene, se muestra el icono de persona)
                    const foto = document.getElementById('modal-foto');
                    const fotoVacia = document.getElementById('modal-foto-vacia');
                    if (o.foto) {
                        foto.src = o.foto;
                        foto.hidden = false;
                        fotoVacia.style.display = 'none';
                    } else {
                        foto.removeAttribute('src');
                        foto.hidden = true;
                        fotoVacia.style.display = '';
                    }

                    const lista = document.getElementById('modal-requisitos');
                    lista.replaceChildren();
                    o.requisitos.forEach(function (requisito) {
                        const item = document.createElement('div');
                        item.style.cssText = 'display:flex;align-items:flex-start;gap:10px;font-size:15px;line-height:1.6;color:#3E4C59';
                        item.innerHTML = ICONO_CHECK;
                        const span = document.createElement('span');
                        span.textContent = requisito;
                        item.appendChild(span);
                        lista.appendChild(item);
                    });
                    document.getElementById('modal-bloque-requisitos').style.display = o.requisitos.length ? 'flex' : 'none';

                    formPostular.action = formPostular.dataset.base + '/' + o.id + '/postular';

                    modal.hidden = false;
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    modal.querySelector('[data-cerrar-modal]').focus();
                }

                function cerrar() {
                    modal.hidden = true;
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                    if (botonOrigen) botonOrigen.focus();
                }

                document.addEventListener('click', function (e) {
                    const boton = e.target.closest('[data-ver-oferta]');
                    if (boton) { abrir(boton); return; }
                    if (e.target.closest('[data-cerrar-modal]') || e.target === modal) cerrar();
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !modal.hidden) cerrar();
                });
            })();
        </script>
    @endpush


