<section class="py-8 w-full max-w-7xl mx-auto px-4">
    <div class="mb-8">
        <h1 class="text-4xl font-serif font-bold text-slate-900 mb-2 flex items-center gap-3">
            <i class="fas fa-users text-blue-600"></i><span
                class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Gestionar
                Usuarios</span>
        </h1>
        <p class="text-slate-600 text-lg">Controla los roles y permisos de los miembros de la comunidad.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                    <tr class="text-left text-slate-700 font-semibold">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nombre</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Rol Actual</th>
                        <th class="px-6 py-4">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-700">
                                <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">#<?= $user['id'] ?></span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($user['name']) ?></td>
                            <td class="px-6 py-4 text-slate-600 text-sm"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= $user['role'] === 'admin' ? 'bg-red-100 text-red-700' : ($user['role'] === 'writer' ? 'bg-teal-100 text-teal-700' : 'bg-blue-100 text-blue-700') ?>">
                                    <?= htmlspecialchars($user['role']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <select name="role"
                                        class="border border-slate-300 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                        <?php foreach (['admin', 'writer', 'subscriber'] as $role): ?>
                                            <option value="<?= $role ?>" <?= $user['role'] === $role ? 'selected' : '' ?>>
                                                <?= ucfirst($role) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button
                                        class="gradient-bg text-white px-3 py-1 rounded-lg hover:shadow-lg transition-all text-sm font-semibold">Actualizar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</section>