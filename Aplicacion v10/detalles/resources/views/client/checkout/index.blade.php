@extends('layouts.client')
@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Continuar compra</h1>
        <p class="text-sm text-gray-500 mt-1">
            Aquí podrás confirmar tus productos antes de registrar el pedido.
        </p>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart as $item)
                <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                            <p class="text-sm text-gray-500">Cantidad: {{ $item['quantity'] }}</p>
                            <p class="text-sm text-gray-500">
                                Tipo:
                                <span class="font-medium">
                                    {{ !empty($item['is_customized']) ? 'Personalizado' : 'Compra directa' }}
                                </span>
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-sm text-gray-500">Subtotal</p>
                            <p class="text-pink-600 font-bold">
                                ${{ number_format((float) ($item['total'] ?? 0), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-6 sticky top-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Resumen final</h2>

                <div class="flex justify-between text-sm text-gray-600 mb-3">
                    <span>Productos</span>
                    <span>{{ count($cart) }}</span>
                </div>

                <div class="flex justify-between text-sm text-gray-600 mb-4">
                    <span>Total</span>
                    <span>${{ number_format((float) $subtotal, 2) }}</span>
                </div>

                <div class="rounded-xl bg-pink-50 border border-pink-100 p-4 text-sm text-gray-600">
                    Siguiente paso: confirmar el pedido para guardarlo en la base de datos.
                </div>

                <form action="{{ route('client.checkout.store') }}" method="POST" class="mt-6">
                    @csrf
                    <button
                        type="submit"
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-xl font-semibold transition"
                    >
                        Confirmar pedido
                    </button>
                </form>

                <a
                    href="{{ route('client.cart.index') }}"
                    class="mt-3 w-full inline-flex items-center justify-center border border-pink-200 text-pink-600 py-3 rounded-xl font-semibold hover:bg-pink-50 transition"
                >
                    Volver al carrito
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
