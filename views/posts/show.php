<article class="max-w-[1000px] mx-auto w-full">

    <!-- CABECERA DE CONTENIDO / TITULO -->
    <header class="text-center mb-12 space-y-6">
        <div
            class="inline-flex items-center gap-2 text-xs font-bold text-theme-primary uppercase tracking-widest bg-orange-50 px-3 py-1 rounded-full">
            <i class="fas fa-star text-theme-secondary"></i>
            <span>Reseña</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-serif font-bold text-theme-text leading-tight text-balance">
            <?= htmlspecialchars($post['title']) ?>
        </h1>
        <div class="flex items-center justify-center gap-6 text-theme-muted text-sm flex-wrap">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-theme-primary flex items-center justify-center text-white text-xs">
                    <i class="fas fa-user"></i>
                </span>
                <span class="font-medium text-theme-text">Por
                    <?= htmlspecialchars($post['username'] ?? 'Autor') ?></span>
            </div>
            <span>•</span>
            <span><?= date('d M, Y', strtotime($post['created_at'])) ?></span>
            <span>•</span>
            <div class="flex items-center gap-1 text-theme-secondary">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="<?= $i <= round((float) ($post['rating'] ?? 0)) ? 'fas' : 'far' ?> fa-star"></i>
                <?php endfor; ?>
            </div>
        </div>
    </header>

    <!-- RECURSO MULTIMEDIA: IMAGEN DE PORTADA (HERO) -->
    <?php if (!empty($post['image_url'])): ?>
        <div class="w-full aspect-[21/9] rounded-3xl overflow-hidden shadow-2xl mb-16 relative group">
            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
            <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="Portada del libro"
                class="w-full h-full object-cover">
        </div>
    <?php endif; ?>

    <!-- CONTENIDO DEL POST -->
    <div class="prose prose-lg prose-stone mx-auto font-serif text-[#57534E] max-w-3xl">


        <!-- Renderizado de contenido (Permitir HTML seguro o nl2br si es texto plano) -->
        <?= nl2br($post['content']) // Nota: En un entorno real deberíamos usar algo como HTMLPurifier si permitimos HTML ?>
    </div>

    <!-- SECCIÓN DE ACCIONES / ADMIN -->
    <?php if (!empty($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['user_id'] || !empty($_SESSION['is_super']))): ?>
        <div class="flex justify-center gap-4 mt-12 pt-8 border-t border-[#E7E5E4]">
            <a href="<?= BASE_URL ?>?controller=post&action=edit&id=<?= $post['id'] ?>"
                class="px-6 py-2 rounded-full border border-theme-primary text-theme-primary hover:bg-theme-primary hover:text-white transition-colors">
                <i class="fas fa-edit mr-2"></i> Editar Reseña
            </a>
            <a href="<?= BASE_URL ?>?controller=post&action=delete&id=<?= $post['id'] ?>"
                onclick="return confirm('¿Seguro que deseas eliminar esta reseña?')"
                class="px-6 py-2 rounded-full border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition-colors">
                <i class="fas fa-trash mr-2"></i> Eliminar
            </a>
        </div>
    <?php endif; ?>

    <!-- SECCIÓN DE AUTOR / PROFILE CARD -->
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
                    Esta reseña fue escrita por
                    <strong><?= htmlspecialchars($post['username'] ?? 'un miembro de la comunidad') ?></strong>.
                    Únete a la conversación compartiendo tus propias lecturas.
                </p>
            </div>
        </div>
    </div>

    <!-- SECCIÓN DE COMENTARIOS Y RATING -->
    <div class="max-w-3xl mx-auto mt-12 pt-12 border-t border-[#E7E5E4]">
        <h3 class="text-2xl font-serif font-bold text-theme-text mb-8">Comentarios y Reseñas</h3>

        <!-- Formulario (Solo si logueado) -->
        <?php if (!empty($_SESSION['user_id'])): ?>
            <form action="<?= BASE_URL ?>?controller=comment&action=store" method="POST"
                class="bg-[#F5F5F4] p-6 rounded-3xl mb-12">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">

                <label class="block text-xs font-bold text-theme-muted uppercase tracking-wider mb-2">Tu valoración</label>
                <div
                    class="flex gap-2 mb-4 text-2xl text-theme-muted hover:text-theme-secondary transition-colors cursor-pointer rating-input">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="rating" value="<?= $i ?>" class="hidden peer">
                            <i
                                class="fas fa-star peer-checked:text-theme-secondary hover:text-theme-secondary transition-colors"></i>
                        </label>
                    <?php endfor; ?>
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
        <?php else: ?>
            <div class="bg-[#F5F5F4] p-8 rounded-3xl text-center mb-12">
                <p class="text-theme-muted mb-4">Inicia sesión para dejar tu reseña.</p>
                <a href="<?= BASE_URL ?>?controller=user&action=login"
                    class="text-theme-primary font-bold hover:underline">Log In</a>
            </div>
        <?php endif; ?>

        <!-- Listado de Comentarios -->
        <div class="space-y-6">
            <?php foreach ($comments as $comment): ?>
                <div class="flex gap-4 p-6 bg-white border border-[#E7E5E4] rounded-2xl shadow-sm">
                    <div
                        class="w-10 h-10 rounded-full bg-theme-primary/10 flex items-center justify-center text-theme-primary text-sm font-bold shrink-0">
                        <?= strtoupper(substr($comment['username'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h5 class="font-bold text-theme-text text-sm">
                                    <?= htmlspecialchars($comment['username'] ?? 'Usuario') ?>
                                </h5>
                                <div class="flex text-xs text-theme-secondary">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="<?= $i <= $comment['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <span
                                class="text-xs text-theme-muted"><?= date('d M Y', strtotime($comment['created_at'])) ?></span>
                        </div>
                        <p class="text-sm text-[#57534E] leading-relaxed"><?= nl2br(htmlspecialchars($comment['body'])) ?>
                        </p>

                        <?php if (!empty($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || !empty($_SESSION['is_super']))): ?>
                            <div class="mt-2 text-right">
                                <a href="<?= BASE_URL ?>?controller=comment&action=delete&id=<?= $comment['id'] ?>"
                                    onclick="return confirm('¿Borrar comentario?')"
                                    class="text-xs text-red-400 hover:text-red-600">Eliminar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($comments)): ?>
                <p class="text-center text-theme-muted italic">Sé el primero en comentar este libro.</p>
            <?php endif; ?>
        </div>
    </div>