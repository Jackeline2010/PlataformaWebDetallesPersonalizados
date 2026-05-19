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
        id="customization-form"
        action="{{ route('client.cart.add', $product->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <input type="hidden" name="preview_image" id="preview-image-input">
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
        <div class="grid grid-cols-1 xl:grid-cols-[260px_minmax(520px,1fr)_300px] 2xl:grid-cols-[280px_minmax(560px,1fr)_320px] gap-6 items-start">

            {{-- PANEL IZQUIERDO --}}
            <div class="min-w-0 space-y-6">

                {{-- RESUMEN DE COMPRA --}}
                <div
                    class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4"
                    id="purchase-summary"
                    data-base-price="{{ (float) $product->precio }}"
                    data-photo-price="{{ (float) ($product->photo_print_price ?? 0) }}"
                >
                    <h3 class="text-base font-semibold text-gray-800 mb-4">
                        Resumen de compra
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Producto base</span>
                            <span
                                id="base-total"
                                class="font-medium text-gray-800"
                                data-value="{{ (float) $product->precio }}"
                            >
                                ${{ number_format((float) $product->precio, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Foto impresa</span>
                            <span
                                id="photo-total"
                                class="font-medium text-gray-800"
                                data-value="0"
                            >
                                $0.00
                            </span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Extras</span>
                            <span
                                id="extras-total"
                                class="font-medium text-gray-800"
                                data-value="0"
                            >
                                $0.00
                            </span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Personalización</span>
                            <span id="custom-total" class="font-medium text-gray-800">
                                Gratis
                            </span>
                        </div>

                        <hr>

                        <div class="flex justify-between gap-3 text-base font-bold">
                            <span>Total</span>
                            <span
                                id="total-price"
                                class="text-pink-600"
                                data-value="{{ (float) $product->precio }}"
                            >
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
            <div class="min-w-0 flex justify-center">
                <div class="w-full max-w-[560px]">
                    @include('client.customization.partials.canvas', ['product' => $product])
                </div>
            </div>

            {{-- PANEL DERECHO --}}
            <div class="min-w-0 space-y-6">

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
                            class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100 resize-none"
                            placeholder="Escribe aquí tu dedicatoria..."
                            data-max-words="20"
                        >{{ old('dedicatoria') }}</textarea>

                        <button
                            type="button"
                            id="restore-card-btn"
                            class="hidden mt-3 w-full rounded-xl border border-pink-200 px-3 py-2 text-sm text-pink-600 hover:bg-pink-50"
                        >
                            Restaurar tarjeta de dedicatoria
                        </button>

                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-gray-400">
                                Máximo 20 palabras
                            </p>
                            <span id="count-dedicatoria" class="text-xs text-gray-400">
                                0/20 palabras
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

                        <button
                            type="button"
                            id="restore-photo-btn"
                            class="hidden mt-2 w-full rounded-xl border border-pink-200 bg-pink-50 px-4 py-2 text-sm font-semibold text-pink-600 hover:bg-pink-100 transition"
                        >
                            Agregar foto nuevamente
                        </button>

                        <p class="text-xs text-gray-400 mt-2">
                            Sube una imagen clara para verla en la vista previa, medidas recomendadas 500 x 700px.
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

                {{-- INDICACIONES ADICIONALES --}}
                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            Indicaciones adicionales
                        </h3>

                        <span class="text-xs text-pink-500">
                            Opcional
                        </span>
                    </div>

                    <input
                        type="text"
                        id="input-destinatario"
                        maxlength="150"
                        class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
                        placeholder="Ejemplo: Deseo el lazo dorado o una nota especial"
                    >

                    <div class="flex justify-end mt-2">
                        <span id="count-destinatario" class="text-xs text-gray-400">0/150</span>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- MODAL AJUSTE DE FOTO --}}
    <div
        id="photo-adjust-modal"
        class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/70 px-4"
    >
        <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-pink-100">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Ajusta tu foto dentro del marco</h3>
                    <p class="text-sm text-gray-500 mt-1">Muévela y acércala o aléjala hasta que quede como deseas.</p>
                </div>

                <button
                    type="button"
                    id="close-photo-adjust-modal"
                    class="w-10 h-10 rounded-full hover:bg-gray-100 text-gray-500 text-xl leading-none"
                >
                    ×
                </button>
            </div>

            <div class="p-5">
                <div
                    id="photo-adjust-stage"
                    class="relative w-full max-w-[360px] mx-auto rounded-2xl bg-gray-100 overflow-hidden border border-pink-100"
                    style="aspect-ratio: 1 / 1;"
                >
                    <div
                        id="photo-adjust-window"
                        class="absolute overflow-hidden"
                        style="
                            left: 18%;
                            top: 14%;
                            width: 64%;
                            height: 52%;
                            border-radius: 10px;
                        "
                    >
                        <img
                            id="photo-adjust-image"
                            alt="Ajuste de foto"
                            class="select-none"
                            draggable="false"
                        >
                    </div>

                    <img
                        id="photo-adjust-frame"
                        src="{{ asset('storage/frames/portarretrato-vertical.png') }}"
                        alt="Marco de foto"
                        class="absolute inset-0 w-full h-full object-contain pointer-events-none select-none"
                        draggable="false"
                    >
                </div>

                <input
                    id="photo-zoom-range"
                    type="range"
                    min="0.65"
                    max="5"
                    step="0.01"
                    value="1"
                    class="w-full mt-4"
                >

                <button
                    type="button"
                    id="save-photo-adjust"
                    class="w-full mt-5 bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-xl font-semibold transition"
                >
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        window.productConfig = {
            id: @json($product->id),
            name: @json($product->nombre),
            baseImage: @json($product->imagen_principal ? asset('storage/' . $product->imagen_principal) : null),
            zones: @json($product->customization_zones ?? []),
            frameImage: @json(asset('storage/frames/portarretrato-vertical.png')),
            cardImage: @json(asset('storage/cards/tarjeta-base.png'))
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    @vite('resources/js/customization-editor.js')
@endpush
