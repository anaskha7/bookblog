<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    // Acceso total para admins.
    public function before(User $user, string $ability): ?bool
    {
        return ($user->role === 'admin' || $user->is_super) ? true : null;
    }

    // Ver lista.
    public function viewAny(User $user): bool
    {
        return true;
    }

    // Ver uno solo.
    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    // Crear comentario.
    public function create(User $user): bool
    {
        return true;
    }

    // Solo el autor edita.
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    // Solo el autor borra.
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
