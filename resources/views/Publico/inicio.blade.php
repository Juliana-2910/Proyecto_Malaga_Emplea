@extends('layouts.publico')

@section('title', 'Bienvenido')

@section('content')

@php
    // Perfiles de registro. "tipo" viaja por la URL para preseleccionar el rol en el formulario.
    $perfiles = [
        [
            'titulo' => 'Busco empleo',
            'texto'  => 'Crea tu hoja de vida, explora vacantes y postúlate desde un solo lugar.',
            'boton'  => 'Explorar oportunidades',
            'tipo'   => 'empleo',
            'icono'  => 'M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z',
        ],
        [
            'titulo' => 'Soy empresa',
            'texto'  => 'Publica tus vacantes y encuentra talento de tu propio municipio.',
            'boton'  => 'Publicar una oferta',
            'tipo'   => 'empresa',
            'icono'  => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75',
        ],
        [
            'titulo' => 'Ofrezco un servicio',
            'texto'  => 'Muestra tu oficio, recibe contactos y gana buenas calificaciones.',
            'boton'  => 'Ofrecer mis servicios',
            'tipo'   => 'servicio',
            'icono'  => 'M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z',
        ],
    ];

    $beneficios = [
        'Todas las ofertas laborales con información detallada.',
        'Servicios locales con sus respectivas calificaciones.',
        'Gestión de tu hoja de vida y postulaciones.',
        'Publicar vacantes o tus propios servicios.',
    ];

    $pasos = [
        ['titulo' => 'Crea tu cuenta',        'texto' => 'Regístrate para buscar empleo, vincular tu empresa u ofrecer tus servicios.'],
        ['titulo' => 'Completa tu perfil',    'texto' => 'Ingresa tus datos y adjunta tu hoja de vida o registra la información de tu empresa, según tu objetivo.'],
        ['titulo' => 'Explora y conecta',     'texto' => 'Consulta ofertas laborales, descubre servicios, presenta postulaciones o publica oportunidades.'],
    ];

    $valores = [
        ['titulo' => 'Oportunidades',      'texto' => 'Conecta con ofertas laborales y servicios disponibles en tu municipio'],
        ['titulo' => 'Confianza',          'texto' => 'Calificaciones de quienes ya contrataron un servicio.'],
        ['titulo' => 'Todo en un lugar',   'texto' => 'Hoja de vida, postulaciones y servicios en tu panel.'],
    ];
@endphp

    {{-- NAVBAR --}}
    <header class=" sticky top-0 z-50 border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-6 py-3">
            <a href="{{ url('/') }}" class="flex items-center gap-3 text-xl font-extrabold text-noche">
                <img src="{{ asset('images/Logo Malaga Emplea.png') }}" alt="Logo de Málaga Emplea" class="size-14 object-contain">
                Málaga Emplea
            </a>

            <nav class="hidden items-center gap-7 text-[15px] font-semibold md:flex">
                <a href="#perfiles" class="py-3 transition hover:text-marca-texto">Perfiles</a>
                <a href="#como" class="py-3 transition hover:text-marca-texto">Cómo funciona</a>
                <a href="#nosotros" class="py-3 transition hover:text-marca-texto">Sobre nosotros</a>
            </nav>

            <div class="flex flex-wrap gap-3">
                <a href="{{ url('/login') }}"
                    class="self-start rounded-full border-2 border-slate-800 bg-white px-4 py-2 text-[15px] font-bold text-slate-800 transition hover:border-carbon hover:bg-carbon hover:text-white">
                        Ingresar
                </a>

                <a href="{{ url('/registro') }}"
                        class=" self-start rounded-full border-2 border-marca bg-marca px-4 py-2 text-[15px] font-bold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white">
                        Registrarse
                </a>
            </div>

        </div>
    </header>


