<section class="py-12 mb-20">
    <div class="w-full max-w-6xl mx-auto px-6">
        <!-- Header -->
        <div class="mb-12 border-b border-[#E7E5E4] pb-8">
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-theme-text mb-4">
                Panel de Control
            </h1>
            <p class="text-theme-muted text-lg font-light tracking-wide">
                Bienvenido al centro de gestión editorial.
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Users Card -->
            <div class="bg-white rounded-xl p-8 border border-[#E7E5E4] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div class="text-theme-text text-xl">
                        <i class="fas fa-users"></i>
                    </div>
                    <span
                        class="text-[10px] font-bold tracking-widest uppercase text-theme-muted border border-[#E7E5E4] px-2 py-1 rounded">Lectores</span>
                </div>
                <p class="text-5xl font-serif font-bold text-theme-primary mb-2"><?= $stats['users'] ?></p>
                <p class="text-theme-muted text-sm font-medium">Usuarios registrados</p>
            </div>

            <!-- Posts Card -->
            <div class="bg-white rounded-xl p-8 border border-[#E7E5E4] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div class="text-theme-text text-xl">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span
                        class="text-[10px] font-bold tracking-widest uppercase text-theme-muted border border-[#E7E5E4] px-2 py-1 rounded">Catálogo</span>
                </div>
                <p class="text-5xl font-serif font-bold text-theme-primary mb-2"><?= $stats['posts'] ?></p>
                <p class="text-theme-muted text-sm font-medium">Reseñas publicadas</p>
            </div>

            <!-- Comments Card -->
            <div class="bg-white rounded-xl p-8 border border-[#E7E5E4] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div class="text-theme-text text-xl">
                        <i class="fas fa-comment-alt"></i>
                    </div>
                    <span
                        class="text-[10px] font-bold tracking-widest uppercase text-theme-muted border border-[#E7E5E4] px-2 py-1 rounded">Comunidad</span>
                </div>
                <p class="text-5xl font-serif font-bold text-theme-primary mb-2"><?= $stats['comments'] ?></p>
                <p class="text-theme-muted text-sm font-medium">Comentarios totales</p>
            </div>
        </div>

        <!-- Actions -->
        <div>
            <h2 class="text-2xl font-serif font-bold text-theme-text mb-8 flex items-center gap-3">
                <span class="w-8 h-px bg-theme-primary"></span>
                Acciones Administrativas
            </h2>
            <div class="grid md:grid-cols-3 gap-6">
                <a href="<?= BASE_URL ?>?controller=admin&action=users"
                    class="group bg-[#F5F5F4] hover:bg-theme-primary p-8 rounded-xl transition-all duration-300 border border-transparent hover:border-theme-primary text-center">
                    <div class="text-3xl text-theme-muted group-hover:text-white mb-4 transition-colors">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h3 class="font-bold text-theme-text group-hover:text-white mb-2 transition-colors">Usuarios</h3>
                    <p class="text-xs text-theme-muted group-hover:text-white/80 transition-colors">Gestionar roles y
                        permisos</p>
                </a>

                <a href="<?= BASE_URL ?>?controller=admin&action=posts"
                    class="group bg-[#F5F5F4] hover:bg-theme-primary p-8 rounded-xl transition-all duration-300 border border-transparent hover:border-theme-primary text-center">
                    <div class="text-3xl text-theme-muted group-hover:text-white mb-4 transition-colors">
                        <i class="fas fa-feather-alt"></i>
                    </div>
                    <h3 class="font-bold text-theme-text group-hover:text-white mb-2 transition-colors">Publicaciones
                    </h3>
                    <p class="text-xs text-theme-muted group-hover:text-white/80 transition-colors">Moderación de
                        reseñas</p>
                </a>

                <a href="<?= BASE_URL ?>?controller=admin&action=comments"
                    class="group bg-[#F5F5F4] hover:bg-theme-primary p-8 rounded-xl transition-all duration-300 border border-transparent hover:border-theme-primary text-center">
                    <div class="text-3xl text-theme-muted group-hover:text-white mb-4 transition-colors">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="font-bold text-theme-text group-hover:text-white mb-2 transition-colors">Comentarios</h3>
                    <p class="text-xs text-theme-muted group-hover:text-white/80 transition-colors">Revisar
                        participación</p>
                </a>
            </div>
        </div>
    </div>
</section>