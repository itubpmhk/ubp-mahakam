<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostMedia;
use App\Support\HtmlSanitizer;
use App\Support\Uploads;
use App\Support\Youtube;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    private const IMAGE_MIMES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private const VIDEO_MIMES = ['video/mp4', 'video/webm', 'video/quicktime'];

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = $request->query('status');

        $posts = Post::query()
            ->withCount('media')
            ->when($q !== '', fn ($w) => $w->where('title', 'like', "%{$q}%"))
            ->when(in_array($status, ['draft', 'published'], true), fn ($w) => $w->where('status', $status))
            ->latest('updated_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', compact('posts', 'q', 'status'));
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post(['status' => 'draft', 'published_at' => now()])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $post = DB::transaction(function () use ($request, $data) {
            $post = new Post($data);
            $post->user_id = $request->user()->id;
            $post->slug = Post::uniqueSlug($data['title']);
            $post->cover_path = Uploads::store($request->file('cover'), 'news/covers');
            $post->save();
            $this->saveMedia($request, $post);

            return $post;
        });

        return redirect()->route('admin.posts.edit', $post)->with('success', 'Berita tersimpan.');
    }

    public function edit(Post $post)
    {
        $post->load('media');

        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);
        $oldInline = self::inlineImages($post->body);

        DB::transaction(function () use ($request, $post, $data) {
            // drafts follow their title; published posts keep their URL unless asked
            if ($request->boolean('regenerate_slug') || ($post->title !== $data['title'] && ! $post->isPublished())) {
                $post->slug = Post::uniqueSlug($data['title'], $post->id);
            }
            $post->fill($data);

            if ($request->boolean('remove_cover')) {
                Uploads::delete($post->cover_path);
                $post->cover_path = null;
            }
            $post->cover_path = Uploads::replace($request->file('cover'), $post->cover_path, 'news/covers');
            $post->save();

            $this->saveMedia($request, $post);
        });

        // pictures that were removed from the text are deleted from storage
        foreach (array_diff($oldInline, self::inlineImages($post->body)) as $path) {
            Uploads::delete($path);
        }

        return redirect()->route('admin.posts.edit', $post)->with('success', 'Berita diperbarui.');
    }

    public function destroy(Post $post)
    {
        foreach ($post->media as $m) {
            Uploads::delete($m->path);
        }
        foreach (self::inlineImages($post->body) as $path) {
            Uploads::delete($path);
        }
        Uploads::delete($post->cover_path);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Berita dihapus.');
    }

    /**
     * Upload for pictures placed inside the news text (Trix editor attachments).
     * Returns the public URL that the editor puts into <img src>.
     */
    public function uploadInline(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ], [
            'file.max' => 'Gambar maksimal 5 MB.',
            'file.image' => 'File harus berupa gambar.',
        ]);

        $path = $request->file('file')->store('news/inline', 'public');

        // relative URL, so it keeps working after moving to another domain
        return response()->json(['url' => '/storage/'.$path]);
    }

    /** Storage paths of pictures embedded in a news body. */
    private static function inlineImages(?string $html): array
    {
        preg_match_all('~/storage/(news/inline/[A-Za-z0-9._/-]+)~', (string) $html, $m);

        return array_values(array_unique($m[1]));
    }

    /* ------------------------------------------------------------------ */

    private function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:400'],
            'body' => ['nullable', 'string', 'max:200000'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'media' => ['nullable', 'array'],
            'media.*.caption' => ['nullable', 'string', 'max:255'],
            'media.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'media.*.delete' => ['nullable'],

            'new_media' => ['nullable', 'array', 'max:20'],
            'new_media.*.type' => ['nullable', Rule::in(array_keys(PostMedia::TYPES))],
            'new_media.*.file' => ['nullable', 'file', 'max:102400', 'mimetypes:'.implode(',', array_merge(self::IMAGE_MIMES, self::VIDEO_MIMES))],
            'new_media.*.url' => ['nullable', 'url:http,https', 'max:2048'],
            'new_media.*.caption' => ['nullable', 'string', 'max:255'],
        ], [
            'cover.max' => 'Gambar sampul maksimal 5 MB.',
            'new_media.*.file.max' => 'Ukuran file media maksimal 100 MB.',
            'new_media.*.file.mimetypes' => 'Format file media harus JPG, PNG, WEBP, GIF, MP4, WEBM, atau MOV.',
            'new_media.*.url.url' => 'Link harus alamat lengkap yang diawali https://',
        ]);

        $body = HtmlSanitizer::clean($data['body'] ?? '');

        $publishedAt = $data['published_at'] ?? null;
        if ($data['status'] === 'published' && ! $publishedAt) {
            $publishedAt = $post?->published_at ?? now();
        }

        return [
            'title' => $data['title'],
            'excerpt' => $data['excerpt'] ?? null,
            'body' => $body,
            'status' => $data['status'],
            'published_at' => $publishedAt ? Carbon::parse($publishedAt) : null,
        ];
    }

    /** Update/delete existing media rows and add new ones. */
    private function saveMedia(Request $request, Post $post): void
    {
        // existing
        foreach ((array) $request->input('media', []) as $id => $row) {
            $media = $post->media()->whereKey($id)->first();
            if (! $media) {
                continue;
            }
            if (! empty($row['delete'])) {
                Uploads::delete($media->path);
                $media->delete();
                continue;
            }
            $media->update([
                'caption' => $row['caption'] ?? null,
                'sort_order' => (int) ($row['sort_order'] ?? $media->sort_order),
            ]);
        }

        // new
        $next = (int) $post->media()->max('sort_order') + 1;
        $errors = [];
        foreach ((array) $request->input('new_media', []) as $i => $row) {
            $type = $row['type'] ?? null;
            if (! $type) {
                continue;
            }
            $file = $request->file("new_media.$i.file");
            $url = trim((string) ($row['url'] ?? ''));
            $item = ['type' => $type, 'caption' => $row['caption'] ?? null, 'sort_order' => $next++];

            if (in_array($type, ['image', 'video'], true)) {
                if (! $file) {
                    continue; // empty row
                }
                $allowed = $type === 'image' ? self::IMAGE_MIMES : self::VIDEO_MIMES;
                if (! in_array($file->getMimeType(), $allowed, true)) {
                    $errors["new_media.$i.file"] = $type === 'image' ? 'File harus berupa gambar.' : 'File harus berupa video (MP4/WEBM/MOV).';
                    continue;
                }
                $item['path'] = $file->store($type === 'image' ? 'news/images' : 'news/videos', 'public');
            } else {
                if ($url === '') {
                    continue;
                }
                if ($type === 'youtube' && ! Youtube::id($url)) {
                    $errors["new_media.$i.url"] = 'Link YouTube tidak dikenali.';
                    continue;
                }
                $item['url'] = $url;
            }

            $post->media()->create($item);
        }

        if ($errors) {
            throw ValidationException::withMessages($errors);
        }
    }
}
