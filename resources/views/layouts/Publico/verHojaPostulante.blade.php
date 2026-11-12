{{-- MODAL HOJA DE VIDA DEL POSTULANTE --}}
<div id="modal-hoja-postulante" hidden
    style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:55;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
    <div role="dialog" aria-modal="true" aria-labelledby="hp-nombre"
        style="width:100%;max-width:720px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

        {{-- Encabezado --}}
        <div style="padding:28px 28px 20px;display:flex;align-items:flex-start;gap:16px;border-bottom:1px solid #E3E8EF">
            <div style="width:64px;height:64px;flex:0 0 auto;border-radius:999px;background:#EAF6FD;border:2px solid #EAF6FD;display:flex;align-items:center;justify-content:center;color:#1A75A8;overflow:hidden">
                <img id="hp-foto" hidden alt="Foto de perfil" style="width:100%;height:100%;object-fit:cover">
                <svg id="hp-foto-vacia" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/></svg>
            </div>

            <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:6px">
                <h2 id="hp-nombre" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25"></h2>
                <span style="font-size:15px;color:#52606D">Postulante a «<span id="hp-oferta"></span>»</span>
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;padding-top:2px">
                    <span id="hp-estado" class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[13px] font-bold">
                        <span id="hp-estado-punto" class="size-2 rounded-full"></span>
                        <span id="hp-estado-texto"></span>
                    </span>
                    <span style="font-size:13px;color:#52606D">Se postuló el <span id="hp-fecha"></span></span>
                </div>
            </div>

            <button type="button" data-cerrar-hoja-postulante aria-label="Cerrar"
                style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Cuerpo --}}
        <div style="padding:24px 28px;display:flex;flex-direction:column;gap:20px;overflow:auto">

            {{-- Contacto: cajitas como en "Ver oferta" --}}
            <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px">

                {{-- Correo --}}
                <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px;min-width:0">
                    <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Correo Electrónico</span>
                    <span id="hp-correo" style="font-size:15px;font-weight:400;color:#12303F"></span>
                </div>

                {{-- Teléfono --}}
                <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px;min-width:0">
                    <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Número de contacto</span>
                    <span id="hp-telefono" style="font-size:15px;font-weight:400;color:#12303F"></span>
                </div>

                {{-- Ubicación --}}
                <div style="background:#F5F7FA;border-radius:14px;padding:10px 10px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px;min-width:0">
                    <span style="font-size:15px;font-weight:800;color:#52606D;letter-spacing:0.04em">Ubicación</span>
                    <span id="hp-ubicacion" style="font-size:15px;font-weight:400;color:#12303F"></span>
                </div>

            </div>

            {{-- Perfil profesional --}}
            <label style="display:flex;flex-direction:column;gap:6px;font-size:13px;font-weight:500;color:#52606D">
                <span style="display:flex;justify-content:space-between;gap:12px">
                    <span>Perfil Personal</span>
                    <span id="hp-perfil-contador" style="font-weight:600;color:#7B8794">0/255</span>
                </span>
                <textarea id="hp-perfil" rows="3" readonly
                    style="font-family:inherit;font-size:15px;line-height:1.5;padding:12px 14px;border:1.5px solid #CBD2D9;border-radius:10px;color:#1F2933;background:#FFFFFF;resize:none"></textarea>
            </label>

            {{-- Experiencia laboral --}}
            <label style="display:flex;flex-direction:column;gap:6px;font-size:13px;font-weight:700;color:#52606D">
                <span style="display:flex;justify-content:space-between;gap:12px">
                    <span>Experiencia laboral</span>
                    <span id="hp-exp-contador" style="font-weight:600;color:#7B8794">0/255</span>
                </span>
                <textarea id="hp-exp" rows="3" readonly
                    style="font-family:inherit;font-size:15px;line-height:1.5;padding:12px 14px;border:1.5px solid #CBD2D9;border-radius:10px;color:#1F2933;background:#FFFFFF;resize:none"></textarea>
            </label>

            {{-- Hoja de vida en PDF --}}
            <div style="display:flex;flex-direction:column;gap:8px">
                <span style="font-size:13px;font-weight:700;color:#52606D">Archivo CV en PDF</span>

                <div id="hp-cv" style="display:none;flex-wrap:wrap;align-items:center;gap:14px;border:1px solid #E3E8EF;border-radius:14px;padding:14px 16px">
                    <span style="width:44px;height:44px;border-radius:12px;background:#FEE2E2;color:#B42318;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800">PDF</span>
                    <div style="flex:1 1 200px;min-width:0;display:flex;flex-direction:column;gap:2px">
                        <span id="hp-cv-nombre" style="font-size:15px;font-weight:700;color:#12303F;word-break:break-all"></span>
                        <span style="font-size:12px;color:#52606D">Actualizado el <span id="hp-cv-fecha"></span></span>
                    </div>
                    <a id="hp-cv-ver" href="#" target="_blank" rel="noopener" aria-label="Ver PDF" title="Ver PDF"
                        class="flex size-11 shrink-0 items-center justify-center rounded-full bg-sky-100 text-marca-texto transition hover:bg-sky-200">
                        <svg width="22" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                </div>

                <div id="hp-cv-vacio" style="display:none;border:1px dashed #CBD2D9;border-radius:14px;padding:14px 16px;font-size:14px;color:#52606D">
                    Esta persona no adjuntó su hoja de vida en PDF.
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Modal hoja de vida del postulante //
    (function () {
        const modal = document.getElementById('modal-hoja-postulante');
        let botonOrigen = null;

        function texto(id, valor) {
            document.getElementById(id).textContent = valor ?? '';
        }

        function areaDeTexto(id, contadorId, valor) {
            document.getElementById(id).value = valor || '';
            document.getElementById(contadorId).textContent = (valor || '').length + '/255';
        }

        function abrir(boton) {
            const d = JSON.parse(boton.dataset.verPostulante);
            botonOrigen = boton;

            texto('hp-nombre', d.nombre);
            texto('hp-oferta', d.oferta);
            texto('hp-fecha', d.fecha);
            texto('hp-correo', d.correo);
            texto('hp-telefono', d.telefono);
            texto('hp-ubicacion', d.ubicacion);

            // Etiqueta de estado (los colores vienen del servidor)
            document.getElementById('hp-estado').className =
                'inline-flex items-center gap-2 rounded-full px-3 py-1 text-[13px] font-bold ' + d.estadoCaja;
            document.getElementById('hp-estado-punto').className = 'size-2 rounded-full ' + d.estadoPunto;
            texto('hp-estado-texto', d.estadoTexto);

            // Foto o icono
            const foto = document.getElementById('hp-foto');
            const fotoVacia = document.getElementById('hp-foto-vacia');
            if (d.foto) {
                foto.src = d.foto;
                foto.hidden = false;
                fotoVacia.style.display = 'none';
            } else {
                foto.removeAttribute('src');
                foto.hidden = true;
                fotoVacia.style.display = '';
            }

            areaDeTexto('hp-perfil', 'hp-perfil-contador', d.perfil);
            areaDeTexto('hp-exp', 'hp-exp-contador', d.experiencia);

            // PDF: si no hay archivo se muestra un aviso
            const tieneCv = Boolean(d.cvUrl);
            document.getElementById('hp-cv').style.display = tieneCv ? 'flex' : 'none';
            document.getElementById('hp-cv-vacio').style.display = tieneCv ? 'none' : 'block';
            if (tieneCv) {
                texto('hp-cv-nombre', d.cvNombre);
                texto('hp-cv-fecha', d.cvFecha || '—');
                document.getElementById('hp-cv-ver').href = d.cvUrl;
            }

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
            const abrirBtn = e.target.closest('[data-ver-postulante]');
            if (abrirBtn) { abrir(abrirBtn); return; }

            if (e.target.closest('[data-cerrar-hoja-postulante]') || e.target === modal) cerrar();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) cerrar();
        });
    })();
</script>
@endpush
