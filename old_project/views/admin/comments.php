<section class="py-8 w-full px-4">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-white mb-2 flex items-center gap-3">
            <i class="fas fa-comments text-pink-400"></i>Gestionar Comentarios
        </h1>
        <p class="text-slate-400">Revisa y administra las reseñas y comentarios</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                    <tr class="text-left text-slate-700 font-semibold">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Post</th>
                        <th class="px-6 py-4">Autor</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Texto</th>
                        <th class="px-6 py-4">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($comments as $comment): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-700">#<?= $comment['id'] ?></td>
                            <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($comment['post_title']) ?></td>
                            <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($comment['author']) ?></td>
                            <td class="px-6 py-4 text-sm"><?= (int) $comment['rating'] ?></td>
                            <td class="px-6 py-4 text-slate-700 text-sm"><?= htmlspecialchars(mb_substr($comment['body'], 0, 80)) ?>...</td>
                            <td class="px-6 py-4">
                                <a class="inline-flex items-center gap-2 bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-lg transition-all text-sm font-semibold" href="<?= BASE_URL ?>?controller=comment&action=delete&id=<?= $comment['id'] ?>" onclick="return confirm('¿Eliminar comentario?')">
                                    <i class="fas fa-trash"></i>Borrar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
