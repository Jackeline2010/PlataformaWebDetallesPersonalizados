<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.admin', function ($view) {

            // Pedidos pendientes (PEN)
            $pendingOrders = Order::where('estado', 'PEN')->count();

            // Pedidos nuevos hoy (PEN creados hoy)
            $newOrdersToday = Order::where('estado', 'PEN')
                ->whereDate('created_at', now()->toDateString())
                ->count();

            // Pedidos en proceso (ING)
            $inProgressOrders = Order::where('estado', 'ING')->count();

            $view->with([
                'pendingOrders'    => $pendingOrders,
                'newOrdersToday'   => $newOrdersToday,
                'inProgressOrders' => $inProgressOrders,
            ]);
        });
    }
}
