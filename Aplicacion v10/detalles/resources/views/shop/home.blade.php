@extends('layouts.app')

@section('title', 'SandyDecor - Detalles y más')

@section('content')
    <!-- Features Section -->

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
                                Ofrecemos detalles a domicilio en Loja, con entregas el mismo día o programadas según tu necesidad.
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
                                Paga de forma segura, aceptamos pagos con tarjeta de crédito, PayPal y transferencia bancaria.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
                <button type="button"
                    class="text-blue-700 hover:text-white border border-blue-600 bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:bg-gray-900 dark:focus:ring-blue-800">Todas
                    las categorías</button>
                <button type="button"
                    class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">Arreglos</button>
                <button type="button"
                    class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">Desayunos</button>
                <button type="button"
                    class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">Detalles</button>
                <button type="button"
                    class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">Peluches</button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_001.jpg') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_002.webp') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_003.webp') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_004.jpg') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_005.webp') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_006.jpg') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_007.webp') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_008.jpg') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_009.webp') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_010.jpg') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_011.webp') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_012.jpg') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_013.webp') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_014.jpg') }}" alt="">
                </div>
                <div>
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('assets/images/producto_015.webp') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-pink-600">
        <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">¿Listo para comenzar?</span>
                <span class="block">Crea algo increíble hoy.</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-indigo-200">
                Laravel y Tailwind CSS te proporcionan todas las herramientas necesarias para construir aplicaciones web
                modernas.
            </p>
            <a href="#"
                class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">
                Comenzar ahora
            </a>
        </div>
    </div>

    
@endsection
