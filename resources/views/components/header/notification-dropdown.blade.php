<div x-data="{ open: false }" class="relative">
    <button type="button" @click="open = !open" @click.outside="open = false" :aria-expanded="open.toString()" aria-label="Ver notificaciones" class="relative flex size-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-500">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 18.75a2.25 2.25 0 0 1-4.5 0m9-2.25H5.25a1.5 1.5 0 0 1-1.14-2.475l1.17-1.365V9a6.72 6.72 0 0 1 13.44 0v3.66l1.17 1.365a1.5 1.5 0 0 1-1.14 2.475Z"/></svg>
    </button>
    <div x-show="open" x-cloak x-transition class="absolute right-0 z-50 mt-2 w-80 overflow-hidden rounded-xl border border-slate-100 bg-white shadow-lg">
        <div class="border-b border-slate-100 px-4 py-3 text-sm font-semibold text-slate-700">Notificaciones</div>
        <ul class="max-h-72 divide-y divide-slate-100 overflow-y-auto">
            @forelse (($notifications ?? []) as $notification)
                <li class="px-4 py-3 text-sm hover:bg-slate-50">
                    <p class="text-slate-700">{{ $notification['message'] ?? '' }}</p>
                    <p class="mt-1 text-xs text-slate-400">{{ $notification['time'] ?? '' }}</p>
                </li>
            @empty
                <li class="px-4 py-6 text-center text-sm text-slate-400">Sin notificaciones nuevas</li>
            @endforelse
        </ul>
    </div>
</div>
