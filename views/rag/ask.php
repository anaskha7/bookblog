<section class="py-8">
    <div class="w-full px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-3 flex items-center justify-center gap-3">
                <i class="fas fa-search text-teal-400"></i>Buscar
            </h1>
            <p class="text-slate-400 text-lg">Descubre reseñas según tus intereses</p>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-200 mb-8">
            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">¿Qué te gustaría saber?</label>
                    <div class="relative">
                        <i class="fas fa-lightbulb absolute left-4 top-1/2 transform -translate-y-1/2 text-teal-400"></i>
                        <input name="question" class="w-full border-2 border-slate-200 rounded-lg pl-12 pr-4 py-4 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all text-lg" placeholder="Ej: ¿Qué libro tiene mejor valoración?" required>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Busca por título, autor, género o cualquier otro criterio</p>
                </div>

                <button class="w-full gradient-bg text-white font-bold py-4 rounded-lg hover:shadow-lg transition-all transform hover:scale-105 active:scale-95 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i>Buscar Ahora
                </button>
            </form>
        </div>

        <!-- Results -->
        <?php if ($answer !== null): ?>
            <!-- Answer Section -->
            <div class="bg-gradient-to-br from-teal-50 to-blue-50 rounded-2xl p-8 border-2 border-teal-200 mb-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-sparkles text-teal-600"></i>Resultado
                </h2>
                <div class="bg-white rounded-lg p-6 text-slate-700 leading-relaxed whitespace-pre-line text-lg">
                    <?= htmlspecialchars($answer) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Sources -->
        <?php if (!empty($authorGroups)): ?>
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-200 mb-6">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-user text-green-600"></i>Autores Encontrados
                </h2>
                <div class="space-y-4">
                    <?php foreach ($authorGroups as $author => $posts): ?>
                        <?php if (count($posts) > 1): // Mostrar solo autores con más de un libro ?>
                            <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg p-4 border border-slate-200 hover:border-green-300 transition-all">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-slate-900 text-lg">
                                        <i class="fas fa-user-edit text-green-600 mr-2"></i><?= htmlspecialchars($author) ?>
                                    </h3>
                                    <span class="bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                        <?= count($posts) ?> libros
                                    </span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <?php foreach ($posts as $p): ?>
                                        <a href="<?= BASE_URL ?>?controller=post&action=show&id=<?= $p['id'] ?>" class="block p-3 bg-white rounded-md border hover:shadow-sm transition">
                                            <div class="font-semibold text-slate-800"><?= htmlspecialchars($p['title']) ?></div>
                                            <div class="text-xs text-slate-500 mt-1">Publicado: <?= htmlspecialchars($p['created_at'] ?? '') ?></div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($sources)): ?>
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-book-open text-blue-600"></i>Reseñas Relacionadas
                </h2>
                <div class="space-y-4">
                    <?php foreach ($sources as $source): ?>
                        <a href="<?= BASE_URL ?>?controller=post&action=show&id=<?= $source['id'] ?>" class="block bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg p-4 border border-slate-200 hover:border-teal-300 transition-all">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-slate-900 text-lg">
                                    <i class="fas fa-book text-teal-600 mr-2"></i><?= htmlspecialchars($source['title']) ?>
                                </h3>
                                <span class="bg-teal-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    Relevancia: <?= number_format($source['score'] * 100, 0) ?>%
                                </span>
                            </div>
                            <p class="text-sm text-slate-600">Encontramos contenido relacionado en esta reseña</p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif ($answer !== null): ?>
            <div class="text-center py-8 bg-blue-50 rounded-2xl border border-blue-200">
                <i class="fas fa-inbox text-4xl text-blue-300 mb-3 block"></i>
                <p class="text-slate-600 font-semibold">No encontramos reseñas relacionadas con tu búsqueda</p>
            </div>
        <?php endif; ?>
    </div>
</section>
