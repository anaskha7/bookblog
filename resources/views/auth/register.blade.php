@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-12 bg-white rounded-3xl p-8 md:p-12 shadow-soft border border-[#E7E5E4]">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-serif font-bold text-theme-text mb-2">Crear nueva cuenta</h1>
            <p class="text-theme-muted">Únete a la nueva comunidad literaria.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Usuario</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-theme-primary outline-none text-theme-text">
            </div>

            <div>
                <label class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-theme-primary outline-none text-theme-text">
            </div>

            <div>
                <label class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Contraseña</label>
                <input type="password" name="password" required
                    class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-theme-primary outline-none text-theme-text">
                <span class="text-xs text-theme-muted mt-1 block">Mínimo 6 caracteres</span>
            </div>

            <div>
                <label class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Código Secreto Admin
                    (Opcional)</label>
                <input type="password" name="secret_code" placeholder="Si tienes un código para ser administrador..."
                    class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-theme-primary outline-none text-theme-text">
            </div>

            <button type="submit"
                class="w-full bg-theme-primary hover:bg-[#8B4513] text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-theme-primary/20">Registrarse</button>
        </form>

        <div class="mt-8 text-center text-sm text-theme-muted">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-theme-primary font-bold hover:underline">Inicia
                Sesión</a>
        </div>
    </div>
@endsection