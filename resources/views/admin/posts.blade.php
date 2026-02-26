@extends('layouts.app')

@section('content')
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-theme-text mb-4">Gestión de Publicaciones</h1>
    </div>

    <div class="mb-12 flex flex-wrap gap-4 border-b border-[#E7E5E4] pb-6">
        <a href="{{ route('admin.dashboard') }}"
            class="px-6 py-2 rounded-full bg-white border text-theme-muted hover:border-theme-primary transition-all text-sm">Dashboard</a>
        <a href="{{ route('admin.posts') }}"
            class="px-6 py-2 rounded-full bg-theme-text text-white font-medium transition-all text-sm">Posts</a>
        <a href="{{ route('admin.comments') }}"
            class="px-6 py-2 rounded-full bg-white border text-theme-muted hover:border-theme-primary transition-all text-sm">Comentarios</a>
        @if(Auth::user()->is_super)
            <a href="{{ route('admin.users') }}"
                class="px-6 py-2 rounded-full bg-[#EF4444]/10 text-[#EF4444] border hover:border-[#EF4444] transition-all text-sm font-semibold">Usuarios
                (Super)</a>
        @endif
    </div>

    <div class="bg-white rounded-3xl shadow-soft border border-[#E7E5E4] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F5F5F4]">
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-widerborder-b border-[#E7E5E4]">
                            Título</th>
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-widerborder-b border-[#E7E5E4]">
                            Autor</th>
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-widerborder-b border-[#E7E5E4]">
                            Estado</th>
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-widerborder-b border-[#E7E5E4]">
                            Fecha</th>
                        <th
                            class="py-4 px-6 text-xs font-bold text-theme-muted uppercase tracking-widerborder-b border-[#E7E5E4] text-right">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr class="hover:bg-orange-50/50 transition-colors border-b border-gray-100 last:border-0">
                            <td class="py-4 px-6 font-medium text-theme-text">
                                <a href="{{ route('posts.show', $post) }}" class="hover:underline"
                                    target="_blank">{{ $post->title }}</a>
                            </td>
                            <td class="py-4 px-6 text-sm text-theme-muted">
                                {{ $post->user->username ?? '---' }}
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('admin.posts.toggle_status', $post) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status"
                                        value="{{ $post->status === 'published' ? 'draft' : 'published' }}">
                                    <button type="submit"
                                        class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-700 hover:bg-red-100 hover:text-red-700' : 'bg-red-100 text-red-700 hover:bg-green-100 hover:text-green-700' }} transition-colors">
                                        {{ $post->status === 'published' ? 'Publicado' : 'Borrador' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ $post->created_at->format('d M, Y') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700 mr-3"
                                    title="Editar"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline"
                                    onsubmit="return confirm('¿Borrar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Borrar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection