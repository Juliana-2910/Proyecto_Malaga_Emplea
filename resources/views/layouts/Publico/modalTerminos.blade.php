{{-- MODAL: TÉRMINOS Y CONDICIONES --}}
{{-- Se incluye una sola vez desde registroLegal.blade.php · Abrir con abrirModalLegal('modalTerminos', 'idDeLaCasilla') --}}
@php
    $btnPrimario = 'rounded-full border-2 border-marca bg-marca px-5 py-3 text-sm font-extrabold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white';
    $btnSecundario = 'rounded-full border-2 border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-noche transition hover:border-carbon hover:bg-carbon hover:text-white';
    $h3 = 'mt-4 text-sm font-bold text-noche';
    $p = 'mt-1 text-sm leading-relaxed text-slate-600';
@endphp

<div id="modalTerminos" style="z-index:110"
    class="modal-legal fixed inset-0 hidden items-center justify-center bg-noche/80 px-3 py-4 backdrop-blur-md"
    role="dialog" aria-modal="true" aria-labelledby="tituloModalTerminos">

    <div class="modal-legal-contenido relative flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-3xl border border-white/70 bg-fondo shadow-2xl shadow-noche/40">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
            <div>
                <h2 id="tituloModalTerminos" class="text-lg font-extrabold text-noche">Términos y Condiciones</h2>
                <p class="text-xs text-slate-500">Última actualización: noviembre de 2026.</p>
            </div>

            <button type="button" onclick="cerrarModalLegal()" aria-label="Cerrar modal"
                class="flex size-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-carbon">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- CONTENIDO --}}
        <div data-contenido-legal class="overflow-y-auto p-5 sm:p-6">
            <p class="{{ $p }} !mt-0">Málaga Emplea ofrece herramientas para registrar cuentas, crear hojas de vida, publicar y consultar ofertas laborales, gestionar postulaciones y calificaciones. Al crear una cuenta o utilizar estas funciones, aceptas las siguientes condiciones. La plataforma facilita la conexión entre usuarios y no se presenta como agencia de empleo autorizada ni garantiza una contratación.</p>

            <h3 class="{{ $h3 }}">1. Uso de la plataforma</h3>
            <p class="{{ $p }}">Utiliza la plataforma para las funciones laborales que ofrece y de acuerdo con la ley. Para registrarte como persona natural debes ser mayor de 18 años.</p>

            <h3 class="{{ $h3 }}">2. Información verdadera</h3>
            <p class="{{ $p }}">Cada persona y empresa debe proporcionar información veraz y mantenerla actualizada. Las empresas son responsables de la existencia, exactitud, legalidad y condiciones de las ofertas que publican, así como de la información y comunicaciones de sus procesos de selección. Se prohíben las ofertas fraudulentas, engañosas, discriminatorias o contrarias a la ley.</p>

            <h3 class="{{ $h3 }}">3. Prohibición de cobros y solicitudes de dinero</h3>
            <p class="{{ $p }}">Málaga Emplea no autoriza ni respalda solicitudes de dinero a cambio de:</p>
            <ul class="{{ $p }} list-disc space-y-0.5 pl-5">
                <li>Postularse a una oferta laboral.</li>
                <li>Participar en procesos de selección.</li>
                <li>Obtener una entrevista o ser contratado.</li>
                <li>Acceder a oportunidades laborales.</li>
            </ul>
            <p class="{{ $p }}">Ningún usuario debe exigir pagos por estos conceptos. No realices transferencias ni entregues información bancaria a quien lo solicite.</p>

            <h3 class="{{ $h3 }}">4. Responsabilidad de los usuarios</h3>
            <p class="{{ $p }}">Cada usuario responde por la información que proporciona, el contenido que publica y los acuerdos que establece con otros usuarios. Mantén tus credenciales de acceso seguras y no las compartas. Verifica la identidad y las condiciones de cualquier oportunidad antes de aceptarla.</p>

            <h3 class="{{ $h3 }}">5. Postulaciones y contrataciones</h3>
            <p class="{{ $p }}">Postularse no garantiza una entrevista, selección o contratación. La decisión de selección y los acuerdos de contratación corresponden a las partes. Málaga Emplea no garantiza que se celebre un contrato ni el cumplimiento de acuerdos entre usuarios. Las calificaciones solo estarán disponibles conforme a las funciones implementadas en la plataforma.</p>

            <h3 class="{{ $h3 }}">6. Respeto y buen comportamiento</h3>
            <p class="{{ $p }}">No se permite publicar contenido ofensivo, discriminatorio, fraudulento, ilegal o que vulnere los derechos de otras personas.</p>

            <h3 class="{{ $h3 }}">7. Protección de datos</h3>
            <p class="{{ $p }}">Tu información personal será tratada conforme a la legislación colombiana sobre protección de datos personales y a nuestra Política de Tratamiento de Datos Personales.</p>

            <h3 class="{{ $h3 }}">8. Incumplimientos</h3>
            <p class="{{ $p }}">Las publicaciones y cuentas deben respetar estos términos. Cuando se detecte un incumplimiento, la administración podrá utilizar las funciones disponibles para retirar una oferta o inactivar una cuenta, de acuerdo con la normativa aplicable.</p>

            <h3 class="{{ $h3 }}">9. Alcance de la plataforma</h3>
            <p class="{{ $p }}">La plataforma facilita herramientas para publicar y consultar ofertas y gestionar postulaciones. El servicio puede presentar interrupciones o indisponibilidad por mantenimiento o dificultades técnicas. No se garantiza la disponibilidad permanente de las ofertas, la atención de una postulación ni un resultado de contratación. Estas condiciones no limitan los derechos que la legislación reconoce a los usuarios.</p>

            <h3 class="{{ $h3 }}">10. Modificaciones</h3>
            <p class="{{ $p }}">Podremos actualizar estos términos cuando sea necesario. Los cambios se publicarán en la plataforma con su fecha de actualización.</p>

            <p class="{{ $p }} font-bold text-noche">Al utilizar Málaga Emplea, aceptas estas condiciones y te comprometes a hacer un uso responsable de la plataforma.</p>
        </div>

        {{-- PIE --}}
        <div class="flex justify-end gap-2 border-t border-slate-200 bg-white px-5 py-3">
            <button type="button" onclick="cerrarModalLegal()" class="{{ $btnSecundario }}">Cerrar</button>
            <button type="button" onclick="aceptarModalLegal()" class="{{ $btnPrimario }}">Acepto</button>
        </div>
    </div>
</div>
