<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::forUser($request->user()->id)
            ->latest()
            ->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        $order->load('orderProducts.product');

        return view('client.orders.show', [
            'order' => $order,
            'orderItems' => $order->orderProducts,
            'subtotal' => $order->subtotal,
            'descuento' => $order->descuento,
            'impuesto' => $order->impuesto,
            'total' => $order->total,
        ]);
    }
}
