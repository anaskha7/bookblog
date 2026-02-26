@extends('layouts.app')

@section('content')
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-theme-text mb-4">Gestión de Comentarios</h1>
    </div>

    <div class="mb-12 flex flex-wrap gap-4 border-b border-[#E7E5E4] pb-6">
        <a href="{{ route('admin.dashboard') }}"
            class="px-6 py-2 rounded-full bg-white border text-theme-muted hover:border-theme-primary transition-all text-sm">Dashboard</a>
        <a href="{{ route('admin.posts') }}"
            class="px-6 py-2 rounded-full bg-white border text-theme-muted hover:border-theme-primary transition-all text-sm">Posts</a>
        <a href="{{ route('admin.comments') }}"
            class="px-6 py-2 rounded-full bg-theme-text text-white font-medium transition-all text-sm">Comentarios</a>
        @if(Auth::user()->is_super)
            <a href="{{ route('admin.users') }}"
                class="px-6 py-2 rounded-full bg-[#EF4444]/10 text-[#EF4444] border hover:border-[#EF4444] transition-all text-sm font-semibold">Usuarios
                (Super)</a>
        @endif
    </div>

    <div class="grid gap-6">
        @forelse($comments as $comment)
            <div
                class="bg-white rounded-2xl p-6 shadow-soft border border-[#E7E5E4] flex flex-col md:flex-row gap-6 md:items-center justify-between hover:border-theme-primary transition-colors">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="font-bold text-theme-text">{{ $comment->user->username ?? '---' }}</span>
                        <span
                            class="text-xs font-medium text-theme-muted bg-[#F5F5F4] px-2 py-1 rounded-full">{{ $comment->created_at->format('d M, Y') }}</span>
                        <div class="flex text-xs text-theme-secondary">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $comment->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>

                    <p class="text-[#57534E] mb-3 text-sm leading-relaxed">{{ $comment->body }}</p>

                    <div class="text-xs text-theme-muted flex items-center gap-2">
                        <i class="fas fa-book-open text-theme-primary"></i>
                        En respuesta a: <a href="{{ route('posts.show', $comment->post) }}"
                            class="font-bold hover:text-theme-primary hover:underline">{{ $comment->post->title }}</a>
                    </div>
                </div>

                <div class="shrink-0 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-[#E7E5E4] md:pl-6">
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar este comentario? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full md:w-auto px-6 py-2 rounded-full bg-red-50 text-red-600 font-bold text-sm hover:bg-red-600 hover:text-white transition-colors border border-red-200 hover:border-red-600 flex items-center justify-center gap-2">
                            <i class="fas fa-trash-alt"></i> Borrar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 text-center border-2 border-dashed border-[#E7E5E4]">
                <div
                    class="w-16 h-16 rounded-full bg-[#F5F5F4] flex items-center justify-center text-theme-muted text-2xl mx-auto mb-4">
                    <i class="fas fa-comment-slash"></i>
                </div>
                <p class="text-theme-muted font-serif text-lg">No hay comentarios todavía.</p>
                <p class="text-sm text-theme-muted/60 mt-2">Los comentarios de los usuarios aparecerán aquí.</p>
            </div>
        @endforelse
    </div>
@endsection