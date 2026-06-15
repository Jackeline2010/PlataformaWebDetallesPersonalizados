@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pedidos</h1>
            <p class="text-sm text-gray-500 mt-1">
                Gestiona los pedidos registrados y confirma los pagos pendientes.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-pink-100">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Pedido
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Método de pago
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Estado pago
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Comprobante
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-pink-100">
                    @forelse($orders as $order)
                        @php
                            $metodoPagoLabel = [
                                'transferencia' => 'Transferencia bancaria',
                                'efectivo' => 'Pago en efectivo',
                                'stripe' => 'Tarjeta con Stripe',
                                'tarjeta_debito' => 'Tarjeta de débito',
                            ][$order->metodo_pago] ?? 'No registrado';

                            $estadoPago = $order->estado_pago ?? 'PENDIENTE';

                            $estadoPagoClass = match($estadoPago) {
                                'PAGADO' => 'bg-green-50 text-green-700 border-green-200',
                                'RECHAZADO' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            };
                        @endphp

                        <tr class="hover:bg-pink-50/40 transition">
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <p class="font-bold text-gray-800">
                                    {{ $order->numero_orden ?? 'Pedido #' . $order->id }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ optional($order->created_at)->format('d/m/Y H:i') }}
                                </p>
                            </td>

                            <td class="px-4 py-4 text-sm text-gray-700">
                                <p class="font-semibold">
                                    {{ $order->contacto_entrega ?? optional($order->client)->nombres ?? 'Cliente' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $order->telefono_contacto ?? 'Sin teléfono' }}
                                </p>
                            </td>

                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ $metodoPagoLabel }}

                                @if(!empty($order->referencia_pago))
                                    <p class="text-xs text-gray-500 mt-1">
                                        Ref: {{ $order->referencia_pago }}
                                    </p>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-semibold {{ $estadoPagoClass }}">
                                    {{ $estadoPago }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-sm font-bold text-pink-600">
                                ${{ number_format((float) ($order->total ?? 0), 2) }}
                            </td>

                            <td class="px-4 py-4 text-sm">
                                @if($order->metodo_pago === 'transferencia' && !empty($order->comprobante_pago))
                                    <a href="{{ asset('storage/' . $order->comprobante_pago) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline font-semibold">
                                        Ver comprobante
                                    </a>
                                @elseif($order->metodo_pago === 'transferencia')
                                    <span class="text-red-500 text-xs font-semibold">
                                        Sin comprobante
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">
                                        No aplica
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-sm text-right">
                                <div class="flex flex-col items-end gap-2">
                                    @if(Route::has('admin.orders.show'))
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="inline-flex items-center justify-center border border-pink-200 text-pink-600 hover:bg-pink-50 px-3 py-2 rounded-lg text-xs font-semibold transition">
                                            Ver detalle
                                        </a>
                                    @endif

                                    @if(($order->estado_pago ?? 'PENDIENTE') !== 'PAGADO' && !empty($order->metodo_pago))
                                        <form action="{{ route('admin.orders.confirmPayment', $order) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    onclick="return confirm('¿Confirmar el pago de este pedido?')"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-xs font-semibold transition">
                                                Confirmar pago
                                            </button>
                                        </form>
                                    @endif

                                    @if(
    ($order->estado_pago ?? 'PENDIENTE') === 'PAGADO'
    && ($order->estado ?? 'PEN') === 'PRO'
)
    <form action="{{ route('admin.orders.complete', $order) }}"
          method="POST">
        @csrf
        @method('PATCH')

        <button type="submit"
                onclick="return confirm('¿Marcar este pedido como completado?')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-xs font-semibold transition">
            Marcar completado
        </button>
    </form>
@endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                No hay pedidos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($orders, 'links'))
            <div class="px-4 py-4 border-t border-pink-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
