<!DOCTYPE html>

<html lang="es" class="h-full bg-[#F4F4F4]">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
    @yield('title', 'Dashboard') - {{ config('app.name', 'Admin') }}
</title>

{{-- Tailwind CSS --}}
<script src="https://cdn.tailwindcss.com"></script>

<script>

    tailwind.config = {

        theme: {

            extend: {

                colors: {

                    primary: {

                        50: '#eef2ff',
                        100: '#e0e7ff',
                        200: '#c7d2fe',
                        300: '#a5b4fc',
                        400: '#818cf8',
                        500: '#6366f1',
                        600: '#4f46e5',
                        700: '#4338ca',
                        800: '#3730a3',
                        900: '#312e81'

                    }

                },

                fontFamily: {

                    sans: [
                        'Inter',
                        'ui-sans-serif',
                        'system-ui',
                        'sans-serif'
                    ]

                }

            }

        }

    };

</script>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
>

{{-- Chart.js --}}
<script
    src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"
    defer>
</script>

<style>

    [x-cloak] {
        display: none !important;
    }

    body {
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
    }

</style>

@stack('styles')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Málaga Emplea') - {{ config('app.name', 'Málaga Emplea') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" defer></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
    </style>

</head>

<body class="h-full text-slate-800 antialiased">


<div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

    {{-- Overlay móvil --}}
    <div
        x-show="sidebarOpen"
        x-cloak
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
        aria-hidden="true"
    >
    </div>

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0 lg:pl-64">

        {{-- Navbar --}}
        @include('layouts.partials.navbar')

        {{-- Contenido de cada vista --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">

        {{-- Mensajes --}}

        {{-- Mensaje de éxito --}}

        @if (session('success'))

            <div
                class="mb-6 flex items-center justify-between rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm"
                x-data="{ show: true }"
                x-show="show"
                x-transition>

                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">

                        @php($icon = 'check')
                        @include('layouts.partials.icons')

                    </div>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

                <button
                    type="button"
                    @click="show = false"
                    class="ml-4 text-green-600 transition hover:text-green-900">

                    @php($icon = 'x-mark')
                    @include('layouts.partials.icons')

                </button>

            </div>

        @endif


        {{-- Mensaje de actualizacion --}}
        @if (session('actualizar'))

            <div
                class="mb-6 flex items-center justify-between rounded-xl border border-[#4DB6E8]/30 bg-[#4DB6E8]/10 px-4 py-3 text-sm text-[#2386B5] shadow-sm"
                x-data="{ show: true }"
                x-show="show"
                x-transition>

                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#4DB6E8]/20">

                        @php($icon = 'arrow-path')
                        @include('layouts.partials.icons')

                    </div>

                    <span>
                        {{ session('actualizar') }}
                    </span>

                </div>

                <button
                    type="button"
                    @click="show = false"
                    class="ml-4 text-[#2386B5] transition hover:text-[#333333]">

                    @php($icon = 'x-mark')
                    @include('layouts.partials.icons')

                </button>

            </div>

        @endif


        {{-- Mensaje de eliminacion --}}
        @if (session('eliminar'))

            <div
                class="mb-6 flex items-center justify-between rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm"
                x-data="{ show: true }"
                x-show="show"
                x-transition>

                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">

                        @php($icon = 'trash')
                        @include('layouts.partials.icons')

                    </div>

                    <span>
                        {{ session('eliminar') }}
                    </span>

                </div>

                <button
                    type="button"
                    @click="show = false"
                    class="ml-4 text-red-600 transition hover:text-red-900">

                    @php($icon = 'x-mark')
                    @include('layouts.partials.icons')

                </button>

            </div>

        @endif


            @yield('content')

        </main>

        {{-- Footer --}}
        @include('layouts.partials.footer')

    </div>

</div>

{{-- AlpineJS --}}
<script
    src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"
    defer>
</script>

@stack('scripts')

</body>

</html>
