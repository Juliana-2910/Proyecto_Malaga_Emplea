{{--
    Contenido del modal "Calificaciones recibidas".
    Lo envía PerfilController (mostrarCalificaciones) y lo pega user-dropdown dentro del modal.
    Variables: $calificaciones (paginador, cada fila trae urlPostulacion calculada en calificacionService), $cuenta, $reputacion ['promedio','total'], $nombreCuenta, $esEmpresa, $foto
--}}
@php
    $promedio = (float) ($reputacion['promedio'] ?? 0);
    $total = (int) ($reputacion['total'] ?? 0);
    $textoPromedio = rtrim(rtrim(number_format($promedio, 2, '.', ''), '0'), '.');
    $esPropio = (bool) request()->user()?->is($cuenta);
    $inicial = mb_strtoupper(mb_substr($nombreCuenta, 0, 1));

    $rutaEstrella = 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z';

    // Dibuja 5 estrellas: las primeras $llenas amarillas y el resto vacías.
    $estrellas = function (int $llenas, string $tam) use ($rutaEstrella): string {
        $html = '<span class="flex gap-0.5">';
        for ($i = 1; $i <= 5; $i++) {
            $estilo = $i <= $llenas ? 'fill-[#F5B72E] stroke-[#F5B72E]' : 'fill-none stroke-slate-300';
            $html .= '<svg class="' . $tam . ' ' . $estilo . '" viewBox="0 0 24 24" stroke-width="1.4" stroke-linejoin="round" aria-hidden="true"><path d="' . $rutaEstrella . '"/></svg>';
        }
        return $html . '</span>';
    };
@endphp

