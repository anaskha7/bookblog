<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin' || $user->is_super) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Post $post): bool
    {
        return $post->status === 'published' || $user->id === $post->user_id;
    }
    public function create(User $user): bool
    {
        return true;
    }
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
    public function restore(User $user, Post $post): bool
    {
        return false;
    }
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
