@if ($calificaciones->isEmpty())
    <div class="rounded-[20px] border border-dashed border-slate-300 bg-white px-6 py-10 text-center">
        <span class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-[#EAF6FD] text-amber-500">
            <svg class="size-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 2 2.9 5.88 6.49.94-4.7 4.58 1.11 6.47L12 16.82l-5.8 3.05 1.1-6.47-4.7-4.58 6.5-.94L12 2Z"/></svg>
        </span>
        <h3 class="mt-4 text-lg font-extrabold text-noche">Aún no tienes calificaciones</h3>
        <p class="mt-1 text-sm text-slate-600">Cuando completes un servicio y haya una calificación, aparecerá aquí.</p>
    </div>
@else
    <div class="grid gap-4 sm:grid-cols-2">
        @foreach ($calificaciones as $calificacion)
            <article class="flex h-full flex-col overflow-hidden rounded-[20px] border border-slate-100 bg-white shadow-md shadow-noche/5 transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="h-1.5 bg-gradient-to-r from-marca to-[#A9DDF5]"></div>
                <div class="flex flex-1 flex-col p-5">
                    <div class="flex items-start justify-between gap-3">
                        <span class="inline-flex items-center rounded-full bg-[#EAF6FD] px-3 py-1 text-xs font-extrabold text-marca-texto">{{ $calificacion->sentidoHistorial }}</span>
                        <time class="shrink-0 text-xs font-semibold text-slate-500" datetime="{{ $calificacion->fecha }}">{{ \Carbon\Carbon::parse($calificacion->fecha)->format('d/m/Y') }}</time>
                    </div>
                    <h3 class="mt-4 text-lg font-extrabold leading-snug text-noche">{{ $calificacion->nombreRelacionado ?: 'Cuenta relacionada' }}</h3>
                    @if ($calificacion->postulacion?->oferta)
                        <p class="mt-1 line-clamp-1 text-sm font-semibold text-slate-500">{{ $calificacion->postulacion->oferta->titulo }}</p>
                    @endif
                    <div class="mt-3 flex items-center gap-1" aria-label="{{ $calificacion->puntuacion }} de 5 estrellas">
                        @for ($estrella = 1; $estrella <= 5; $estrella++)
                            <svg class="size-4 {{ $estrella <= (int) $calificacion->puntuacion ? 'text-amber-400' : 'text-slate-200' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 2 2.9 5.88 6.49.94-4.7 4.58 1.11 6.47L12 16.82l-5.8 3.05 1.1-6.47-4.7-4.58 6.5-.94L12 2Z"/></svg>
                        @endfor
                        <span class="ml-1 text-sm font-extrabold text-noche">{{ $calificacion->puntuacion }}/5</span>
                    </div>
                    <p class="mt-4 flex-1 whitespace-pre-line break-words rounded-xl bg-[#F8FBFD] p-4 text-sm leading-relaxed text-slate-700">{{ $calificacion->comentario ?: 'Sin comentario.' }}</p>
                </div>
            </article>
        @endforeach
    </div>
@endif
