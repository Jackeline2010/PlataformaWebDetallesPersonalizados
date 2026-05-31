@extends('layouts.client')

@section('title', 'Pago con tarjeta')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Pago con tarjeta de débito
        </h1>

        <p class="text-gray-500 mb-6">
            Pedido:
            <strong>
                {{ $order->numero_orden ?? '#' . $order->id }}
            </strong>
        </p>

        <div class="bg-pink-50 border border-pink-100 rounded-xl p-4 mb-6">
            <p class="text-sm text-gray-600">
                Total a pagar:
            </p>

            <p class="text-3xl font-bold text-pink-600">
                ${{ number_format($order->total, 2) }}
            </p>
        </div>

        {{-- MODO LOCAL / SIMULACIÓN --}}
        @if(config('niubiz.env') === 'local')

            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                <p class="text-yellow-800 font-semibold mb-2">
                    Modo simulación local
                </p>

                <p class="text-sm text-yellow-700">
                    Este pago será aprobado automáticamente para pruebas.
                </p>
            </div>

            <form
                action="{{ route('client.payment.niubiz.authorize', $order) }}"
                method="POST"
                class="text-center"
            >
                @csrf

                <input
                    type="hidden"
                    name="transactionToken"
                    value="LOCAL_SIMULATION_TOKEN"
                >

                <button
                    type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600 transition"
                >
                    Simular pago aprobado
                </button>
            </form>

        @else

            {{-- NIUBIZ REAL --}}
            <div class="text-center">
                <button
                    type="button"
                    onclick="openNiubiz()"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600 transition"
                >
                    Pagar con tarjeta
                </button>
            </div>

            <script src="{{ $jsUrl }}"></script>

            <script>
                function openNiubiz() {
                    VisanetCheckout.configure({
                        sessiontoken: "{{ $sessionKey }}",
                        channel: "{{ $channel }}",
                        merchantid: "{{ $merchantId }}",
                        purchasenumber: "{{ $purchaseNumber }}",
                        amount: "{{ number_format($order->total, 2, '.', '') }}",
                        expirationminutes: "20",
                        timeouturl: "{{ route('client.payment.failed', $order) }}",
                        merchantlogo: "",
                        formbuttoncolor: "#ec4899",
                        action: "{{ route('client.payment.niubiz.authorize', $order) }}"
                    });

                    VisanetCheckout.open();
                }
            </script>

        @endif

    </div>
</div>
@endsection
