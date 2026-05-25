@extends('layouts.client')
@section('title', 'Checkout')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Continuar compra</h1>
        <p class="text-sm text-gray-500 mt-1">
            Confirma la forma de entrega y tus datos antes de registrar el pedido.
        </p>
    </div>

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

    <form method="POST" action="{{ route('client.checkout.store') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">

                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5 space-y-4">
                    <h2 class="text-lg font-bold text-gray-800">Forma de entrega</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="cursor-pointer rounded-2xl border border-pink-100 bg-pink-50 p-4 flex gap-3 items-start">
                            <input type="radio"
                                   name="tipo_entrega"
                                   value="domicilio"
                                   class="mt-1 text-pink-600 focus:ring-pink-300"
                                   {{ old('tipo_entrega', 'domicilio') === 'domicilio' ? 'checked' : '' }}>
                            <div>
                                <p class="font-semibold text-gray-800">Entrega a domicilio</p>
                                <p class="text-sm text-gray-500">
                                    Solo disponible dentro de la ciudad.
                                </p>
                            </div>
                        </label>

                        <label class="cursor-pointer rounded-2xl border border-pink-100 bg-white p-4 flex gap-3 items-start">
                            <input type="radio"
                                   name="tipo_entrega"
                                   value="retiro_tienda"
                                   class="mt-1 text-pink-600 focus:ring-pink-300"
                                   {{ old('tipo_entrega') === 'retiro_tienda' ? 'checked' : '' }}>
                            <div>
                                <p class="font-semibold text-gray-800">Retiro en tienda física</p>
                                <p class="text-sm text-gray-500">
                                    El cliente retirará el pedido directamente en el local.
                                </p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5 space-y-4">
                    <h2 class="text-lg font-bold text-gray-800">Datos de entrega</h2>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nombre de quien recibe o retira
                        </label>
                        <input type="text"
                               name="contacto_entrega"
                               value="{{ old('contacto_entrega', auth()->user()->name ?? '') }}"
                               class="w-full rounded-xl border border-pink-100 px-4 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                               placeholder="Ejemplo: María López">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Teléfono de contacto
                        </label>
                        <input type="text"
                               name="telefono_contacto"
                               value="{{ old('telefono_contacto') }}"
                               required
                               class="w-full rounded-xl border border-pink-100 px-4 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                               placeholder="Ejemplo: 0999999999">
                    </div>

                    <div id="zona-entrega-wrapper">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Zona de entrega
                        </label>

                        <select name="zona_entrega"
                                id="zona_entrega"
                                class="w-full rounded-xl border border-pink-100 px-4 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100">
                            <option value="centro" {{ old('zona_entrega', 'centro') === 'centro' ? 'selected' : '' }}>
                                Centro de la ciudad - $3.00
                            </option>
                            <option value="urbana" {{ old('zona_entrega') === 'urbana' ? 'selected' : '' }}>
                                Zona urbana dentro de la ciudad - $4.00
                            </option>
                            <option value="lejana" {{ old('zona_entrega') === 'lejana' ? 'selected' : '' }}>
                                Zona lejana dentro de la ciudad - $5.00
                            </option>
                        </select>

                        <p class="text-xs text-gray-500 mt-1">
                            No se realizan entregas fuera de la ciudad.
                        </p>
                    </div>

                    <div id="direccion-entrega-wrapper">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Dirección de entrega
                        </label>
                        <textarea name="direccion_entrega"
                                  id="direccion_entrega"
                                  rows="3"
                                  class="w-full rounded-xl border border-pink-100 px-4 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                                  placeholder="Ejemplo: Loja, Av. Universitaria y 10 de Agosto">{{ old('direccion_entrega') }}</textarea>
                    </div>

                    <div id="retiro-tienda-info" class="hidden rounded-xl bg-pink-50 border border-pink-100 p-4 text-sm text-gray-600">
                        Has seleccionado retiro en tienda física. No necesitas ingresar dirección ni zona de entrega.
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Observaciones
                        </label>
                        <textarea name="observaciones"
                                  rows="3"
                                  class="w-full rounded-xl border border-pink-100 px-4 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                                  placeholder="Ejemplo: entregar en la tarde, llamar antes de llegar">{{ old('observaciones') }}</textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($cart as $item)
                        <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="font-semibold text-gray-800">
                                        {{ $item['name'] }}
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Cantidad: {{ $item['quantity'] }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Tipo:
                                        <span class="font-medium">
                                            {{ !empty($item['is_customized']) ? 'Personalizado' : 'Compra directa' }}
                                        </span>
                                    </p>

                                    @if(!empty($item['dedicatoria']))
                                        <p class="text-sm text-gray-500 mt-1">
                                            Dedicatoria: {{ $item['dedicatoria'] }}
                                        </p>
                                    @endif

                                    @if(!empty($item['color']))
                                        <p class="text-sm text-gray-500 mt-1">
                                            Color: {{ $item['color'] }}
                                        </p>
                                    @endif

                                    @if(!empty($item['photo']))
                                        <p class="text-sm text-gray-500 mt-1">
                                            Foto impresa: Sí
                                        </p>
                                    @endif
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
            </div>

            <div>
                <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-6 sticky top-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Resumen final
                    </h2>

                    <div class="flex justify-between text-sm text-gray-600 mb-3">
                        <span>Productos</span>
                        <span>{{ count($cart) }}</span>
                    </div>

                    <div class="flex justify-between text-sm text-gray-600 mb-3">
                        <span>Subtotal</span>
                        <span>${{ number_format((float) $subtotal, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-sm text-gray-600 mb-3">
                        <span id="shipping-label">Envío a domicilio</span>
                        <span id="shipping-value">${{ number_format((float) $shipping, 2) }}</span>
                    </div>

                    <div class="border-t border-pink-100 my-4"></div>

                    <div class="flex justify-between text-base font-bold text-gray-800 mb-4">
                        <span>Total</span>
                        <span id="total-value" class="text-pink-600">
                            ${{ number_format((float) $total, 2) }}
                        </span>
                    </div>

                    <div class="rounded-xl bg-pink-50 border border-pink-100 p-4 text-sm text-gray-600 mb-4">
                        Al confirmar, el pedido se guardará y el carrito se vaciará automáticamente.
                    </div>

                    <button type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-xl font-semibold transition">
                        Confirmar pedido
                    </button>

                    <a href="{{ route('client.cart.index') }}"
                       class="mt-3 w-full inline-flex items-center justify-center border border-pink-200 text-pink-600 py-3 rounded-xl font-semibold hover:bg-pink-50 transition">
                        Volver al carrito
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const SHIPPING_COSTS = {
            centro: 2.00,
            urbana: 3.00,
            lejana: 4.00
        };

        const radios = document.querySelectorAll('input[name="tipo_entrega"]');
        const zonaEntregaWrapper = document.getElementById('zona-entrega-wrapper');
        const zonaEntregaInput = document.getElementById('zona_entrega');

        const direccionWrapper = document.getElementById('direccion-entrega-wrapper');
        const direccionInput = document.getElementById('direccion_entrega');
        const retiroInfo = document.getElementById('retiro-tienda-info');

        const shippingLabel = document.getElementById('shipping-label');
        const shippingValue = document.getElementById('shipping-value');
        const totalValue = document.getElementById('total-value');

        const subtotal = {{ (float) $subtotal }};

        function formatMoney(value) {
            return '$' + Number(value).toFixed(2);
        }

        function getSelectedDeliveryType() {
            return document.querySelector('input[name="tipo_entrega"]:checked')?.value || 'domicilio';
        }

        function getSelectedZoneCost() {
            const zone = zonaEntregaInput?.value || 'centro';
            return SHIPPING_COSTS[zone] ?? SHIPPING_COSTS.centro;
        }

        function updateDeliveryType() {
            const selected = getSelectedDeliveryType();

            if (selected === 'retiro_tienda') {
                zonaEntregaWrapper.classList.add('hidden');
                direccionWrapper.classList.add('hidden');
                retiroInfo.classList.remove('hidden');

                zonaEntregaInput.removeAttribute('required');
                direccionInput.removeAttribute('required');

                shippingLabel.textContent = 'Retiro en tienda';
                shippingValue.textContent = '$0.00';
                totalValue.textContent = formatMoney(subtotal);

                return;
            }

            zonaEntregaWrapper.classList.remove('hidden');
            direccionWrapper.classList.remove('hidden');
            retiroInfo.classList.add('hidden');

            zonaEntregaInput.setAttribute('required', 'required');
            direccionInput.setAttribute('required', 'required');

            const shipping = getSelectedZoneCost();

            shippingLabel.textContent = 'Envío a domicilio';
            shippingValue.textContent = formatMoney(shipping);
            totalValue.textContent = formatMoney(subtotal + shipping);
        }

        radios.forEach(function (radio) {
            radio.addEventListener('change', updateDeliveryType);
        });

        zonaEntregaInput.addEventListener('change', updateDeliveryType);

        updateDeliveryType();
    });
</script>
@endsection
