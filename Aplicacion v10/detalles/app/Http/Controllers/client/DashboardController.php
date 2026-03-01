<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // últimos pedidos del usuario
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // contador del carrito (si tu Cart soporta user o session)
        $userId = $user->id;
        $sessionId = Session::getId();

        $cartCount = Cart::query()
            ->where(function ($q) use ($userId, $sessionId) {
                $q->where('user_id', $userId)
                  ->orWhere('session_id', $sessionId);
            })
            ->sum('cantidad');

        return view('client.dashboard', compact('orders', 'cartCount'));
    }
}
