{{-- Casillas legales del registro (solo las dos obligatorias). --}}
{{-- Uso: @include('layouts.Publico.registroCasillasLegales', ['prefijo' => 'Usuario'])  ·  prefijo: Usuario | Empresa --}}
@php
    $casilla = 'mt-0.5 size-4 shrink-0 cursor-pointer rounded border-slate-300';
    $texto = 'text-xs leading-relaxed text-slate-600';
    $enlace = 'font-semibold text-marca-texto underline transition hover:text-carbon';
@endphp

<div class="space-y-3">
    {{-- TÉRMINOS Y CONDICIONES --}}
    <div data-campo-legal>
        <div class="relative flex items-start gap-2.5">
            <input style="accent-color:#4DB6E8" id="chkTerminos{{ $prefijo }}" name="terminos" type="checkbox" value="1" required class="{{ $casilla }}">
            <label for="chkTerminos{{ $prefijo }}" class="{{ $texto }}">
                <span class="font-bold text-noche">(OBLIGATORIO)</span> Acepto los
                <button type="button" onclick="abrirModalLegal('modalTerminos', 'chkTerminos{{ $prefijo }}')" class="{{ $enlace }}">Términos y Condiciones</button>
                y confirmo que la información suministrada es correcta.
            </label>
        </div>
    </div>

    {{-- TRATAMIENTO DE DATOS --}}
    <div data-campo-legal>
        <div class="relative flex items-start gap-2.5">
            <input style="accent-color:#4DB6E8" id="chkDatos{{ $prefijo }}" name="datos" type="checkbox" value="1" required class="{{ $casilla }}">
            <label for="chkDatos{{ $prefijo }}" class="{{ $texto }}">
                <span class="font-bold text-noche">(OBLIGATORIO)</span> Autorizo el
                <button type="button" onclick="abrirModalLegal('modalDatos', 'chkDatos{{ $prefijo }}')" class="{{ $enlace }}">tratamiento de mis datos personales</button>
                de acuerdo con la Política de Tratamiento de Datos Personales.
            </label>
        </div>
    </div>
</div>
