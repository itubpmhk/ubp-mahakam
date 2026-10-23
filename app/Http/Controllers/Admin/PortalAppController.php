<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalApp;
use App\Support\Uploads;
use Illuminate\Http\Request;

class PortalAppController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $apps = PortalApp::query()
            ->when($q !== '', fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('category', 'like', "%{$q}%"))
            ->ordered()->get();

        return view('admin.apps.index', compact('apps', 'q'));
    }

    public function create()
    {
        $next = (int) PortalApp::query()->max('sort_order') + 1;

        return view('admin.apps.form', [
            'item' => new PortalApp(['is_active' => true, 'open_new_tab' => true, 'category' => 'Umum', 'sort_order' => $next]),
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['thumbnail_path'] = Uploads::store($request->file('thumbnail'), 'portal');
        PortalApp::query()->create($data);

        return redirect()->route('admin.apps.index')->with('success', 'Aplikasi ditambahkan.');
    }

    public function edit(PortalApp $app)
    {
        return view('admin.apps.form', ['item' => $app, 'categories' => $this->categories()]);
    }

    public function update(Request $request, PortalApp $app)
    {
        $data = $this->validated($request);
        if ($request->boolean('remove_thumbnail')) {
            Uploads::delete($app->thumbnail_path);
            $app->thumbnail_path = null;
        }
        $data['thumbnail_path'] = Uploads::replace($request->file('thumbnail'), $app->thumbnail_path, 'portal');
        $app->update($data);

        return redirect()->route('admin.apps.index')->with('success', 'Aplikasi diperbarui.');
    }

    public function destroy(PortalApp $app)
    {
        Uploads::delete($app->thumbnail_path);
        $app->delete();

        return back()->with('success', 'Aplikasi dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:60'],
            'description' => ['nullable', 'string', 'max:500'],
            'url' => ['required', 'string', 'max:2048', 'regex:~^(https?://|/)~i'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'url.regex' => 'Alamat aplikasi harus diawali http://, https://, atau / (alamat di server yang sama).',
            'thumbnail.max' => 'Thumbnail maksimal 4 MB.',
        ]);
        unset($data['thumbnail']);
        $data['category'] = trim($data['category']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['open_new_tab'] = $request->boolean('open_new_tab');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function categories()
    {
        return PortalApp::query()->distinct()->orderBy('category')->pluck('category');
    }
}
