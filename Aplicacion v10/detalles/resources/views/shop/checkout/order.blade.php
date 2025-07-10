@extends('layouts.app')

@section('title', 'SandyDecor - Resumen de Orden')

@section('content')
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <form action="#" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-3xl">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Resumen de la Orden</h2>
                <div class="mt-6 space-y-4 border-b border-t border-gray-200 py-8 dark:border-gray-700 sm:mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Información de Entrega y Facturación</h4>
                    <dl>
                        <dd class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">Ramona Cordero 4-75 y José
                            Astudillo, Catamayo, Loja. Celular: 098 733 7085.</dd>
                        <dd class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">Casa esquinera de 2 pisos
                            diagonal al parque central de Catamayo.</dd>
                    </dl>
                    <button type="button" data-modal-target="billingInformationModal"
                        data-modal-toggle="billingInformationModal"
                        class="text-base font-medium text-primary-700 hover:underline dark:text-primary-500">Editar</button>
                </div>
                <div class="mt-6 sm:mt-8">
                    <div class="relative overflow-x-auto border-b border-gray-200 dark:border-gray-800">
                        <table class="w-full text-left font-medium text-gray-900 dark:text-white md:table-fixed">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                <tr>
                                    <td class="whitespace-nowrap py-4 md:w-[384px]">
                                        <div class="flex items-center gap-4">
                                            <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                                                <img class="h-auto w-full max-h-full"
                                                    src="{{ asset('assets/products/producto_001.jpg') }}"
                                                    alt="Ramo de Flores con Oso de Peluche" />
                                            </a>
                                            <a href="#" class="hover:underline">Ramo de Flores con Oso de Peluche</a>
                                        </div>
                                    </td>
                                    <td class="p-4 text-right text-base font-normal text-gray-900 dark:text-white">x1</td>
                                    <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">$30.00</td>
                                </tr>
                                <tr>
                                    <td class="whitespace-nowrap py-4 md:w-[384px]">
                                        <div class="flex items-center gap-4">
                                            <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                                                <img class="h-auto w-full max-h-full"
                                                    src="{{ asset('assets/products/producto_008.jpg') }}"
                                                    alt="Combo San Valentin - Flores, Peluche y Chocolates" />
                                            </a>
                                            <a href="#" class="hover:underline">Combo San Valentin - Flores, Peluche y
                                                Chocolates</a>
                                        </div>
                                    </td>
                                    <td class="p-4 text-right text-base font-normal text-gray-900 dark:text-white">x1</td>
                                    <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">$75.00</td>
                                </tr>
                                <tr>
                                    <td class="whitespace-nowrap py-4 md:w-[384px]">
                                        <div class="flex items-center gap-4">
                                            <a href="#" class="flex items-center aspect-square w-10 h-10 shrink-0">
                                                <img class="h-auto w-full max-h-full"
                                                    src="{{ asset('assets/products/producto_003.webp') }}"
                                                    alt="Ramo de Girasoles y Rosas - Estilo Nocturno" />
                                            </a>
                                            <a href="#" class="hover:underline">Ramo de Girasoles y Rosas - Estilo
                                                Nocturno </a>
                                        </div>
                                    </td>
                                    <td class="p-4 text-right text-base font-normal text-gray-900 dark:text-white">x1</td>
                                    <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">$18.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 space-y-6">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Resumen de la Orden</h4>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-gray-500 dark:text-gray-400">Precio normal</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">$123.00</dd>
                                </dl>
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-gray-500 dark:text-gray-400">Descuento</dt>
                                    <dd class="text-base font-medium text-green-500">-$3.00</dd>
                                </dl>
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-gray-500 dark:text-gray-400">Entrega</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">$4.50</dd>
                                </dl>
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-gray-500 dark:text-gray-400">Impuestos</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">$0.00</dd>
                                </dl>
                            </div>
                            <dl
                                class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                <dt class="text-lg font-bold text-gray-900 dark:text-white">Total</dt>
                                <dd class="text-lg font-bold text-gray-900 dark:text-white">$124.50</dd>
                            </dl>
                        </div>
                        <div class="flex items-start sm:items-center">
                            <input id="terms-checkbox-2" type="checkbox" value=""
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-primary-600 focus:ring-2 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                            <label for="terms-checkbox-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Estoy de acuerdo con los <a href="{{ route('terms') }}" title=""
                                    class="text-indigo-700 underline hover:no-underline dark:text-primary-500">Terminos y
                                    Condiciones</a> del servicio de SandyDecor</label>
                        </div>
                        <div class="gap-4 sm:flex sm:items-center">
                            <button type="button"
                                class="w-full rounded-lg  border border-gray-200 bg-white px-5  py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Seguir
                                comprando</button>

                            <button type="submit"
                                class="mt-4 flex w-full items-center justify-center rounded-lg bg-pink-600  px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-primary-300  dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 sm:mt-0">Confirmar
                                la Orden</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div id="billingInformationModal" tabindex="-1" aria-hidden="true"
        class="antialiased fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-auto w-full max-h-full items-center justify-center overflow-y-auto overflow-x-hidden antialiased md:inset-0">
        <div class="relative max-h-auto w-full max-h-full max-w-lg p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Información de Facturación</h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="billingInformationModal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-5">
                        <div class="sm:col-span-2">
                            <div class="mb-2 flex items-center gap-1">
                                <label for="saved-address-modal"
                                    class="block text-sm font-medium text-gray-900 dark:text-white"> Dirección de Entrega
                                </label>
                                <svg data-tooltip-target="saved-address-modal-desc-2" data-tooltip-trigger="hover"
                                    class="h-4 w-4 text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <select id="saved-address-modal"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                <option selected>Escoja la dirección de entrega</option>
                                <option value="address-1">Ramona Cordero 4-75 y José Astudillo</option>
                                <option value="address-2">Mariscal Sucre 10-56 y Padre Aguirre</option>
                            </select>
                            <div id="saved-address-modal-desc-2" role="tooltip"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                Escoja su dirección de Entrega
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <div>
                            <label for="first_name_billing_modal"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Nombre </label>
                            <input type="text" id="first_name_billing_modal"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                placeholder="Ingrese su nombre" required />
                        </div>
                        <div>
                            <label for="last_name_billing_modal"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Apellido </label>
                            <input type="text" id="last_name_billing_modal"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                placeholder="Ingrese su apellido" required />
                        </div>
                        <div class="sm:col-span-2">
                            <label for="phone-input_billing_modal"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Celular </label>
                            <div class="flex items-center">
                                <button id="dropdown_phone_input__button_billing_modal"
                                    data-dropdown-toggle="dropdown_phone_input_billing_modal"
                                    class="z-10 inline-flex shrink-0 items-center rounded-s-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                                    type="button">
                                    +593
                                    <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
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

                        


                        <div>
                            <div class="mb-2 flex items-center gap-2">
                                <label for="select_country_input_billing_modal"
                                    class="block text-sm font-medium text-gray-900 dark:text-white"> Provincia </label>
                            </div>
                            <select id="select_country_input_billing_modal"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                <option value="11">Loja</option>
                            </select>
                        </div>
                        <div>
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
                        <div class="sm:col-span-2">
                            <label for="address_billing_modal"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Indicaciones o
                                Referencias</label>
                            <textarea id="address_billing_modal" rows="4"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                placeholder="Lugares cercanos, características del lugar, etc."></textarea>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5">
                        <button type="submit"
                            class="me-2 inline-flex items-center rounded-lg bg-pink-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-pindigo-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Guardar
                            Información</button>
                        <button type="button" data-modal-toggle="billingInformationModal"
                            class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
