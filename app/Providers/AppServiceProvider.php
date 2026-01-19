<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use App\Models\Sport;

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
         View::composer('admin.*', function ($view) {
        $view->with('categories', Category::all());
    });
    View::composer('shop.layouts.*', function ($view) {
        $view->with(
            'sports',
            Sport::orderBy('name')->get()
        );
    });
    }
}
