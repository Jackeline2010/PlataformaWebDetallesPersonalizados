<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Order $order)
    {
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403);
        }

        if (($order->estado_pago ?? 'PENDIENTE') === 'PAGADO') {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('success', 'Este pedido ya tiene el pago registrado.');
        }

        return view('client.payment.index', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'metodo_pago' => ['required', 'in:transferencia,efectivo,tarjeta_debito'],
            'referencia_pago' => ['nullable', 'string', 'max:100'],
        ]);

        $metodoPago = $validated['metodo_pago'];

        $estadoPago = match ($metodoPago) {
            'tarjeta_debito' => 'PAGADO',
            'transferencia' => 'PENDIENTE',
            'efectivo' => 'PENDIENTE',
            default => 'PENDIENTE',
        };

        $order->update([
            'metodo_pago' => $metodoPago,
            'estado_pago' => $estadoPago,
            'referencia_pago' => $validated['referencia_pago'] ?? null,
            ]);

        return redirect()
            ->route('client.orders.show', $order)
            ->with('success', 'Método de pago registrado correctamente.');
    }
}
