@extends('layouts.admin')

@section('title', 'Pagos')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Pagos</h1>
    <p class="text-gray-500 mb-6">Consulta los métodos de pago y estados registrados por pedido.</p>

    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-pink-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Pedido</th>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Método</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Referencia / Transacción</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-right">Fecha</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-pink-100">
                @forelse($orders as $order)
                    @php
                        $metodoPago = match($order->metodo_pago) {
                            'transferencia' => 'Transferencia bancaria',
                            'efectivo' => 'Pago en efectivo',
                            'tarjeta_debito' => 'Tarjeta de débito',
                            default => 'No registrado',
                        };

                        $estadoPagoClass = match($order->estado_pago) {
                            'PAGADO' => 'bg-green-100 text-green-700',
                            'RECHAZADO' => 'bg-red-100 text-red-700',
                            default => 'bg-yellow-100 text-yellow-700',
                        };
                    @endphp

                    <tr>
                        <td class="px-4 py-3 font-semibold">
                            {{ $order->numero_orden ?? '#' . $order->id }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->user->name ?? 'Cliente' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $metodoPago }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $estadoPagoClass }}">
                                {{ $order->estado_pago ?? 'PENDIENTE' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $order->payment_transaction_id ?? $order->referencia_pago ?? 'Sin referencia' }}
                        </td>

                        <td class="px-4 py-3 text-right font-bold text-pink-600">
                            ${{ number_format((float) $order->total, 2) }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            {{ optional($order->fpedido)->format('d/m/Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                            No hay pagos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($orders, 'links'))
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
