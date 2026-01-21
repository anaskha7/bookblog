<?php $errors = $errors ?? []; $message = $message ?? null; ?>

<div class="w-full min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">Introducir código de administrador</h1>
                <p class="text-slate-600">Si tienes un código válido, introdúcelo aquí para obtener permisos de administrador.</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                    <?php foreach ($errors as $error): ?>
                        <p class="text-red-700 text-sm"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($message): ?>
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                    <p class="text-green-700 text-sm"><?= htmlspecialchars($message) ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Código</label>
                    <div class="relative">
                        <i class="fas fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="secret_code" class="w-full border border-slate-300 rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="Introduce el código">
                    </div>
                </div>

                <button type="submit" class="w-full gradient-bg text-white font-bold py-3 rounded-lg hover:shadow-lg transition-all transform hover:scale-105 active:scale-95">Enviar código</button>
            </form>

            <div class="mt-6 text-center">
                <a href="<?= BASE_URL ?>" class="text-sm text-slate-600 hover:text-slate-800">Volver a la página principal</a>
            </div>
        </div>
    </div>
</div>
