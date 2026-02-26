@extends('layouts.app')

@section('content')
    <article class="max-w-[1000px] mx-auto w-full">
        <!-- Header -->
        <header class="text-center mb-12 space-y-6">
            <div
                class="inline-flex items-center gap-2 text-xs font-bold text-theme-primary uppercase tracking-widest bg-orange-50 px-3 py-1 rounded-full">
                <i class="fas fa-star text-theme-secondary"></i>
                <span>Reseña</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-serif font-bold text-theme-text leading-tight text-balance">
                {{ $post->title }}
            </h1>
            <div class="flex items-center justify-center gap-6 text-theme-muted text-sm flex-wrap">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-theme-primary flex items-center justify-center text-white text-xs">
                        <i class="fas fa-user"></i>
                    </span>
                    <span class="font-medium text-theme-text">Por {{ $post->user->username }}</span>
                </div>
                <span>•</span>
                <span>{{ $post->created_at->format('d M, Y') }}</span>
                <span>•</span>
                <div class="flex items-center gap-1 text-theme-secondary">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= round($avgRating) ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>
            </div>
        </header>

        <!-- Cover Image -->
        @if ($post->image_url)
            <div class="w-full aspect-[21/9] rounded-3xl overflow-hidden shadow-2xl mb-16 relative group">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                <img src="{{ asset($post->image_url) }}" alt="Portada del libro" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Content -->
        <div class="prose prose-lg prose-stone mx-auto font-serif text-[#57534E] max-w-3xl">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Actions -->
        @can('update', $post)
            <div class="flex justify-center gap-4 mt-12 pt-8 border-t border-[#E7E5E4]">
                <a href="{{ route('posts.edit', $post) }}"
                    class="px-6 py-2 rounded-full border border-theme-primary text-theme-primary hover:bg-theme-primary hover:text-white transition-colors">
                    <i class="fas fa-edit mr-2"></i> Editar Reseña
                </a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline"
                    onsubmit="return confirm('¿Seguro que deseas eliminar esta reseña?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-2 rounded-full border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition-colors">
                        <i class="fas fa-trash mr-2"></i> Eliminar
                    </button>
                </form>
            </div>
        @endcan

        <!-- Related Posts -->
        @if ($relatedPosts->isNotEmpty())
            <div class="max-w-3xl mx-auto mt-16 pt-12 border-t border-[#E7E5E4]">
                <h3 class="text-2xl font-serif font-bold text-theme-text mb-8">También te podría interesar</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($relatedPosts as $related)
                        <a href="{{ route('posts.show', $related) }}"
                            class="group bg-white rounded-2xl p-4 border border-[#E7E5E4] hover:border-theme-primary hover:shadow-md transition-all">
                            <div class="aspect-square rounded-xl bg-[#F5F5F4] overflow-hidden mb-3 relative">
                                @if ($related->image_url)
                                    <img src="{{ asset($related->image_url) }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">
                                        <i class="fas fa-book"></i>
                                    </div>
                                @endif
                            </div>
                            <h4
                                class="font-serif font-bold text-theme-text text-sm leading-tight group-hover:text-theme-primary transition-colors">
                                {{ $related->title }}
                            </h4>
                            <span class="text-xs text-theme-muted mt-1 block">
                                Por {{ $related->user->username }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Author Section -->
        <div class="max-w-3xl mx-auto mt-16 pt-12 border-t border-[#E7E5E4]">
            <div
                class="bg-white p-8 rounded-3xl shadow-soft border border-[#E7E5E4] flex flex-col md:flex-row gap-8 items-center md:items-start text-center md:text-left">
                <div
                    class="w-24 h-24 rounded-full bg-theme-primary/10 shrink-0 overflow-hidden shadow-inner flex items-center justify-center text-theme-primary text-3xl">
                    <i class="fas fa-feather-alt"></i>
                </div>
                <div>
                    <h4 class="text-xl font-serif font-bold text-theme-text mb-2">Sobre el Autor</h4>
                    <p class="text-theme-muted text-sm mb-4">
                        Esta reseña fue escrita por <strong>{{ $post->user->username }}</strong>. Únete a la conversación
                        compartiendo tus propias lecturas.
                    </p>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="max-w-3xl mx-auto mt-12 pt-12 border-t border-[#E7E5E4]">
            <h3 class="text-2xl font-serif font-bold text-theme-text mb-8">Comentarios y Reseñas</h3>

            @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="bg-[#F5F5F4] p-6 rounded-3xl mb-12">
                    @csrf
                    <label class="block text-xs font-bold text-theme-muted uppercase tracking-wider mb-2">Tu valoración</label>
                    <div
                        class="flex gap-2 mb-4 text-2xl text-theme-muted hover:text-theme-secondary transition-colors cursor-pointer rating-input">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                <i
                                    class="fas fa-star peer-checked:text-theme-secondary hover:text-theme-secondary transition-colors"></i>
                            </label>
                        @endfor
                    </div>

                    <label class="block text-xs font-bold text-theme-muted uppercase tracking-wider mb-2">Tu comentario</label>
                    <textarea name="body" rows="4"
                        class="w-full bg-white border border-[#E7E5E4] rounded-xl p-4 text-sm focus:outline-none focus:border-theme-primary transition-colors mb-4"
                        placeholder="¿Qué te pareció este libro?" required></textarea>

                    <button type="submit"
                        class="bg-theme-primary text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:bg-[#8B4513] transition-colors">
                        Publicar Reseña
                    </button>
                </form>
            @else
                <div class="bg-[#F5F5F4] p-8 rounded-3xl text-center mb-12">
                    <p class="text-theme-muted mb-4">Inicia sesión para dejar tu reseña.</p>
                    <a href="{{ route('login') }}" class="text-theme-primary font-bold hover:underline">Log In</a>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse ($comments as $comment)
                    <div class="flex gap-4 p-6 bg-white border border-[#E7E5E4] rounded-2xl shadow-sm">
                        <div
                            class="w-10 h-10 rounded-full bg-theme-primary/10 flex items-center justify-center text-theme-primary text-sm font-bold shrink-0">
                            {{ strtoupper(substr($comment->user->username, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h5 class="font-bold text-theme-text text-sm">
                                        {{ $comment->user->username }}
                                    </h5>
                                    <div class="flex text-xs text-theme-secondary">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $comment->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-xs text-theme-muted">{{ $comment->created_at->format('d M Y') }}</span>
                            </div>
                            <p class="text-sm text-[#57534E] leading-relaxed">{{ $comment->body }}</p>

                            @can('delete', $comment)
                                <div class="mt-2 text-right flex justify-end">
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                        onsubmit="return confirm('¿Borrar comentario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-400 hover:text-red-600">Eliminar</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p class="text-center text-theme-muted italic">Sé el primero en comentar este libro.</p>
                @endforelse
            </div>
        </div>
    </article>

    <script>
        // Rating star interactions
        document.querySelectorAll('.rating-input label').forEach(label => {
            label.addEventListener('click', function () {
                let input = this.querySelector('input');
                let allLabels = this.parentElement.querySelectorAll('label');
                let clickedValue = parseInt(input.value);

                allLabels.forEach(lbl => {
                    let lblVal = parseInt(lbl.querySelector('input').value);
                    let icon = lbl.querySelector('i');
                    if (lblVal <= clickedValue) {
                        icon.classList.add('text-theme-secondary');
                        icon.classList.remove('text-theme-muted');
                    } else {
                        icon.classList.remove('text-theme-secondary');
                        icon.classList.add('text-theme-muted');
                    }
                });
            });
        });
    </script>
@endsection