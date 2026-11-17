{{--
    Base compartida de los modales de registro.
    Contiene SOLO lo que comparten los tres modales (estilos del modal, abrir/cerrar,
    mostrar contraseña y envío por fetch). Cada modal la incluye y la directiva once evita que se cargue dos veces.
--}}
@once
<style>
    /* Modales de registro: aparición suave */
    .modal-registro {
        opacity: 0;
        transition: opacity .25s ease;
    }

    .modal-registro.modal-visible {
        opacity: 1;
    }

    .modal-registro-contenido {
        max-height: 90dvh;
        opacity: 0;
        transform: translateY(18px) scale(.97);
        transition: opacity .3s ease, transform .3s cubic-bezier(.2, .8, .2, 1);
    }

    .modal-registro.modal-visible .modal-registro-contenido {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .etapa-animacion {
        animation: aparecerEtapa .35s ease both;
    }

    @keyframes aparecerEtapa {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .campo-registro {
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .campo-registro:focus {
        border-color: #4DB6E8;
        box-shadow: 0 0 0 3px rgba(77, 182, 232, .2);
    }

    @media (prefers-reduced-motion: reduce) {
        .modal-registro,
        .modal-registro-contenido,
        .etapa-animacion {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<script>
    // ---------- Apertura y cierre de los modales de registro ----------
    // Uso: abrirModalRegistro()           → selector de tipo de cuenta
    //      abrirModalRegistro('usuario')  → registro de persona natural
    //      abrirModalRegistro('empresa')  → registro de empresa
    const modalesRegistro = {
        tipo: 'modalRegistroTipo',
        usuario: 'modalRegistroUsuario',
        empresa: 'modalRegistroEmpresa',
    };

    function ocultarModalRegistro(modal) {
        modal.classList.remove('modal-visible', 'flex');
        modal.classList.add('hidden');
    }

    function abrirModalRegistro(tipo = null) {
        const modal = document.getElementById(modalesRegistro[tipo] ?? modalesRegistro.tipo);
        if (!modal) return;

        document.querySelectorAll('.modal-registro').forEach(otro => {
            if (otro !== modal) ocultarModalRegistro(otro);
        });

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        modal.querySelector('[data-contenido-registro]')?.scrollTo({ top: 0 });

        void modal.offsetWidth;
        modal.classList.add('modal-visible');
    }

    function cerrarModalRegistro() {
        document.querySelectorAll('.modal-registro.modal-visible').forEach(modal => {
            modal.classList.remove('modal-visible');
        });

        setTimeout(() => {
            document.querySelectorAll('.modal-registro:not(.modal-visible)').forEach(ocultarModalRegistro);

            if (!document.querySelector('.modal-registro.modal-visible')) {
                document.body.classList.remove('overflow-hidden');
            }
        }, 250);
    }

    // Cerrar al pulsar fuera del contenido
    document.addEventListener('click', function (evento) {
        if (evento.target.classList?.contains('modal-registro')) cerrarModalRegistro();
    });

    // Cerrar con Escape
    document.addEventListener('keydown', function (evento) {
        if (evento.key === 'Escape' && document.querySelector('.modal-registro.modal-visible')) {
            cerrarModalRegistro();
        }
    });

    // ---------- Mostrar / ocultar contraseñas de registro ----------
    function alternarPassword(id, boton) {
        const campo = document.getElementById(id);
        if (!campo) return;

        const mostrar = campo.type === 'password';
        campo.type = mostrar ? 'text' : 'password';

        boton.setAttribute(
            'aria-label',
            mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );

        boton.setAttribute(
            'title',
            mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );

        boton.innerHTML = mostrar
            ? `<svg class="size-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.5 12s3.4-6.5 9.5-6.5 9.5 6.5 9.5 6.5-3.4 6.5-9.5 6.5-9.5-6.5-9.5-6.5z"/>
                    <circle cx="12" cy="12" r="3"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.5 7.5 5 5.5M12 5.5V3.5M17.5 7.5 19 5.5"/>
               </svg>`
            : `<svg class="size-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 10.5c2.1 3 4.8 4.5 8 4.5s5.9-1.5 8-4.5M7 12.5l-1.5 2M12 15v2M17 12.5l1.5 2"/>
               </svg>`;
    }

    // ---------- Enviar el registro (persona natural y empresa) ----------
    async function enviarRegistro(formulario, ruta) {
        const boton = formulario.querySelector('[type="submit"]');
        const textoOriginal = boton.textContent;

        boton.disabled = true;
        boton.textContent = 'Registrando...';

        limpiarErrores(formulario);

        try {
            const respuesta = await fetch(ruta, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: new FormData(formulario)
            });

            const resultado = await respuesta.json().catch(() => ({}));

            if (!respuesta.ok) {
                if (respuesta.status === 422 && resultado.errors) {
                    mostrarErrores(formulario, resultado.errors);
                } else {
                    console.error('Respuesta del servidor:', respuesta.status, resultado);

                    mostrarMensajeRegistro(
                        resultado.message || 'No fue posible completar el registro. Inténtalo nuevamente.',
                        'error',
                        formulario
                    );
                }

                return;
            }

            formulario.reset();
            mostrarMensajeRegistro(resultado.mensaje, 'exito', formulario);

            window.location.href = resultado.redirect;

        } catch (error) {
            console.error('Error al registrar:', error);

            mostrarMensajeRegistro('No fue posible conectar con el servidor. Inténtalo nuevamente.', 'error', formulario);

        } finally {
            boton.disabled = false;
            boton.textContent = textoOriginal;
        }
    }

    function limpiarErrores(formulario) {
        formulario.querySelectorAll('.error-registro').forEach(error => error.remove());

        formulario.querySelectorAll('[name="terminos"], [name="datos"]').forEach(campo => {
            campo.classList.remove('campo-error', 'border-red-500');
        });

        formulario.querySelectorAll('.campo-registro').forEach(campo => {
            campo.classList.remove('campo-error', 'border-red-500');
        });

        formulario.closest('.modal-registro')?.querySelector('[data-mensaje-registro]')?.remove();
    }

    function mostrarErrores(formulario, errores) {
        Object.entries(errores).forEach(([campo, mensajes]) => {
            const input = formulario.querySelector(`[name="${campo}"]`);
            if (!input) return;

            input.classList.add('campo-error', 'border-red-500');

            const mensaje = document.createElement('p');
            mensaje.className = 'error-registro mt-1 block text-xs font-normal text-red-600';            mensaje.textContent = mensajes[0];

            const contenedorLegal = input.closest('[data-campo-legal]');
            let contenedorCampo = contenedorLegal ?? input.parentElement;

            if (!contenedorLegal && contenedorCampo.classList.contains('relative')) {
                contenedorCampo = contenedorCampo.parentElement;
            }

            contenedorCampo.appendChild(mensaje);
        });
    }

    function mostrarMensajeRegistro(mensaje, tipo, formulario) {
        const modal = formulario.closest('.modal-registro');
        let contenedor = modal.querySelector('[data-mensaje-registro]');

        if (!contenedor) {
            contenedor = document.createElement('div');
            contenedor.setAttribute('data-mensaje-registro', '');
            modal.querySelector('[data-contenido-registro]').prepend(contenedor);
        }

        contenedor.className = tipo === 'exito'
            ? 'mb-4 rounded-xl border border-green-300 bg-green-50 p-3 text-sm font-medium text-green-800'
            : 'mb-4 rounded-xl border border-red-300 bg-red-50 p-3 text-sm font-medium text-red-800';

        contenedor.textContent = mensaje;
    }
</script>

@include('layouts.Publico.registroLegal')
@endonce
