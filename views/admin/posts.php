<section class="py-8 w-full max-w-7xl mx-auto px-4">
    <div class="mb-8">
        <h1 class="text-4xl font-serif font-bold text-slate-900 mb-2 flex items-center gap-3">
            <i class="fas fa-book-open text-blue-600"></i><span
                class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Gestionar
                Reseñas</span>
        </h1>
        <p class="text-slate-600 text-lg">Administra todos los libros y publicaciones de la plataforma.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                    <tr class="text-left text-slate-700 font-semibold">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Título</th>
                        <th class="px-6 py-4">Autor</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($posts as $post): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-700">
                                <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">#<?= $post['id'] ?></span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($post['title']) ?></td>
                            <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($post['author']) ?></td>
                            <td class="px-6 py-4 text-slate-500 text-sm">
                                <?= date('d M Y', strtotime($post['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if (($post['status'] ?? 'published') === 'published'): ?>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <i class="fas fa-check-circle"></i> Publicado
                                    </span>
                                <?php else: ?>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                        <i class="fas fa-clock"></i> Borrador
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <form method="POST" action="<?= BASE_URL ?>?controller=admin&action=toggle_status"
                                        class="inline">
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                        <?php if (($post['status'] ?? 'published') === 'published'): ?>
                                            <input type="hidden" name="status" value="draft">
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1 rounded-lg transition-all text-sm font-semibold"
                                                title="Ocultar (Borrador)">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                        <?php else: ?>
                                            <input type="hidden" name="status" value="published">
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1 rounded-lg transition-all text-sm font-semibold"
                                                title="Publicar">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    <a class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-lg transition-all text-sm font-semibold"
                                        href="<?= BASE_URL ?>?controller=post&action=edit&id=<?= $post['id'] ?>">
                                        <i class="fas fa-edit"></i>Editar
                                    </a>
                                    <a class="inline-flex items-center gap-2 bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-lg transition-all text-sm font-semibold"
                                        href="<?= BASE_URL ?>?controller=post&action=delete&id=<?= $post['id'] ?>"
                                        onclick="return confirm('¿Eliminar esta reseña?')">
                                        <i class="fas fa-trash"></i>Borrar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (empty($posts)): ?>
            <div class="text-center py-12 px-6">
                <i class="fas fa-inbox text-4xl text-slate-300 mb-3 block"></i>
                <p class="text-slate-500 font-semibold">No hay reseñas aún</p>
            </div>
        <?php endif; ?>
    </div>
</section>