@extends('layouts.client')

@section('title', 'Método de pago')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Selecciona método de pago
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Pedido {{ $order->numero_orden ?? '#' . $order->id }}
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('client.payment.store', $order) }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-4">
                <label class="block cursor-pointer bg-white border border-pink-100 rounded-2xl p-5 shadow-sm">
                    <div class="flex gap-3">
                        <input type="radio" name="metodo_pago" value="transferencia" class="mt-1 text-pink-600" required>
                        <div>
                            <h3 class="font-bold text-gray-800">Transferencia bancaria</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                El pedido quedará pendiente hasta validar el comprobante.
                            </p>
                        </div>
                    </div>
                </label>

                <label class="block cursor-pointer bg-white border border-pink-100 rounded-2xl p-5 shadow-sm">
                    <div class="flex gap-3">
                        <input type="radio" name="metodo_pago" value="efectivo" class="mt-1 text-pink-600">
                        <div>
                            <h3 class="font-bold text-gray-800">Pago en efectivo</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                El pago se realizará al retirar en tienda o al recibir el pedido.
                            </p>
                        </div>
                    </div>
                </label>

                <label class="block cursor-pointer bg-white border border-pink-100 rounded-2xl p-5 shadow-sm">
                    <div class="flex gap-3">
                        <input type="radio" name="metodo_pago" value="tarjeta_debito" class="mt-1 text-pink-600">
                        <div>
                            <h3 class="font-bold text-gray-800">Tarjeta de débito</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Por ahora se simulará el pago como aprobado.
                            </p>
                        </div>
                    </div>
                </label>

                <div class="bg-white border border-pink-100 rounded-2xl p-5 shadow-sm">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Referencia o comprobante
                    </label>
                    <input type="text"
                           name="referencia_pago"
                           value="{{ old('referencia_pago') }}"
                           class="w-full rounded-xl border border-pink-100 px-4 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                           placeholder="Ejemplo: número de transferencia o referencia">
                </div>
            </div>

            <div>
                <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm sticky top-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        Resumen
                    </h2>

                    <div class="flex justify-between text-sm text-gray-600 mb-3">
                        <span>Total a pagar</span>
                        <span class="font-bold text-pink-600">
                            ${{ number_format((float) $order->total, 2) }}
                        </span>
                    </div>

                    <button type="submit"
                            class="w-full mt-4 bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-xl font-semibold transition">
                        Confirmar método de pago
                    </button>

                    <a href="{{ route('client.orders.show', $order) }}"
                       class="mt-3 w-full inline-flex items-center justify-center border border-pink-200 text-pink-600 py-3 rounded-xl font-semibold hover:bg-pink-50 transition">
                        Volver al pedido
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
