<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $posts = Post::query()
            ->published()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('body', 'like', "%{$q}%");
                });
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('site.news.index', compact('posts', 'q'));
    }

    public function show(Post $post)
    {
        // drafts / scheduled posts are only visible to logged-in admins (preview)
        abort_unless($post->isPublished() || auth()->check(), 404);

        if ($post->isPublished()) {
            $post->increment('views');
        }

        $post->load('media');

        $related = Post::query()->published()
            ->whereKeyNot($post->id)
            ->latest('published_at')->take(3)->get();

        return view('site.news.show', compact('post', 'related'));
    }
}
