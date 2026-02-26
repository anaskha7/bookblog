<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, \App\Models\Post $post)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'body' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        \App\Models\Comment::create([
            'post_id' => $post->id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'body' => $validated['body'],
            'rating' => $validated['rating'],
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', '¡Comentario añadido!');
    }

    public function destroy(\App\Models\Comment $comment)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('success', 'Comentario eliminado.');
    }
}
