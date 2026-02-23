<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Compartir datos con el layout del admin Y el sidebar
        View::composer(['layouts.admin', 'layouts.sidebar'], function ($view) {

            // Pedidos pendientes (PEN)
            $pendingOrders = Order::where('estado', 'PEN')->count();

            // Pedidos nuevos hoy (PEN creados hoy)
            $newOrdersToday = Order::where('estado', 'PEN')
                ->whereDate('created_at', now()->toDateString())
                ->count();

            // Pedidos en proceso (ING)
            $inProgressOrders = Order::where('estado', 'ING')->count();

            // Categorías activas (para el submenú del sidebar)
            $adminCategories = Category::where('activo', true)
                ->orderBy('orden')
                ->get();

            $view->with([
                'pendingOrders'    => $pendingOrders,
                'newOrdersToday'   => $newOrdersToday,
                'inProgressOrders' => $inProgressOrders,
                'adminCategories'  => $adminCategories,
            ]);
        });
    }
}
