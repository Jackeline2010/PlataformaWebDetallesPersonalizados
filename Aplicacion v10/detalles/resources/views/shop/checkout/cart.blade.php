@extends('layouts.app')

@section('title', 'SandyDecor - Carrito')

@section('content')
    <!-- Features Section -->
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Carrito de compras</h2>
            
            @if($items_count > 0)
                <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                    <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                        <div class="space-y-6">
                            @foreach($items as $item)
                                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6" data-cart-item="{{ $item->id }}">
                                    <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                        <a href="#" class="shrink-0 md:order-1">
                                            @if($item->product->imagen_principal)
                                                <img class="h-20 w-20 object-cover rounded" 
                                                     src="{{ asset('assets/products/' . $item->product->imagen_principal) }}"
                                                     alt="{{ $item->product->nombre }}" />
                                            @else
                                                <div class="h-20 w-20 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">Sin imagen</span>
                                                </div>
                                            @endif
                                        </a>
                                        
                                        <div class="flex items-center justify-between md:order-3 md:justify-end">
                                            <div class="flex items-center">
                                                <button type="button" 
                                                        class="decrement-btn inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                                                        data-cart-id="{{ $item->id }}">
                                                    <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M1 1h16" />
                                                    </svg>
                                                </button>
                                                <input type="text" 
                                                       class="quantity-input w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white"
                                                       value="{{ $item->cantidad }}" 
                                                       data-cart-id="{{ $item->id }}"
                                                       min="1" />
                                                <button type="button" 
                                                        class="increment-btn inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                                                        data-cart-id="{{ $item->id }}">
                                                    <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 1v16M1 9h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="text-end md:order-4 md:w-32">
                                                <p class="item-total text-base font-bold text-gray-900 dark:text-white">
                                                    ${{ number_format($item->total, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                            <a href="#" class="text-base font-medium text-gray-900 hover:underline dark:text-white">
                                                {{ $item->product->nombre }}
                                            </a>
                                            
                                            @if($item->product->descripcion_corta)
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ Str::limit($item->product->descripcion_corta, 100) }}
                                                </p>
                                            @endif
                                            
                                            <div class="flex items-center gap-4">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    Precio unitario: ${{ number_format($item->precio_unitario, 2) }}
                                                </span>
                                                
                                                @if($item->descuento > 0)
                                                    <span class="text-sm text-green-600 dark:text-green-400">
                                                        Descuento: {{ $item->descuento }}%
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex items-center gap-4">
                                                <button type="button" 
                                                        class="remove-item-btn inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500"
                                                        data-cart-id="{{ $item->id }}">
                                                    <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <br>
                        <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                            <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">Resumen de la orden</p>
                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <dl class="flex items-center justify-between gap-4">
                                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Subtotal</dt>
                                            <dd id="cart-subtotal" class="text-base font-medium text-gray-900 dark:text-white">
                                                ${{ number_format($subtotal, 2) }}
                                            </dd>
                                        </dl>
                                        @if($discount > 0)
                                            <dl class="flex items-center justify-between gap-4">
                                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Descuentos</dt>
                                                <dd id="cart-discount" class="text-base font-medium text-green-600">
                                                    -${{ number_format($discount, 2) }}
                                                </dd>
                                            </dl>
                                        @endif
                                        <dl class="flex items-center justify-between gap-4">
                                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Entrega</dt>
                                            <dd id="cart-shipping" class="text-base font-medium text-gray-900 dark:text-white">
                                                ${{ number_format($shipping, 2) }}
                                            </dd>
                                        </dl>
                                        <dl class="flex items-center justify-between gap-4">
                                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Impuestos</dt>
                                            <dd id="cart-tax" class="text-base font-medium text-gray-900 dark:text-white">
                                                ${{ number_format($tax, 2) }}
                                            </dd>
                                        </dl>
                                    </div>
                                    <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                        <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                        <dd id="cart-total" class="text-base font-bold text-gray-900 dark:text-white">
                                            ${{ number_format($total, 2) }}
                                        </dd>
                                    </dl>
                                </div>
                                <a href="{{ route('order') }}"
                                    class="flex w-full items-center justify-center rounded-lg bg-pink-600 px-5 py-3 text-xl font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    Finalizar compra
                                </a>
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> o </span>
                                    <a href="{{ route('products') }}" title=""
                                        class="inline-flex items-center gap-2 text-lg font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">
                                        Continuar Comprando
                                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="mt-6 sm:mt-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <div class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                            <svg class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tu carrito está vacío</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                No tienes productos en tu carrito. ¡Explora nuestros productos y encuentra algo que te guste!
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('products') }}"
                                    class="inline-flex items-center rounded-lg bg-pink-600 px-5 py-3 text-sm font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300 dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Explorar Productos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- JavaScript for Cart Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // CSRF Token for AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            // Quantity increment buttons
            document.querySelectorAll('.increment-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const cartId = this.getAttribute('data-cart-id');
                    const quantityInput = document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`);
                    const currentQuantity = parseInt(quantityInput.value);
                    updateQuantity(cartId, currentQuantity + 1);
                });
            });

            // Quantity decrement buttons
            document.querySelectorAll('.decrement-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const cartId = this.getAttribute('data-cart-id');
                    const quantityInput = document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`);
                    const currentQuantity = parseInt(quantityInput.value);
                    if (currentQuantity > 1) {
                        updateQuantity(cartId, currentQuantity - 1);
                    }
                });
            });

            // Quantity input change
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const cartId = this.getAttribute('data-cart-id');
                    const quantity = parseInt(this.value);
                    if (quantity >= 1) {
                        updateQuantity(cartId, quantity);
                    } else {
                        this.value = 1;
                    }
                });
            });

            // Remove item buttons
            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const cartId = this.getAttribute('data-cart-id');
                    removeItem(cartId);
                });
            });

            // Update quantity function
            function updateQuantity(cartId, quantity) {
                fetch(`/cart/update/${cartId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ cantidad: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update quantity input
                        document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`).value = quantity;
                        
                        // Update item total
                        document.querySelector(`[data-cart-item="${cartId}"] .item-total`).textContent = 
                            `$${parseFloat(data.new_total).toFixed(2)}`;
                        
                        // Update cart totals
                        updateCartTotals(data.cart_totals);
                    }
                })
                .catch(error => {
                    console.error('Error updating quantity:', error);
                    alert('Error al actualizar la cantidad');
                });
            }

            // Remove item function
            function removeItem(cartId) {
                if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
                    fetch(`/cart/remove/${cartId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove item from DOM
                            document.querySelector(`[data-cart-item="${cartId}"]`).remove();
                            
                            // Update cart totals or reload page if cart is empty
                            if (data.cart_totals.items_count === 0) {
                                location.reload();
                            } else {
                                updateCartTotals(data.cart_totals);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error removing item:', error);
                        alert('Error al eliminar el producto');
                    });
                }
            }

            // Update cart totals in the summary
            function updateCartTotals(totals) {
                document.getElementById('cart-subtotal').textContent = `$${parseFloat(totals.subtotal).toFixed(2)}`;
                if (document.getElementById('cart-discount')) {
                    document.getElementById('cart-discount').textContent = `-$${parseFloat(totals.discount).toFixed(2)}`;
                }
                document.getElementById('cart-shipping').textContent = `$${parseFloat(totals.shipping).toFixed(2)}`;
                document.getElementById('cart-tax').textContent = `$${parseFloat(totals.tax).toFixed(2)}`;
                document.getElementById('cart-total').textContent = `$${parseFloat(totals.total).toFixed(2)}`;
            }
        });
    </script>
@endsection
