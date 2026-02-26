@extends('layouts.app')

@section('content')
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-theme-text mb-4">Panel de Administración</h1>
        <p class="text-theme-muted text-lg">Resumen de la actividad en BookBlog.</p>
    </div>

    <!-- Admin Navigation -->
    <div class="mb-12 flex flex-wrap gap-4 border-b border-[#E7E5E4] pb-6">
        <a href="{{ route('admin.dashboard') }}"
            class="px-6 py-2 rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-theme-text text-white font-medium' : 'bg-white border text-theme-muted hover:border-theme-primary' }} transition-all text-sm">Dashboard</a>
        <a href="{{ route('admin.posts') }}"
            class="px-6 py-2 rounded-full {{ request()->routeIs('admin.posts') ? 'bg-theme-text text-white font-medium' : 'bg-white border text-theme-muted hover:border-theme-primary' }} transition-all text-sm">Posts</a>
        <a href="{{ route('admin.comments') }}"
            class="px-6 py-2 rounded-full {{ request()->routeIs('admin.comments') ? 'bg-theme-text text-white font-medium' : 'bg-white border text-theme-muted hover:border-theme-primary' }} transition-all text-sm">Comentarios</a>

        @if(Auth::user()->is_super)
            <a href="{{ route('admin.users') }}"
                class="px-6 py-2 rounded-full {{ request()->routeIs('admin.users') ? 'bg-theme-text text-white font-medium' : 'bg-[#EF4444]/10 text-[#EF4444] border hover:border-[#EF4444]' }} transition-all text-sm font-semibold">Usuarios
                (Super)</a>
        @endif
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl p-8 border border-[#E7E5E4] shadow-soft relative overflow-hidden group">
            <h3 class="text-theme-muted font-bold text-sm tracking-widest uppercase mb-2 relative z-10">Usuarios</h3>
            <p class="text-5xl font-serif font-bold text-theme-text relative z-10">{{ $stats['users'] }}</p>
            <div
                class="absolute right-0 bottom-0 text-7xl text-[#F5F5F4] group-hover:text-theme-primary/10 transition-colors transform translate-x-4 translate-y-4">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-[#E7E5E4] shadow-soft relative overflow-hidden group">
            <h3 class="text-theme-muted font-bold text-sm tracking-widest uppercase mb-2 relative z-10">Reseñas</h3>
            <p class="text-5xl font-serif font-bold text-theme-text relative z-10">{{ $stats['posts'] }}</p>
            <div
                class="absolute right-0 bottom-0 text-7xl text-[#F5F5F4] group-hover:text-theme-primary/10 transition-colors transform translate-x-4 translate-y-4">
                <i class="fas fa-book"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-[#E7E5E4] shadow-soft relative overflow-hidden group">
            <h3 class="text-theme-muted font-bold text-sm tracking-widest uppercase mb-2 relative z-10">Comentarios</h3>
            <p class="text-5xl font-serif font-bold text-theme-text relative z-10">{{ $stats['comments'] }}</p>
            <div
                class="absolute right-0 bottom-0 text-7xl text-[#F5F5F4] group-hover:text-theme-primary/10 transition-colors transform translate-x-4 translate-y-4">
                <i class="fas fa-comments"></i>
            </div>
        </div>
    </div>
@endsection