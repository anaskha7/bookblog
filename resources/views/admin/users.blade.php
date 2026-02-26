@extends('layouts.app')

@section('content')
    <div class="mb-12 flex items-end justify-between">
        <div>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-theme-text mb-4">Gestión de Usuarios</h1>
            <p class="text-theme-muted text-lg"><span
                    class="bg-[#EF4444] text-white px-2 py-0.5 rounded text-sm uppercase tracking-widest font-bold">Zona
                    Super Admin</span></p>
        </div>
    </div>

    <div class="mb-12 flex flex-wrap gap-4 border-b border-[#E7E5E4] pb-6">
        <a href="{{ route('admin.dashboard') }}"
            class="px-6 py-2 rounded-full bg-white border text-theme-muted hover:border-theme-primary transition-all text-sm">Dashboard</a>
        <a href="{{ route('admin.posts') }}"
            class="px-6 py-2 rounded-full bg-white border text-theme-muted hover:border-theme-primary transition-all text-sm">Posts</a>
        <a href="{{ route('admin.comments') }}"
            class="px-6 py-2 rounded-full bg-white border text-theme-muted hover:border-theme-primary transition-all text-sm">Comentarios</a>
        <a href="{{ route('admin.users') }}"
            class="px-6 py-2 rounded-full bg-[#EF4444] text-white font-medium transition-all text-sm shadow-md">Usuarios
            (Super)</a>
    </div>

    <div class="bg-white rounded-3xl shadow-soft border border-[#E7E5E4] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F5F5F4]">
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-wider border-b border-[#E7E5E4]">
                            Usuario</th>
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-wider border-b border-[#E7E5E4]">
                            Configuración</th>
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-wider border-b border-[#E7E5E4]">
                            Super Admin</th>
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-wider border-b border-[#E7E5E4] text-right">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr
                            class="hover:bg-orange-50/50 transition-colors border-b border-gray-100 last:border-0 {{ $user->is_super ? 'bg-red-50/30' : '' }}">
                            <form action="{{ route('admin.users.update_role', $user) }}" method="POST">
                                @csrf
                                <td class="py-4 px-6">
                                    <span class="font-bold text-theme-text block">{{ $user->username }}</span>
                                    <span class="text-xs text-theme-muted">{{ $user->email }}</span>
                                </td>

                                <td class="py-4 px-6">
                                    <select name="role"
                                        class="bg-[#F5F5F4] border border-[#E7E5E4] rounded-lg px-3 py-2 text-sm text-theme-text focus:outline-none focus:border-theme-primary {{ $user->id === Auth::id() ? 'opacity-50 pointer-events-none' : '' }}">
                                        <option value="subscriber" {{ $user->role === 'subscriber' ? 'selected' : '' }}>Suscriptor
                                        </option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </td>

                                <td class="py-4 px-6">
                                    <label
                                        class="relative inline-flex items-center cursor-pointer {{ $user->id === Auth::id() ? 'opacity-50 pointer-events-none' : '' }}">
                                        <input type="checkbox" name="is_super" value="1" class="sr-only peer" {{ $user->is_super ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#EF4444]">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 hidden md:inline">Otorgar
                                            Superpoderes</span>
                                    </label>
                                </td>

                                <td class="py-4 px-6 text-right">
                                    @if($user->id !== Auth::id())
                                        <button type="submit"
                                            class="px-4 py-2 bg-theme-text text-white text-xs font-bold rounded-full hover:bg-theme-primary transition-colors">
                                            Guardar
                                        </button>
                                    @else
                                        <span class="text-xs text-theme-muted italic">Tú</span>
                                    @endif
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection