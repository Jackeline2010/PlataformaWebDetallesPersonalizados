@extends('layouts.app')

@section('title', 'SandyDecor - Catálogo')

@section('content')
<!-- Features Section -->
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
@endsection