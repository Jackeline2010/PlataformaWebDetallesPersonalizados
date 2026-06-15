<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function confirmPayment(\App\Models\Order $order)
{
    if (($order->estado_pago ?? 'PENDIENTE') === 'PAGADO') {
        return back()->with('success', 'Este pedido ya tiene el pago confirmado.');
    }

    $order->update([
        'estado_pago' => 'PAGADO',
        'estado' => 'PRO',
        'fecha_pago_confirmado' => now(),
    ]);

    return back()->with('success', 'Pago confirmado correctamente. El pedido pasó a En Proceso.');
}

public function complete(\App\Models\Order $order)
{
    if (($order->estado_pago ?? 'PENDIENTE') !== 'PAGADO') {
        return back()->with('error', 'No puedes completar un pedido sin pago confirmado.');
    }

    if (($order->estado ?? 'PEN') !== 'PRO') {
        return back()->with('error', 'Solo se pueden completar pedidos que estén en proceso.');
    }

    $order->update([
        'estado' => 'COM',
    ]);

    return back()->with('success', 'Pedido marcado como completado correctamente.');
}
}
