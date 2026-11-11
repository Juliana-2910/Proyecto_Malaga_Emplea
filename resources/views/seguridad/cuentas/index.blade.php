@extends('seguridad.layout')

@section('title', 'Cuentas y estados')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-[#257da3]">Control de acceso</p>
            <h2 class="mt-1 text-2xl font-extrabold text-[#333333]">Cuentas y estados</h2>
            <p class="mt-1 text-sm text-gray-500">Activa o restringe el acceso de personas y empresas.</p>
        </div>
        <a href="{{ route('seguridad.cuentas.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-[#333333] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#4DB6E8] hover:text-[#17232c]">
            Crear cuenta de persona
        </a>
    </div>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <div>
                <h3 class="font-bold text-[#333333]">Cuentas registradas</h3>
                <p class="mt-0.5 text-xs text-gray-500">{{ $cuentas->count() }} cuenta(s)</p>
            </div>
            <span class="rounded-full bg-[#4DB6E8]/15 px-3 py-1 text-xs font-bold text-[#257da3]">Gestión administrativa</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th scope="col" class="px-5 py-3">Cuenta</th>
                        <th scope="col" class="px-5 py-3">Tipo</th>
                        <th scope="col" class="px-5 py-3">Roles</th>
                        <th scope="col" class="px-5 py-3">Estado</th>
                        <th scope="col" class="px-5 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($cuentas as $cuenta)
                        @php
                            $esEmpresa = class_basename($cuenta) === 'Empresa';
                            $tipoCuenta = $esEmpresa ? 'empresa' : 'usuario';
                            $nombreCuenta = $esEmpresa
                                ? $cuenta->nombreEmpresa
                                : trim($cuenta->nombres . ' ' . $cuenta->apellidos);
                            $estaActivo = strtolower((string) $cuenta->estado) === 'activo';
                            $esCuentaActual = $cuenta->is(auth()->user());
                        @endphp
                        <tr class="hover:bg-[#F4F4F4]/70">
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="font-semibold text-[#333333]">{{ $nombreCuenta }}</div>
                                <div class="mt-0.5 text-xs text-gray-500">{{ $cuenta->email }}</div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $esEmpresa ? 'bg-[#333333]/10 text-[#333333]' : 'bg-[#4DB6E8]/15 text-[#257da3]' }}">
                                    {{ $esEmpresa ? 'Empresa' : 'Persona' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse ($cuenta->rolesConInactivos as $rol)
                                        <span class="rounded-full px-2 py-0.5 text-xs font-medium {{ $rol->activo ? 'bg-[#4DB6E8]/15 text-[#257da3]' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $rol->name }}{{ $rol->activo ? '' : ' · inactivo' }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400">Sin roles asignados</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $estaActivo ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    <span class="size-1.5 rounded-full {{ $estaActivo ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $estaActivo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($esEmpresa)
                                        <form action="{{ route('seguridad.cuentas.estado', ['tipo' => $tipoCuenta, 'id' => $cuenta->getKey()]) }}" method="POST"
                                            onsubmit="return confirm(this.dataset.confirm)" data-confirm="{{ $estaActivo ? '¿Inactivar' : 'Activar' }} la cuenta de {{ $nombreCuenta }}?">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="font-semibold {{ $estaActivo ? 'text-red-600 hover:text-red-800' : 'text-[#257da3] hover:text-[#333333]' }}">
                                                {{ $estaActivo ? 'Inactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('seguridad.cuentas.edit', $cuenta->getKey()) }}" class="font-semibold text-[#257da3] hover:text-[#333333]">Editar</a>
                                        @if (! ($esCuentaActual && $estaActivo))
                                            <form action="{{ route('seguridad.cuentas.estado', ['tipo' => $tipoCuenta, 'id' => $cuenta->getKey()]) }}" method="POST"
                                                onsubmit="return confirm(this.dataset.confirm)" data-confirm="{{ $estaActivo ? '¿Inactivar' : 'Activar' }} la cuenta de {{ $nombreCuenta }}?">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="font-semibold {{ $estaActivo ? 'text-red-600 hover:text-red-800' : 'text-[#257da3] hover:text-[#333333]' }}">
                                                    {{ $estaActivo ? 'Inactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">Sesión actual protegida</span>
                                        @endif
                                        @unless ($esCuentaActual)
                                            <form action="{{ route('seguridad.cuentas.destroy', $cuenta->getKey()) }}" method="POST"
                                                onsubmit="return confirm('¿Eliminar la cuenta {{ $cuenta->email }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-semibold text-red-600 hover:text-red-800">Eliminar</button>
                                            </form>
                                        @endunless
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-500">No hay cuentas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
