@extends('layouts.app')

@section('title', 'Crear Rol')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

```
<div class="mx-auto max-w-3xl px-6">

    {{-- Encabezado --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Crear rol
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Registra un nuevo rol para el sistema.
        </p>

    </div>


    {{-- Formulario --}}
    <div class="rounded-xl bg-white p-6 shadow">

        <form action="{{ route('roles.store') }}" method="POST">

            @csrf

            {{-- Campo rol --}}
            <div class="mb-6">

                <label for="rol"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Rol
                </label>

                <select name="rol"
                        id="rol"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#4DB6E8] focus:ring-2 focus:ring-[#4DB6E8]"
                        required>

                    <option value="">
                        Seleccione un rol
                    </option>

                    <option value="administrador">
                        Administrador
                    </option>

                    <option value="usuario">
                        Usuario
                    </option>

                </select>

                @error('rol')

                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Botones --}}
            <div class="flex items-center justify-end gap-3">

                <a href="{{ route('roles.index') }}"
                   class="rounded-lg bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-300">
                    Cancelar
                </a>

                <button type="submit"
                        class="rounded-lg bg-[#4DB6E8] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#333333]">
                    Guardar rol
                </button>

            </div>

        </form>

    </div>

</div>
```

</div>

@endsection
