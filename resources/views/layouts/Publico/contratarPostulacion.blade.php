{{-- MODAL CONFIRMAR: CONTRATAR UNA POSTULACIÓN --}}
<div id="modal-contratar-postulacion" hidden
    style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:60;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.7)">
    <div role="alertdialog" aria-modal="true" aria-labelledby="cp-titulo"
        style="width:100%;max-width:380px;max-height:100%;overflow:auto;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

        <div style="padding:28px 24px 20px;text-align:center">
            <span style="width:68px;height:68px;margin:0 auto 20px;border-radius:50%;background:#E0F2FE;color:#1A75A8;display:flex;align-items:center;justify-content:center">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 17l2 2a1 1 0 1 0 3-3 M14 14l2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4 M21 3l1 11h-2 M3 3l-1 11l6.5 6.5a1 1 0 1 0 3-3 M3 4h8"/></svg>
            </span>
            <h2 id="cp-titulo" style="margin:0 0 12px;font-size:19px;font-weight:700;color:#12303F;line-height:1.4">
                ¿Confirmas que <span id="cp-nombre"></span> ha sido contratado?
            </h2>
            <p style="margin:0;font-size:14px;line-height:1.7;color:#52606D">
                Al continuar, ambas partes acuerdan realizar el trabajo. Se habilitará la calificación mutua y se rechazarán las demás postulaciones de esta oferta.
        </div>

        <div style="padding:0 24px 20px;display:flex;flex-direction:column;gap:10px">
            <div style="display:flex;align-items:center;gap:10px">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></svg>
                <p style="margin:0;font-size:14px;line-height:1.5;color:#52606D">Esta acción no se puede deshacer.</p>
            </div>
        </div>

        <form id="cp-form" method="POST" action="#" data-base="{{ url('/mis-ofertas/postulantes') }}"
            style="margin:0;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;padding:18px 24px;border-top:1px solid #E3E8EF;background:#FFFFFF">
            @csrf
            @method('PATCH')
            {{-- TEMPORAL: cuando exista el login, este campo se quita y el usuario sale de la sesión --}}
            @if (! empty($idUsuario))
                <input type="hidden" name="idUsuario" value="{{ $idUsuario }}">
            @endif

            <button type="button" data-cerrar-contratar class="{{ $btnSecundario }} cursor-pointer">Cancelar</button>
            <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Confirmar</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Modal confirmar contratar postulación //
    (function () {
        const modal = document.getElementById('modal-contratar-postulacion');
        const form = document.getElementById('cp-form');
        let botonOrigen = null;

        function abrir(boton) {
            const d = JSON.parse(boton.dataset.contratar);
            botonOrigen = boton;

            document.getElementById('cp-nombre').textContent = d.nombre;
            form.action = form.dataset.base + '/' + d.id + '/contratar';
            form.querySelector('[type="submit"]').disabled = false;

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

        // Evita enviar dos veces con doble clic
        form.addEventListener('submit', function () {
            form.querySelector('[type="submit"]').disabled = true;
        });

        document.addEventListener('click', function (e) {
            const abrirBtn = e.target.closest('[data-contratar]');
            if (abrirBtn) { abrir(abrirBtn); return; }

            if (e.target.closest('[data-cerrar-contratar]') || e.target === modal) cerrar();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) cerrar();
        });
    })();
</script>
@endpush
