<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $query = \App\Models\Post::with('user')->where('status', 'published');

        if ($q) {
            $query->whereRaw("MATCH(title, content) AGAINST (? IN NATURAL LANGUAGE MODE)", [$q]);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $rawPosts = $query->get();

        $posts = $rawPosts->map(function (\App\Models\Post $post) {
            $post->avg_rating = $post->comments()->avg('rating') ?? 0;
            return $post;
        });

        $featured = $posts->sortByDesc('avg_rating')->take(3);

        return view('posts.index', compact('posts', 'featured', 'q'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function show(\App\Models\Post $post)
    {
        if ($post->status === 'draft') {
            if (!\Illuminate\Support\Facades\Auth::check() || (!\Illuminate\Support\Facades\Auth::user()->is_super && \Illuminate\Support\Facades\Auth::user()->role !== 'admin' && \Illuminate\Support\Facades\Auth::user()->id !== $post->user_id)) {
                abort(404, 'Post no encontrado');
            }
        }

        $comments = $post->comments()->with('user')->orderBy('created_at', 'desc')->get();
        $avgRating = $post->comments()->avg('rating') ?? 0;

        $relatedQuery = $post->title . ' ' . substr($post->content, 0, 100);
        $relatedPosts = \App\Models\Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->whereRaw("MATCH(title, content) AGAINST (? IN NATURAL LANGUAGE MODE)", [$relatedQuery])
            ->take(3)
            ->get();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = \App\Models\Post::where('status', 'published')
                ->where('id', '!=', $post->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        }

        return view('posts.show', compact('post', 'comments', 'avgRating', 'relatedPosts'));
    }

    public function create()
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login');
        }
        return view('posts.create');
    }

    public function store(Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:65536',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'cover_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $imagePath = '/uploads/' . $filename;
        }

        $post = clone \App\Models\Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'image_url' => $imagePath,
            'status' => 'published',
        ]);

        if (env('N8N_WEBHOOK_URL')) {
            try {
                \Illuminate\Support\Facades\Http::post(env('N8N_WEBHOOK_URL'), [
                    'event' => 'new_post',
                    'post_id' => $post->id,
                    'title' => $post->title,
                    'summary' => substr($post->content, 0, 200) . '...',
                    'author_id' => $post->user_id,
                    'image_url' => $post->image_url ? (env('APP_URL') . $post->image_url) : null,
                    'created_at' => now()->toDateTimeString()
                ]);
            } catch (\Exception $e) {
                // Ignore N8N errors like original project
            }
        }

        return redirect()->route('posts.show', $post->id)->with('success', '¡Reseña publicada con éxito! Gracias por compartir.');
    }

    public function edit(\App\Models\Post $post)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, \App\Models\Post $post)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:65536',
        ]);

        $post->title = $validated['title'];
        $post->content = $validated['content'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'cover_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $post->image_url = '/uploads/' . $filename;
        }

        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'La reseña se ha actualizado correctamente.');
    }

    public function destroy(\App\Models\Post $post)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $post);
        $post->delete();

        return redirect()->route('home')->with('success', 'La reseña ha sido eliminada.');
    }
}
