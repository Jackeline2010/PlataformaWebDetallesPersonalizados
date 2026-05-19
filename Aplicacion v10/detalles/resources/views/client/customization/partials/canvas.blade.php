<div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4 md:p-5 w-full">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            Vista previa
        </h2>

        <span class="text-xs text-pink-600 bg-pink-50 border border-pink-100 px-3 py-1 rounded-full">
            Edición en vivo
        </span>
    </div>

    {{-- CANVAS --}}
    <div class="flex justify-center">
        <div
            id="editor-wrapper"
            class="relative w-full max-w-[620px] aspect-square bg-pink-50 rounded-2xl overflow-hidden border border-pink-100"
            data-card-template="{{ asset('storage/cards/tarjeta-base.png') }}"
            data-frame-vertical="{{ asset('storage/frames/portarretrato-vertical.png') }}"
            data-frame-horizontal="{{ asset('storage/frames/portarretrato-horizontal.png') }}"
        >

            {{-- IMAGEN BASE --}}
            @if(!empty($product->imagen_principal))
                <img
                    id="base-product-image"
                    src="{{ asset('storage/' . $product->imagen_principal) }}"
                    crossorigin="anonymous"
                    alt="{{ $product->nombre }}"
                    class="absolute inset-0 w-full h-full object-contain pointer-events-none select-none z-[1]"
                    draggable="false"
                >
            @else
                <div class="absolute inset-0 flex items-center justify-center text-sm text-gray-400 bg-gray-50 z-[1]">
                    Sin imagen base
                </div>
            @endif

            {{-- ÁREA PRINCIPAL DE DISEÑO --}}
            <div
                id="design-area"
                class="absolute inset-[8%] rounded-xl border-2 border-dashed border-pink-300 z-[5]"
                data-zones='@json($product->customization_zones ?? [])'
                data-layout="{{ $product->plantilla_preview ?? 'free_layout' }}"
                data-card-template="{{ asset('storage/cards/tarjeta-base.png') }}"
                data-frame-vertical="{{ asset('storage/frames/portarretrato-vertical.png') }}"
                data-frame-horizontal="{{ asset('storage/frames/portarretrato-horizontal.png') }}"
            >

                {{-- MENSAJE INICIAL --}}
                <div
                    id="empty-state"
                    class="absolute inset-0 flex items-center justify-center text-xs text-gray-400 text-center px-4 pointer-events-none z-[1]"
                >
                    Personaliza tu producto aquí
                </div>

                {{-- ZONA CENTRAL DE REFERENCIA PARA EXTRAS --}}
                <div
                    id="extras-guide-zone"
                    class="absolute left-[10%] right-[10%] top-[18%] bottom-[24%] border border-dashed border-pink-200/70 rounded-xl pointer-events-none z-[2]"
                ></div>

                {{-- ZONA SUGERIDA PARA PORTARRETRATO / FOTO --}}
                <div
                    id="photo-guide-zone"
                    class="absolute top-[10%] right-[8%] w-[26%] h-[28%] border-2 border-dashed border-pink-200 rounded-xl bg-white/20 pointer-events-none z-[2]"
                ></div>

                {{-- ZONA SUGERIDA PARA TARJETA --}}
                <div
                    id="card-guide-zone"
                    class="absolute bottom-[5%] left-[18%] right-[18%] h-[16%] border-2 border-dashed border-pink-300 rounded-xl bg-white/20 pointer-events-none z-[2]"
                ></div>

                {{-- EXTRAS LIBRES --}}
                <div id="items-layer" class="absolute inset-0 z-[10]"></div>

                {{-- FOTO / PORTARRETRATO --}}
                <div id="photo-layer" class="absolute inset-0 z-[20] pointer-events-none"></div>

                {{-- TARJETA DEDICATORIA --}}
                <div id="card-layer" class="absolute inset-0 z-[30] pointer-events-none"></div>

                {{-- TEXTO / CAPAS VISUALES --}}
                <div id="text-layer" class="absolute inset-0 pointer-events-none z-[40]"></div>

            </div>
        </div>
    </div>

    {{-- INFO --}}
    <div class="mt-3 space-y-1">
        <p class="text-xs text-gray-500 text-center">
            Arrastra los extras dentro del área punteada para personalizar el arreglo.
        </p>
        <p class="text-xs text-gray-400 text-center">
            La tarjeta irá en la base y el portarretrato en la zona superior sugerida.
        </p>
    </div>

</div>
