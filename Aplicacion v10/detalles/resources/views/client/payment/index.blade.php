@extends('layouts.client')

@section('title', 'Método de pago')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Selecciona método de pago
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Pedido {{ $order->numero_orden ?? '#' . $order->id }}
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
            <p class="font-semibold mb-2">Corrige los siguientes campos:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('client.payment.store', $order) }}"
          enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-4">

                {{-- TRANSFERENCIA --}}
                <label class="payment-option block cursor-pointer bg-white border border-pink-100 rounded-2xl p-5 shadow-sm hover:border-pink-300 transition">
                    <div class="flex gap-3">
                        <input type="radio"
                               name="metodo_pago"
                               value="transferencia"
                               class="mt-1 text-pink-600"
                               required
                               {{ old('metodo_pago') === 'transferencia' ? 'checked' : '' }}>

                        <div>
                            <h3 class="font-bold text-gray-800">
                                🏦 Transferencia bancaria
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                El pedido quedará pendiente hasta validar el comprobante.
                            </p>
                        </div>
                    </div>
                </label>

                <div id="transferencia-info" class="hidden bg-pink-50 border border-pink-100 rounded-2xl p-5 text-sm text-gray-700">
                    <h4 class="font-bold text-gray-800 mb-2">
                        Datos para transferencia
                    </h4>

                    <div class="space-y-1">
                        <p><strong>Banco:</strong> Banco Pichincha</p>
                        <p><strong>Tipo de cuenta:</strong> Ahorros</p>
                        <p><strong>Número de cuenta:</strong> 0000000000</p>
                        <p><strong>Titular:</strong> SandyDecor</p>
                        <p><strong>Correo:</strong> sandydecor@example.com</p>
                    </div>

                    <p class="mt-3 text-gray-500">
                        Luego de realizar la transferencia, ingresa la referencia y sube el comprobante.
                    </p>
                </div>

                {{-- EFECTIVO --}}
                <label class="payment-option block cursor-pointer bg-white border border-pink-100 rounded-2xl p-5 shadow-sm hover:border-pink-300 transition">
                    <div class="flex gap-3">
                        <input type="radio"
                               name="metodo_pago"
                               value="efectivo"
                               class="mt-1 text-pink-600"
                               {{ old('metodo_pago') === 'efectivo' ? 'checked' : '' }}>

                        <div>
                            <h3 class="font-bold text-gray-800">
                                💵 Pago en efectivo
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                El pago se realizará al retirar en tienda o al recibir el pedido.
                            </p>
                        </div>
                    </div>
                </label>

                <div id="efectivo-info" class="hidden bg-pink-50 border border-pink-100 rounded-2xl p-5 text-sm text-gray-700">
                    <h4 class="font-bold text-gray-800 mb-2">
                        Pago en efectivo
                    </h4>

                    <p>
                        El pedido se mantendrá con pago pendiente hasta que el administrador confirme
                        el pago al momento de la entrega o retiro en tienda.
                    </p>

                    <ul class="list-disc ml-5 mt-3 space-y-1 text-gray-600">
                        <li>Disponible para retiro en tienda.</li>
                        <li>Disponible para entrega a domicilio.</li>
                        <li>La confirmación del pago será registrada por administración.</li>
                    </ul>
                </div>

                {{-- STRIPE --}}
                <label class="payment-option block cursor-pointer bg-white border border-pink-100 rounded-2xl p-5 shadow-sm hover:border-pink-300 transition">
                    <div class="flex gap-3">
                        <input type="radio"
                               name="metodo_pago"
                               value="stripe"
                               class="mt-1 text-pink-600"
                               {{ old('metodo_pago') === 'stripe' ? 'checked' : '' }}>

                        <div>
                            <h3 class="font-bold text-gray-800">
                                💳 Tarjeta de crédito o débito (Stripe)
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Pago seguro mediante Stripe. Se aceptan tarjetas Visa y Mastercard.
                            </p>
                        </div>
                    </div>
                </label>

                <div id="tarjeta-info" class="hidden bg-green-50 border border-green-100 rounded-2xl p-5 text-sm text-green-700">
                    <h4 class="font-bold text-green-800 mb-2">
                        Pago con tarjeta
                    </h4>

                    <p>
                        Serás redirigido a Stripe para completar el pago de forma segura.
                    </p>

                    <ul class="list-disc ml-5 mt-3 space-y-1">
                        <li>Tarjetas Visa</li>
                        <li>Tarjetas Mastercard</li>
                        <li>Pago seguro cifrado</li>
                        <li>Confirmación automática del pedido</li>
                    </ul>
                </div>

                {{-- DATOS DE TRANSFERENCIA --}}
                <div id="referencia-wrapper" class="hidden bg-white border border-pink-100 rounded-2xl p-5 shadow-sm">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Referencia de la transferencia
                    </label>

                    <input type="text"
                           id="referencia_pago"
                           name="referencia_pago"
                           value="{{ old('referencia_pago') }}"
                           class="w-full rounded-xl border border-pink-100 px-4 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                           placeholder="Ejemplo: número de transferencia o referencia">

                    <p id="referencia-help" class="text-xs text-gray-500 mt-2">
                        Para transferencia bancaria, este campo es obligatorio.
                    </p>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Subir comprobante de pago
                        </label>

                        <input type="file"
                               id="comprobante_pago"
                               name="comprobante_pago"
                               accept="image/*,.pdf"
                               class="w-full rounded-xl border border-pink-100 px-4 py-2 bg-white focus:border-pink-300 focus:ring focus:ring-pink-100">

                        <p id="comprobante-help" class="text-xs text-gray-500 mt-2">
                            Puedes subir una imagen o PDF del comprobante.
                        </p>
                    </div>
                </div>
            </div>

            {{-- RESUMEN --}}
            <div>
                <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm lg:sticky lg:top-24">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        Resumen
                    </h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Total a pagar</span>
                            <span class="font-bold text-pink-600">
                                ${{ number_format((float) $order->total, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between text-gray-600">
                            <span>Estado actual</span>
                            <span class="font-semibold text-yellow-600">
                                {{ $order->estado_pago ?? 'PENDIENTE' }}
                            </span>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full mt-5 bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-xl font-semibold transition">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="metodo_pago"]');

        const transferenciaInfo = document.getElementById('transferencia-info');
        const efectivoInfo = document.getElementById('efectivo-info');
        const tarjetaInfo = document.getElementById('tarjeta-info');

        const referenciaWrapper = document.getElementById('referencia-wrapper');
        const referenciaInput = document.getElementById('referencia_pago');
        const comprobanteInput = document.getElementById('comprobante_pago');
        const referenciaHelp = document.getElementById('referencia-help');

        function updatePaymentMethod() {
            const selected = document.querySelector('input[name="metodo_pago"]:checked')?.value;

            transferenciaInfo.classList.add('hidden');
            efectivoInfo.classList.add('hidden');
            tarjetaInfo.classList.add('hidden');

            referenciaWrapper.classList.add('hidden');
            referenciaInput.removeAttribute('required');
            comprobanteInput.removeAttribute('required');

            if (selected === 'transferencia') {
                transferenciaInfo.classList.remove('hidden');
                referenciaWrapper.classList.remove('hidden');

                referenciaInput.setAttribute('required', 'required');
                comprobanteInput.setAttribute('required', 'required');

                referenciaHelp.textContent = 'Ingresa el número de comprobante de la transferencia.';
            }

            if (selected === 'efectivo') {
                efectivoInfo.classList.remove('hidden');
            }

            if (selected === 'stripe') {
                tarjetaInfo.classList.remove('hidden');
            }
        }

        radios.forEach(function (radio) {
            radio.addEventListener('change', updatePaymentMethod);
        });

        updatePaymentMethod();
    });
</script>
@endsection
