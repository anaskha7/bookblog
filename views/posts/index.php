<section class="mb-24">
    <!-- Figma Hero Section -->
    <div
        class="w-full bg-gradient-to-br from-white to-[#F3F0EB] rounded-[3rem] p-8 md:p-16 relative overflow-hidden shadow-soft border border-[#E7E5E4]">
        <!-- Mesh Gradient Decoration -->
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-br from-[#FFDEE9] to-[#B5FFFC] rounded-full blur-[100px] opacity-30 -translate-y-1/2 translate-x-1/4 pointer-events-none">
        </div>

        <div class="relative z-10 grid lg:grid-cols-2 gap-16 items-center">
            <!-- Left: Typography & CTA -->
            <div class="space-y-10">
                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-theme-primary"></span>
                    <span class="text-xs font-bold tracking-[0.2em] text-theme-muted uppercase">Curaduría Semanal</span>
                </div>

                <?php if (!empty($featured[0])):
                    $main = $featured[0]; ?>
                    <h1
                        class="text-6xl md:text-7xl lg:text-8xl font-serif font-medium text-theme-text leading-[0.9] tracking-tight text-balance">
                        <?= htmlspecialchars($main['title']) ?>
                    </h1>

                    <p class="text-lg text-[#57534E] max-w-lg leading-relaxed font-light">
                        <?= htmlspecialchars(mb_substr(strip_tags($main['content']), 0, 160)) ?>...
                        <span class="text-theme-primary font-medium">Leer más</span>
                    </p>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="<?= BASE_URL ?>?controller=post&action=show&id=<?= $main['id'] ?>"
                            class="px-8 py-4 rounded-full bg-theme-primary text-white font-medium hover:bg-[#8B4513] transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                            Leer Reseña
                        </a>
                        <a href="<?= BASE_URL ?>"
                            class="px-8 py-4 rounded-full bg-white border border-[#E7E5E4] text-theme-text font-medium hover:border-theme-primary transition-all shadow-sm">
                            Buscar reseñas
                        </a>
                    </div>
                <?php else: ?>
                    <h1 class="text-7xl font-serif font-medium text-theme-text leading-[0.9]">Lecturas que<br>dejan huella
                    </h1>
                    <p class="text-lg text-[#57534E] font-light">Reseñas honestas, listas temáticas y recomendaciones.</p>
                <?php endif; ?>
            </div>

            <!-- Right: 'Tendencias' Card (The Green/Dark Card) -->
            <div class="hidden lg:flex justify-end relative">
                <div class="bg-[#4a5d55] rounded-3xl p-8 w-[380px] shadow-2xl relative overflow-hidden group">
                    <!-- Card Header -->
                    <div class="mb-8 relative z-10">
                        <span
                            class="text-[#a5b8b0] text-[10px] font-bold tracking-widest uppercase mb-1 block">Tendencias</span>
                        <h2 class="text-white font-serif text-3xl">Bibliotecas vivas</h2>
                    </div>

                    <!-- Book Covers Grid -->
                    <div class="grid grid-cols-3 gap-3 relative z-10 mb-8">
                        <?php
                        // Mock covers if none exist for visual fidelity
                        $covers = array_slice($posts, 0, 3);
                        while (count($covers) < 3)
                            $covers[] = ['image_url' => ''];

                        foreach ($covers as $k => $p): ?>
                            <div class="aspect-[2/3] rounded-md overflow-hidden bg-white/10 relative shadow-lg transform transition-transform hover:-translate-y-1 duration-300"
                                style="transition-delay: <?= $k * 50 ?>ms">
                                <?php if (!empty($p['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($p['image_url']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <!-- Fallback colors matching the Figma design -->
                                    <div
                                        class="w-full h-full flex items-center justify-center  <?= $k == 0 ? 'bg-[#FFD700]' : ($k == 1 ? 'bg-[#1C2541]' : 'bg-[#FF6B6B]') ?>">
                                        <i class="fas fa-book text-white/50"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pt-6 border-t border-white/10 text-center relative z-10">
                        <p class="text-white/60 text-xs">Más de 120 reseñas nuevas esta semana.</p>
                    </div>

                    <!-- Decorative Circle behind -->
                    <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                </div>

                <!-- Floating elements behind card -->
                <div
                    class="absolute top-10 right-10 w-full h-full border border-theme-primary/10 rounded-3xl -z-10 translate-x-4 translate-y-4">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Grid Header -->
<div class="mb-12">
    <h2 class="text-4xl font-serif font-bold text-theme-text mb-3">Últimas publicaciones</h2>
    <p class="text-[#78716c]">Encuentra las reseñas más recientes de libros fascinantes</p>
</div>

<!-- LAYOUT DE 2 COLUMNAS (Main + Sidebar) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

    <!-- COLUMNA IZQUIERDA: LISTADO POSTS (8/12) -->
    <div class="lg:col-span-8">
        <div class="mb-8 flex items-end justify-between">
            <span class="text-sm text-theme-muted italic">Mostrando <?= count($posts) ?> resultados</span>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <?php foreach ($posts as $post): ?>
                <article
                    class="group flex flex-col h-full bg-white rounded-3xl p-4 shadow-soft hover:shadow-hover transition-all duration-300 border border-transparent hover:border-[#E7E5E4]">
                    <!-- Image -->
                    <a href="<?= BASE_URL ?>?controller=post&action=show&id=<?= $post['id'] ?>"
                        class="block relative aspect-[4/3] overflow-hidden rounded-2xl bg-[#F5F5F4] mb-6">
                        <?php if (!empty($post['image_url'])): ?>
                            <img src="<?= htmlspecialchars($post['image_url']) ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center"
                                style="background-color: <?= ['#FFD700', '#FF6B6B', '#4ECDC4'][rand(0, 2)] ?>">
                                <i class="fas fa-book text-4xl text-white/50"></i>
                            </div>
                        <?php endif; ?>

                        <!-- Rating Badge -->
                        <div
                            class="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                            <i class="fas fa-star text-theme-secondary"></i> <?= number_format($post['avg_rating'], 1) ?>
                        </div>
                    </a>

                    <!-- Content -->
                    <div class="flex-1 flex flex-col px-2">
                        <div class="mb-3">
                            <h3
                                class="text-2xl font-serif font-bold text-theme-text leading-tight mb-2 group-hover:text-theme-primary transition-colors">
                                <a href="<?= BASE_URL ?>?controller=post&action=show&id=<?= $post['id'] ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h3>
                            <div
                                class="flex items-center gap-2 text-xs font-bold text-theme-muted uppercase tracking-wider">
                                <i class="fas fa-feather-alt text-theme-primary"></i>
                                <?= htmlspecialchars($post['author']) ?>
                            </div>
                        </div>

                        <p class="text-[#78716c] text-sm leading-relaxed line-clamp-2 mb-6 flex-1 font-light">
                            <?= htmlspecialchars(mb_substr(strip_tags($post['content']), 0, 120)) ?>...
                        </p>

                        <div class="pt-4 border-t border-[#F5F5F4] flex items-center justify-between">
                            <span class="text-xs font-medium text-theme-muted bg-[#F5F5F4] px-3 py-1 rounded-full">
                                <?= date('d M Y', strtotime($post['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if (empty($posts)): ?>
            <div class="py-20 text-center border border-dashed border-[#E7E5E4] rounded-3xl bg-[#FFFBF5]">
                <p class="text-theme-muted font-serif italic text-lg">No hay publicaciones disponibles.</p>
            </div>
        <?php endif; ?>

        <!-- Paginación (Static for now/placeholder) -->
        <div class="mt-12 flex justify-center gap-2">
            <button
                class="w-10 h-10 rounded-full bg-theme-primary text-white flex items-center justify-center">1</button>
            <button
                class="w-10 h-10 rounded-full bg-white border border-[#E7E5E4] text-theme-muted hover:border-theme-primary flex items-center justify-center"><i
                    class="fas fa-arrow-right"></i></button>
        </div>
    </div>

    <!-- COLUMNA DERECHA: SIDEBAR / FILTROS (4/12) -->
    <aside class="lg:col-span-4 space-y-8">

        <!-- Widget Buscar -->
        <div class="bg-white p-6 rounded-3xl shadow-soft border border-[#E7E5E4]">
            <h4 class="font-serif font-bold text-lg mb-4">Buscar</h4>
            <div class="relative">
                <input type="text" placeholder="Buscar título o autor..."
                    class="w-full bg-[#F5F5F4] border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-theme-primary outline-none">
                <i class="fas fa-search absolute right-4 top-3.5 text-theme-muted"></i>
            </div>
        </div>

        <!-- Widget Categorías -->
        <div class="bg-white p-6 rounded-3xl shadow-soft border border-[#E7E5E4]">
            <h4 class="font-serif font-bold text-lg mb-4">Categorías</h4>
            <ul class="space-y-3">
                <li>
                    <a href="#"
                        class="flex items-center justify-between text-theme-muted hover:text-theme-primary group">
                        <span>Novela Histórica</span>
                        <span class="text-xs bg-[#F5F5F4] px-2 py-1 rounded-full group-hover:bg-theme-bg">12</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-between text-theme-muted hover:text-theme-primary group">
                        <span>Ciencia Ficción</span>
                        <span class="text-xs bg-[#F5F5F4] px-2 py-1 rounded-full group-hover:bg-theme-bg">8</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-between text-theme-muted hover:text-theme-primary group">
                        <span>Realismo Mágico</span>
                        <span class="text-xs bg-[#F5F5F4] px-2 py-1 rounded-full group-hover:bg-theme-bg">5</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Widget Suscripción -->
        <?php if (empty($_SESSION['user_id'])): ?>
            <div class="bg-theme-text text-white p-8 rounded-3xl shadow-lg text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-serif font-bold text-xl mb-2">Newsletter</h4>
                    <p class="text-white/60 text-sm mb-6">Recibe las mejores reseñas semanalmente en tu correo.</p>
                    <input type="email" placeholder="tu@email.com"
                        class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white text-sm mb-3 placeholder-white/30 focus:bg-white/20 outline-none">
                    <button
                        class="w-full bg-theme-primary hover:bg-[#8B4513] text-white font-bold py-3 rounded-xl transition-colors">Suscribirse</button>
                </div>
                <!-- Decoración -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-theme-primary/30 rounded-full blur-2xl"></div>
            </div>
        <?php endif; ?>

    </aside>
</div>