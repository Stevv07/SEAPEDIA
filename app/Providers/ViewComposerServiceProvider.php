<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;  // Model kategori

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Kirim data $categories ke semua view yang memakai 'components.pembeli.header'
        View::composer('components.pembeli.header', function ($view) {
            $categories = Category::all();
            $view->with('categories', $categories);
        });

        // Kalau mau ke semua view, pakai:
        // View::share('categories', Category::all());
    }

    public function register()
    {
        //
    }
}
