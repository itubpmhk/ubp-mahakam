<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Every public page (and the admin layout, for the site name) gets $site = all landing settings.
        View::composer(['layouts.site', 'site.*', 'layouts.admin'], function ($view) {
            try {
                $site = Setting::allCached();          // served from cache after the first request
            } catch (\Throwable $e) {
                $site = Setting::defaults();           // e.g. before "php artisan migrate" has run
            }
            $view->with('site', $site);
        });
    }
}
