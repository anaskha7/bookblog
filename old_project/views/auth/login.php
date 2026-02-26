<?php $errors = $errors ?? []; ?>

<div class="flex items-center justify-center min-h-[70vh] relative overflow-hidden py-12">

    <!-- Elementos Decorativos de Fondo -->
    <div
        class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-[#FFDEE9] rounded-full blur-[120px] opacity-30 z-0 pointer-events-none">
    </div>
    <div
        class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-[#F5F5DC] rounded-full blur-[120px] opacity-40 z-0 pointer-events-none">
    </div>

    <!-- TARJETA DE LOGIN -->
    <div class="w-full max-w-md bg-white p-10 rounded-3xl shadow-soft relative z-10 border border-[#E7E5E4]">
        <div class="text-center mb-10">
            <div
                class="w-12 h-12 bg-theme-primary rounded-xl flex items-center justify-center text-white mx-auto mb-4 shadow-lg rotate-3">
                <i class="fas fa-user"></i>
            </div>
            <h2 class="text-3xl font-serif font-bold text-theme-text mb-2">Bienvenido</h2>
            <p class="text-theme-muted text-sm">Ingresa a tu cuenta para guardar tus lecturas.</p>
        </div>

        <!-- Error Display -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6 text-center">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-600 text-sm font-medium"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="space-y-6" method="POST">
            <div>
                <label class="block text-xs font-bold text-theme-text uppercase tracking-wider mb-2">Correo
                    Electrónico</label>
                <input type="email" name="email" placeholder="lector@ejemplo.com"
                    class="w-full bg-[#F5F5F4] border-transparent focus:bg-white focus:border-theme-primary focus:ring-0 rounded-xl px-4 py-3 transition-all outline-none"
                    required>
            </div>

            <div>
                <label class="block text-xs font-bold text-theme-text uppercase tracking-wider mb-2">Contraseña</label>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full bg-[#F5F5F4] border-transparent focus:bg-white focus:border-theme-primary focus:ring-0 rounded-xl px-4 py-3 transition-all outline-none"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-theme-primary hover:bg-[#8B4513] text-white font-bold py-3.5 rounded-xl shadow-lg transition-transform hover:-translate-y-0.5">
                Iniciar Sesión
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-theme-muted">
            ¿No tienes cuenta? <a href="<?= BASE_URL ?>?controller=user&action=register"
                class="text-theme-primary font-bold hover:underline">Regístrate aquí</a>
        </div>

    </div>
</div>