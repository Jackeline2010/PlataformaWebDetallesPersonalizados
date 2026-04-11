@extends('layouts.client')
@section('title', 'Catálogo')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Título --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Catálogo de productos
        </h1>
        <p class="text-gray-500 text-sm">
            Elige tu arreglo y personalízalo a tu gusto
        </p>
    </div>


    {{-- GRID PRODUCTOS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($products as $product)

        <a href="{{ route('client.products.show', $product->id) }}"
           class="bg-white rounded-xl border border-pink-100 shadow-sm hover:shadow-md transition p-3">

            {{-- Imagen --}}
            <div class="h-40 flex items-center justify-center mb-3">

                @if($product->imagen_principal)

                    <img
                        src="{{ asset('storage/'.$product->imagen_principal) }}"
                        class="h-full object-cover rounded-lg">

                @else

                    <div class="text-gray-300 text-sm">
                        Sin imagen
                    </div>

                @endif

            </div>

            {{-- Nombre --}}
            <h3 class="font-semibold text-gray-700 text-sm line-clamp-2">
                {{ $product->nombre }}
            </h3>

            {{-- Precio --}}
            <div class="mt-2 text-pink-600 font-bold">
                ${{ number_format($product->precio,2) }}
            </div>

        </a>

        @empty

        <div class="col-span-full text-center text-gray-400 py-10">
            No hay productos disponibles
        </div>

        @endforelse

    </div>

</div>

@endsection
