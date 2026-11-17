{{-- Campo de contraseña del registro. Uso: @include('layouts.Publico.registroCampoPassword', ['id' => 'registroPasswordUsuario']) --}}
@php
    $campoRegistro = 'campo-registro w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none';
    $etiquetaRegistro = 'mb-1 block text-xs font-semibold text-noche';
@endphp

<div>
    <label for="{{ $id }}" class="{{ $etiquetaRegistro }}">Contraseña</label>
    <div class="relative">
        <input id="{{ $id }}" name="password" type="password"
            minlength="8" required autocomplete="new-password"
            class="{{ $campoRegistro }} pr-11">

        <button type="button"
            onclick="alternarPassword('{{ $id }}', this)"
            aria-label="Mostrar contraseña"
            title="Mostrar contraseña"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 transition hover:text-marca-texto">
            <svg class="size-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 10.5c2.1 3 4.8 4.5 8 4.5s5.9-1.5 8-4.5M7 12.5l-1.5 2M12 15v2M17 12.5l1.5 2"/>
            </svg>
        </button>
    </div>
    <p class="mt-1 text-[11px] text-slate-500">Mínimo 8 caracteres.</p>
</div>
