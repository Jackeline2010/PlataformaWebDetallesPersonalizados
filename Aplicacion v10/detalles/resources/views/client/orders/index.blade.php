@extends('layouts.client')

@section('title', 'Mis Pedidos | SandyDecor')

@section('content')
<div class="space-y-6">

    <h1 class="text-2xl font-bold text-pink-600 mb-6">
        Mis Pedidos
    </h1>

    @if($orders->count())
        <div class="space-y-4">
            @foreach($orders as $order)

                @php
                    $badge = match($order->estado) {
                        'ING' => ['Ingresado', 'bg-gray-100 text-gray-700'],
                        'PEN' => ['Pendiente', 'bg-orange-100 text-orange-700'],
                        'PRO' => ['En Proceso', 'bg-blue-100 text-blue-700'],
                        'COM' => ['Completado', 'bg-green-100 text-green-700'],
                        'CAN' => ['Cancelado', 'bg-red-100 text-red-700'],
                        default => ['Desconocido', 'bg-gray-100 text-gray-700'],
                    };
                @endphp

                <a href="{{ route('client.orders.show', $order->id) }}"
                   class="block bg-white shadow rounded-xl p-5 hover:shadow-md transition">

                    <div class="flex justify-between items-center">

                        <div>
                            <p class="font-bold text-gray-800">
                                Pedido #{{ $order->numero_orden ?? $order->id }}
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ optional($order->fpedido)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge[1] }}">
                                {{ $badge[0] }}
                            </span>

                            <span class="text-lg font-bold text-pink-600">
                                ${{ number_format($order->total, 2) }}
                            </span>
                        </div>

                    </div>
                </a>

            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    @else
        <div class="bg-white p-6 rounded-xl text-center text-gray-500 shadow">
            No tienes pedidos aún.
        </div>
    @endif

</div>
@endsection
