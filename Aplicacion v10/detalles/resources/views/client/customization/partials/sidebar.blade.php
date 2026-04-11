<div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4 space-y-4">

    <h2 class="text-lg font-semibold text-gray-800">
        Extras
    </h2>

    <p class="text-sm text-gray-500">
        Selecciona un extra para agregarlo al diseño.
    </p>

    @if(!$product->extras || $product->extras->count() == 0)

        <div class="text-sm text-gray-400 border rounded-xl p-3 bg-gray-50">
            Este producto no tiene extras disponibles.
        </div>

    @else

        <div class="space-y-3">

            @foreach($product->extras as $extra)

                @php
                    $image = !empty($extra->imagen)
                        ? asset('storage/' . $extra->imagen)
                        : null;

                    $price = $extra->precio_adicional
                        ?? $extra->precio
                        ?? 0;
                @endphp

                <button
                    type="button"
                    class="w-full text-left border border-pink-100 rounded-xl p-3 hover:bg-pink-50 transition add-extra-btn"
                    data-extra-id="{{ $extra->id }}"
                    data-extra-name="{{ $extra->nombre }}"
                    data-extra-image="{{ $image }}"
                    data-extra-price="{{ $price }}"
                >

                    <div class="flex items-center gap-3">

                        <div class="w-14 h-14 rounded-lg border bg-gray-50 overflow-hidden flex items-center justify-center shrink-0">
                            @if($image)
                                <img
                                    src="{{ $image }}"
                                    alt=""
                                    class="w-full h-full object-cover rounded-lg"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                                <div
                                    class="w-full h-full bg-gray-100 hidden items-center justify-center text-[10px] text-gray-400 text-center px-1">
                                    Sin imagen
                                </div>
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 text-center px-1">
                                    Sin imagen
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">

                            <p class="font-medium text-gray-800">
                                {{ $extra->nombre }}
                            </p>

                            @if(!empty($extra->descripcion))
                                <p class="text-xs text-gray-400 leading-relaxed">
                                    {{ $extra->descripcion }}
                                </p>
                            @endif

                            <p class="text-sm font-semibold text-pink-600">
                                +${{ number_format((float) $price, 2) }}
                            </p>

                        </div>

                    </div>

                </button>

            @endforeach

        </div>

    @endif

</div>
