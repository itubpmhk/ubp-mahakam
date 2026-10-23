<?php

namespace App\Http\Controllers;

use App\Models\PortalApp;

class PortalController extends Controller
{
    public function __invoke()
    {
        $apps = PortalApp::query()->where('is_active', true)->ordered()->get();
        $categories = $apps->pluck('category')->filter()->unique()->values();

        return view('site.portal', compact('apps', 'categories'));
    }
}
