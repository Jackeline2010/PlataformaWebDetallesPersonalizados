<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $userId = $user->id;
        $sessionId = Session::getId();

        $cartCount = Cart::query()
            ->where(function ($q) use ($userId, $sessionId) {
                $q->where('user_id', $userId)
                  ->orWhere('session_id', $sessionId);
            })
            ->sum('cantidad');

        $promotions = Promotion::where('activo', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('client.dashboard', compact(
            'orders',
            'cartCount',
            'promotions'
        ));
    }
}
