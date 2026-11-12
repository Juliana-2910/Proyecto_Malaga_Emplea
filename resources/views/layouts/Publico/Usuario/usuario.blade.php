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

    @php
        // Obtener la cuenta que inició sesión.
        $cuenta = request()->user();

        // Mostrar el nombre según el tipo de cuenta.
        $nombre = $cuenta?->nombreEmpresa
            ?? trim(($cuenta?->nombres ?? '') . ' ' . ($cuenta?->apellidos ?? ''));

        $nombre = $nombre ?: 'Usuario';

    @endphp

    @include('layouts.Publico.Usuario.navbarUsuario')

    <main>
        @yield('content')
    </main>

    @include('layouts.Publico.footer')

    @stack('scripts')
</body>
</html>
