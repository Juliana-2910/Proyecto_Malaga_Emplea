{{--Paginado Administrativo --}}
{{-- Uso:
    @include('layouts.partials.paginacion', [
    'paginador' => $variable,
    'singular'  => 'texto en singular',
    'plural'    => 'texto en plural',
])
--}}

@if ($paginador->total() > 0)

    @php
        $actual = $paginador->currentPage();
        $ultima = $paginador->lastPage();

        // Primera, última y las vecinas de la actual; si hay un salto se pone "…"
        $paginas = collect([1, $actual - 1, $actual, $actual + 1, $ultima])
            ->filter(fn ($p) => $p >= 1 && $p <= $ultima)
            ->unique()
            ->sort()
            ->values();

        $botonBase = 'inline-flex h-10 min-w-[40px] items-center justify-center gap-1.5 whitespace-nowrap rounded-xl border px-3.5 text-sm font-semibold transition duration-200';
        $botonLink = $botonBase . ' border-gray-200 bg-white text-gray-600 hover:border-[#333333] hover:bg-[#333333] hover:text-white';
        $botonOff  = $botonBase . ' cursor-not-allowed border-gray-200 bg-white text-gray-400 opacity-50';
        $botonOn   = $botonBase . ' border-[#4DB6E8] bg-[#4DB6E8] text-white';
    @endphp

    <div class="mt-6 grid items-center gap-4 px-1 sm:grid-cols-[1fr_auto_1fr]">

        {{-- IZQUIERDA: contador --}}
        <p class="text-center text-sm text-gray-500 sm:text-left">

            Mostrando

            <span class="font-semibold text-gray-800">
                {{ $paginador->count() }}
            </span>

            de

            <span class="font-semibold text-gray-800">
                {{ $paginador->total() }}
            </span>

            {{ $paginador->total() == 1 ? $singular : $plural }}

        </p>

        {{-- CENTRO: paginado --}}
        <div class="flex justify-center">

            @if ($paginador->hasPages())

                <nav aria-label="Paginación" class="flex flex-wrap items-center justify-center gap-1.5 sm:flex-nowrap">

                    {{-- Anterior --}}
                    @if ($paginador->onFirstPage())
                        <span class="{{ $botonOff }}" aria-disabled="true">
                            @php( $icon = 'chevron-left')
                            @include('layouts.partials.icons')
                            Anterior
                        </span>
                    @else
                        <a href="{{ $paginador->previousPageUrl() }}" rel="prev" class="{{ $botonLink }}">
                            @php( $icon = 'chevron-left')
                            @include('layouts.partials.icons')
                            Anterior
                        </a>
                    @endif

                    {{-- Números --}}
                    @foreach ($paginas as $i => $pagina)

                        @if ($i > 0 && $pagina - $paginas[$i - 1] > 1)
                            <span class="px-1 text-gray-400">…</span>
                        @endif

                        @if ($pagina === $actual)
                            <span class="{{ $botonOn }}" aria-current="page">{{ $pagina }}</span>
                        @else
                            <a href="{{ $paginador->url($pagina) }}" class="{{ $botonLink }}" aria-label="Ir a la página {{ $pagina }}">{{ $pagina }}</a>
                        @endif

                    @endforeach

                    {{-- Siguiente --}}
                    @if ($paginador->hasMorePages())
                        <a href="{{ $paginador->nextPageUrl() }}" rel="next" class="{{ $botonLink }}">
                            Siguiente
                            @php( $icon = 'chevron-right')
                            @include('layouts.partials.icons')
                        </a>
                    @else
                        <span class="{{ $botonOff }}" aria-disabled="true">
                            Siguiente
                            @php( $icon = 'chevron-right')
                            @include('layouts.partials.icons')
                        </span>
                    @endif

                </nav>

            @endif

        </div>

        {{-- DERECHA: marca --}}
        <div class="hidden items-center justify-end gap-2 text-xs text-gray-400 sm:flex">

            <span class="h-2 w-2 rounded-full bg-[#4DB6E8]"></span>

            Málaga Emplea

        </div>

    </div>

@endif
