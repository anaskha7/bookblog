<?php $errors = $errors ?? []; ?>

<div class="py-12 w-full max-w-4xl mx-auto px-4">
    <!-- Header -->
    <div class="mb-10 text-center">
        <a href="<?= BASE_URL ?>/posts/<?= $post['id'] ?>"
            class="text-blue-600 hover:text-blue-700 font-bold inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full bg-blue-50 hover:bg-blue-100 transition-colors">
            <i class="fas fa-arrow-left"></i>Volver a la reseña
        </a>
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 mb-3">Editar Reseña</h1>
        <p class="text-slate-600 text-lg">Actualiza la información de tu publicación.</p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-[2.5rem] shadow-xl p-8 md:p-12 border border-slate-100">
        <!-- Errors -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-8">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-700 font-medium flex items-center gap-2"><i class="fas fa-exclamation-circle"></i>
                        <?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form class="space-y-8" method="POST" enctype="multipart/form-data">
            <!-- Título -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Nombre del Libro</label>
                <div class="relative group">
                    <i
                        class="fas fa-book absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>"
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 focus:outline-none focus:border-blue-500 focus:bg-white transition-all text-lg font-medium text-slate-800 placeholder-slate-400"
                        required>
                </div>
            </div>

            <!-- Contenido -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Tu Reseña</label>
                <div class="relative group">
                    <i
                        class="fas fa-align-left absolute left-5 top-6 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    <textarea name="content" rows="8"
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 focus:outline-none focus:border-blue-500 focus:bg-white transition-all resize-none text-lg text-slate-800 placeholder-slate-400 leading-relaxed"
                        required><?= htmlspecialchars($post['content']) ?></textarea>
                </div>
            </div>

            <!-- Portada (Recursos Multimedia) -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Actualizar Portada
                    (Opcional)</label>
                <div class="flex gap-6 items-center">
                    <?php if (!empty($post['image_url'])): ?>
                        <div class="w-24 h-32 rounded-lg overflow-hidden flex-shrink-0 shadow-md border border-slate-200">
                            <img src="<?= htmlspecialchars($post['image_url']) ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>

                    <div
                        class="relative border-2 border-dashed border-slate-200 rounded-2xl p-6 flex-1 text-center hover:bg-slate-50 transition-colors hover:border-blue-400 group cursor-pointer h-32 flex flex-col justify-center">
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="space-y-1">
                            <i
                                class="fas fa-cloud-upload-alt text-2xl text-slate-300 group-hover:text-blue-500 transition-colors"></i>
                            <p class="text-slate-600 font-medium text-sm">Click para cambiar imagen</p>
                            <p class="text-xs text-slate-400">Deja vacío para mantener la actual</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-slate-100">
                <button type="submit"
                    class="flex-1 bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-black hover:shadow-lg transition-all transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-save text-blue-400"></i>Guardar Cambios
                </button>
                <a href="<?= BASE_URL ?>/posts/<?= $post['id'] ?>"
                    class="flex-1 border-2 border-slate-200 text-slate-600 font-bold py-4 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all inline-flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>