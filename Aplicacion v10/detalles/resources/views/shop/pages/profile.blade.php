@extends('layouts.app')

@section('title', 'SandyDecor - Mi perfil')

@section('content')
    <!-- Features Section -->
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
        <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
            <nav class="mb-4 flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="mx-1 h-4 w-4 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m9 5 7 7-7 7" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ms-2">Perfil</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl md:mb-6">Perfil de Usuario</h2>

            <div class="py-4 md:py-8">
                <div class="mb-4 grid gap-4 sm:grid-cols-2 sm:gap-8 lg:gap-16">
                    <div class="space-y-4">
                        <div class="flex space-x-4">
                            <img class="h-16 w-16 rounded-lg" src="{{ asset('assets/users/profile-picture-2.jpg') }}"
                                alt="Avatar de usuario" />
                            <div>
                                <span
                                    class="mb-2 inline-block rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                    Cuenta de Usuario </span>
                                <h2
                                    class="flex items-center text-xl font-bold leading-none text-gray-900 dark:text-white sm:text-2xl">
                                    {{ Auth::user()->name }}</h2>
                            </div>
                        </div>
                        <dl class="">
                            <dt class="font-semibold text-gray-900 dark:text-white">Dirección de Correo</dt>
                            <dd class="text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</dd>
                        </dl>
                        <dl>
                            <dt class="font-semibold text-gray-900 dark:text-white">Dirección de Entrega</dt>
                            <dd class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                                <svg class="hidden h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500 lg:inline"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                </svg>
                                Ramona Cordero 4-75 y José Astudillo. Catamayo, Loja
                            </dd>
                        </dl>
                    </div>
                    <div class="space-y-4">
                        <dl>
                            <dt class="font-semibold text-gray-900 dark:text-white">Teléfono Celular</dt>
                            <dd class="text-gray-500 dark:text-gray-400">098 733 7086</dd>
                        </dl>
                        <dl>
                            <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Métodos de Pago</dt>
                            <dd class="flex items-center space-x-4 text-gray-500 dark:text-gray-400">
                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                                    <img class="h-4 w-auto dark:hidden"
                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa.svg"
                                        alt="" />
                                    <img class="hidden h-4 w-auto dark:flex"
                                        src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa-dark.svg"
                                        alt="" />
                                </div>
                                <div>
                                    <div class="text-sm">
                                        <p class="mb-0.5 font-medium text-gray-900 dark:text-white">Visa terminada en 7658
                                        </p>
                                        <p class="font-normal text-gray-500 dark:text-gray-400">Expiración 10/2029</p>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <button type="button" data-modal-target="accountInformationModal2"
                    data-modal-toggle="accountInformationModal2"
                    class="inline-flex w-full items-center justify-center rounded-lg bg-pink-600 px-5 py-2.5 text-lg font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 sm:w-auto">
                    <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z">
                        </path>
                    </svg>
                    Editar Información
                </button>
            </div>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 md:p-8">
                <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Ultimas órdenes</h3>
                <div
                    class="flex flex-wrap items-center gap-y-4 border-b border-gray-200 pb-4 dark:border-gray-700 md:pb-5">
                    <dl class="w-1/2 sm:w-48">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Orden:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                            <a href="#" class="hover:underline">#FWB12546798</a>
                        </dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Fecha:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">11/05/2025</dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/5 md:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Total:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">$25.00</dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/4 sm:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Estado:</dt>
                        <dd
                            class="me-2 mt-1.5 inline-flex shrink-0 items-center rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                            <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z">
                                </path>
                            </svg>
                            En proceso
                        </dd>
                    </dl>

                    <div class="w-full sm:flex sm:w-32 sm:items-center sm:justify-end sm:gap-4">
                        <button id="actionsMenuDropdownModal10" data-dropdown-toggle="dropdownOrderModal10"
                            type="button"
                            class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto">
                            Acciones
                            <svg class="-me-0.5 ms-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownOrderModal10"
                            class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                            <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
                                aria-labelledby="actionsMenuDropdown10">
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4">
                                            </path>
                                        </svg>
                                        <span>Re Ordenar</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                        </svg>
                                        Detalles
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-modal-target="deleteOrderModal"
                                        data-modal-toggle="deleteOrderModal"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z">
                                            </path>
                                        </svg>
                                        Cancelar orden
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-wrap items-center gap-y-4 border-b border-gray-200 py-4 pb-4 dark:border-gray-700 md:py-5">
                    <dl class="w-1/2 sm:w-48">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Orden:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                            <a href="#" class="hover:underline">#FWB12546777</a>
                        </dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Fecha:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">10/11/2024</dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/5 md:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Total:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">$22.00</dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/4 sm:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Estado:</dt>
                        <dd
                            class="mt-1.5 inline-flex items-center rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                            <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"></path>
                            </svg>
                            Cancelada
                        </dd>
                    </dl>

                    <div class="w-full sm:flex sm:w-32 sm:items-center sm:justify-end sm:gap-4">
                        <button id="actionsMenuDropdownModal11" data-dropdown-toggle="dropdownOrderModal11"
                            type="button"
                            class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto">
                            Acciones
                            <svg class="-me-0.5 ms-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownOrderModal11"
                            class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                            <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
                                aria-labelledby="actionsMenuDropdown11">
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4">
                                            </path>
                                        </svg>
                                        <span>Re Ordenar</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                        </svg>
                                        Detalles
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-wrap items-center gap-y-4 border-b border-gray-200 py-4 pb-4 dark:border-gray-700 md:py-5">
                    <dl class="w-1/2 sm:w-48">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Orden:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                            <a href="#" class="hover:underline">#FWB12546846</a>
                        </dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Fecha:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">07/11/2024</dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/5 md:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Total:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">$124.50</dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/4 sm:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Estado:</dt>
                        <dd
                            class="mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                            <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"></path>
                            </svg>
                            Completada
                        </dd>
                    </dl>

                    <div class="w-full sm:flex sm:w-32 sm:items-center sm:justify-end sm:gap-4">
                        <button id="actionsMenuDropdownModal12" data-dropdown-toggle="dropdownOrderModal12"
                            type="button"
                            class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto">
                            Acciones
                            <svg class="-me-0.5 ms-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownOrderModal12"
                            class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                            <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
                                aria-labelledby="actionsMenuDropdown12">
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4">
                                            </path>
                                        </svg>
                                        <span>Re Ordenar</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                        </svg>
                                        Detalles
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-y-4 pt-4 md:pt-5">
                    <dl class="w-1/2 sm:w-48">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Orden:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                            <a href="#" class="hover:underline">#FWB12546212</a>
                        </dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Fecha:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">18/10/2024</dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/5 md:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Total:</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">$75.00</dd>
                    </dl>

                    <dl class="w-1/2 sm:w-1/4 sm:flex-1 lg:w-auto">
                        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Estado:</dt>
                        <dd
                            class="mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                            <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"></path>
                            </svg>
                            Completada
                        </dd>
                    </dl>

                    <div class="w-full sm:flex sm:w-32 sm:items-center sm:justify-end sm:gap-4">
                        <button id="actionsMenuDropdownModal13" data-dropdown-toggle="dropdownOrderModal13"
                            type="button"
                            class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto">
                            Acciones
                            <svg class="-me-0.5 ms-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdownOrderModal13"
                            class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                            <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
                                aria-labelledby="actionsMenuDropdown13">
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4">
                                            </path>
                                        </svg>
                                        <span>Re Ordenar</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                        </svg>
                                        Detalles
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <br>
            <br>
        </div>
        <!-- Account Information Modal -->
        <div id="accountInformationModal2" tabindex="-1" aria-hidden="true"
            class="max-h-auto fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden antialiased md:inset-0">
            <div class="max-h-auto relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Información de Cuenta</h3>
                        <button type="button"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="accountInformationModal2">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5">
                        <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="col-span-2">
                                <label for="pick-up-point-input"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Nombres
                                </label>
                                <input type="text" id="pick-up-point-input"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Ingrese sus nombres" required />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="full_name_info_modal"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Apellido
                                </label>
                                <input type="text" id="full_name_info_modal"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Ingrese su apellido" required />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="email_info_modal"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Correo
                                </label>
                                <input type="text" id="email_info_modal"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Ingrese su email" required />
                            </div>

                            <div class="col-span-2">
                                <label for="phone-input_billing_modal"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Número de Celular
                                </label>
                                <div class="flex items-center">
                                    <button id="dropdown_phone_input__button_billing_modal"
                                        data-dropdown-toggle="dropdown_phone_input_billing_modal"
                                        class="z-10 inline-flex shrink-0 items-center rounded-s-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                                        type="button">
                                        +593
                                        <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 9-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div class="relative w-full">
                                        <input type="text" id="phone-input"
                                            class="z-20 block w-full rounded-e-lg border border-s-0 border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:border-s-gray-700  dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500"
                                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="099-999-9999" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select_country_input_billing_modal"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> Provincia </label>
                                </div>
                                <select id="select_country_input_billing_modal"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                    <option value="11">Loja</option>
                                </select>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select_city_input_billing_modal"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> Ciudad </label>
                                </div>
                                <select id="select_city_input_billing_modal"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                    <option value="01">Loja</option>
                                    <option value="03">Catamayo</option>
                                    <option value="04">Celica</option>
                                    <option value="06">Espíndola</option>
                                    <option value="07">Gonzanamá</option>
                                    <option value="08">Macará</option>
                                    <option value="11">saraguro</option>
                                    <option value="13">Zapotillo</option>
                                    <option value="14">Pindal</option>
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label for="address_billing_modal"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dirección de
                                    Entrega</label>
                                <textarea id="address_billing_modal" rows="4"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Ingrese su dirección de forma detallada"></textarea>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5">
                            <button type="submit"
                                class="me-2 inline-flex items-center rounded-lg bg-pink-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Guardar
                                Información</button>
                            <button type="button" data-modal-toggle="accountInformationModal2"
                                class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="deleteOrderModal" tabindex="-1" aria-hidden="true"
            class="fixed left-0 right-0 top-0 z-50 hidden h-modal w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 md:h-full">
            <div class="relative h-full w-full max-w-md p-4 md:h-auto">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white p-4 text-center shadow dark:bg-gray-800 sm:p-5">
                    <button type="button"
                        class="absolute right-2.5 top-2.5 ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="deleteOrderModal">
                        <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div
                        class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-pink-600 p-2 dark:bg-pink-600">
                        <svg class="h-8 w-8 text-wite dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>
                        <span class="sr-only">Danger icon</span>
                    </div>
                    <p class="mb-3.5 text-gray-900 dark:text-white">¿<a href="#"
                            class="font-medium text-primary-700 hover:underline dark:text-primary-500">{{ Auth::user()->name }}</a>, está seguro(a) que desea cancelar esta orden?</p>
                    <p class="mb-4 text-gray-500 dark:text-gray-300">Esta acción no puede ser reversada.</p>
                    <div class="flex items-center justify-center space-x-4">
                        <button data-modal-toggle="deleteOrderModal" type="button"
                            class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-lg font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-600">No,
                            cancelar</button>
                        <button type="submit"
                            class="rounded-lg bg-pink-600 px-3 py-2 text-center text-lg font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Si,
                            borrar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
