<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F4F4F4]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seguridad') - {{ config('app.name', 'Málaga Emplea') }}</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc',
                            400: '#75c8ee', 500: '#4DB6E8', 600: '#3097c7', 700: '#257da3',
                            800: '#1c617f', 900: '#164a61'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-[#F4F4F4] text-[#333333] antialiased">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

        {{-- Overlay móvil --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-[#17232c]/60 backdrop-blur-sm lg:hidden"
            aria-hidden="true"
        ></div>

        {{-- Sidebar Estilo Panel de Control --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-[#333333] text-white transition-transform duration-300 ease-in-out lg:translate-x-0">
            <div class="flex h-20 items-center gap-3 border-b border-white/10 px-5">
                <span class="flex size-11 items-center justify-center overflow-hidden rounded-xl bg-white p-1.5">
                    <img src="{{ asset('images/Logo Malaga Emplea.png') }}" alt="" class="h-full w-full object-contain">
                </span>
                <span>
                    <span class="block text-sm font-extrabold tracking-wide">Málaga Emplea</span>
                    <span class="mt-0.5 block text-xs text-white/60">Panel de seguridad</span>
                </span>
            </div>

            <div class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <div class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-white/50">Administración</div>

                @foreach ([
                    ['seguridad.roles.index', 'Roles', 'seguridad.roles.*', '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />'],
                    ['seguridad.permisos.index', 'Permisos', 'seguridad.permisos.*', '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />'],
                    ['seguridad.cuentas.index', 'Cuentas y estados', 'seguridad.cuentas.*', '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />'],
                    ['seguridad.usuarios.index', 'Usuarios y roles', 'seguridad.usuarios.*', '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.715m12 0v-.503a3.333 3.333 0 00-3-3.333h-6c-1.657 0-3 1.492-3 3.333v.503m6-9.5a3 3 0 11-6 0 3 3 0 016 0z" />'],
                ] as [$ruta, $texto, $patron, $icono])
                    <a href="{{ route($ruta) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs($patron) ? 'bg-[#4DB6E8] text-[#17232c] shadow-sm' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">{!! $icono !!}</svg>
                        {{ $texto }}
                    </a>
                @endforeach

                <div class="mt-4 border-t border-white/10 pt-4">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/60 transition-colors hover:bg-white/10 hover:text-white">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                        Volver a la app
                    </a>
                </div>
            </div>

            <div class="border-t border-white/10 p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/75 transition-colors hover:bg-white/10 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- Contenido principal --}}
        <div class="flex min-w-0 flex-1 flex-col lg:pl-64">

            {{-- Navbar superior --}}
            <header class="z-20 flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" aria-label="Abrir menú" class="text-[#333333]/70 hover:text-[#333333] lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-base font-bold text-[#333333]">@yield('title', 'Seguridad')</h1>
                </div>

                <div class="flex items-center gap-4">
                    @php($cuentaActual = auth()->user())
                    @php($nombreActual = class_basename($cuentaActual) === 'Empresa' ? $cuentaActual->nombreEmpresa : trim(($cuentaActual->nombres ?? '') . ' ' . ($cuentaActual->apellidos ?? '')))
                    <div class="flex items-center gap-3">
                        <span class="flex size-9 items-center justify-center rounded-full bg-[#4DB6E8]/15 text-xs font-bold text-[#257da3]">{{ strtoupper(substr($nombreActual ?: 'A', 0, 1)) }}</span>
                        <span class="hidden text-sm font-semibold text-[#333333] sm:inline">{{ $nombreActual ?: 'Administrador' }}</span>
                    </div>
                </div>
            </header>

            {{-- Contenido con alertas y yield --}}
            <main class="flex-1 space-y-4 p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 shadow-sm">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 shadow-sm">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="flex flex-col items-center justify-between gap-2 border-t border-gray-200 bg-white px-6 py-4 text-xs text-gray-500 sm:flex-row">
                <div>&copy; {{ date('Y') }} Málaga Emplea. Todos los derechos reservados.</div>
                <div>Administración segura</div>
            </footer>
        </div>
    </div>

    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>
