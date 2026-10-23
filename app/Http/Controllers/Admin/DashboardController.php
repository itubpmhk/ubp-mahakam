<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commitment;
use App\Models\PortalApp;
use App\Models\Post;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'published' => Post::query()->published()->count(),
                'drafts' => Post::query()->where('status', 'draft')->count(),
                'apps' => PortalApp::query()->where('is_active', true)->count(),
                'commitments' => Commitment::query()->where('is_active', true)->count(),
            ],
            'latestPosts' => Post::query()->latest('updated_at')->take(6)->get(),
        ]);
    }
}
