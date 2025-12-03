<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;

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
        // Share favoriteCount ke semua view yang extend templates.app
        View::composer('templates.app', function ($view) {
            $favoriteCount = auth()->check()
                ? auth()->user()->likes()->count()
                : 0;

            $view->with('favoriteCount', $favoriteCount);
        });
    }
}
