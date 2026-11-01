@if ($paginator->hasPages())
    @php
        $base = 'flex min-h-11 min-w-11 items-center justify-center rounded-xl border-[1.5px] px-4 text-[15px] transition';
        $normal = $base . ' border-slate-300 bg-white font-semibold hover:border-carbon hover:bg-carbon hover:text-white';
        $activa = $base . ' border-marca bg-marca font-bold text-tinta';
        $apagada = $base . ' border-slate-200 bg-white font-semibold text-slate-400';
    @endphp

    <nav aria-label="Paginación" class="flex flex-wrap justify-center gap-2">
        @if ($paginator->onFirstPage())
            <span class="{{ $apagada }}">Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="{{ $normal }}">Anterior</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="{{ $apagada }}">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $pagina => $url)
                    @if ($pagina == $paginator->currentPage())
                        <span class="{{ $activa }}" aria-current="page">{{ $pagina }}</span>
                    @else
                        <a href="{{ $url }}" class="{{ $normal }}">{{ $pagina }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="{{ $normal }}">Siguiente</a>
        @else
            <span class="{{ $apagada }}">Siguiente</span>
        @endif
    </nav>
@endif
