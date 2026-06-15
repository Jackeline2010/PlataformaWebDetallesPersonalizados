<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(Order $order)
    {
        $this->authorizeOrder($order);

        if (($order->estado ?? 'PEN') === 'CAN') {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('error', 'No puedes pagar un pedido cancelado.');
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
        $this->authorizeOrder($order);

        if (($order->estado ?? 'PEN') === 'CAN') {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('error', 'No puedes pagar un pedido cancelado.');
        }

        if (($order->estado_pago ?? 'PENDIENTE') === 'PAGADO') {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('success', 'Este pedido ya tiene el pago registrado.');
        }

        $validated = $request->validate([
            'metodo_pago' => ['required', 'in:transferencia,efectivo,stripe'],
            'referencia_pago' => ['nullable', 'string', 'max:100'],
            'comprobante_pago' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $metodoPago = $validated['metodo_pago'];

        if ($metodoPago === 'transferencia') {
            $request->validate([
                'referencia_pago' => ['required', 'string', 'max:100'],
                'comprobante_pago' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            ]);

            $comprobantePath = $request->file('comprobante_pago')
                ->store('comprobantes', 'public');

            $order->update([
                'metodo_pago' => 'transferencia',
                'estado_pago' => 'PENDIENTE',
                'estado' => 'PEN',
                'referencia_pago' => $validated['referencia_pago'],
                'comprobante_pago' => $comprobantePath,
                'payment_provider' => null,
                'payment_transaction_id' => null,
                'payment_token' => null,
                'payment_session_key' => null,
                'payment_url' => null,
                'payment_response' => null,
            ]);

            return redirect()
                ->route('client.orders.show', $order)
                ->with('success', 'Comprobante enviado correctamente. El pago queda pendiente hasta validación del administrador.');
        }

        if ($metodoPago === 'efectivo') {
            $order->update([
                'metodo_pago' => 'efectivo',
                'estado_pago' => 'PENDIENTE',
                'estado' => 'PEN',
                'referencia_pago' => null,
                'comprobante_pago' => null,
                'payment_provider' => null,
                'payment_transaction_id' => null,
                'payment_token' => null,
                'payment_session_key' => null,
                'payment_url' => null,
                'payment_response' => null,
            ]);

            return redirect()
                ->route('client.orders.show', $order)
                ->with('success', 'Pago en efectivo registrado. El pago queda pendiente hasta la entrega o retiro.');
        }

        if ($metodoPago === 'stripe') {
            $order->update([
                'metodo_pago' => 'stripe',
                'estado_pago' => 'PENDIENTE',
                'estado' => 'PEN',
                'referencia_pago' => null,
                'comprobante_pago' => null,
                'payment_provider' => 'STRIPE',
            ]);

            return redirect()->route('client.stripe.checkout', $order);
        }

        return redirect()
            ->route('client.payment.index', $order)
            ->with('error', 'Método de pago no válido.');
    }

    public function failed(Order $order)
    {
        $this->authorizeOrder($order);

        return redirect()
            ->route('client.payment.index', $order)
            ->with('error', 'El pago no fue completado. Puedes intentarlo nuevamente.');
    }

    private function authorizeOrder(Order $order): void
    {
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403);
        }
    }
}