<div class="flex flex-col gap-5">

    {{-- ENCABEZADO: persona + promedio general --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:gap-6">
        <div class="flex min-w-0 items-center gap-4 md:flex-1">
            @if ($foto)
                <img src="{{ $foto }}" alt="Foto de {{ $nombreCuenta }}" class="size-20 shrink-0 rounded-full border-2 border-black object-cover sm:size-24">
            @else
                <span class="flex size-20 shrink-0 items-center justify-center rounded-full border-2 border-black bg-noche text-3xl font-extrabold text-white sm:size-24">{{ $inicial }}</span>
            @endif
            <div class="flex min-w-0 flex-col items-start gap-2">
                <h3 class="break-words text-2xl font-extrabold leading-tight text-noche sm:text-[28px]">{{ $nombreCuenta }}</h3>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF6FD] px-3.5 py-1.5 text-sm font-extrabold text-marca-texto">
                    @if ($esEmpresa)
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
                        Publicador
                    @else
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/></svg>
                        Usuario
                    @endif
                </span>
                <p class="text-sm text-slate-600 sm:text-[15px]">Aquí puedes consultar las opiniones recibidas.</p>
            </div>
        </div>

        <div class="flex flex-col items-center gap-1.5 rounded-2xl bg-[#F2F9FE] p-4 md:rounded-none md:border-l md:border-slate-200 md:bg-transparent md:py-0 md:pl-7 md:pr-0">
            @if ($total > 0)
                <span class="flex items-center gap-3.5">
                    {!! $estrellas((int) round($promedio), 'size-7 sm:size-8') !!}
                    <span class="text-3xl font-extrabold text-noche">{{ $textoPromedio }} <span class="text-xl font-semibold text-slate-600">/ 5</span></span>
                </span>
                <span class="text-sm font-semibold text-slate-600">Promedio general · {{ $total }} {{ $total === 1 ? 'calificación' : 'calificaciones' }}</span>
            @else
                <span class="text-lg font-extrabold text-slate-600">Aún sin calificaciones</span>
                <span class="text-sm font-semibold text-slate-500">Promedio general</span>
            @endif
        </div>
    </div>

    {{-- HISTORIAL: una sola lista, de la más reciente a la más antigua --}}
    @if ($calificaciones->isEmpty())
        <div class="rounded-2xl border border-dashed border-[#B9E3F6] bg-[#F2F9FE] px-6 py-10 text-center">
            <p class="text-lg font-extrabold text-noche">{{ $esPropio ? 'Aún no tienes calificaciones' : 'Esta cuenta aún no tiene calificaciones' }}</p>
            <p class="mt-1 text-sm text-slate-600">Cuando alguien califique una contratación, aparecerá aquí.</p>
        </div>
    @else
        <div class="flex flex-col gap-3">
            @foreach ($calificaciones as $calificacion)
                @php
                    $esPublicador = (bool) $calificacion->esPublicadorCalificador;
                    $tituloOferta = $calificacion->postulacion?->oferta?->titulo ?? 'Oferta relacionada';
                    $puntos = (int) $calificacion->puntuacion;
                    $fecha = $calificacion->fecha ? \Carbon\Carbon::parse($calificacion->fecha)->format('d/m/Y') : '—';
                @endphp
                <article class="{{ $calificacion->urlPostulacion ? 'cursor-pointer transition hover:border-[#80C7E8] hover:shadow-md' : '' }} relative grid overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_1px_3px_rgba(18,48,63,0.06)] md:grid-cols-[132px_minmax(0,1.15fr)_minmax(0,.95fr)_minmax(0,1.3fr)]">
                    @if ($calificacion->urlPostulacion)
                        <a href="{{ $calificacion->urlPostulacion }}" aria-label="Abrir la postulación de {{ $tituloOferta }}" class="absolute inset-0 z-10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-inset focus:ring-marca"></a>
                    @endif

                    {{-- A. Tipo de calificador --}}
                    <div class="flex items-center gap-3 bg-[#F2F9FE] px-4 py-3 md:flex-col md:justify-center md:gap-2 md:px-2.5 md:py-3.5">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-[#E1F1FB] text-marca-texto md:size-14 md:rounded-2xl">
                            @if ($esPublicador)
                                <svg class="size-6 md:size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
                            @else
                                <svg class="size-6 md:size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/></svg>
                            @endif
                        </span>
                        <span class="rounded-full bg-white px-3 py-0.5 text-[13px] font-extrabold text-marca-texto">{{ $esPublicador ? 'Publicador' : 'Usuario' }}</span>
                    </div>

                    {{-- B. Contratación: oferta y quién calificó --}}
                    <div class="flex min-w-0 flex-col justify-center gap-1 border-t border-slate-200 px-5 py-4 md:border-l md:border-t-0">
                        <h4 class="break-words text-[17px] font-extrabold leading-snug text-noche">{{ $tituloOferta }}</h4>
                        <span class="text-sm text-slate-600">
                            {{ $esPublicador ? 'Publicado por:' : 'Calificado por:' }}
                            <strong class="font-extrabold text-marca-texto">{{ $calificacion->nombreCalificador ?: 'Cuenta relacionada' }}</strong>
                        </span>
                    </div>

                    {{-- C. Puntuación y fecha --}}
                    <div class="flex min-w-0 flex-col justify-center gap-2 border-t border-slate-200 px-5 py-4 md:border-l md:border-t-0">
                        <span class="flex items-center gap-2.5">
                            <span role="img" aria-label="{{ $puntos }} de 5 estrellas">{!! $estrellas($puntos, 'size-5') !!}</span>
                            <span class="text-base font-extrabold text-noche">{{ number_format($puntos, 1, '.', '') }} <span class="font-semibold text-slate-600">/ 5</span></span>
                        </span>
                        <span class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="size-[18px] shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            {{ $fecha }}
                            @if ($calificacion->urlPostulacion)
                            <span class="text-xs font-extrabold text-marca-texto">Ver postulación →</span>
                        @endif
                        </span>

                    </div>

                    {{-- D. Comentario --}}
                    <div class="flex min-w-0 items-center border-t border-slate-200 px-5 py-4 md:border-l md:border-t-0">
                        <p class="break-words text-[15px] italic leading-relaxed text-slate-700">“{{ $calificacion->comentario ?: 'Sin comentario.' }}”</p>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Paginación (los enlaces con data-calificaciones-page los atiende user-dropdown) --}}
        @if ($calificaciones->hasPages())
            @php
                $paginaInicio = max(1, $calificaciones->currentPage() - 2);
                $paginaFin = min($calificaciones->lastPage(), $calificaciones->currentPage() + 2);
            @endphp
            <nav aria-label="Paginación de calificaciones" class="flex flex-wrap items-center justify-center gap-1.5 pt-1">
                @if ($calificaciones->onFirstPage())
                    <span class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-400">Anterior</span>
                @else
                    <a data-calificaciones-page href="{{ $calificaciones->previousPageUrl() }}" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-noche hover:bg-[#EAF6FD]">Anterior</a>
                @endif
                @foreach ($calificaciones->getUrlRange($paginaInicio, $paginaFin) as $pagina => $url)
                    @if ($pagina === $calificaciones->currentPage())
                        <span aria-current="page" class="rounded-lg border border-marca bg-marca px-3 py-2 text-sm font-extrabold text-noche">{{ $pagina }}</span>
                    @else
                        <a data-calificaciones-page href="{{ $url }}" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-noche hover:bg-[#EAF6FD]">{{ $pagina }}</a>
                    @endif
                @endforeach
                @if ($calificaciones->hasMorePages())
                    <a data-calificaciones-page href="{{ $calificaciones->nextPageUrl() }}" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-noche hover:bg-[#EAF6FD]">Siguiente</a>
                @else
                    <span class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-400">Siguiente</span>
                @endif
            </nav>
        @endif
    @endif
</div>
