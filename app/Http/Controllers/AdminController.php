<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Panel principal.
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'posts' => Post::count(),
            'comments' => Comment::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Lista de posts.
    public function posts()
    {
        $posts = Post::with('user')->latest()->get();
        return view('admin.posts', compact('posts'));
    }

    // Lista de comentarios.
    public function comments()
    {
        $comments = Comment::with(['user', 'post'])->latest()->get();
        return view('admin.comments', compact('comments'));
    }

    // Cambia estado del post.
    public function toggleStatus(Request $request, Post $post)
    {
        $validated = $request->validate(['status' => 'required|in:draft,published']);
        $post->update($validated);

        return redirect()->route('admin.posts')->with('success', 'Estado modificado.');
    }

    // Lista de usuarios.
    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    // Cambia rol del usuario.
    public function updateUserRole(Request $request, User $user)
    {
        $validated = $request->validate(['role' => 'required|in:admin,editor,subscriber']);

        $user->update([
            'role' => $validated['role'],
            'is_super' => $request->has('is_super'),
        ]);

        return redirect()->route('admin.users')->with('success', 'Usuario modificado.');
    }
}
