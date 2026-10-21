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
        \Illuminate\Support\Facades\View::composer('layouts.public', function ($view) {
            $navPlatformCategories = \App\Models\PlatformCategory::orderBy('sort_order')->orderBy('name')->get();
            $view->with('navPlatformCategories', $navPlatformCategories);
        });
    }
}
