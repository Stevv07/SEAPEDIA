<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;

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
        // Kirim data jumlah cart ke semua view
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $cartCount = Cart::where('user_email', Auth::user()->email)->count();
            }

            $view->with('cartCount', $cartCount);
        });

        // Untuk header admin: kirim notifikasi order (status = WAITING)
        View::composer('components.admin.header', function ($view) {
            $waitingOrders = Order::with('orderItems','user', 'payment')
                ->where('status', 'WAITING')
                ->latest()
                ->take(3)
                ->get();

            $view->with('waitingOrders', $waitingOrders);
        });

         if ($this->app->environment('local')) {
            $this->app->register(\App\Providers\BroadcastServiceProvider::class);
        }
    }
}
