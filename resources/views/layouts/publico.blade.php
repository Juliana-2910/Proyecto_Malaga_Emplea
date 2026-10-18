<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inicio') · Málaga Emplea</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-fondo font-sans text-slate-800 antialiased">



    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-slate-800 px-6 py-8 text-sm leading-relaxed text-slate-300">
        <div class="mx-auto grid max-w-6xl items-center gap-5 md:grid-cols-3">
            <p>© 2026 Málaga Emplea. Todos los derechos reservados.</p>

            <div class="text-center">
                <p class="font-bold text-white">Desarrollado por</p>
                <p>
                    Juliana Alvarez López (juliana.loal29@gmail.com) <br>
                    Edison Ruiz (yamid2918@gmail.com)
                </p>
            </div>

            <p class="md:text-right">Versión 1.0.0</p>
        </div>
    </footer>

</body>
</html>
