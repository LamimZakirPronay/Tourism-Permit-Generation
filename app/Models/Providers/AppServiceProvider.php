<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator; // Required for pagination styling
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Fix the large pagination icons by forcing Bootstrap 5 styling
        Paginator::useBootstrapFive();

        // 2. Share $siteSettings variable with every blade view
        View::composer('*', function ($view) {
            $view->with('siteSettings', SiteSetting::pluck('value', 'key'));
        });
    }
}
