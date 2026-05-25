@extends('layouts.client')

@section('title', 'Mis Pedidos | SandyDecor')

@section('content')
<div class="max-w-6xl mx-auto px-4 md:px-6 py-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Mis pedidos
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Revisa el estado de tus compras y pagos registrados.
        </p>
        @if(session('success'))
         <div class="mt-4 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl">
        {{ session('success') }}
             </div>
        @endif

        @if(session('error'))
          <div class="mt-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
        {{ session('error') }}
    </div>
        @endif
    </div>

    @if($orders->count())

        <div class="space-y-5">

            @foreach($orders as $order)

                @php

                    $estadoPedido = match($order->estado) {

                        'PEN' => [
                            'Pendiente',
                            'bg-yellow-100 text-yellow-700 border-yellow-200'
                        ],

                        'PRO' => [
                            'En proceso',
                            'bg-blue-100 text-blue-700 border-blue-200'
                        ],

                        'ENV' => [
                            'Enviado',
                            'bg-purple-100 text-purple-700 border-purple-200'
                        ],

                        'ENT' => [
                            'Entregado',
                            'bg-green-100 text-green-700 border-green-200'
                        ],

                        'CAN' => [
                            'Cancelado',
                            'bg-red-100 text-red-700 border-red-200'
                        ],

                        default => [
                            'Pendiente',
                            'bg-gray-100 text-gray-700 border-gray-200'
                        ],
                    };

                    $estadoPago = match($order->estado_pago) {

                        'PAGADO' => [
                            'Pagado',
                            'bg-green-100 text-green-700 border-green-200'
                        ],

                        'RECHAZADO' => [
                            'Rechazado',
                            'bg-red-100 text-red-700 border-red-200'
                        ],

                        default => [
                            'Pendiente',
                            'bg-yellow-100 text-yellow-700 border-yellow-200'
                        ],
                    };

                    $metodoPago = match($order->metodo_pago) {

                        'transferencia' => 'Transferencia bancaria',
                        'efectivo' => 'Pago en efectivo',
                        'tarjeta_debito' => 'Tarjeta de débito',

                        default => 'No registrado',
                    };

                    $tipoEntrega = match($order->tipo_entrega) {

                        'retiro_tienda' => 'Retiro en tienda',
                        default => 'Entrega a domicilio',
                    };

                @endphp

                <a href="{{ route('client.orders.show', $order->id) }}"
                   class="block bg-white border border-pink-100 rounded-2xl shadow-sm hover:shadow-md transition p-5">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                        <div class="space-y-3">

                            <div>
                                <p class="text-sm text-gray-500">
                                    Número de pedido
                                </p>

                                <h2 class="text-lg font-bold text-gray-800">
                                    {{ $order->numero_orden ?? ('#' . $order->id) }}
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">

                                <div>
                                    <p class="text-gray-500">
                                        Fecha
                                    </p>

                                    <p class="font-semibold text-gray-800">
                                        {{ optional($order->fpedido)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-gray-500">
                                        Método de pago
                                    </p>

                                    <p class="font-semibold text-gray-800">
                                        {{ $metodoPago }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-gray-500">
                                        Tipo de entrega
                                    </p>

                                    <p class="font-semibold text-gray-800">
                                        {{ $tipoEntrega }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-gray-500">
                                        Total
                                    </p>

                                    <p class="font-bold text-pink-600 text-lg">
                                        ${{ number_format((float) $order->total, 2) }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="flex flex-col items-start lg:items-end gap-3">

                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $estadoPedido[1] }}">
                                Pedido: {{ $estadoPedido[0] }}
                            </span>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $estadoPago[1] }}">
                                Pago: {{ $estadoPago[0] }}
                            </span>

                            <span class="text-sm text-pink-600 font-semibold">
                                Ver detalle →
                            </span>
                    @if(in_array($order->estado, ['PEN', 'ING']) && ($order->estado_pago ?? 'PENDIENTE') !== 'PAGADO')
    <form action="{{ route('client.orders.cancel', $order) }}"
          method="POST"
          onclick="event.stopPropagation();"
          onsubmit="return confirm('¿Seguro que deseas cancelar este pedido?');">
        @csrf
        @method('PATCH')

        <button type="submit"
                class="text-sm text-red-600 font-semibold hover:text-red-700">
            Cancelar pedido
        </button>
    </form>
@endif
                        </div>
                    </div>
                </a>

            @endforeach

        </div>

        @if(method_exists($orders, 'links'))
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif

    @else

        <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-10 text-center">

            <div class="text-5xl mb-4">
                🛍️
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-2">
                Aún no tienes pedidos
            </h2>

            <p class="text-gray-500 mb-6">
                Explora nuestro catálogo y personaliza tu primer detalle.
            </p>

            <a href="{{ route('client.products.index') }}"
               class="inline-flex items-center justify-center bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                Ir al catálogo
            </a>

        </div>

    @endif

</div>
@endsection
