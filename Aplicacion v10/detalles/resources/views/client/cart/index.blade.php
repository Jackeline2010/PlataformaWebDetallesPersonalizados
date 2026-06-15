@extends('layouts.client')
@section('title', 'Carrito')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    @php
        $promotion = session('cart_promotion');
        $discount = (float) ($promotion['discount'] ?? 0);
        $totalFinal = max((float) $subtotal - $discount, 0);
    @endphp

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mi carrito</h1>

        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-2 mt-3 px-4 py-2 rounded-xl border border-pink-200 bg-white text-pink-600 hover:bg-pink-50 text-sm font-semibold">
            ← Regresar a personalización
        </a>

        <p class="text-sm text-gray-500 mt-1">
            Revisa los productos agregados antes de continuar.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(empty($cart))
        <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-6 text-center text-gray-500">
            Tu carrito está vacío.
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $itemId => $item)
                    <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-4">
                        <div class="flex gap-4">
                            <div class="w-48 h-48 rounded-2xl overflow-hidden border border-pink-100 bg-pink-50 flex items-center justify-center flex-shrink-0">
                                @if(!empty($item['preview_image']))
                                    <img
                                        src="{{ $item['preview_image'] }}"
                                        alt="Diseño personalizado de {{ $item['name'] }}"
                                        class="w-full h-full object-contain bg-pink-50"
                                    >
                                @elseif(!empty($item['image']))
                                    <img
                                        src="{{ asset('storage/' . $item['image']) }}"
                                        alt="{{ $item['name'] }}"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <span class="text-xs text-gray-400">Sin imagen</span>
                                @endif
                            </div>

                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-800 text-lg">
                                            {{ $item['name'] }}
                                        </h3>

                                        <div class="flex items-center gap-3 mt-2 flex-wrap">
                                            <form
                                                action="{{ route('client.cart.remove', $itemId) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Deseas eliminar este producto del carrito?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1 text-xs font-semibold text-red-500 hover:text-red-700"
                                                >
                                                    🗑 Eliminar
                                                </button>
                                            </form>

                                            <a
                                                href="{{ route('client.products.customize', $item['product_id']) }}"
                                                class="inline-flex items-center gap-1 text-xs font-semibold text-pink-600 hover:text-pink-700"
                                            >
                                                ✏️ Editar personalización
                                            </a>
                                        </div>

                                        <p class="text-sm text-gray-500 mt-2">
                                            Cantidad: {{ $item['quantity'] }}
                                        </p>

                                        <p class="text-sm text-gray-500">
                                            Tipo:
                                            <span class="font-medium">
                                                {{ !empty($item['is_customized']) ? 'Personalizado' : 'Compra directa' }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="text-left md:text-right">
                                        <p class="text-sm text-gray-500">Subtotal</p>
                                        <p class="text-pink-600 font-bold text-lg">
                                            ${{ number_format((float) ($item['total'] ?? 0), 2) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                    <div class="flex justify-between sm:block">
                                        <span class="text-gray-500">Precio base</span>
                                        <p class="font-medium text-gray-800">
                                            ${{ number_format((float) ($item['base_price'] ?? 0), 2) }}
                                        </p>
                                    </div>

                                    <div class="flex justify-between sm:block">
                                        <span class="text-gray-500">Foto impresa</span>
                                        <p class="font-medium text-gray-800">
                                            ${{ number_format((float) ($item['photo_price'] ?? 0), 2) }}
                                        </p>
                                    </div>

                                    <div class="flex justify-between sm:block">
                                        <span class="text-gray-500">Extras</span>
                                        <p class="font-medium text-gray-800">
                                            ${{ number_format((float) ($item['extras_total'] ?? $item['extras_price'] ?? 0), 2) }}
                                        </p>
                                    </div>

                                    <div class="flex justify-between sm:block">
                                        <span class="text-gray-500">Precio unitario</span>
                                        <p class="font-medium text-gray-800">
                                            ${{ number_format((float) ($item['unit_price'] ?? $item['total'] ?? 0), 2) }}
                                        </p>
                                    </div>
                                </div>

                                @if(!empty($item['dedicatoria']) || !empty($item['destinatario']) || !empty($item['color']) || !empty($item['selected_color']) || !empty($item['frase']) || !empty($item['photo']) || !empty($item['extras']))
                                    <div class="mt-4 border-t border-pink-100 pt-4">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-3">
                                            Detalle de personalización
                                        </h4>

                                        <div class="space-y-2 text-sm">
                                            @if(!empty($item['dedicatoria']))
                                                <div>
                                                    <span class="text-gray-500">Dedicatoria:</span>
                                                    <p class="text-gray-800 mt-1">
                                                        {{ $item['dedicatoria'] }}
                                                    </p>
                                                </div>
                                            @endif

                                            @if(!empty($item['destinatario']))
                                                <div>
                                                    <span class="text-gray-500">Destinatario:</span>
                                                    <p class="text-gray-800 mt-1">
                                                        {{ $item['destinatario'] }}
                                                    </p>
                                                </div>
                                            @endif

                                            @if(!empty($item['frase']))
                                                <div>
                                                    <span class="text-gray-500">Frase:</span>
                                                    <p class="text-gray-800 mt-1">
                                                        {{ $item['frase'] }}
                                                    </p>
                                                </div>
                                            @endif

                                            @if(!empty($item['color']) || !empty($item['selected_color']))
                                                <div>
                                                    <span class="text-gray-500">Color:</span>
                                                    <p class="text-gray-800 mt-1">
                                                        {{ $item['color'] ?? $item['selected_color'] }}
                                                    </p>
                                                </div>
                                            @endif

                                            @if(!empty($item['photo']))
                                                <div>
                                                    <span class="text-gray-500">Foto cargada:</span>
                                                    <div class="mt-2">
                                                        <img
                                                            src="{{ asset('storage/' . $item['photo']) }}"
                                                            alt="Foto personalizada"
                                                            class="w-20 h-20 object-cover rounded-xl border border-pink-100"
                                                        >
                                                    </div>
                                                </div>
                                            @endif

                                            @if(!empty($item['extras']) && is_array($item['extras']))
                                                <div>
                                                    <span class="text-gray-500">Extras agregados:</span>

                                                    <div class="mt-2 space-y-2">
                                                        @foreach($item['extras'] as $extra)
                                                            <div class="flex items-center justify-between rounded-xl bg-pink-50 border border-pink-100 px-3 py-2">
                                                                <span class="text-gray-800">
                                                                    {{ $extra['nombre'] ?? 'Extra' }}
                                                                </span>
                                                                <span class="font-medium text-pink-600">
                                                                    +${{ number_format((float) ($extra['precio'] ?? 0), 2) }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-6 sticky top-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Resumen
                    </h2>

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Productos</span>
                            <span>{{ count($cart) }}</span>
                        </div>

                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span>${{ number_format((float) $subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                            <div class="flex justify-between text-sm text-green-600 font-semibold">
                                <span>
                                    Descuento
                                    @if(!empty($promotion['codigo']))
                                        ({{ $promotion['codigo'] }})
                                    @endif
                                </span>
                                <span>- ${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif
                    </div>

                   <div class="bg-pink-50 border border-pink-100 rounded-2xl p-4 mt-5">
    <h3 class="font-semibold text-gray-800 mb-3">
        Código de promoción
    </h3>

    @if($promotion)
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3">
            <p class="font-semibold">
                {{ $promotion['nombre'] ?? 'Promoción aplicada' }}
            </p>

            <p class="text-sm mt-1">
                Código:
                <span class="font-extrabold">
                    {{ $promotion['codigo'] ?? '' }}
                </span>
            </p>

            <p class="text-sm mt-1">
                Descuento: -${{ number_format($discount, 2) }}
            </p>

            <form action="{{ route('client.cart.removePromotion') }}" method="POST" class="mt-3">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="text-sm font-bold text-red-600 hover:text-red-700">
                    Quitar promoción
                </button>
            </form>
        </div>
    @else
        <form action="{{ route('client.cart.applyPromotion') }}" method="POST">
            @csrf

            <input
                type="text"
                name="codigo"
                value="{{ request('coupon') }}"
                placeholder="Ejemplo: MAMA10"
                class="w-full rounded-xl border border-pink-100 px-4 py-3 focus:border-pink-400 focus:ring focus:ring-pink-100"
            >

            <button type="submit"
                    class="mt-3 w-full rounded-xl bg-pink-600 px-5 py-3 text-sm font-extrabold text-white hover:bg-pink-700">
                Aplicar cupón
            </button>
        </form>
    @endif
</div>

                    <div class="border-t border-pink-100 pt-4 mt-4 flex justify-between text-lg font-bold text-pink-600">
                        <span>Total</span>
                        <span>${{ number_format((float) $totalFinal, 2) }}</span>
                    </div>

                    <a href="{{ route('client.checkout') }}"
                       class="mt-4 w-full inline-flex items-center justify-center rounded-xl bg-pink-500 px-6 py-3 text-white font-semibold hover:bg-pink-600">
                        Continuar compra
                    </a>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
