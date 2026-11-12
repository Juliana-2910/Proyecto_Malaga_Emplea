@php
    $promedio = $reputacion['promedio'] ?? 0;
    $promedioTexto = rtrim(rtrim(number_format($promedio, 2, '.', ''), '0'), '.');
    $total = $reputacion['total'] ?? 0;
    $estrellas = (int) round($promedio);
    $inicial = mb_strtoupper(mb_substr($nombreCuenta, 0, 1));
@endphp
<div class="space-y-3 sm:space-y-4">
    <section class="grid items-center gap-2 rounded-xl border border-slate-100 bg-white p-2.5 shadow-sm sm:grid-cols-[1fr_auto] sm:p-3">
        <div class="flex min-w-0 items-center gap-2.5">
            @if ($foto)
                <img src="{{ $foto }}" alt="Foto de {{ $nombreCuenta }}" class="size-12 shrink-0 rounded-full border-2 border-[#EAF6FD] object-cover sm:size-14">
            @else
                <span class="flex size-12 shrink-0 items-center justify-center rounded-full border-2 border-[#EAF6FD] bg-noche text-xl font-extrabold text-white sm:size-14">{{ $inicial }}</span>
            @endif
            <div class="min-w-0">
                <h3 class="truncate text-base font-extrabold text-noche sm:text-lg">{{ $nombreCuenta }}</h3>
                <span class="mt-0.5 inline-flex items-center gap-1 rounded-full bg-[#EAF6FD] px-2 py-0.5 text-[10px] font-bold text-marca-texto sm:text-xs">
                    @if ($esEmpresa)
                        <svg class="size-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v4h3a2 2 0 0 1 2 2v10h-7v-4h-4v4H3Zm4-14v2h2V7H7Zm0 4v2h2v-2H7Zm0 4v2h2v-2H7Zm5-8v2h2V7h-2Zm0 4v2h2v-2h-2Zm0 4v2h2v-2h-2Z"/></svg>
                        Publicador
                    @else
                        <svg class="size-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 1 1 14 0H5Z"/></svg>
                        Usuario
                    @endif
                </span>
                <p class="mt-0.5 text-[11px] leading-tight text-slate-600">Aquí puedes consultar las opiniones recibidas.</p>
            </div>
        </div>
        <div class="border-t border-slate-200 pt-2 text-center sm:border-l sm:border-t-0 sm:pl-3 sm:pt-0">
            @if ($total > 0)
                <div class="flex items-center justify-center gap-0.5" aria-label="Promedio {{ $promedioTexto }} de 5">
                    @for ($i = 1; $i <= 5; $i++)<svg class="size-5 {{ $i <= $estrellas ? 'text-amber-400' : 'text-slate-300' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 2 2.9 5.88 6.49.94-4.7 4.58 1.11 6.47L12 16.82l-5.8 3.05 1.1-6.47-4.7-4.58 6.5-.94L12 2Z"/></svg>@endfor
                    <strong class="ml-1 whitespace-nowrap text-xl text-noche">{{ $promedioTexto }} / 5</strong>
                </div>
                <p class="mt-0.5 text-[11px] text-slate-600">Promedio general · {{ $total }} {{ $total === 1 ? 'calificación' : 'calificaciones' }}</p>
            @else
                <p class="font-bold text-slate-600">Aún sin calificaciones</p>
                <p class="mt-1 text-sm text-slate-500">Promedio general</p>
            @endif
        </div>
    </section>

    @forelse ($calificaciones as $calificacion)
        @php
            $tipoAutor = $calificacion->esPublicadorCalificador ? 'Publicador' : 'Usuario';
            $puntuacion = (int) $calificacion->puntuacion;
            $postulacionRelacionada = $calificacion->postulacion;
            $ofertaRelacionada = $postulacionRelacionada?->oferta;
            $visor = auth()->user();
            $urlPostulacion = null;

            if ($visor instanceof \App\Models\Usuario && $postulacionRelacionada) {
                if ((int) $postulacionRelacionada->idUsuario === (int) $visor->id) {
                    $urlPostulacion = route('Publico.postulaciones', ['destacar' => $postulacionRelacionada->id]) . '#postulacion-' . $postulacionRelacionada->id;
                } elseif ((int) $ofertaRelacionada?->idUsuario === (int) $visor->id) {
                    $urlPostulacion = route('Publico.misOfertas.postulantes', ['id' => $ofertaRelacionada->id, 'destacar' => $postulacionRelacionada->id]) . '#postulacion-' . $postulacionRelacionada->id;
                }
            } elseif ($visor instanceof \App\Models\Empresa && $postulacionRelacionada
                && (int) $ofertaRelacionada?->idEmpresa === (int) $visor->id
                && $visor->can('ver postulacion')) {
                $urlPostulacion = route('Publico.misOfertas.postulantes', ['id' => $ofertaRelacionada->id, 'destacar' => $postulacionRelacionada->id]) . '#postulacion-' . $postulacionRelacionada->id;
            }
        @endphp
        <article class="{{ $urlPostulacion ? 'group relative cursor-pointer transition hover:border-[#80C7E8] hover:bg-[#F8FCFF] hover:shadow-md' : '' }} flex flex-wrap items-center gap-x-3 gap-y-1 rounded-xl border border-slate-200 bg-white px-2.5 py-2 shadow-sm">
            @if ($urlPostulacion)<a href="{{ $urlPostulacion }}" aria-label="Abrir postulación para {{ $calificacion->postulacion?->oferta?->titulo ?? 'la oferta' }} y revisar tu calificación" class="absolute inset-0 z-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-inset focus:ring-marca"></a>@endif
            <div class="flex shrink-0 items-center gap-1 rounded-lg bg-[#EAF6FD] px-2 py-1">
                @if ($tipoAutor === 'Publicador')<svg class="size-7 shrink-0 text-marca-texto" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21V5a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v4h3a2 2 0 0 1 2 2v10h-7v-4h-4v4H3Zm4-14v2h2V7H7Zm0 4v2h2v-2H7Zm0 4v2h2v-2H7Zm5-8v2h2V7h-2Zm0 4v2h2v-2h-2Zm0 4v2h2v-2h-2Z"/></svg>@else<svg class="size-7 shrink-0 text-marca-texto" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 1 1 14 0H5Z"/></svg>@endif
                <span class="text-[10px] font-extrabold text-marca-texto">{{ $tipoAutor }}</span>
            </div>
            <div class="min-w-0 flex-1 basis-40">
                <h3 class="truncate text-xs font-extrabold leading-tight text-noche">{{ $calificacion->postulacion?->oferta?->titulo ?? 'Oferta relacionada' }}</h3>
                <p class="truncate text-[11px] leading-tight text-slate-600">{{ $calificacion->esPublicadorCalificador ? 'Te calificó: ' : 'Calificado por: ' }}<span class="font-bold text-marca-texto">{{ $calificacion->nombreCalificador ?: 'Cuenta relacionada' }}</span></p>
            </div>
            <span class="inline-flex shrink-0 items-center gap-1 text-[11px] font-extrabold text-noche" aria-label="{{ $puntuacion }} de 5 estrellas">
                <span class="text-amber-400" aria-hidden="true">{{ str_repeat('★', $puntuacion) }}{{ str_repeat('☆', 5 - $puntuacion) }}</span>{{ $puntuacion }}/5
            </span>
            <time class="shrink-0 text-[10px] text-slate-500" datetime="{{ $calificacion->fecha }}">{{ \Carbon\Carbon::parse($calificacion->fecha)->format('d/m/Y') }}</time>
            @if ($urlPostulacion)<span class="ml-auto shrink-0 text-[10px] font-bold text-marca-texto">Ver postulación →</span>@endif
            <div class="basis-full truncate border-t border-slate-100 pt-1 text-[11px] italic leading-tight text-slate-600">
                {{ $calificacion->comentario ?: 'Sin comentario.' }}
            </div>
        </article>
    @empty
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-6 text-center text-sm text-slate-600">Aún no has recibido calificaciones. Cuando completes una contratación y te califiquen, aparecerá aquí.</div>
    @endforelse
    @if ($calificaciones->hasPages())
        @php
            $paginaInicio = max(1, $calificaciones->currentPage() - 2);
            $paginaFin = min($calificaciones->lastPage(), $calificaciones->currentPage() + 2);
        @endphp
        <nav aria-label="Paginación de calificaciones" class="flex flex-wrap items-center justify-center gap-1.5 pt-1">
            @if ($calificaciones->onFirstPage())
                <span class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs text-slate-400">Anterior</span>
            @else
                <a data-calificaciones-page href="{{ $calificaciones->previousPageUrl() }}" class="rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-bold text-noche hover:bg-[#EAF6FD]">Anterior</a>
            @endif
            @foreach ($calificaciones->getUrlRange($paginaInicio, $paginaFin) as $pagina => $url)
                @if ($pagina === $calificaciones->currentPage())
                    <span aria-current="page" class="rounded-lg border border-marca bg-marca px-2.5 py-1.5 text-xs font-extrabold text-white">{{ $pagina }}</span>
                @else
                    <a data-calificaciones-page href="{{ $url }}" class="rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-bold text-noche hover:bg-[#EAF6FD]">{{ $pagina }}</a>
                @endif
            @endforeach
            @if ($calificaciones->hasMorePages())
                <a data-calificaciones-page href="{{ $calificaciones->nextPageUrl() }}" class="rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-bold text-noche hover:bg-[#EAF6FD]">Siguiente</a>
            @else
                <span class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs text-slate-400">Siguiente</span>
            @endif
        </nav>
    @endif
    <footer class="flex flex-col gap-2 rounded-2xl bg-[#DFF2FC] p-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="flex items-center gap-3 text-sm text-marca-texto"><span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-marca font-extrabold text-white">i</span>El historial se actualiza automáticamente con cada nueva calificación.</p>
        <button type="button" onclick="this.closest('[role=dialog]').querySelector('header button').click()" class="rounded-xl bg-marca px-6 py-3 font-extrabold text-white transition hover:bg-[#176D99]">Cerrar</button>
    </footer>
</div>
