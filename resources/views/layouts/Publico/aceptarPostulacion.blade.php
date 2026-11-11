{{-- MODAL CONFIRMAR: ACEPTAR UNA POSTULACIÓN --}}
<div id="modal-aceptar-postulacion" hidden
    style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:60;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.7)">
    <div role="alertdialog" aria-modal="true" aria-labelledby="ap-titulo"
        style="width:100%;max-width:380px;max-height:100%;overflow:auto;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

        <div style="padding:28px 24px 20px;text-align:center">
            <span style="width:68px;height:68px;margin:0 auto 20px;border-radius:50%;background:#DCFCE7;color:#16A34A;display:flex;align-items:center;justify-content:center">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="7" r="4"/><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 11l2 2 4-4"/></svg>
            </span>
            <h2 id="ap-titulo" style="margin:0 0 12px;font-size:19px;font-weight:700;color:#12303F;line-height:1.4">
                ¿Deseas aceptar a <span id="ap-nombre"></span>?
            </h2>
            <p style="margin:0;font-size:14px;line-height:1.7;color:#52606D">
                Al continuar, podrás contactar a este candidato para acordar las condiciones y detalles del trabajo.
            </p>
        </div>

        <div style="padding:0 24px 20px;display:flex;align-items:center;gap:10px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1A75A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex:0 0 auto"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></svg>
            <p style="margin:0;font-size:14px;line-height:1.5;color:#52606D">Esto no representa un compromiso de contratación.</p>
        </div>

        <form id="ap-form" method="POST" action="#" data-base="{{ url('/mis-ofertas/postulantes') }}"
            style="margin:0;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;padding:18px 24px;border-top:1px solid #E3E8EF;background:#FFFFFF">
            @csrf
            @method('PATCH')
            {{-- TEMPORAL: cuando exista el login, este campo se quita y el usuario sale de la sesión --}}
            @if (! empty($idUsuario))
                <input type="hidden" name="idUsuario" value="{{ $idUsuario }}">
            @endif

            <button type="button" data-cerrar-aceptar class="{{ $btnSecundario }} cursor-pointer">Cancelar</button>
            <button type="submit" class="{{ $btnPrimario }} cursor-pointer">Aceptar</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Modal confirmar aceptar postulación //
    (function () {
        const modal = document.getElementById('modal-aceptar-postulacion');
        const form = document.getElementById('ap-form');
        let botonOrigen = null;

        function abrir(boton) {
            const d = JSON.parse(boton.dataset.aceptar);
            botonOrigen = boton;

            document.getElementById('ap-nombre').textContent = d.nombre;
            form.action = form.dataset.base + '/' + d.id + '/aceptar';

            // Por si el modal se abrió antes y quedó el botón bloqueado
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
            const abrirBtn = e.target.closest('[data-aceptar]');
            if (abrirBtn) { abrir(abrirBtn); return; }

            if (e.target.closest('[data-cerrar-aceptar]') || e.target === modal) cerrar();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) cerrar();
        });
    })();
</script>
@endpush
