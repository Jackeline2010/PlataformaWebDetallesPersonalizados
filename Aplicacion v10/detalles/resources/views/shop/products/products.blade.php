@extends('layouts.app')

@section('title', 'SandyDecor - Productos')

@section('content')
    <!-- Features Section -->
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <!-- Heading & Filters -->
            <div class="flex items-center justify-center flex-wrap" id="categoriesList">
                <button type="button" data-category="all"
                    class="category-btn active text-blue-700 hover:text-white border border-blue-600 bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:bg-gray-900 dark:focus:ring-blue-800">Todas
                    las categorías</button>
                @foreach($categories as $category)
                <button type="button" data-category="{{ $category->id }}"
                    class="category-btn text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">{{ $category->nombre }}</button>
                @endforeach
            </div>
            <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                <div>
                    <h2 id="productSubtitle" class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Todos los Productos
                    </h2>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button"
                        class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
                        <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
                        </svg>
                        Ordenar
                        <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 9-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="dropdownSort1"
                        class="z-50 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
                        data-popper-placement="bottom">
                        <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
                            aria-labelledby="sortDropdownButton">
                            <li>
                                <a href="#" data-sort="price-high"
                                    class="sort-option group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Precio mayor </a>
                            </li>
                            <li>
                                <a href="#" data-sort="price-low"
                                    class="sort-option group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Precio menor </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4" id="productGallery">
                @forelse($products as $product)
                    <div class="product-item rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800" data-categories="{{ $product->categories->pluck('id')->implode(',') }}">
                        <div class="h-56 w-full">
                            <a href="#">
                                @if($product->imagen_principal)
                                    <img class="mx-auto h-full object-cover dark:hidden" src="{{ asset('' . $product->imagen_principal) }}"
                                        alt="{{ $product->nombre }}" />
                                    <img class="mx-auto hidden h-full object-cover dark:block"
                                        src="{{ asset('' . $product->imagen_principal) }}" alt="{{ $product->nombre }}" />
                                @else
                                    <img class="mx-auto h-full object-cover dark:hidden" src="{{ asset('assets/products/producto_001.jpg') }}"
                                        alt="{{ $product->nombre }}" />
                                    <img class="mx-auto hidden h-full object-cover dark:block"
                                        src="{{ asset('assets/products/producto_001.jpg') }}" alt="{{ $product->nombre }}" />
                                @endif
                            </a>
                        </div>
                        <div class="pt-6">
                            <div class="mb-4 flex items-center justify-between gap-4">
                                @if($product->descuento > 0)
                                    <span
                                        class="me-2 rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                        {{ number_format($product->descuento, 0) }}% descuento </span>
                                @endif
                            </div>
                            <a href="#"
                                class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">{{ $product->nombre }}</a>
                            
                            @if($product->descripcion_corta)
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $product->descripcion_corta }}</p>
                            @endif
                            
                            <ul class="mt-2 flex items-center gap-4">
                                <li class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                    </svg>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Entrega a domicilio</p>
                                </li>
                                @if($product->stock <= $product->stock_minimo)
                                    <li class="flex items-center gap-2">
                                        <span class="text-xs font-medium text-red-600 dark:text-red-400">Stock bajo</span>
                                    </li>
                                @endif
                            </ul>
                            <div class="mt-4 flex items-center justify-between gap-4">
                                @if($product->precio)
                                    @if($product->descuento > 0)
                                        <div class="flex flex-col">
                                            <p class="text-sm text-gray-500 line-through dark:text-gray-400">${{ number_format($product->precio, 2) }}</p>
                                            <p class="text-2xl font-extrabold leading-tight text-gray-900 dark:text-white">${{ number_format($product->precio_with_discount, 2) }}</p>
                                        </div>
                                    @else
                                        <p class="text-2xl font-extrabold leading-tight text-gray-900 dark:text-white">${{ number_format($product->precio, 2) }}</p>
                                    @endif
                                @else
                                    <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Consultar precio</p>
                                @endif
                                
                                @if($product->stock > 0)
                                    <button type="button"
                                        class="inline-flex items-center rounded-lg bg-pink-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300 dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
                                        <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                        </svg>
                                        Comprar
                                    </button>
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
                        <p class="text-gray-500 dark:text-gray-400">No hay productos disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>
            
            @if($products->count() > 0)
                <div class="w-full text-center">
                    <button type="button"
                        class="rounded-lg border border-gray-200 bg-pink-600 px-10 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 hover:text-white focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Mostrar
                        más</button>
                </div>
            @endif
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const productItems = document.querySelectorAll('.product-item');
            const productSubtitle = document.getElementById('productSubtitle');
            const sortOptions = document.querySelectorAll('.sort-option');
            const productGallery = document.getElementById('productGallery');

            // Category filtering functionality
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedCategory = this.getAttribute('data-category');
                    const categoryName = this.textContent.trim();
                    
                    // Update subtitle based on selected category
                    if (selectedCategory === 'all') {
                        productSubtitle.textContent = 'Todos los Productos';
                    } else {
                        productSubtitle.textContent = categoryName;
                    }
                    
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

            // Sorting functionality
            sortOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sortType = this.getAttribute('data-sort');
                    
                    // Get all visible products
                    const visibleProducts = Array.from(productItems).filter(item => 
                        item.style.display !== 'none' && !item.classList.contains('hidden')
                    );
                    
                    // Sort products by price
                    visibleProducts.sort((a, b) => {
                        const priceA = extractPrice(a);
                        const priceB = extractPrice(b);
                        
                        if (sortType === 'price-high') {
                            return priceB - priceA; // Descending order (highest first)
                        } else if (sortType === 'price-low') {
                            return priceA - priceB; // Ascending order (lowest first)
                        }
                        return 0;
                    });
                    
                    // Reorder products in the DOM
                    visibleProducts.forEach(product => {
                        productGallery.appendChild(product);
                    });
                    
                    // Close dropdown (if using Flowbite or similar)
                    const dropdown = document.getElementById('dropdownSort1');
                    if (dropdown) {
                        dropdown.classList.add('hidden');
                    }
                });
            });

            // Function to extract price from product element
            function extractPrice(productElement) {
                const priceElement = productElement.querySelector('.text-2xl.font-extrabold');
                if (priceElement) {
                    const priceText = priceElement.textContent.replace(/[^0-9.]/g, '');
                    return parseFloat(priceText) || 0;
                }
                return 0;
            }

            // Toggle dropdown functionality
            const sortButton = document.getElementById('sortDropdownButton1');
            const dropdown = document.getElementById('dropdownSort1');
            
            if (sortButton && dropdown) {
                sortButton.addEventListener('click', function() {
                    dropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!sortButton.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endsection
