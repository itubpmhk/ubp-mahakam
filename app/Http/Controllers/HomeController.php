<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use App\Models\PortalApp;
use App\Models\Post;
use App\Models\Setting;
use App\Support\Youtube;

class HomeController extends Controller
{
    public function __invoke()
    {
        $site = Setting::allCached();

        return view('site.home', [
            'commitments' => Commitment::query()->where('is_active', true)->ordered()->get(),
            'latestPosts' => Post::query()->published()->latest('published_at')->take(3)->get(),
            'apps' => PortalApp::query()->where('is_active', true)->ordered()->take(3)->get(),
            'videoId' => Youtube::id($site['video_youtube'] ?? null),
        ]);
    }
}
