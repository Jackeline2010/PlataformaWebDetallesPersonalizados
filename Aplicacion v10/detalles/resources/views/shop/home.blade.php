@extends('layouts.app')

@section('title', 'SandyDecor - Detalles y más')

@section('content')
    <!-- Features Section -->
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto grid max-w-screen-xl px-4 pb-8 md:grid-cols-12 lg:gap-12 lg:pb-16 xl:gap-0">
            <div class="content-center justify-self-start md:col-span-7 md:text-start">
                <h1
                    class="mb-4 text-4xl text-indigo-700 font-extrabold leading-none tracking-tight dark:text-white md:max-w-2xl md:text-5xl xl:text-6xl">
                    Detalles especiales<br />para toda ocasión!</h1>
                <p class="mb-4 max-w-2xl text-gray-700 dark:text-gray-400 md:mb-12 md:text-lg mb-3 lg:mb-5 lg:text-xl">No
                    esperes para compartir un regalo con esa persona especial!</p>
                <a href="{{ route('products') }}"
                    class="inline-block rounded-lg bg-pink-600 px-6 py-3.5 text-center font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-pink-600 dark:hover:bg-indigo-700 dark:focus:ring-primary-800">Comprar
                    ahora</a>
            </div>
            <div class="hidden md:col-span-5 md:mt-0 md:flex">
                <img src="{{ asset('assets/images/portada.svg') }}" alt="shopping illustration" />
            </div>
        </div>
        <div
            class="mx-auto grid max-w-screen-xl grid-cols-2 gap-8 text-gray-500 dark:text-gray-400 sm:grid-cols-3 sm:gap-12 lg:grid-cols-5 px-4">
            <a href="{{ route('products') }}" class="flex items-center md:justify-center"
                data-tooltip-target="tooltip-arreglo">
                <img src="{{ asset('assets/images/arreglo.svg') }}" alt="shopping illustration" />
            </a>
            <a href="{{ route('products') }}" class="flex items-center md:justify-center"
                data-tooltip-target="tooltip-peluche">
                <img src="{{ asset('assets/images/peluche.svg') }}" alt="shopping illustration" />
            </a>
            <a href="{{ route('products') }}" class="flex items-center md:justify-center"
                data-tooltip-target="tooltip-chocolates">
                <img src="{{ asset('assets/images/chocolates.svg') }}" alt="shopping illustration" />
            </a>
            <a href="{{ route('products') }}" class="flex items-center md:justify-center"
                data-tooltip-target="tooltip-taza">
                <img src="{{ asset('assets/images/taza.svg') }}" alt="shopping illustration" />
            </a>
            <a href="{{ route('products') }}" class="flex items-center md:justify-center"
                data-tooltip-target="tooltip-caja">
                <img src="{{ asset('assets/images/cajaSorpresa.svg') }}" alt="shopping illustration" />
            </a>
            <div id="tooltip-arreglo" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Arreglos y Globos
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div id="tooltip-peluche" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Peluches
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div id="tooltip-chocolates" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Chocolates y Dulces
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div id="tooltip-taza" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Artículos Personalizados
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div id="tooltip-caja" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Cajas Sorpresa
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </section>
    <br>
    <div class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center py-4 md:py-8 flex-wrap" id="categoriesList">
                <button type="button" data-category="all"
                    class="category-btn active text-blue-700 hover:text-white border border-blue-600 bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:bg-gray-900 dark:focus:ring-blue-800">Todas
                    las categorías</button>
                @foreach($categories as $category)
                <button type="button" data-category="{{ $category->id }}"
                    class="category-btn text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">{{ $category->nombre }}</button>
                @endforeach
            </div>
            <div id="productGallery" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($products as $product)
                    <div class="product-item" data-categories="{{ $product->categories->pluck('id')->implode(',') }}">
                        <img class="h-auto max-w-full rounded-lg hover:scale-105 transition-transform duration-300"
                             src="{{ $product->imagen_principal ? asset($product->imagen_principal) : asset('assets/images/producto_001.jpg') }}"
                             alt="{{ $product->nombre }}"
                             title="{{ $product->nombre }}">
                        <div class="mt-2 text-center">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->nombre }}</h3>
                            @if($product->precio)
                                <p class="text-lg font-bold text-pink-600">${{ number_format($product->precio, 2) }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">No hay productos disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="lg:text-center">
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    ¿Buscas una detalle para una persona especial?
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Te ofrecemos los más lindos detalles con entrega rápida en toda la ciudad.
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 21v-9m3-4H7.5a2.5 2.5 0 1 1 0-5c1.5 0 2.875 1.25 3.875 2.5M14 21v-9m-9 0h14v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-8ZM4 8h16a1 1 0 0 1 1 1v3H3V9a1 1 0 0 1 1-1Zm12.155-5c-3 0-5.5 5-5.5 5h5.5a2.5 2.5 0 0 0 0-5Z" />
                            </svg>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-lg font-medium text-gray-900">Detalles originales</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Te ofrecemos detalles con muchas opciones de personalización, para que sea único y especial.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-emerald-500 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                            </svg>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-lg font-medium text-gray-900">Entrega a domicilio</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Ofrecemos detalles a domicilio en Loja, con entregas el mismo día o programadas según tu
                                necesidad.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-500 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                            </svg>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-lg font-medium text-gray-900">Pagos seguros</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Paga de forma segura, aceptamos pagos con tarjeta de crédito, y transferencia
                                bancaria.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- CTA Section -->
    <div class="bg-pink-600">
        <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Mira el testimonio de nuestros clientes.</span>
            </h2>
            <p class="mt-4 text-xl leading-6 text-indigo-100">
                Nuestros detalles han sido entregados en muchos lugares de la provincia y tenemos cientos de clientes
                satisfechos.
            </p>
            <a href="{{ route('gallery') }}"
                class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">
                Galería de Fotos
            </a>
        </div>
    </div>
    <br>
    <br>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const productItems = document.querySelectorAll('.product-item');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedCategory = this.getAttribute('data-category');

                    // Remove active class from all buttons
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.classList.remove('text-blue-700', 'border-blue-600');
                        btn.classList.add('text-gray-900', 'border-white');
                    });

                    // Add active class to clicked button
                    this.classList.add('active');
                    this.classList.remove('text-gray-900', 'border-white');
                    this.classList.add('text-blue-700', 'border-blue-600');

                    // Filter products
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
        });
    </script>
@endsection
