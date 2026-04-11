@extends('layouts.client')
@section('title', $product->nombre ?? 'Producto')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 xl:gap-12 items-start">

        {{-- IZQUIERDA: IMAGEN --}}
        <div class="w-full">
            <div class="w-full max-w-[560px] mx-auto lg:mx-0 bg-white border border-pink-100 rounded-2xl shadow-sm p-4">
                <div class="aspect-square min-h-[320px] sm:min-h-[420px] bg-pink-50 rounded-xl overflow-hidden flex items-center justify-center">
                    @if(!empty($product->imagen_principal))
                        <img
                            src="{{ asset('storage/' . $product->imagen_principal) }}"
                            alt="{{ $product->nombre }}"
                            class="w-full h-full object-contain"
                        >
                    @else
                        <div class="text-gray-400 text-sm text-center px-4">
                            Sin imagen disponible
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- DERECHA: INFORMACIÓN --}}
        <div class="w-full max-w-[640px] space-y-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">
                    {{ $product->nombre }}
                </h1>

                <p class="text-2xl sm:text-3xl text-pink-600 font-extrabold mt-2">
                    ${{ number_format((float) $product->precio, 2) }}
                </p>

                @if(!empty($product->descripcion_corta))
                    <p class="text-sm text-gray-500 mt-2">
                        {{ $product->descripcion_corta }}
                    </p>
                @endif
            </div>

            @if(!empty($product->descripcion))
                <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-5">
                    <h2 class="text-base font-semibold text-gray-800 mb-2">
                        Descripción
                    </h2>

                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                        {{ $product->descripcion }}
                    </p>
                </div>
            @endif

            @if(isset($availableOptions) && $availableOptions->count())
                <div class="bg-pink-50 border border-pink-100 rounded-2xl p-5">
                    <h3 class="font-semibold text-gray-800 mb-3">
                        Personaliza tu producto
                    </h3>

                    <div class="flex flex-wrap gap-3">
                        @foreach($availableOptions as $option)
                            <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-pink-200 text-pink-600 text-sm font-medium">
                                <span>{{ $option['icon'] }}</span>
                                <span>{{ $option['label'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <p class="text-xs text-gray-500 mt-3">
                        Puedes personalizar este producto antes de agregarlo al carrito.
                    </p>
                </div>
            @endif

            <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-5">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Precio base</span>
                        <span class="font-semibold text-gray-800">
                            ${{ number_format((float) $product->precio, 2) }}
                        </span>
                    </div>

                    @if(!empty($product->photo_print_price) && (float) $product->photo_print_price > 0)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Foto impresa</span>
                            <span class="font-semibold text-pink-600">
                                +${{ number_format((float) $product->photo_print_price, 2) }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-5 mt-5 border-t border-pink-100">
                    <form method="POST" action="{{ route('client.products.buyAsIs', $product->id) }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-xl font-semibold border transition">
                            Comprar tal como está
                        </button>
                    </form>

                    @if(!empty($canCustomize) && $canCustomize)
                        <a href="{{ route('client.products.customize', $product->id) }}"
                           class="w-full flex items-center justify-center bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-xl font-semibold transition shadow-md">
                            Personalizar ahora
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
