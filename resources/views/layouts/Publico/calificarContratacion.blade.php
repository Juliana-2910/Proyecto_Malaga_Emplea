{{-- MODAL CALIFICAR A QUIEN TE CONTRATÓ --}}
@php
    $bolsaCal = $errors->getBag('calificar');
    $reabrirCal = $bolsaCal->any();
    $estrella = 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z';
@endphp

<div id="modal-calificar" hidden data-viejo-id="{{ $reabrirCal ? old('idPostulacion') : '' }}" data-vieja-puntuacion="{{ $reabrirCal ? old('puntuacion') : '' }}"
    style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:55;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">
    <div role="dialog" aria-modal="true" aria-labelledby="cal-titulo"
        style="width:100%;max-width:640px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

        {{-- Encabezado --}}
        <div style="padding:28px 28px 20px;display:flex;align-items:flex-start;gap:16px;border-bottom:1px solid #E3E8EF">
            <span style="width:56px;height:56px;border-radius:14px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $estrella }}"/></svg>
            </span>
            <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:4px">
                <h2 id="cal-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25">Califica esta experiencia</h2>
                <span id="cal-subtitulo" style="font-size:15px;line-height:1.5;color:#52606D">Cuéntanos cómo fue la experiencia.</span>
            </div>
            <button type="button" data-cerrar-calificar aria-label="Cerrar"
                    style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="cal-form" method="POST" action="#" data-base="{{ url('/mis-postulaciones') }}"
                style="margin:0;display:flex;flex-direction:column;min-height:0;flex:1 1 auto">
            @csrf
            <input type="hidden" name="idPostulacion" id="cal-id" value="">
            <input type="hidden" name="puntuacion" id="cal-puntuacion" value="">

            {{-- Cuerpo --}}
            <div style="padding:24px 28px;display:flex;flex-direction:column;gap:22px;overflow:auto">

                {{-- A quién calificas --}}
                <div style="display:flex;align-items:center;gap:16px;border:1px solid #E3E8EF;border-radius:14px;padding:14px 16px;background:#FFFFFF">
                    <div style="width:64px;height:64px;flex:0 0 auto;border-radius:999px;background:#EAF6FD;border:2px solid #000000;display:flex;align-items:center;justify-content:center;color:#1A75A8;overflow:hidden">
                        <img id="cal-foto" hidden alt="Foto de perfil" style="width:100%;height:100%;object-fit:cover">
                        <svg id="cal-foto-vacia" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/></svg>
                    </div>
                    <div style="min-width:0;display:flex;flex-direction:column;gap:2px">
                        <span style="display:flex;flex-wrap:wrap;align-items:center;gap:8px">
                            <span id="cal-nombre" style="font-size:16px;font-weight:700;color:#12303F"></span>
                            <span id="cal-tipo" style="padding:3px 10px;border-radius:999px;background:#F5F7FA;color:#52606D;font-size:12px;font-weight:700"></span>
                        </span>
                        <span id="cal-leyenda" style="font-size:13px;color:#52606D"></span>
                    </div>
                </div>

                {{-- Calificación + aviso --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:16px;align-items:stretch">

                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <span style="font-size:13px;font-weight:500;color:#52606D">Tu calificación</span>
                        <div style="display:flex;gap:6px;justify-content:center;width:100%">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" data-estrella="{{ $i }}" aria-label="{{ $i }} {{ $i === 1 ? 'estrella' : 'estrellas' }}"
                                        style="border:none;background:transparent;padding:0;display:flex;cursor:pointer">
                                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#D5DBE3" stroke-width="1.4" stroke-linejoin="round" aria-hidden="true"><path d="{{ $estrella }}"/></svg>
                                </button>
                            @endfor
                        </div>
                        <span style="font-size:14px;color:#52606D"><strong id="cal-etiqueta" style="color:#12303F">Elige una calificación</strong><span id="cal-etiqueta-resto"></span></span>
                        <span id="cal-error-estrellas" @if (! $bolsaCal->has('puntuacion')) hidden @endif style="font-size:12px;font-weight:600;color:#B42318">{{ $bolsaCal->first('puntuacion') }}</span>
                    </div>

                    <div style="background:#EAF6FD;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto"><path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        <div style="display:flex;flex-direction:column;gap:2px">
                            <span style="font-size:14px;font-weight:700;color:#12303F">Una sola oportunidad</span>
                            <span style="font-size:13px;line-height:1.45;color:#3E4C59">Después de enviarla no podrás editarla.</span>
                        </div>
                    </div>
                </div>

                {{-- Comentario --}}
                <div style="display:flex;flex-direction:column;gap:8px">
                    <label style="display:flex;flex-direction:column;gap:6px;font-size:13px;font-weight:500;color:#52606D">
                        <span style="display:flex;justify-content:space-between;gap:12px">
                            <span>Tu comentario</span>
                            <span id="cal-contador" style="font-weight:600;color:#7B8794">0/255</span>
                        </span>
                        <textarea id="cal-comentario" name="comentario" rows="4" maxlength="255"
                                placeholder="Cuenta cómo fue el trato, el pago y las condiciones del trabajo"
                                style='font-family:inherit;font-size:15px;padding:12px 14px;border:1.5px solid #CBD2D9;border-radius:10px;color:#1F2933;background:#FFFFFF;width:100%;box-sizing:border-box'>{{ $reabrirCal ? old('comentario') : '' }}</textarea>
                        @if ($bolsaCal->has('comentario')) <span style="font-size:12px;font-weight:600;color:#B42318">{{ $bolsaCal->first('comentario') }}</span> @endif
                    </label>
                    <span style="display:flex;align-items:center;gap:6px;font-size:14px;color:#7B8794">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto"><path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        Tu opinión ayuda a otras personas.
                    </span>
                </div>
            </div>

            {{-- Botones --}}
            <div style="padding:18px 28px;border-top:1px solid #E3E8EF;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;background:#FFFFFF">
                <button type="button" data-cerrar-calificar class="{{ $btnSecundario }} cursor-pointer">Cancelar</button>
                <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Enviar</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Modal calificar la experiencia del trabajo //

    (function () {
        const modal = document.getElementById('modal-calificar');
        const form = document.getElementById('cal-form');
        const campoPuntuacion = document.getElementById('cal-puntuacion');
        const comentario = document.getElementById('cal-comentario');
        const contador = document.getElementById('cal-contador');
        const etiqueta = document.getElementById('cal-etiqueta');
        const etiquetaResto = document.getElementById('cal-etiqueta-resto');
        const errorEstrellas = document.getElementById('cal-error-estrellas');
        const botones = modal.querySelectorAll('[data-estrella]');
        const ETIQUETAS = ['Elige una calificación', 'Muy mala', 'Mala', 'Regular', 'Buena', 'Excelente'];
        let botonOrigen = null;

        function texto(id, valor) {
            document.getElementById(id).textContent = valor ?? '';
        }

        function pintar(n) {
            campoPuntuacion.value = n || '';
            botones.forEach(function (b) {
                const llena = Number(b.dataset.estrella) <= n;
                const svg = b.querySelector('svg');
                svg.setAttribute('fill', llena ? '#F5B72E' : 'none');
                svg.setAttribute('stroke', llena ? '#F5B72E' : '#D5DBE3');
            });
            etiqueta.textContent = ETIQUETAS[n || 0];
            etiquetaResto.textContent = n ? ' · ' + n + ' de 5' : '';
            if (n) errorEstrellas.hidden = true;
        }

        function actualizarContador() {
            contador.textContent = comentario.value.length + '/255';
        }

        function abrir(boton, conservar) {
            const d = JSON.parse(boton.dataset.calificar);
            botonOrigen = boton;

            texto('cal-nombre', d.nombre);
            texto('cal-tipo', d.tipo);
            texto('cal-oferta', d.titulo);
            texto('cal-leyenda', d.leyenda || 'Sobre la oferta «' + d.titulo + '»');
            texto('cal-subtitulo', d.subtitulo || 'Cuéntanos cómo fue la experiencia.');
            document.getElementById('cal-id').value = d.id;
            form.action = d.url || form.dataset.base + '/' + d.id + '/calificar';

            const foto = document.getElementById('cal-foto');
            const fotoVacia = document.getElementById('cal-foto-vacia');
            if (d.foto) {
                foto.src = d.foto;
                foto.hidden = false;
                fotoVacia.style.display = 'none';
            } else {
                foto.removeAttribute('src');
                foto.hidden = true;
                fotoVacia.style.display = '';
            }

            if (!conservar) {
                pintar(0);
                comentario.value = '';
                errorEstrellas.hidden = true;
            }
            actualizarContador();

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

        comentario.addEventListener('input', actualizarContador);

        // No se envía sin estrellas
        form.addEventListener('submit', function (e) {
            if (!campoPuntuacion.value) {
                e.preventDefault();
                errorEstrellas.textContent = 'Elige de 1 a 5 estrellas.';
                errorEstrellas.hidden = false;
            }
        });

        document.addEventListener('click', function (e) {
            const abrirBtn = e.target.closest('[data-calificar]');
            if (abrirBtn) { abrir(abrirBtn, false); return; }

            const estrella = e.target.closest('[data-estrella]');
            if (estrella) { pintar(Number(estrella.dataset.estrella)); return; }

            if (e.target.closest('[data-cerrar-calificar]') || e.target === modal) cerrar();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) cerrar();
        });

        // Si el servidor devolvió errores de validación, el modal se abre solo con lo que escribiste
        const viejoId = modal.dataset.viejoId;
        if (viejoId) {
            const origen = Array.from(document.querySelectorAll('[data-calificar]')).find(function (b) {
                return String(JSON.parse(b.dataset.calificar).id) === String(viejoId);
            });
            if (origen) {
                abrir(origen, true);
                pintar(Number(modal.dataset.viejaPuntuacion) || 0);
            }
        }
        actualizarContador();
    })();
</script>
@endpush
