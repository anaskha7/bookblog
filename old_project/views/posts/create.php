<?php $errors = $errors ?? []; ?>

<div class="py-12 w-full max-w-4xl mx-auto px-4">
    <!-- Header -->
    <div class="mb-10 text-center">
        <a href="<?= BASE_URL ?>"
            class="text-blue-600 hover:text-blue-700 font-bold inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full bg-blue-50 hover:bg-blue-100 transition-colors">
            <i class="fas fa-arrow-left"></i>Volver a inicio
        </a>
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 mb-3">Comparte tu Lectura</h1>
        <p class="text-slate-600 text-lg">Cuéntanos qué te pareció el libro y ayuda a otros lectores.</p>
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
                    <input type="text" name="title"
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 focus:outline-none focus:border-blue-500 focus:bg-white transition-all text-lg font-medium text-slate-800 placeholder-slate-400"
                        placeholder="Ej: Cien años de soledad" required>
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
                        placeholder="Comparte tu experiencia..." required></textarea>
                </div>
                <p class="text-xs text-slate-400 text-right">Mínimo 50 caracteres</p>
            </div>

            <!-- Portada (Recursos Multimedia) -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Portada del Libro</label>
                <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:bg-slate-50 transition-colors hover:border-blue-400 group cursor-pointer"
                    onclick="document.getElementById('fileInput').click()">
                    <input type="file" id="fileInput" name="image" accept="image/jpeg,image/png,image/webp"
                        class="hidden" required onchange="updateFileName(this)">
                    <div class="space-y-2">
                        <i id="uploadIcon"
                            class="fas fa-cloud-upload-alt text-4xl text-slate-300 group-hover:text-blue-500 transition-colors"></i>
                        <p id="fileName" class="text-slate-600 font-medium">Click para subir imagen</p>
                        <p class="text-xs text-slate-400">JPG, PNG o WEBP (Máx. 64MB)</p>
                    </div>
                </div>
                <script>
                    function updateFileName(input) {
                        const fileNameDisplay = document.getElementById('fileName');
                        const uploadIcon = document.getElementById('uploadIcon');
                        if (input.files && input.files[0]) {
                            fileNameDisplay.textContent = 'Seleccionado: ' + input.files[0].name;
                            fileNameDisplay.classList.add('text-blue-600');
                            uploadIcon.className = 'fas fa-check-circle text-4xl text-green-500 transition-colors';
                        }
                    }
                </script>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-slate-100">
                <button type="submit"
                    class="flex-1 bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-black hover:shadow-lg transition-all transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-blue-400"></i>Publicar Reseña
                </button>
                <a href="<?= BASE_URL ?>"
                    class="flex-1 border-2 border-slate-200 text-slate-600 font-bold py-4 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all inline-flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>