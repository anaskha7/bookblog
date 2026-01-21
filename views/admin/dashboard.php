<section class="py-8">
    <div class="w-full px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-2 flex items-center justify-center gap-3">
                <i class="fas fa-shield-alt text-teal-400"></i>Gestión
            </h1>
            <p class="text-slate-400 text-lg">Controla todo desde aquí</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <!-- Users Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 border border-blue-200 hover:shadow-xl transition-all transform hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-500 text-white rounded-full w-14 h-14 flex items-center justify-center text-2xl">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-200 px-3 py-1 rounded-full">Total</span>
                </div>
                <p class="text-slate-700 text-sm font-semibold mb-1">Usuarios</p>
                <p class="text-5xl font-bold gradient-text"><?= $stats['users'] ?></p>
            </div>

            <!-- Posts Card -->
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl p-8 border border-teal-200 hover:shadow-xl transition-all transform hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-teal-500 text-white rounded-full w-14 h-14 flex items-center justify-center text-2xl">
                        <i class="fas fa-book"></i>
                    </div>
                    <span class="text-xs font-bold text-teal-600 bg-teal-200 px-3 py-1 rounded-full">Total</span>
                </div>
                <p class="text-slate-700 text-sm font-semibold mb-1">Reseñas</p>
                <p class="text-5xl font-bold gradient-text"><?= $stats['posts'] ?></p>
            </div>

            <!-- Comments Card -->
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl p-8 border border-pink-200 hover:shadow-xl transition-all transform hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-pink-500 text-white rounded-full w-14 h-14 flex items-center justify-center text-2xl">
                        <i class="fas fa-comments"></i>
                    </div>
                    <span class="text-xs font-bold text-pink-600 bg-pink-200 px-3 py-1 rounded-full">Total</span>
                </div>
                <p class="text-slate-700 text-sm font-semibold mb-1">Comentarios</p>
                <p class="text-5xl font-bold gradient-text"><?= $stats['comments'] ?></p>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-200">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                <i class="fas fa-cogs text-teal-600"></i>Acciones Rápidas
            </h2>
            <div class="grid md:grid-cols-3 gap-4">
                <a class="group bg-gradient-to-br from-blue-500 to-blue-600 text-white px-8 py-6 rounded-xl hover:shadow-xl transition-all transform hover:scale-105 text-center font-bold inline-flex items-center justify-center gap-2" href="<?= BASE_URL ?>?controller=admin&action=users">
                    <i class="fas fa-user-check"></i>Gestionar Usuarios
                </a>
                <a class="group bg-gradient-to-br from-teal-500 to-teal-600 text-white px-8 py-6 rounded-xl hover:shadow-xl transition-all transform hover:scale-105 text-center font-bold inline-flex items-center justify-center gap-2" href="<?= BASE_URL ?>?controller=admin&action=posts">
                    <i class="fas fa-book-bookmark"></i>Gestionar Reseñas
                </a>
                <a class="group bg-gradient-to-br from-pink-500 to-pink-600 text-white px-8 py-6 rounded-xl hover:shadow-xl transition-all transform hover:scale-105 text-center font-bold inline-flex items-center justify-center gap-2" href="<?= BASE_URL ?>?controller=admin&action=comments">
                    <i class="fas fa-comment-dots"></i>Gestionar Comentarios
                </a>
            </div>
        </div>
    </div>
</section>
