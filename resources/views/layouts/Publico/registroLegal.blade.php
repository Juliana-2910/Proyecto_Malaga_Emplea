{{--
    Base de los modales legales del registro (Términos y Condiciones y Tratamiento de Datos).
    Se incluye UNA sola vez desde registroBase.blade.php (dentro de su @once), por eso los modales
    quedan fuera de los modales de registro y no se ven afectados por su transform/overflow.
    No usan la clase .modal-registro para que cerrarlos no cierre el registro que está detrás.
--}}
@include('layouts.Publico.modalTerminos')
@include('layouts.Publico.modalDatos')

<style>
    .modal-legal {
        opacity: 0;
        transition: opacity .25s ease;
    }

    .modal-legal.modal-visible {
        opacity: 1;
    }

    .modal-legal-contenido {
        max-height: 90dvh;
        opacity: 0;
        transform: translateY(18px) scale(.97);
        transition: opacity .3s ease, transform .3s cubic-bezier(.2, .8, .2, 1);
    }

    .modal-legal.modal-visible .modal-legal-contenido {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    @media (prefers-reduced-motion: reduce) {
        .modal-legal,
        .modal-legal-contenido {
            transition: none !important;
        }
    }
</style>

<script>
    // ---------- Modales legales del registro ----------
    // Uso: abrirModalLegal('modalTerminos', 'chkTerminosUsuario')
    //      abrirModalLegal('modalDatos', 'chkDatosEmpresa')
    let casillaLegalActiva = null;

    function abrirModalLegal(idModal, idCasilla) {
        const modal = document.getElementById(idModal);
        if (!modal) return;

        casillaLegalActiva = idCasilla;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.querySelector('[data-contenido-legal]')?.scrollTo({ top: 0 });

        void modal.offsetWidth;
        modal.classList.add('modal-visible');
    }

    function cerrarModalLegal() {
        document.querySelectorAll('.modal-legal.modal-visible').forEach(modal => {
            modal.classList.remove('modal-visible');
        });

        setTimeout(() => {
            document.querySelectorAll('.modal-legal:not(.modal-visible)').forEach(modal => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });
        }, 250);
    }

    // "Acepto" / "Autorizo": marca la casilla del formulario que abrió el modal
    function aceptarModalLegal() {
        const casilla = document.getElementById(casillaLegalActiva);

        if (casilla) {
            casilla.checked = true;
            casilla.dispatchEvent(new Event('change', { bubbles: true }));
        }

        cerrarModalLegal();
    }

    // Cerrar al pulsar fuera del contenido
    document.addEventListener('click', function (evento) {
        if (evento.target.classList?.contains('modal-legal')) cerrarModalLegal();
    });

    // Escape cierra solo el modal legal (captura, para que no cierre también el registro)
    document.addEventListener('keydown', function (evento) {
        if (evento.key === 'Escape' && document.querySelector('.modal-legal.modal-visible')) {
            evento.stopPropagation();
            cerrarModalLegal();
        }
    }, true);
</script>
