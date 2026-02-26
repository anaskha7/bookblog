@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-12 flex items-center justify-between">
            <div>
                <a href="{{ route('home') }}"
                    class="text-theme-muted hover:text-theme-primary transition-colors text-sm font-semibold flex items-center gap-2 mb-4">
                    <i class="fas fa-arrow-left"></i> Volver a inicio
                </a>
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-theme-text mb-4">Escribir nueva reseña</h1>
                <p class="text-theme-muted text-lg">Comparte tu opinión sobre esa lectura que no puedes olvidar.</p>
            </div>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-3xl p-8 md:p-12 shadow-soft border border-[#E7E5E4]">
            @csrf
            <div class="space-y-8">
                <div>
                    <label for="title" class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Título
                        del Libro <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-4 text-theme-text focus:ring-2 focus:ring-theme-primary outline-none transition-shadow text-lg font-medium">
                </div>

                <div>
                    <label for="image" class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Portada
                        del Libro (JPG, PNG, WEBP) <span class="text-red-500">*</span></label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-[#E7E5E4] rounded-2xl hover:border-theme-primary/50 transition-colors bg-[#FFFBF5]">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-image text-3xl text-theme-muted mb-3"></i>
                            <div class="flex text-sm text-theme-text justify-center">
                                <label for="image"
                                    class="relative cursor-pointer rounded-md font-medium text-theme-primary hover:text-[#8B4513] focus-within:outline-none">
                                    <span>Subir un archivo</span>
                                    <input id="image" name="image" type="file" required
                                        accept="image/jpeg,image/png,image/webp" class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-theme-muted">Hasta 6MB</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="content" class="block text-sm font-bold text-theme-text mb-2 uppercase tracking-wide">Tu
                        Reseña <span class="text-red-500">*</span></label>
                    <textarea id="content" name="content" rows="12" required
                        class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-4 text-theme-text focus:ring-2 focus:ring-theme-primary outline-none transition-shadow leading-relaxed resize-y">{{ old('content') }}</textarea>
                    <p class="mt-2 text-sm text-theme-muted">Escribe con libertad. Usa espacios para separar párrafos.</p>
                </div>

                <div class="pt-6 flex items-center justify-end gap-4 border-t border-[#E7E5E4]">
                    <a href="{{ route('home') }}"
                        class="px-6 py-3 rounded-full font-medium text-theme-muted hover:text-theme-text transition-colors">Cancelar</a>
                    <button type="submit"
                        class="px-8 py-3 rounded-full bg-theme-primary text-white font-medium hover:bg-[#8B4513] transition-colors shadow-lg shadow-theme-primary/20">Publicar
                        Reseña</button>
                </div>
            </div>
        </form>
    </div>
@endsection