{{-- ============ HERO (banner con imagen) ============ --}}
<section class="relative isolate overflow-hidden">
    <img src="{{ asset('images/Malaga Fondo.png') }}" alt=""
        class="absolute inset-0 -z-20 h-full w-full object-cover">
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-slate-950/90 via-slate-950/65 to-slate-950/40"></div>

    <div class="mx-auto grid max-w-6xl items-center gap-14 px-6 py-24 lg:grid-cols-2">

        {{-- Texto principal --}}
        <div class="flex flex-col gap-6">
            <span class="self-start rounded-full bg-white px-4 py-1.5 text-[13px] font-bold text-marca-texto">
                "Oportunidades que transforman"
            </span>

            <h1 class="text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-[56px]">
                Tu próximo empleo o servicio comienza aquí
            </h1>

            <p class="max-w-xl text-lg leading-relaxed text-slate-200">
                Crea tu cuenta y conecta con empresas, oportunidades de trabajo y personas que ofrecen servicios en tu municipio.
            </p>


            <div class="flex flex-wrap gap-4">

                <br>
                <br>
                <br>

            </div>
        </div>

        {{-- Tarjeta: qué se desbloquea al registrarse --}}
        <div class="flex flex-col gap-5 rounded-3xl bg-white p-7 shadow-xl">
            <div class="flex items-center gap-3">
                <span class="flex size-11 items-center justify-center rounded-xl bg-sky-50 text-marca-texto">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </span>
                <h2 class="text-xl font-extrabold text-noche">Al registrarte accedes a</h2>
            </div>

            <ul class="flex flex-col gap-3.5 text-base text-slate-600">
                @foreach ($beneficios as $beneficio)
                    <li class="flex items-center gap-3">
                        <svg class="size-5 shrink-0 text-marca-texto" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        {{ $beneficio }}
                    </li>
                @endforeach
            </ul>

            <a href="{{ url('/registro') }}"
                class="rounded-xl border-2 border-noche bg-noche px-5 py-3.5 text-center text-base font-bold text-white transition hover:border-carbon hover:bg-carbon">
                Registrarme ahora
            </a>
        </div>
    </div>
</section>

{{-- ============ PERFILES ============ --}}
<section id="perfiles" class="scroll-mt-4 px-6 pb-12 pt-20">
    <div class="mx-auto flex max-w-6xl flex-col gap-9">
        <div class="space-y-2">
            <h2 class="text-3xl font-extrabold text-noche sm:text-4xl">Únete a nosotros</h2>
            <p class="text-[17px] text-slate-500">Elige cómo quieres participar.</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-3 lg:grid-cols-3">
            @foreach ($perfiles as $perfil)
                <article class="flex flex-col gap-3.5 rounded-2xl border border-slate-200 bg-white p-7 transition hover:shadow-lg">
                    <span class="flex size-[52px] items-center justify-center rounded-2xl bg-sky-50 text-marca-texto">
                        <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $perfil['icono'] }}" />
                        </svg>
                    </span>
                    <h3 class="text-[21px] font-bold">{{ $perfil['titulo'] }}</h3>
                    <p class="leading-relaxed text-slate-500">{{ $perfil['texto'] }}</p>
                    <a href="{{ url('/registro?tipo=' . $perfil['tipo']) }}"
                        class="mt-auto self-start rounded-xl border-2 border-marca bg-marca px-5 py-3 text-[15px] font-bold text-tinta transition hover:border-carbon hover:bg-carbon hover:text-white">
                        {{ $perfil['boton'] }}
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ CÓMO FUNCIONA ============ --}}
<section id="como" class="scroll-mt-4 bg-white px-6 py-20">
    <div class="mx-auto flex max-w-6xl flex-col gap-10">
        <div class="space-y-2">
            <h2 class="text-3xl font-extrabold text-noche sm:text-4xl">Empezar es muy fácil</h2>
            <p class="text-[17px] text-slate-500">En tres pasos, conecta con nuevas oportunidades.</p>
        </div>

        <div class="grid gap-8 md:grid-cols-3">
            @foreach ($pasos as $i => $paso)
                <div class="flex flex-col gap-3.5">
                    <span class="flex size-12 items-center justify-center rounded-full bg-marca text-xl font-extrabold text-tinta">
                        {{ $i + 1 }}
                    </span>
                    <h3 class="text-xl font-bold">{{ $paso['titulo'] }}</h3>
                    <p class="leading-relaxed text-slate-500">{{ $paso['texto'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ SOBRE NOSOTROS ============ --}}
<section id="nosotros" class="scroll-mt-4 px-6 py-20">
    <div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-2 lg:items-start">
        <div class="space-y-3.5">
            <h2 class="text-3xl font-extrabold text-noche sm:text-4xl">Conectamos oportunidades en Garcia Rovira</h2>
            <p class="text-[17px] leading-relaxed text-slate-600">
                Málaga Emplea complementa los servicios de intermediación laboral existentes y facilita la conexión entre quienes buscan empleo, las empresas y quienes ofrecen servicios de la región.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-3">
            @foreach ($valores as $valor)
                <div class="space-y-2 rounded-2xl border border-slate-200 bg-white p-6">
                    <h3 class="text-lg font-bold text-noche">{{ $valor['titulo'] }}</h3>
                    <p class="leading-relaxed text-slate-500">{{ $valor['texto'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section

@endsection
