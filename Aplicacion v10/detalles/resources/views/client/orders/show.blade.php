@extends('layouts.client')

@section('title', 'Detalle del pedido')

@section('content')
@php
    $productCount = collect($orderItems ?? [])->sum(fn($item) => (int) ($item->cantidad ?? 1));
@endphp

<div class="max-w-6xl mx-auto px-4 md:px-6 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detalle del pedido</h1>
        <p class="text-sm text-gray-500 mt-1">
            Revisa el resumen de tu pedido registrado.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <p class="text-sm text-gray-500">Número de orden</p>
                        <h2 class="text-lg font-bold text-gray-800">
                            {{ $order->numero_orden ?? 'Pedido #' . $order->id }}
                        </h2>
                    </div>

                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-pink-50 text-pink-600 border border-pink-100">
                        {{ $order->estado ?? 'PEN' }}
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Datos de entrega</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Recibe</p>
                        <p class="font-semibold text-gray-800">
                            {{ $order->contacto_entrega ?? 'No registrado' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Teléfono</p>
                        <p class="font-semibold text-gray-800">
                            {{ $order->telefono_contacto ?? 'No registrado' }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-gray-500">Dirección</p>
                        <p class="font-semibold text-gray-800">
                            {{ $order->direccion_entrega ?? 'No registrada' }}
                        </p>
                    </div>

                    @if(!empty($order->observaciones))
                        <div class="md:col-span-2">
                            <p class="text-gray-500">Observaciones</p>
                            <p class="font-semibold text-gray-800 whitespace-pre-line">
                                {{ $order->observaciones }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            @forelse($orderItems as $item)
                @php
                    $product = $item->product ?? null;
                    $customizations = $item->customizations ?? collect();
                @endphp

                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
                    <div class="flex gap-4">
                        <div class="w-36 h-36 rounded-2xl overflow-hidden border border-pink-100 bg-pink-50 flex items-center justify-center flex-shrink-0">
                            @if(!empty($item->preview_image))
                                <img
                                    src="{{ $item->preview_image }}"
                                    alt="Diseño personalizado"
                                    class="w-full h-full object-contain bg-pink-50"
                                >
                            @elseif($product && !empty($product->imagen_principal))
                                <img
                                    src="{{ asset('storage/' . $product->imagen_principal) }}"
                                    alt="{{ $product->nombre }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <span class="text-xs text-gray-400">
                                    Sin imagen
                                </span>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">
                                        {{ $product->nombre ?? 'Producto' }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Cantidad: {{ $item->cantidad ?? 1 }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Tipo: Personalizado
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Subtotal</p>
                                    <p class="text-pink-600 font-bold text-lg">
                                        ${{ number_format((float) ($item->total ?? 0), 2) }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-gray-500">Precio unitario</span>
                                    <p class="font-medium text-gray-800">
                                        ${{ number_format((float) ($item->precio_unitario ?? 0), 2) }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-gray-500">Descuento</span>
                                    <p class="font-medium text-gray-800">
                                        ${{ number_format((float) ($item->descuento ?? 0), 2) }}
                                    </p>
                                </div>
                            </div>

                            @if($customizations->count())
                                <div class="mt-4 border-t border-pink-100 pt-4">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">
                                        Personalización
                                    </h4>

                                    <div class="space-y-2 text-sm">
                                        @foreach($customizations as $customization)
                                            @if(!empty($customization->value_text))
                                                <div class="rounded-xl bg-pink-50 border border-pink-100 px-3 py-2">
                                                    <p class="text-gray-700">
                                                        @if(str_contains(strtolower($customization->value_text), 'customizations/photos'))
                                                            <a href="{{ asset('storage/' . $customization->value_text) }}"
                                                               target="_blank"
                                                               class="text-pink-600 underline font-semibold">
                                                                Ver foto personalizada
                                                            </a>
                                                        @else
                                                            {{ $customization->value_text }}
                                                        @endif
                                                    </p>

                                                    @if(!empty($customization->extra_price) && (float) $customization->extra_price > 0)
                                                        <p class="text-pink-600 font-semibold text-xs mt-1">
                                                            +${{ number_format((float) $customization->extra_price, 2) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6 text-center text-gray-500">
                    No hay productos en este pedido.
                </div>
            @endforelse
        </div>

        <div>
            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6 sticky top-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Resumen</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Productos</span>
                        <span>{{ $productCount }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format((float) ($subtotal ?? $order->subtotal ?? 0), 2) }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                        <span>Descuento</span>
                        <span>${{ number_format((float) ($descuento ?? $order->descuento ?? 0), 2) }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                        <span>Impuestos</span>
                        <span>${{ number_format((float) ($impuesto ?? $order->impuesto ?? 0), 2) }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                    <span>Costo de entrega</span>
                    <span>${{ number_format((float) ($costoEntrega ?? $order->costo_entrega ?? 0), 2) }}</span>
                    </div>

                </div>

                <div class="border-t border-pink-100 pt-4 mt-4 flex justify-between text-lg font-bold text-pink-600">
                    <span>Total</span>
                    <span>${{ number_format((float) ($total ?? $order->total ?? 0), 2) }}</span>
                </div>

                @if(($order->estado_pago ?? 'PENDIENTE') !== 'PAGADO')
                <a href="{{ route('client.payment.index', $order) }}"
               class="mb-3 w-full inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition">
                Proceder al pago
                 </a>
            @endif
                <a href="{{ route('client.orders') }}"
                   class="mt-6 w-full inline-flex items-center justify-center bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-xl font-semibold transition">
                    Ver mis pedidos
                </a>

                <a href="{{ route('client.products.index') }}"
                   class="mt-3 w-full inline-flex items-center justify-center border border-pink-200 text-pink-600 hover:bg-pink-50 py-3 rounded-xl font-semibold transition">
                    Seguir comprando
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
