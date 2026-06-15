@extends('layouts.app')

@section('title', 'SandyDecor - Productos')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="space-y-6">

            {{-- PROMOCIONES DISPONIBLES --}}
            @if(isset($promotions) && $promotions->count() > 0)
                <div class="max-w-7xl mx-auto px-4">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Promociones disponibles
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Usa estos cupones al finalizar tu compra.
                        </p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($promotions as $promotion)
                            <div class="bg-white border border-pink-100 rounded-2xl shadow-sm p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-lg font-bold text-pink-700">
                                            {{ $promotion->nombre }}
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Código:
                                            <span class="font-bold text-gray-800">
                                                {{ $promotion->codigo }}
                                            </span>
                                        </p>
                                    </div>

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-pink-50 text-pink-600 border border-pink-200">
                                        Activa
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <p class="text-sm text-gray-700">
                                        @if($promotion->tipo === 'porcentaje')
                                            {{ number_format((float) $promotion->valor, 0) }}% de descuento
                                        @else
                                            ${{ number_format((float) $promotion->valor, 2) }} de descuento
                                        @endif
                                    </p>

                                    <p class="text-xs text-gray-500 mt-2">
                                        Compra mínima: ${{ number_format((float) $promotion->compra_minima, 2) }}
                                    </p>

                                    @if($promotion->fecha_fin)
                                        <p class="text-xs text-gray-500 mt-1">
                                            Válido hasta: {{ $promotion->fecha_fin }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- CATEGORÍAS --}}
            <div class="flex items-center justify-center flex-wrap" id="categoriesList">
                <button type="button" data-category="all"
                    class="category-btn active text-blue-700 hover:text-white border border-blue-600 bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3">
                    Todas las categorías
                </button>

                @foreach($categories as $category)
                    <button type="button" data-category="{{ $category->id }}"
                        class="category-btn text-gray-900 border border-white hover:border-gray-200 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3">
                        {{ $category->nombre }}
                    </button>
                @endforeach
            </div>

            <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8 px-4">
                <div>
                    <h2 id="productSubtitle" class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
                        Todos los Productos
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <button id="sortDropdownButton1" type="button"
                        class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 sm:w-auto">
                        Ordenar
                    </button>

                    <div id="dropdownSort1"
                        class="z-50 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow">
                        <ul class="p-2 text-left text-sm font-medium text-gray-500">
                            <li>
                                <a href="#" data-sort="price-high"
                                    class="sort-option group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                                    Precio mayor
                                </a>
                            </li>
                            <li>
                                <a href="#" data-sort="price-low"
                                    class="sort-option group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                                    Precio menor
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- PRODUCTOS --}}
            <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4 px-4" id="productGallery">
                @forelse($products as $product)
                    <div class="product-item rounded-lg border border-gray-200 bg-white p-6 shadow-sm"
                         data-categories="{{ $product->categories->pluck('id')->implode(',') }}">

                        <div class="h-56 w-full">
                            <a href="#">
                                @if($product->imagen_principal)
                                    <img class="mx-auto h-full object-cover"
                                         src="{{ asset($product->imagen_principal) }}"
                                         alt="{{ $product->nombre }}">
                                @else
                                    <img class="mx-auto h-full object-cover"
                                         src="{{ asset('assets/products/producto_001.jpg') }}"
                                         alt="{{ $product->nombre }}">
                                @endif
                            </a>
                        </div>

                        <div class="pt-6">
                            <div class="mb-4 flex items-center justify-between gap-4">
                                @if($product->descuento > 0)
                                    <span class="me-2 rounded bg-pink-100 px-2.5 py-0.5 text-xs font-medium text-pink-800">
                                        {{ number_format($product->descuento, 0) }}% descuento
                                    </span>
                                @endif
                            </div>

                            <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline">
                                {{ $product->nombre }}
                            </a>

                            @if($product->descripcion_corta)
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $product->descripcion_corta }}
                                </p>
                            @endif

                            <ul class="mt-2 flex items-center gap-4">
                                <li class="flex items-center gap-2">
                                    <p class="text-sm font-medium text-gray-500">
                                        Entrega a domicilio
                                    </p>
                                </li>

                                @if($product->stock <= $product->stock_minimo)
                                    <li class="flex items-center gap-2">
                                        <span class="text-xs font-medium text-red-600">
                                            Stock bajo
                                        </span>
                                    </li>
                                @endif
                            </ul>

                            <div class="mt-4 flex items-center justify-between gap-4">
                                @if($product->precio)
                                    @if($product->descuento > 0)
                                        <div class="flex flex-col">
                                            <p class="text-sm text-gray-500 line-through">
                                                ${{ number_format($product->precio, 2) }}
                                            </p>
                                            <p class="text-2xl font-extrabold leading-tight text-gray-900">
                                                ${{ number_format($product->precio_with_discount, 2) }}
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-2xl font-extrabold leading-tight text-gray-900">
                                            ${{ number_format($product->precio, 2) }}
                                        </p>
                                    @endif
                                @else
                                    <p class="text-lg font-medium text-gray-500">
                                        Consultar precio
                                    </p>
                                @endif

                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="cantidad" value="1">

                                        <button type="submit"
                                            class="inline-flex items-center rounded-lg bg-pink-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300">
                                            Comprar
                                        </button>
                                    </form>
                                @else
                                    <button type="button" disabled
                                        class="inline-flex items-center rounded-lg bg-gray-400 px-5 py-2.5 text-sm font-medium text-white cursor-not-allowed">
                                        Agotado
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">
                            No hay productos disponibles en este momento.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const productItems = document.querySelectorAll('.product-item');
            const productSubtitle = document.getElementById('productSubtitle');
            const sortOptions = document.querySelectorAll('.sort-option');
            const productGallery = document.getElementById('productGallery');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedCategory = this.getAttribute('data-category');
                    const categoryName = this.textContent.trim();

                    productSubtitle.textContent = selectedCategory === 'all'
                        ? 'Todos los Productos'
                        : categoryName;

                    categoryButtons.forEach(btn => {
                        btn.classList.remove('active', 'text-blue-700', 'border-blue-600');
                        btn.classList.add('text-gray-900', 'border-white');
                    });

                    this.classList.add('active', 'text-blue-700', 'border-blue-600');
                    this.classList.remove('text-gray-900', 'border-white');

                    productItems.forEach(item => {
                        const productCategories = item.getAttribute('data-categories').split(',');

                        if (selectedCategory === 'all' || productCategories.includes(selectedCategory)) {
                            item.style.display = 'block';
                            item.classList.remove('hidden');
                        } else {
                            item.style.display = 'none';
                            item.classList.add('hidden');
                        }
                    });
                });
            });

            sortOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();

                    const sortType = this.getAttribute('data-sort');

                    const visibleProducts = Array.from(productItems).filter(item =>
                        item.style.display !== 'none' && !item.classList.contains('hidden')
                    );

                    visibleProducts.sort((a, b) => {
                        const priceA = extractPrice(a);
                        const priceB = extractPrice(b);

                        if (sortType === 'price-high') {
                            return priceB - priceA;
                        }

                        if (sortType === 'price-low') {
                            return priceA - priceB;
                        }

                        return 0;
                    });

                    visibleProducts.forEach(product => {
                        productGallery.appendChild(product);
                    });

                    const dropdown = document.getElementById('dropdownSort1');
                    if (dropdown) {
                        dropdown.classList.add('hidden');
                    }
                });
            });

            function extractPrice(productElement) {
                const priceElement = productElement.querySelector('.text-2xl.font-extrabold');

                if (priceElement) {
                    const priceText = priceElement.textContent.replace(/[^0-9.]/g, '');
                    return parseFloat(priceText) || 0;
                }

                return 0;
            }

            const sortButton = document.getElementById('sortDropdownButton1');
            const dropdown = document.getElementById('dropdownSort1');

            if (sortButton && dropdown) {
                sortButton.addEventListener('click', function() {
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!sortButton.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endsection
