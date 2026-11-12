@extends('layouts.Publico.inicio')

@section('title', 'Crear nueva contraseña')
@section('hide-public-footer', 'true')

@section('content')
<main class="relative isolate flex min-h-screen items-center justify-center overflow-hidden bg-[#F4F4F4] px-4 py-10 sm:px-6">
    <div class="absolute -left-32 -top-32 -z-10 size-96 rounded-full bg-[#4DB6E8]/20 blur-3xl"></div>
    <div class="absolute -bottom-40 -right-32 -z-10 size-[450px] rounded-full bg-[#333333]/10 blur-3xl"></div>

    <section class="w-full max-w-lg overflow-hidden rounded-[2rem] border border-white/80 bg-white/95 shadow-2xl backdrop-blur-xl">
        <div class="h-2 w-full bg-gradient-to-r from-[#333333] via-[#4DB6E8] to-[#333333]"></div>
        <div class="px-6 py-8 sm:px-10 sm:py-10">
            <a href="{{ route('login') }}" class="mb-7 inline-flex items-center gap-2 text-sm font-bold text-[#2386B5] transition hover:text-[#333333]">
                <span aria-hidden="true">←</span> Volver al inicio de sesión
            </a>

            <div class="mb-7 flex items-center gap-4">
                <div class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-[#EAF6FD] text-[#2386B5]">
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2386B5]">{{ $tipo === 'empresa' ? 'Cuenta empresa' : 'Cuenta personal' }}</p>
                    <h1 class="mt-1 text-2xl font-extrabold tracking-tight text-[#333333] sm:text-3xl">Crea tu contraseña</h1>
                </div>
            </div>

            <p class="mb-6 text-sm leading-relaxed text-slate-500">Elige una contraseña nueva de al menos 8 caracteres para volver a ingresar a tu cuenta.</p>

            @if ($errors->getBag('resetPassword')->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                    @foreach ($errors->getBag('resetPassword')->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="tipo" value="{{ old('tipo', $tipo) }}">
                <input type="hidden" name="token" value="{{ old('token', $token) }}">
                <input type="hidden" name="email" value="{{ old('email', $email) }}">

                <div>
                    <label for="emailReset" class="mb-2 block text-sm font-bold text-[#333333]">Correo de la cuenta</label>
                    <input id="emailReset" type="email" value="{{ old('email', $email) }}" readonly
                        class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3.5 text-sm text-slate-600 outline-none">
                </div>

                <div>
                    <label for="passwordReset" class="mb-2 block text-sm font-bold text-[#333333]">Nueva contraseña</label>
                    <input id="passwordReset" name="password" type="password" required minlength="8" autocomplete="new-password" autofocus
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-[#333333] outline-none transition placeholder:text-slate-400 focus:border-[#4DB6E8] focus:bg-white focus:ring-4 focus:ring-[#4DB6E8]/15"
                        placeholder="Mínimo 8 caracteres">
                </div>

                <div>
                    <label for="passwordConfirmation" class="mb-2 block text-sm font-bold text-[#333333]">Confirma la nueva contraseña</label>
                    <input id="passwordConfirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-[#333333] outline-none transition placeholder:text-slate-400 focus:border-[#4DB6E8] focus:bg-white focus:ring-4 focus:ring-[#4DB6E8]/15"
                        placeholder="Escríbela nuevamente">
                </div>

                <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-[#333333] px-5 py-4 text-sm font-extrabold text-white shadow-lg shadow-[#333333]/20 transition hover:-translate-y-0.5 hover:bg-[#4DB6E8] hover:text-[#333333]">
                    Guardar nueva contraseña
                    <svg class="size-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </button>
            </form>
        </div>
    </section>
</main>
@endsection
