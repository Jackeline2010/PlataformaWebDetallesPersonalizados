@extends('layouts.client')

@section('title', 'Métodos de Pago')

@section('content')

<div class="bg-white rounded-3xl border border-pink-100 p-8 shadow-sm">

    <h1 class="text-3xl font-bold text-gray-800 mb-2">
        Métodos de Pago
    </h1>

    <p class="text-gray-500 mb-8">
        Selecciona el método de pago que prefieras utilizar al momento de realizar tu compra.
    </p>

    <div class="grid md:grid-cols-3 gap-6">

        <div class="border border-pink-100 rounded-2xl p-6 bg-pink-50">
            <div class="text-4xl mb-3">💳</div>

            <h2 class="font-bold text-lg text-gray-800 mb-2">
                Stripe
            </h2>

            <p class="text-gray-600 text-sm">
                Pago seguro con tarjetas Visa y Mastercard.
            </p>

            <div class="mt-4">
                <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                    Próximamente
                </span>
            </div>
        </div>

        <div class="border border-pink-100 rounded-2xl p-6 bg-pink-50">
            <div class="text-4xl mb-3">🏦</div>

            <h2 class="font-bold text-lg text-gray-800 mb-2">
                Transferencia Bancaria
            </h2>

            <p class="text-gray-600 text-sm">
                Realiza una transferencia y adjunta el comprobante.
            </p>
        </div>

        <div class="border border-pink-100 rounded-2xl p-6 bg-pink-50">
            <div class="text-4xl mb-3">💵</div>

            <h2 class="font-bold text-lg text-gray-800 mb-2">
                Pago en Efectivo
            </h2>

            <p class="text-gray-600 text-sm">
                Disponible para entrega o retiro en tienda.
            </p>
        </div>

    </div>

</div>

@endsection
