<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\NiubizService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            'metodo_pago' => ['required', 'in:transferencia,efectivo,tarjeta_debito'],
            'referencia_pago' => ['nullable', 'string', 'max:100'],
        ]);

        $metodoPago = $validated['metodo_pago'];

        if ($metodoPago === 'transferencia' && empty($validated['referencia_pago'])) {
            return back()
                ->withErrors([
                    'referencia_pago' => 'Para transferencia bancaria debes ingresar una referencia o número de comprobante.',
                ])
                ->withInput();
        }

        if ($metodoPago === 'tarjeta_debito') {
            $order->update([
                'metodo_pago' => $metodoPago,
                'estado_pago' => 'PENDIENTE',
                'referencia_pago' => null,
                'payment_provider' => 'NIUBIZ',
            ]);

            return redirect()->route('client.payment.niubiz', $order);
        }

        $mensaje = match ($metodoPago) {
            'transferencia' => 'Transferencia registrada. El pago queda pendiente hasta validación del administrador.',
            'efectivo' => 'Pago en efectivo registrado. El pago queda pendiente hasta la entrega o retiro.',
            default => 'Método de pago registrado correctamente.',
        };

        $order->update([
            'metodo_pago' => $metodoPago,
            'estado_pago' => 'PENDIENTE',
            'referencia_pago' => $validated['referencia_pago'] ?? null,
            'payment_provider' => null,
        ]);

        return redirect()
            ->route('client.orders.show', $order)
            ->with('success', $mensaje);
    }

    public function niubiz(Order $order, NiubizService $niubiz)
    {
        $this->authorizeOrder($order);

        if (($order->estado_pago ?? 'PENDIENTE') === 'PAGADO') {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('success', 'Este pedido ya tiene el pago registrado.');
        }

        try {
            $purchaseNumber = (string) ($order->numero_orden ?? $order->id);
            $amount = (float) $order->total;

            $data = $niubiz->createSession($amount, $purchaseNumber);

            $session = $data['session'] ?? [];
            $sessionKey = $session['sessionKey'] ?? null;

            if (!$sessionKey) {
                throw new Exception('Niubiz no devolvió sessionKey.');
            }

            $order->update([
                'payment_provider' => 'NIUBIZ',
                'payment_token' => $data['access_token'] ?? null,
                'payment_session_key' => $sessionKey,
            ]);

            return view('client.payment.niubiz', [
                'order' => $order,
                'sessionKey' => $sessionKey,
                'merchantId' => $niubiz->getMerchantId(),
                'apiKey' => $niubiz->getApiKey(),
                'jsUrl' => $niubiz->getJsUrl(),
                'channel' => config('niubiz.channel', 'web'),
                'purchaseNumber' => $purchaseNumber,
            ]);
        } catch (Exception $e) {
            Log::error('Error creando sesión Niubiz', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('client.payment.index', $order)
               ->with('error', $e->getMessage());
        }
    }

    public function authorizeNiubiz(Request $request, Order $order, NiubizService $niubiz)
    {
        $this->authorizeOrder($order);

        try {
            $transactionToken = $request->input('transactionToken');

            if (!$transactionToken) {
                return redirect()
                    ->route('client.payment.failed', $order)
                    ->with('error', 'No se recibió el token de transacción de Niubiz.');
            }

            $purchaseNumber = (string) ($order->numero_orden ?? $order->id);
            $amount = (float) $order->total;

            $response = $niubiz->authorizePayment(
                $transactionToken,
                $amount,
                $purchaseNumber
            );

            $transactionId = data_get($response, 'dataMap.TRANSACTION_ID')
                ?? data_get($response, 'order.transactionId')
                ?? data_get($response, 'transactionId');

            $actionCode = data_get($response, 'dataMap.ACTION_CODE')
                ?? data_get($response, 'order.actionCode');

            $isApproved = in_array((string) $actionCode, ['000'], true);

            $order->update([
                'estado_pago' => $isApproved ? 'PAGADO' : 'RECHAZADO',
                'payment_provider' => 'NIUBIZ',
                'payment_transaction_id' => $transactionId,
                'payment_response' => $response,
            ]);

            if (!$isApproved) {
                return redirect()
                    ->route('client.payment.failed', $order)
                    ->with('error', 'El pago fue rechazado por Niubiz.');
            }

            return redirect()
                ->route('client.orders.show', $order)
                ->with('success', 'Pago con tarjeta aprobado correctamente.');
        } catch (Exception $e) {
            Log::error('Error autorizando pago Niubiz', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('client.payment.failed', $order)
                ->with('error', 'Ocurrió un error al confirmar el pago con Niubiz.');
        }
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
