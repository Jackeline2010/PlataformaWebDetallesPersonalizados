@extends('layouts.app')

@section('title', 'SandyDecor - Galería')

@section('content')
    <div class="flex items-center justify-center flex-wrap bg-white py-8">
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div>
                <img class="h-96 rounded-lg" src="{{ asset('assets/photos/photo_01.webp') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_02.webp') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_03.jpg') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_04.jpg') }}" alt="">
            </div>
            <div>
                <img class="h-96 rounded-lg" src="{{ asset('assets/photos/photo_05.jpg') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_06.jpg') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_07.webp') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_08.jpg') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_09.jpg') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_10.jpg') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_05.jpg') }}" alt="">
            </div>
            <div>
                <img class="h-96 max-w-full rounded-lg" src="{{ asset('assets/photos/photo_06.jpg') }}" alt="">
            </div>
        </div>
    </div>
    <br>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                <div class="gap-4 sm:flex sm:items-center sm:justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Nuestras Historias</h2>
                    <div class="mt-6 sm:mt-0">
                        <label for="order-type"
                            class="sr-only mb-2 block text-sm font-medium text-gray-900 dark:text-white">Select review
                            type</label>
                        <select id="order-type"
                            class="block w-full min-w-[8rem] rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                            <option selected>Todas</option>
                            <option value="5">5 estrellas</option>
                            <option value="4">4 estrellas</option>
                            <option value="3">3 estrellas</option>
                            <option value="2">2 estrellas</option>
                            <option value="1">1 estrellas</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flow-root sm:mt-8">
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="grid md:grid-cols-12 gap-4 md:gap-6 pb-4 md:pb-6">
                            <dl class="md:col-span-3 order-3 md:order-1">
                                <dt class="sr-only">Product:</dt>
                                <dd class="text-base font-semibold text-gray-900 dark:text-white">
                                    <a href="#" class="hover:underline">Carlos Andrés Mora
                                    </a>
                                </dd>
                            </dl>

                            <dl class="md:col-span-6 order-4 md:order-2">
                                <dt class="sr-only">Message:</dt>
                                <dd class=" text-gray-500 dark:text-gray-400">Excelente servicio y puntualidad en la
                                    entrega. El detalle era muy hermoso y cuando lo recibí estaba encantado...</dd>
                            </dl>

                            <div class="md:col-span-3 content-center order-1 md:order-3 flex items-center justify-between">
                                <dl>
                                    <dt class="sr-only">Stars:</dt>
                                    <dd class="flex items-center space-x-1">
                                        <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                            </path>
                                        </svg>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-12 gap-4 md:gap-6 py-4 md:py-6">
                        <dl class="md:col-span-3 order-3 md:order-1">
                            <dt class="sr-only">Product:</dt>
                            <dd class="text-base font-semibold text-gray-900 dark:text-white">
                                <a href="#" class="hover:underline">Laura Alexandra Espinoza</a>
                            </dd>
                        </dl>

                        <dl class="md:col-span-6 order-4 md:order-2">
                            <dt class="sr-only">Message:</dt>
                            <dd class=" text-gray-500 dark:text-gray-400">Lucía muy elegante y enorme. Tenía flores frescas
                                y unos chocolates deliciosos... em encantó y lo entregaron directamente en mi lugra de
                                trabajo...</dd>
                        </dl>

                        <div class="md:col-span-3 content-center order-1 md:order-3 flex items-center justify-between">
                            <dl>
                                <dt class="sr-only">Stars:</dt>
                                <dd class="flex items-center space-x-1">
                                    <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                        </path>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                        </path>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                        </path>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                        </path>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                        </path>
                                    </svg>
                                </dd>
                            </dl>

                        </div>
                    </div>
                </div>
                <div class="grid md:grid-cols-12 gap-4 md:gap-6 py-4 md:py-6">
                    <dl class="md:col-span-3 order-3 md:order-1">
                        <dt class="sr-only">Product:</dt>
                        <dd class="text-base font-semibold text-gray-900 dark:text-white">
                            <a href="#" class="hover:underline">Juan Galarza </a>
                        </dd>
                    </dl>

                    <dl class="md:col-span-6 order-4 md:order-2">
                        <dt class="sr-only">Message:</dt>
                        <dd class=" text-gray-500 dark:text-gray-400">Estuvo excelente, un buen vino y muchos chocolates
                            deliciosos...</dd>
                    </dl>

                    <div class="md:col-span-3 content-center order-1 md:order-3 flex items-center justify-between">
                        <dl>
                            <dt class="sr-only">Stars:</dt>
                            <dd class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z" />
                                </svg>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
@endsection
