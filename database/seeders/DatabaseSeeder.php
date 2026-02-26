<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario admin.
        $admin = User::create([
            'username' => 'Admin Superior',
            'email' => 'admin@bookblog.com',
            'password_hash' => Hash::make('admin123'),
            'role' => 'admin',
            'is_super' => true,
        ]);

        // Usuario normal.
        $user = User::create([
            'username' => 'Lector Entusiasta',
            'email' => 'lector@bookblog.com',
            'password_hash' => Hash::make('lector123'),
            'role' => 'subscriber',
            'is_super' => false,
        ]);

        // Post de prueba.
        $post = Post::create([
            'title' => 'El Imperio Final: Una Fantasía Magistral',
            'content' => 'Brandon Sanderson nos sumerge en un mundo cubierto de ceniza donde el sol brilla escarlata y el Lord Legislador gobierna con mano de hierro. La magia alomántica es un sistema brillante que atrapa desde el primer capítulo.',
            'user_id' => $admin->id,
            'status' => 'published',
        ]);

        // Comentario de prueba.
        Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => '¡Totalmente de acuerdo! El sistema de magia es lo mejor que he leído.',
            'rating' => 5,
        ]);
    }
}
