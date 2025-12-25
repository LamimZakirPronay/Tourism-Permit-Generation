<?php

namespace App\Providers;

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
    // This shares the $siteSettings variable with every blade view
    \Illuminate\Support\Facades\View::composer('*', function ($view) {
        $view->with('siteSettings', \App\Models\SiteSetting::pluck('value', 'key'));
    });
}
}
