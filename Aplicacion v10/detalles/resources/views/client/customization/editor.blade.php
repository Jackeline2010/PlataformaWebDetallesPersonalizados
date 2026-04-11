@extends('layouts.client')
@section('title', 'Personalizar ' . $product->nombre)

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 py-6">

    {{-- ENCABEZADO --}}
    <div class="mb-6 flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Personaliza tu detalle
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Ajusta las opciones disponibles para este producto.
            </p>
        </div>

        <a href="{{ route('client.products.show', $product->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-pink-200 bg-white hover:bg-pink-50 text-sm transition">
            ← Volver
        </a>
    </div>

    <form
        id="add-to-cart-form"
        action="{{ route('client.cart.add', $product->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <input type="hidden" name="quantity" value="1">
        <input type="hidden" id="selected-color" name="selected_color" value="">
        <input type="hidden" id="save-frase" name="frase" value="">
        <input type="hidden" id="save-dedicatoria" name="dedicatoria" value="">
        <input type="hidden" id="save-destinatario" name="destinatario" value="">
        <input type="hidden" id="save-color" name="color" value="">
        <input type="hidden" id="save-design-json" name="design_json" value="">
        <div id="selected-extras-inputs"></div>

        {{-- RESUMEN DEL PRODUCTO --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4 md:p-5 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ $product->nombre }}
                    </h2>

                    @if(!empty($product->descripcion))
                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                            {{ $product->descripcion }}
                        </p>
                    @endif
                </div>

                <div class="text-lg md:text-xl font-bold text-pink-600">
                    ${{ number_format((float) $product->precio, 2) }}
                </div>
            </div>
        </div>

        {{-- LAYOUT PRINCIPAL DEL EDITOR --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- PANEL IZQUIERDO --}}
            <div class="lg:col-span-3 space-y-6">

                {{-- RESUMEN DE COMPRA --}}
                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">
                        Resumen de compra
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Producto base</span>
                            <span class="font-medium text-gray-800">
                                ${{ number_format((float) $product->precio, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Foto impresa</span>
                            <span id="photo-total" class="font-medium text-gray-800">
                                $0.00
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Extras</span>
                            <span id="extras-total" class="font-medium text-gray-800">
                                $0.00
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Personalización</span>
                            <span id="custom-total" class="font-medium text-gray-800">
                                Gratis
                            </span>
                        </div>

                        <hr>

                        <div class="flex justify-between text-base font-bold">
                            <span>Total</span>
                            <span id="total-price" class="text-pink-600">
                                ${{ number_format((float) $product->precio, 2) }}
                            </span>
                        </div>
                    </div>

                    <button
                        id="btn-add-cart"
                        type="submit"
                        class="w-full mt-5 bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-xl font-semibold transition shadow-md"
                    >
                        Agregar al carrito
                    </button>
                </div>

                {{-- EXTRAS --}}
                @if(isset($extras) && $extras->count())
                    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
                        <div class="flex items-center justify-between gap-3 mb-3">
                            <h3 class="text-base font-semibold text-gray-800">
                                Productos extras
                            </h3>

                            <span class="text-xs text-pink-600 bg-pink-50 border border-pink-100 px-2 py-1 rounded-full">
                                Opcional
                            </span>
                        </div>

                        <p class="text-sm text-gray-500 mb-4">
                            Agrega complementos a tu detalle.
                        </p>

                        <div class="space-y-3">
                            @foreach($extras as $extra)
                                <div class="border border-pink-100 rounded-xl p-3">
                                    <div class="flex gap-3 items-start">
                                        @if(!empty($extra->imagen))
                                            <img
                                                src="{{ asset('storage/' . $extra->imagen) }}"
                                                alt="{{ $extra->nombre }}"
                                                class="w-14 h-14 rounded-lg object-cover border border-pink-100 flex-shrink-0"
                                            >
                                        @else
                                            <div class="w-14 h-14 rounded-lg border border-pink-100 bg-gray-50 flex items-center justify-center text-[11px] text-gray-400 flex-shrink-0">
                                                Sin imagen
                                            </div>
                                        @endif

                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-800 leading-tight text-sm">
                                                {{ $extra->nombre }}
                                            </p>

                                            @if(!empty($extra->descripcion))
                                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                                    {{ $extra->descripcion }}
                                                </p>
                                            @endif

                                            <div class="mt-2 flex items-center justify-between gap-2">
                                                <span class="text-sm font-semibold text-pink-600">
                                                    +${{ number_format((float) $extra->precio_adicional, 2) }}
                                                </span>

                                                <button
                                                    type="button"
                                                    class="add-extra-btn px-3 py-1.5 rounded-lg bg-pink-600 text-white text-xs hover:bg-pink-700 transition whitespace-nowrap"
                                                    data-extra-id="{{ $extra->id }}"
                                                    data-extra-name="{{ $extra->nombre }}"
                                                    data-extra-price="{{ (float) $extra->precio_adicional }}"
                                                    data-extra-image="{{ !empty($extra->imagen) ? asset('storage/' . $extra->imagen) : '' }}"
                                                    data-selected="0"
                                                >
                                                    Agregar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- CANVAS CENTRAL --}}
            <div class="lg:col-span-6 flex justify-center">
                <div class="w-full max-w-[520px]">
                    @include('client.customization.partials.canvas', ['product' => $product])
                </div>
            </div>

            {{-- PANEL DERECHO --}}
            <div class="lg:col-span-3 space-y-6">

                {{-- DEDICATORIA --}}
                @if(isset($dedicatoriaField) && $dedicatoriaField)
                    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
                        <div class="flex items-center justify-between gap-3 mb-3">
                            <h3 class="text-base font-semibold text-gray-800">
                                {{ $dedicatoriaField->label }}
                            </h3>

                            @if($dedicatoriaField->is_required)
                                <span class="text-xs text-red-500 font-medium">
                                    Obligatorio
                                </span>
                            @endif
                        </div>

                        <textarea
                            id="input-dedicatoria"
                            rows="4"
                            maxlength="{{ $dedicatoriaField->max_length ?? 120 }}"
                            class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100 resize-none"
                            placeholder="Escribe aquí tu dedicatoria..."
                        >{{ old('dedicatoria') }}</textarea>

                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-gray-400">
                                Máximo {{ $dedicatoriaField->max_length ?? 120 }} caracteres
                            </p>
                            <span id="count-dedicatoria" class="text-xs text-gray-400">
                                0/{{ $dedicatoriaField->max_length ?? 120 }}
                            </span>
                        </div>
                    </div>
                @endif

                {{-- COLOR --}}
                @if(isset($colorField) && $colorField && isset($colors) && $colors->count())
                    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
                        <div class="flex items-center justify-between gap-3 mb-3">
                            <h3 class="text-base font-semibold text-gray-800">
                                {{ $colorField->label }}
                            </h3>

                            <span id="selected-color-label" class="text-xs text-pink-600 font-medium">
                                Original
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button
                                type="button"
                                class="color-swatch px-3 py-2 rounded-xl border border-pink-200 bg-white text-sm font-medium text-pink-600 transition hover:bg-pink-50"
                                data-color=""
                                data-image="{{ asset('storage/' . $product->imagen_principal) }}"
                            >
                                Original
                            </button>

                            @foreach($colors as $color)
                                <button
                                    type="button"
                                    class="color-swatch px-3 py-2 rounded-xl border border-pink-200 hover:bg-pink-50 text-sm transition"
                                    data-color="{{ $color->nombre }}"
                                    data-image="{{ !empty($color->imagen) ? asset('storage/' . $color->imagen) : asset('storage/' . $product->imagen_principal) }}"
                                >
                                    {{ $color->nombre }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- FOTO DEL CLIENTE --}}
                @if(isset($fotoField) && $fotoField)
                    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
                        <div class="flex items-center justify-between gap-3 mb-3">
                            <h3 class="text-base font-semibold text-gray-800">
                                {{ $fotoField->label }}
                            </h3>

                            @if(!empty($product->photo_print_price) && (float)$product->photo_print_price > 0)
                                <span class="text-xs text-pink-600 font-semibold">
                                    +${{ number_format((float) $product->photo_print_price, 2) }}
                                </span>
                            @endif
                        </div>

                        <input
                            type="file"
                            id="input-foto"
                            name="customer_photo"
                            accept="image/*"
                            class="w-full text-sm text-gray-600 file:mr-3 file:px-4 file:py-2 file:rounded-xl file:border-0 file:bg-pink-600 file:text-white file:text-sm hover:file:bg-pink-700"
                        >

                        <p class="text-xs text-gray-400 mt-2">
                            Sube una imagen clara para verla en la vista previa.
                            @if(!empty($product->photo_print_price) && (float)$product->photo_print_price > 0)
                                Esta opción tiene un costo adicional de ${{ number_format((float) $product->photo_print_price, 2) }}.
                            @endif
                        </p>
                    </div>
                @endif

                {{-- CAMPOS PERSONALIZADOS ADICIONALES --}}
                @if(isset($customFields) && $customFields->count())
                    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
                        <h3 class="text-base font-semibold text-gray-800 mb-4">
                            Personalización adicional
                        </h3>

                        <div class="space-y-4">
                            @foreach($customFields as $field)
                                @if($field->type !== 'image')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ $field->label }}
                                            @if($field->is_required)
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>

                                        @if($field->type === 'text')
                                            <input
                                                type="text"
                                                name="custom_fields[{{ $field->id }}]"
                                                maxlength="{{ $field->max_length ?? 255 }}"
                                                class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                                            >
                                        @elseif($field->type === 'textarea')
                                            <textarea
                                                name="custom_fields[{{ $field->id }}]"
                                                rows="3"
                                                maxlength="{{ $field->max_length ?? 255 }}"
                                                class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100 resize-none"
                                            ></textarea>
                                        @elseif(in_array($field->type, ['select', 'radio']))
                                            <div class="flex flex-col gap-2">
                                                @foreach($field->options ?? [] as $option)
                                                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                                        <input
                                                            type="radio"
                                                            name="custom_fields[{{ $field->id }}]"
                                                            value="{{ $option->id }}"
                                                        >
                                                        <span>{{ $option->label }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif($field->type === 'checkbox')
                                            <div class="flex flex-col gap-2">
                                                @foreach($field->options ?? [] as $option)
                                                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                                        <input
                                                            type="checkbox"
                                                            name="custom_fields[{{ $field->id }}][]"
                                                            value="{{ $option->id }}"
                                                        >
                                                        <span>{{ $option->label }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- DESTINATARIO --}}
                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">
                        Destinatario
                    </h3>

                    <input
                        type="text"
                        id="input-destinatario"
                        maxlength="30"
                        class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                        placeholder="Ejemplo: Para María"
                    >

                    <div class="flex justify-end mt-2">
                        <span id="count-destinatario" class="text-xs text-gray-400">0/30</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    @vite('resources/js/customization-editor.js')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const basePrice = {{ (float) $product->precio }};
            const photoPrintPrice = {{ (float) ($product->photo_print_price ?? 0) }};

            const extrasTotalEl = document.getElementById('extras-total');
            const photoTotalEl = document.getElementById('photo-total');
            const totalPriceEl = document.getElementById('total-price');
            const customTotalEl = document.getElementById('custom-total');

            const inputFoto = document.getElementById('input-foto');
            const inputDedicatoria = document.getElementById('input-dedicatoria');
            const inputDestinatario = document.getElementById('input-destinatario');
            const hiddenDedicatoria = document.getElementById('save-dedicatoria');
            const hiddenDestinatario = document.getElementById('save-destinatario');
            const hiddenColor = document.getElementById('selected-color');
            const saveColor = document.getElementById('save-color');
            const extrasInputsContainer = document.getElementById('selected-extras-inputs');
            const selectedColorLabel = document.getElementById('selected-color-label');

            const countDedicatoria = document.getElementById('count-dedicatoria');
            const countDestinatario = document.getElementById('count-destinatario');

            const extraButtons = document.querySelectorAll('.add-extra-btn');
            const colorButtons = document.querySelectorAll('.color-swatch');

            const selectedExtras = new Map();

            function formatMoney(value) {
                return '$' + Number(value).toFixed(2);
            }

            function syncHiddenExtras() {
                if (!extrasInputsContainer) return;

                extrasInputsContainer.innerHTML = '';

                selectedExtras.forEach((extra, id) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'extras[]';
                    input.value = id;
                    extrasInputsContainer.appendChild(input);
                });
            }

            function calculateTotals() {
                let extrasTotal = 0;

                selectedExtras.forEach((extra) => {
                    extrasTotal += Number(extra.price || 0);
                });

                const photoTotal = (inputFoto && inputFoto.files && inputFoto.files.length > 0)
                    ? photoPrintPrice
                    : 0;

                const total = basePrice + extrasTotal + photoTotal;

                if (extrasTotalEl) extrasTotalEl.textContent = formatMoney(extrasTotal);
                if (photoTotalEl) photoTotalEl.textContent = formatMoney(photoTotal);
                if (customTotalEl) customTotalEl.textContent = 'Gratis';
                if (totalPriceEl) totalPriceEl.textContent = formatMoney(total);
            }

            function updateDedicatoriaCounter() {
                if (!inputDedicatoria || !countDedicatoria) return;
                const max = inputDedicatoria.getAttribute('maxlength') || 120;
                countDedicatoria.textContent = `${inputDedicatoria.value.length}/${max}`;
                if (hiddenDedicatoria) hiddenDedicatoria.value = inputDedicatoria.value;
            }

            function updateDestinatarioCounter() {
                if (!inputDestinatario || !countDestinatario) return;
                const max = inputDestinatario.getAttribute('maxlength') || 30;
                countDestinatario.textContent = `${inputDestinatario.value.length}/${max}`;
                if (hiddenDestinatario) hiddenDestinatario.value = inputDestinatario.value;
            }

            extraButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const extraId = button.dataset.extraId;
                    const extraName = button.dataset.extraName || '';
                    const extraPrice = parseFloat(button.dataset.extraPrice || '0');
                    const isSelected = button.dataset.selected === '1';

                    if (isSelected) {
                        button.dataset.selected = '0';
                        button.textContent = 'Agregar';
                        button.classList.remove('bg-gray-700');
                        button.classList.add('bg-pink-600', 'hover:bg-pink-700');
                        selectedExtras.delete(extraId);
                    } else {
                        button.dataset.selected = '1';
                        button.textContent = 'Quitar';
                        button.classList.remove('bg-pink-600', 'hover:bg-pink-700');
                        button.classList.add('bg-gray-700');
                        selectedExtras.set(extraId, {
                            id: extraId,
                            name: extraName,
                            price: extraPrice
                        });
                    }

                    syncHiddenExtras();
                    calculateTotals();
                });
            });

            colorButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const color = button.dataset.color || '';

                    if (hiddenColor) hiddenColor.value = color;
                    if (saveColor) saveColor.value = color;

                    if (selectedColorLabel) {
                        selectedColorLabel.textContent = color && color.trim() !== '' ? color : 'Original';
                    }

                    colorButtons.forEach((btn) => {
                        btn.classList.remove('ring-2', 'ring-pink-400', 'bg-pink-50', 'text-pink-700');
                    });

                    button.classList.add('ring-2', 'ring-pink-400', 'bg-pink-50', 'text-pink-700');
                });
            });

            inputFoto?.addEventListener('change', calculateTotals);
            inputDedicatoria?.addEventListener('input', updateDedicatoriaCounter);
            inputDestinatario?.addEventListener('input', updateDestinatarioCounter);

            updateDedicatoriaCounter();
            updateDestinatarioCounter();
            syncHiddenExtras();
            calculateTotals();
        });
    </script>
@endpush
