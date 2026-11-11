@extends('seguridad.layout')

@section('title', 'Roles')

@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">Roles</h1>
    <a href="{{ route('seguridad.roles.create') }}" class="rounded-xl bg-[#333333] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#4DB6E8] hover:text-[#17232c]">Nuevo rol</a>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">Rol</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3">Permisos</th>
                <th class="px-4 py-3">Usuarios</th>
                <th class="px-4 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($roles as $rol)
                @php
                    $protegido = $rolService->esProtegido($rol);
                    $noDesactivable = $rolService->esNoDesactivable($rol);
                @endphp
                <tr>
                    <td class="px-4 py-3 font-medium">
                        {{ $rol->name }}
                        @if ($protegido)
                            <span class="ml-1 text-xs text-slate-400">protegido</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if ($rol->activo)
                            <span class="rounded-full bg-green-100 text-green-700 text-xs font-medium px-2 py-0.5">Activo</span>
                        @else
                            <span class="rounded-full bg-slate-200 text-slate-600 text-xs font-medium px-2 py-0.5">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $rol->permissions->count() }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $rol->users_count }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('seguridad.roles.edit', $rol) }}" class="font-semibold text-[#257da3] hover:text-[#333333]">Editar</a>

                            @unless ($noDesactivable)
                                <form action="{{ route('seguridad.roles.estado', $rol) }}" method="POST"
                                      @if ($rol->activo && $rol->users_count > 0)
                                          onsubmit="return confirm('Este rol tiene {{ $rol->users_count }} usuario(s). Al desactivarlo perderán sus permisos. ¿Continuar?');"
                                      @endif>
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="font-semibold {{ $rol->activo ? 'text-red-600 hover:text-red-800' : 'text-[#257da3] hover:text-[#333333]' }}">
                                        {{ $rol->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            @endunless

                            @unless ($protegido)
                                <form action="{{ route('seguridad.roles.destroy', $rol) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar el rol {{ $rol->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                </form>
                            @endunless
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-slate-500">No hay roles registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
