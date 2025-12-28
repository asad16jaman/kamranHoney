<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            if (auth('customer')->check()) {
                $userId = auth('customer')->id();
                $cart = session()->get('cart_' . $userId, []);
                $cartCount = array_sum(array_column($cart, 'quantity'));
            } else {
                $cartCount = 0;
            }
            $view->with('cartCount', $cartCount);
        });
    }

    public function register()
    {
        //
    }
}
