{{-- MODAL: POLÍTICA DE TRATAMIENTO DE DATOS PERSONALES --}}
{{-- Se incluye una sola vez desde registroLegal.blade.php · Abrir con abrirModalLegal('modalDatos', 'idDeLaCasilla') --}}
@php
    $btnPrimario = 'rounded-full border-2 border-marca bg-marca px-5 py-3 text-sm font-extrabold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white';
    $btnSecundario = 'rounded-full border-2 border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-noche transition hover:border-carbon hover:bg-carbon hover:text-white';
    $h3 = 'mt-4 text-sm font-bold text-noche';
    $p = 'mt-1 text-sm leading-relaxed text-slate-600';
    $ul = 'mt-1 list-disc space-y-0.5 pl-5 text-sm leading-relaxed text-slate-600';
@endphp

<div id="modalDatos" style="z-index:110"
    class="modal-legal fixed inset-0 hidden items-center justify-center bg-noche/80 px-3 py-4 backdrop-blur-md"
    role="dialog" aria-modal="true" aria-labelledby="tituloModalDatos">

    <div class="modal-legal-contenido relative flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl border border-white/70 bg-fondo shadow-2xl shadow-noche/40">
        <div class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
            <div>
                <h2 id="tituloModalDatos" class="text-lg font-extrabold text-noche">Política de Tratamiento de Datos Personales</h2>
                <p class="text-xs text-slate-500">Última actualización: noviembre de 2026.</p>
            </div>
            <button type="button" onclick="cerrarModalLegal()" aria-label="Cerrar modal"
                class="flex size-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-carbon">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div data-contenido-legal class="overflow-y-auto p-5 sm:p-6">
            <p class="{{ $p }} !mt-0">Esta política se rige por el artículo 15 de la Constitución Política de Colombia, la Ley 1581 de 2012 y su reglamentación, incluido el Decreto 1377 de 2013 compilado en el Decreto 1074 de 2015.</p>

            <h3 class="{{ $h3 }}">1. Identificación del responsable</h3>
            <p class="{{ $p }}">Antes de publicar esta política, deben completarse los datos de identificación y contacto del responsable del tratamiento:</p>
            <ul class="{{ $ul }} list-none pl-0">
                <li>Nombre o razón social del responsable: ______________________________</li>
                <li>Identificación: ______________________________</li>
                <li>Dirección física: ______________________________</li>
                <li>Correo electrónico para protección de datos: ______________________________</li>
                <li>Teléfono de contacto: ______________________________</li>
            </ul>

            <h3 class="{{ $h3 }}">2. Datos tratados</h3>
            <p class="{{ $p }}">Según el tipo de cuenta y las funciones utilizadas, se tratan los siguientes datos:</p>
            <ul class="{{ $ul }}">
                <li>Personas naturales: nombres, apellidos, fecha de nacimiento, tipo y número de documento, teléfono y correo electrónico, requeridos para el registro; y contraseña de acceso, almacenada de forma protegida. La foto de perfil es opcional.</li>
                <li>Empresas: nombre o razón social, NIT, dirección y correo electrónico, requeridos para el registro; y contraseña de acceso, almacenada de forma protegida. La foto de perfil es opcional.</li>
                <li>Hojas de vida: ubicación, nivel educativo, perfil profesional, experiencia laboral y, si se adjunta, archivo de hoja de vida.</li>
                <li>Actividad del servicio: ofertas publicadas, postulaciones, sus estados y calificaciones relacionadas.</li>
            </ul>
            <p class="{{ $p }}">No se solicitan datos sensibles como requisito general para utilizar la plataforma. Si excepcionalmente se llegan a tratar, se informará su carácter sensible y su suministro será facultativo, salvo las excepciones legales aplicables. El registro de personas naturales está reservado a mayores de 18 años.</p>

            <h3 class="{{ $h3 }}">3. Finalidades</h3>
            <ul class="{{ $ul }}">
                <li>Registrar y administrar cuentas, autenticar usuarios y proteger la seguridad del servicio.</li>
                <li>Crear y administrar hojas de vida y cuentas de empresa, y publicar y consultar ofertas laborales.</li>
                <li>Gestionar postulaciones y compartir la hoja de vida con la empresa responsable de la oferta a la que se postula el usuario, para el proceso de selección.</li>
                <li>Gestionar las calificaciones disponibles en la plataforma y prevenir usos fraudulentos o incumplimientos.</li>
                <li>Enviar comunicaciones relacionadas con el funcionamiento del servicio.</li>
            </ul>

            <h3 class="{{ $h3 }}">4. Derechos de los titulares</h3>
            <p class="{{ $p }}">Puedes conocer, actualizar y rectificar tus datos; solicitar prueba de la autorización; conocer el uso dado a la información; solicitar la supresión o revocar la autorización cuando proceda; acceder gratuitamente a tus datos y presentar quejas ante la Superintendencia de Industria y Comercio, una vez agotado el trámite de consulta o reclamo ante el responsable o encargado, conforme a la ley.</p>

            <h3 class="{{ $h3 }}">5. Consultas y reclamos</h3>
            <p class="{{ $p }}">Para ejercer tus derechos, envía tu solicitud al correo para protección de datos indicado en la sección 1. Las consultas se atenderán en un máximo de 10 días hábiles desde su recibo; si no es posible responder en ese plazo, se informará el motivo y la nueva fecha, que no podrá superar 5 días hábiles adicionales. Los reclamos se atenderán en un máximo de 15 días hábiles desde el día siguiente a su recibo; si no es posible, se informará el motivo y la nueva fecha, que no podrá superar 8 días hábiles adicionales. La solicitud debe identificar al titular y describir claramente la consulta o reclamo.</p>

            <h3 class="{{ $h3 }}">6. Compartición de información</h3>
            <p class="{{ $p }}">La hoja de vida podrá compartirse con la empresa que publicó la oferta a la que te postulaste, para gestionar la selección. También podrán tratar datos los proveedores tecnológicos que presten servicios necesarios para operar la plataforma, sujetos a las obligaciones legales y contractuales de protección de datos. La información podrá comunicarse a autoridades cuando exista una obligación o requerimiento legal válido.</p>

            <h3 class="{{ $h3 }}">7. Seguridad y conservación</h3>
            <p class="{{ $p }}">Se adoptarán medidas razonables de seguridad para proteger los datos frente a acceso, uso o pérdida no autorizados. La información se conservará durante el tiempo necesario para las finalidades autorizadas y para cumplir deberes legales o atender responsabilidades aplicables; después se suprimirá o tratará conforme a la ley.</p>

            <h3 class="{{ $h3 }}">8. Modificaciones y vigencia</h3>
            <p class="{{ $p }}">Esta política rige desde su publicación. Sus actualizaciones se publicarán en la plataforma con la fecha correspondiente y los cambios sustanciales se informarán oportunamente antes de implementarse. Cuando la ley lo requiera, se solicitará una nueva autorización.</p>

            <p class="{{ $p }} font-bold text-noche">Al marcar la casilla correspondiente, autorizas de manera previa, expresa e informada el tratamiento de tus datos conforme a esta política.</p>
        </div>

        <div class="flex justify-end gap-2 border-t border-slate-200 bg-white px-5 py-3">
            <button type="button" onclick="cerrarModalLegal()" class="{{ $btnSecundario }}">Cerrar</button>
            <button type="button" onclick="aceptarModalLegal()" class="{{ $btnPrimario }}">Autorizo</button>
        </div>
    </div>
</div>
