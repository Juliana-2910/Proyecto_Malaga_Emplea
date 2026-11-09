        {{-- MODAL COMPLETAR MI HOJA DE VIDA --}}
        @php
            $niveles = [
                'Basica Primaria'   => 'Básica primaria',
                'Basica Secundaria' => 'Básica secundaria',
                'Tecnico'           => 'Técnico',
                'Tecnologo'         => 'Tecnólogo',
                'Profesional'       => 'Profesional',
            ];

            $campoHv = 'font-family:inherit;font-size:15px;padding:12px 14px;border:1.5px solid #CBD2D9;border-radius:10px;color:#1F2933;background:#FFFFFF;width:100%;box-sizing:border-box';
            $labelHv = 'display:flex;flex-direction:column;gap:6px;font-size:13px;font-weight:500;color:#52606D';
            $errorHv = 'font-size:12px;font-weight:600;color:#B42318';

            $urlArchivoHv = !empty($hojaDeVida?->archivoCV)
                ? asset('storage/' . $hojaDeVida->archivoCV)
                : '';

            $nombreArchivoHv = !empty($hojaDeVida?->archivoCV)
                ? basename($hojaDeVida->archivoCV)
                : '';

            $fechaArchivoHv = !empty($hojaDeVida?->archivoCV) && !empty($hojaDeVida->fechaActualizacion)
                ? 'Actualizado el ' . \Carbon\Carbon::parse($hojaDeVida->fechaActualizacion)->format('d/m/Y')
                : '';
        @endphp

        <div id="modal-hoja-de-vida" hidden
            data-abrir-al-cargar="{{ $errors->any() ? '1' : '0' }}"
            style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:55;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;background:rgba(18,48,63,0.6)">

            <div role="dialog" aria-modal="true" aria-labelledby="hv-titulo"
                style="width:100%;max-width:720px;max-height:100%;display:flex;flex-direction:column;overflow:hidden;border-radius:20px;background:#FFFFFF;box-shadow:0 24px 64px rgba(18,48,63,0.35);font-family:inherit">

                {{-- Encabezado --}}
                <div style="padding:28px 28px 20px;display:flex;flex-direction:column;gap:18px;border-bottom:1px solid #E3E8EF">

                    <div style="display:flex;align-items:flex-start;gap:16px">

                        <span style="width:56px;height:56px;border-radius:14px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            </svg>
                        </span>

                        <div style="flex:1 1 auto;min-width:0;display:flex;flex-direction:column;gap:4px">
                            <h2 id="hv-titulo" style="margin:0;font-size:24px;font-weight:700;color:#12303F;line-height:1.25">
                                Mi hoja de vida
                            </h2>

                            <span style="font-size:15px;line-height:1.5;color:#52606D">
                                Quien publica una oferta la revisa cuando te postulas.
                            </span>
                        </div>

                        <button type="button" data-cerrar-hoja aria-label="Cerrar"
                            style="width:44px;height:44px;flex:0 0 auto;border-radius:12px;border:none;background:#F5F7FA;color:#1F2933;display:flex;align-items:center;justify-content:center;cursor:pointer">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                    </div>

                    {{-- Progreso --}}
                    <div style="display:flex;flex-direction:column;gap:6px">

                        <span id="hv-progreso-texto" style="font-size:13px;font-weight:700;color:#52606D">
                            {{ $hojaDeVidaProgreso }}% completado
                        </span>

                        <div style="height:10px;border-radius:999px;background:#E3E8EF">
                            <div id="hv-progreso-barra"
                                style="width:{{ $hojaDeVidaProgreso }}%;height:10px;border-radius:999px;background:#4DB6E8;transition:width .2s">
                            </div>
                        </div>

                    </div>
                </div>

                <form id="hv-form" method="POST"
                    action="{{ route('Publico.guardarHojaDeVida') }}"
                    enctype="multipart/form-data"
                    style="margin:0;display:flex;flex-direction:column;min-height:0;flex:1 1 auto">

                    @csrf

                    {{-- TEMPORAL: cuando exista el login, este campo se quita y el usuario sale de la sesión --}}
                    @if (!empty($idUsuario))
                        <input type="hidden" name="idUsuario" value="{{ $idUsuario }}">
                    @endif

                    {{-- Formulario --}}
                    <div style="padding:24px 28px;display:flex;flex-direction:column;gap:20px;overflow:auto">

                        {{-- Ubicación y nivel educativo --}}
                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px">

                            <label style="{{ $labelHv }}">
                                Ubicación

                                <input type="text" name="ubicacion" data-hv-campo maxlength="255"
                                    placeholder="Ej.: Málaga, Santander"
                                    value="{{ $errors->any() ? old('ubicacion') : ($hojaDeVida->ubicacion ?? '') }}"
                                    style="{{ $campoHv }}">

                                @error('ubicacion')
                                    <span style="{{ $errorHv }}">{{ $message }}</span>
                                @enderror
                            </label>

                            <label style="{{ $labelHv }}">
                                Nivel Educativo

                                <select name="nivelEducativo" data-hv-campo
                                    style="{{ $campoHv }};min-height:46px">

                                    <option value="">Selecciona una opción</option>

                                    @foreach ($niveles as $valor => $texto)
                                        <option value="{{ $valor }}"
                                            @selected(old('nivelEducativo', $hojaDeVida->nivelEducativo ?? '') === $valor)>
                                            {{ $texto }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('nivelEducativo')
                                    <span style="{{ $errorHv }}">{{ $message }}</span>
                                @enderror
                            </label>

                        </div>

                        {{-- Perfil personal --}}
                        <label style="{{ $labelHv }}">

                            <span style="display:flex;justify-content:space-between;gap:12px">
                                <span>Perfil Personal</span>

                                <span data-hv-contador style="font-weight:600;color:#7B8794"></span>
                            </span>

                            <textarea name="perfilProfesional" data-hv-campo data-hv-max
                                rows="3" maxlength="255"
                                placeholder="Cuéntale a quien publica quién eres y qué sabes hacer"
                                style="{{ $campoHv }};line-height:1.5;resize:vertical">{{ old('perfilProfesional', $hojaDeVida->perfilProfesional ?? '') }}</textarea>

                            @error('perfilProfesional')
                                <span style="{{ $errorHv }}">{{ $message }}</span>
                            @enderror

                        </label>

                        {{-- Experiencia laboral --}}
                        <label style="{{ $labelHv }}">

                            <span style="display:flex;justify-content:space-between;gap:12px">
                                <span>Experiencia Laboral</span>

                                <span data-hv-contador style="font-weight:600;color:#7B8794"></span>
                            </span>

                            <textarea name="experienciaLaboral" data-hv-campo data-hv-max
                                rows="3" maxlength="255"
                                placeholder="Dónde has trabajado, qué hacías y por cuánto tiempo"
                                style="{{ $campoHv }};line-height:1.5;resize:vertical">{{ old('experienciaLaboral', $hojaDeVida->experienciaLaboral ?? '') }}</textarea>

                            @error('experienciaLaboral')
                                <span style="{{ $errorHv }}">{{ $message }}</span>
                            @enderror

                        </label>

                        {{-- Archivo PDF (opcional) --}}
                        <div style="display:flex;flex-direction:column;gap:8px">

                            <span style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;color:#52606D">
                                Archivo CV en PDF

                                <span style="padding:2px 8px;border-radius:999px;background:#F5F7FA;border:1px solid #E3E8EF;font-size:11px;font-weight:700;color:#7B8794">
                                    Opcional
                                </span>
                            </span>

                            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px">

                                {{-- Izquierda: elegir o arrastrar --}}
                                <label id="hv-zona"
                                    style="border:2px dashed #CBD2D9;border-radius:14px;padding:22px 18px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:8px;background:#F5F7FA;cursor:pointer">

                                    <input type="file" id="hv-archivo" name="archivoCV"
                                        accept="application/pdf,.pdf" style="display:none">

                                    <span style="width:44px;height:44px;border-radius:999px;background:#EAF6FD;color:#1A75A8;display:flex;align-items:center;justify-content:center">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                        </svg>
                                    </span>

                                    <span id="hv-zona-titulo"
                                        style="font-size:15px;font-weight:700;color:#12303F;word-break:break-all">
                                        Elige tu archivo o arrástralo aquí
                                    </span>

                                    <span id="hv-zona-ayuda"
                                        style="font-size:13px;color:#52606D">
                                        Solo PDF · máximo 5 MB
                                    </span>

                                </label>

                                {{-- Derecha: archivo actual o seleccionado --}}
                                <div id="hv-archivo-panel"
                                    data-archivo-url="{{ !empty($hojaDeVida?->archivoCV) ? asset('storage/' . $hojaDeVida->archivoCV) : '' }}"
                                    data-archivo-nombre="{{ !empty($hojaDeVida?->archivoCV) ? basename($hojaDeVida->archivoCV) : '' }}"
                                    data-archivo-fecha="{{ !empty($hojaDeVida?->archivoCV) ? 'Actualizado el ' . \Carbon\Carbon::parse($hojaDeVida->fechaActualizacion)->format('d/m/Y') : '' }}"
                                    style="border:1px solid #E3E8EF;border-radius:14px;padding:22px 18px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:8px;background:#FFFFFF">

                                    <span id="hv-archivo-titulo" style="font-size:12px;font-weight:800;color:#52606D;text-transform:uppercase;letter-spacing:0.04em">
                                        {{ !empty($hojaDeVida?->archivoCV) ? 'Archivo actual' : 'Vista previa' }}
                                    </span>

                                    <span id="hv-archivo-icono" style="width:44px;height:44px;border-radius:12px;background:#FEE2E2;color:#B42318;display:{{ !empty($hojaDeVida?->archivoCV) ? 'flex' : 'none' }};align-items:center;justify-content:center;font-size:12px;font-weight:800">
                                        PDF
                                    </span>

                                    <div id="hv-archivo-detalle" style="min-width:0;max-width:100%;display:{{ !empty($hojaDeVida?->archivoCV) ? 'flex' : 'none' }};flex-direction:column;gap:2px">

                                        <span id="hv-archivo-nombre" style="font-size:14px;font-weight:700;color:#1F2933;word-break:break-all">
                                            {{ !empty($hojaDeVida?->archivoCV) ? basename($hojaDeVida->archivoCV) : '' }}
                                        </span>

                                        <span id="hv-archivo-fecha" style="font-size:12px;color:#52606D">
                                            {{ !empty($hojaDeVida?->archivoCV) ? 'Actualizado el ' . \Carbon\Carbon::parse($hojaDeVida->fechaActualizacion)->format('d/m/Y') : '' }}
                                        </span>

                                    </div>

                                    <span id="hv-archivo-vacio" style="font-size:13px;color:#7B8794;display:{{ !empty($hojaDeVida?->archivoCV) ? 'none' : 'block' }}">
                                        Aún no has subido un archivo.
                                    </span>

                                    <a id="hv-archivo-ver"
                                        href="{{ !empty($hojaDeVida?->archivoCV) ? asset('storage/' . $hojaDeVida->archivoCV) : '#' }}"
                                        target="_blank" rel="noopener"
                                        style="width:38px;height:38px;border:1px solid #E3E8EF;border-radius:50%;display:{{ !empty($hojaDeVida?->archivoCV) ? 'inline-flex' : 'none' }};align-items:center;justify-content:center;background:#FFFFFF;color:#1A75A8;;text-decoration:none;transition:all 0.2s ease"
                                        title="Ver archivo PDF"
                                        aria-label="Ver archivo PDF">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"> <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                </div>
                            </div>

                            @error('archivoCV')
                                <span style="{{ $errorHv }}">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                    {{-- Botonoes --}}
                    <div style="padding:18px 28px;border-top:1px solid #E3E8EF;display:flex;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:12px;background:#FFFFFF">

                        <button type="button" data-cerrar-hoja
                            class="{{ $btnSecundario }} cursor-pointer">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="{{ $btnPrimario }} cursor-pointer">
                            Guardar
                        </button>

                    </div>

                </form>

            </div>
        </div>

    @push('scripts')
        <script>

            // Modal completar mi hoja de vida //

            (function () {
                const modal = document.getElementById('modal-hoja-de-vida');
                const archivo = document.getElementById('hv-archivo');
                const zona = document.getElementById('hv-zona');
                const zonaTitulo = document.getElementById('hv-zona-titulo');
                const zonaAyuda = document.getElementById('hv-zona-ayuda');
                const campos = modal.querySelectorAll('[data-hv-campo]');
                const TEXTO_INICIAL = zonaTitulo.textContent;
                const AYUDA_INICIAL = zonaAyuda.textContent;
                const TIENE_ARCHIVO = {{ ! empty($hojaDeVida?->archivoCV) ? 'true' : 'false' }};
                let botonOrigen = null;

                // Elementos del panel derecho del archivo CV
                const panelArchivo = document.getElementById('hv-archivo-panel');
                const archivoTitulo = document.getElementById('hv-archivo-titulo');
                const archivoIcono = document.getElementById('hv-archivo-icono');
                const archivoDetalle = document.getElementById('hv-archivo-detalle');
                const archivoNombre = document.getElementById('hv-archivo-nombre');
                const archivoFecha = document.getElementById('hv-archivo-fecha');
                const archivoVacio = document.getElementById('hv-archivo-vacio');
                const archivoVer = document.getElementById('hv-archivo-ver');

                // Información del archivo que ya está guardado
                const URL_ARCHIVO_ACTUAL = panelArchivo.dataset.archivoUrl;
                const NOMBRE_ARCHIVO_ACTUAL = panelArchivo.dataset.archivoNombre;
                const FECHA_ARCHIVO_ACTUAL = panelArchivo.dataset.archivoFecha;

                // URL temporal del archivo seleccionado
                let urlVistaPrevia = null;

                // Contadores y barra de progreso (5 elementos, 20% cada uno)
                function actualizar() {
                    modal.querySelectorAll('[data-hv-max]').forEach(function (t) {
                        t.closest('label').querySelector('[data-hv-contador]').textContent = t.value.length + '/255';
                    });

                    let llenos = 0;

                    campos.forEach(function (c) {
                        if (c.value.trim() !== '') llenos++;
                    });

                    if (TIENE_ARCHIVO || archivo.files.length) llenos++;

                    const pct = Math.round(llenos * 100 / 5);

                    document.getElementById('hv-progreso-texto').textContent = pct + '% completado';
                    document.getElementById('hv-progreso-barra').style.width = pct + '%';
                }

                // Mostrar información del archivo en el panel derecho
                function mostrarArchivo(nombre, url, fecha, titulo) {
                    archivoTitulo.textContent = titulo;
                    archivoIcono.style.display = 'flex';
                    archivoDetalle.style.display = 'flex';
                    archivoVacio.style.display = 'none';

                    archivoNombre.textContent = nombre;
                    archivoFecha.textContent = fecha;

                    archivoVer.href = url;
                    archivoVer.style.display = 'inline-flex';
                }

                // Restaurar el archivo que ya estaba guardado
                function restaurarArchivoActual() {
                    if (URL_ARCHIVO_ACTUAL) {
                        mostrarArchivo(
                            NOMBRE_ARCHIVO_ACTUAL,
                            URL_ARCHIVO_ACTUAL,
                            FECHA_ARCHIVO_ACTUAL,
                            'Archivo actual'
                        );
                    } else {
                        archivoTitulo.textContent = 'Vista previa';
                        archivoIcono.style.display = 'none';
                        archivoDetalle.style.display = 'none';
                        archivoVacio.style.display = 'block';
                        archivoVer.style.display = 'none';
                        archivoVer.href = '#';
                    }
                }

                // Liberar URL temporal de vista previa
                function liberarVistaPrevia() {
                    if (urlVistaPrevia) {
                        URL.revokeObjectURL(urlVistaPrevia);
                        urlVistaPrevia = null;
                    }
                }

                // Seleccionar y validar archivo PDF
                function elegirArchivo() {
                    const f = archivo.files[0];

                    if (!f) {
                        zonaTitulo.textContent = TEXTO_INICIAL;
                        zonaAyuda.textContent = AYUDA_INICIAL;
                        zonaAyuda.style.color = '#52606D';

                        liberarVistaPrevia();
                        restaurarArchivoActual();

                        actualizar();
                        return;
                    }

                    // Validar formato y tamaño del archivo
                    const esPdf = f.type === 'application/pdf' || /\.pdf$/i.test(f.name);
                    const tamanoValido = f.size <= 5 * 1024 * 1024;

                    if (!esPdf || !tamanoValido) {
                        archivo.value = '';
                        zonaTitulo.textContent = TEXTO_INICIAL;

                        zonaAyuda.textContent = !esPdf
                            ? 'El archivo debe estar en formato PDF.'
                            : 'El archivo supera el tamaño máximo de 5 MB.';

                        zonaAyuda.style.color = '#B42318';

                        liberarVistaPrevia();
                        restaurarArchivoActual();

                        actualizar();
                        return;
                    }

                    // Liberar vista previa anterior
                    liberarVistaPrevia();

                    // Crear vista previa del PDF seleccionado
                    urlVistaPrevia = URL.createObjectURL(f);

                    // Actualizar panel derecho
                    mostrarArchivo(
                        f.name,
                        urlVistaPrevia,
                        'Pendiente de guardar',
                        'Archivo seleccionado'
                    );

                    // Actualizar zona izquierda
                    zonaTitulo.textContent = f.name;
                    zonaAyuda.textContent = 'Se guardará cuando presiones «Guardar»';
                    zonaAyuda.style.color = '#52606D';
                    actualizar();
                }

                // Evento al seleccionar un archivo
                archivo.addEventListener('change', elegirArchivo);

                ['dragenter', 'dragover'].forEach(function (ev) {
                    zona.addEventListener(ev, function (e) {
                        e.preventDefault();
                        zona.style.borderColor = '#4DB6E8';
                        zona.style.background = '#EAF6FD';
                    });
                });

                ['dragleave', 'drop'].forEach(function (ev) {
                    zona.addEventListener(ev, function (e) {
                        e.preventDefault();
                        zona.style.borderColor = '#CBD2D9';
                        zona.style.background = '#F5F7FA';
                    });
                });

                // Recibir archivo arrastrado
                zona.addEventListener('drop', function (e) {
                    if (e.dataTransfer.files.length) {
                        archivo.files = e.dataTransfer.files;
                        elegirArchivo();
                    }
                });

                modal.addEventListener('input', actualizar);

                // Abrir modal
                function abrir(boton) {
                    botonOrigen = boton || null;
                    actualizar();
                    modal.hidden = false;
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }

                // Cerrar modal
                function cerrar() {
                    modal.hidden = true;
                    modal.style.display = 'none';

                    // Descartar archivo nuevo que no se haya guardado
                    archivo.value = '';

                    // Liberar URL temporal
                    liberarVistaPrevia();

                    // Restaurar zona de selección
                    zonaTitulo.textContent = TEXTO_INICIAL;
                    zonaAyuda.textContent = AYUDA_INICIAL;
                    zonaAyuda.style.color = '#52606D';

                    // Restaurar archivo actual en el panel derecho
                    restaurarArchivoActual();

                    const ofertaAbierta = document.getElementById('modal-oferta') && !document.getElementById('modal-oferta').hidden;

                    if (!ofertaAbierta) document.body.style.overflow = '';

                    if (botonOrigen) botonOrigen.focus();

                    actualizar();
                }

                document.addEventListener('click', function (e) {
                    const boton = e.target.closest('[data-abrir-hoja-de-vida]');

                    if (boton) {
                        abrir(boton);
                        return;
                    }

                    if (e.target.closest('[data-cerrar-hoja]') || e.target === modal) {
                        cerrar();
                    }
                });

                // Escape cierra solo este modal (captura para que no cierre también el de la oferta)
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !modal.hidden) {
                        e.stopImmediatePropagation();
                        cerrar();
                    }
                }, true);

                // Si el servidor devolvió errores de validación, se abre solo
                if (modal.dataset.abrirAlCargar === '1') abrir(null);

                // Inicializar panel derecho y progreso
                restaurarArchivoActual();
                actualizar();
            })();
        </script>
    @endpush
