@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-12 bg-white rounded-3xl p-8 md:p-12 shadow-soft border border-[#E7E5E4]">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-serif font-bold text-theme-text mb-2">Bienvenido de nuevo</h1>
            <p class="text-theme-muted">Inicia sesión para continuar compartiendo.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-theme-primary outline-none text-theme-text">
            </div>

            <div>
                <label class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Contraseña</label>
                <input type="password" name="password" required
                    class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-theme-primary outline-none text-theme-text">
            </div>

            <button type="submit"
                class="w-full bg-theme-primary hover:bg-[#8B4513] text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-theme-primary/20">Entrar</button>
        </form>

        <div class="mt-8 text-center text-sm text-theme-muted">
            ¿Aún no tienes cuenta? <a href="{{ route('register') }}"
                class="text-theme-primary font-bold hover:underline">Regístrate</a>
        </div>
    </div>
@endsection