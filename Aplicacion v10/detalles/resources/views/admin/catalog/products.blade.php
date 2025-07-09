<x-admin-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-16 py-3">
                        <span class="sr-only">Image</span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Producto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Stock
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio Individual
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio Total
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_001.jpg') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Flores con Oso de Peluche
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="20" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 30.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 600.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_002.webp') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Girasoles con Azucenas
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="8" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 15.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 120.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_003.webp') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Girasoles y Rosas - Estilo Nocturno
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="4" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 18.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 76.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_004.jpg') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Rosas y Orquideas + Chocolates Noggy
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">

                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="6" required />
                            </div>

                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 25.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 150.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_005.webp') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Flores Amarillas - Girasoles y Margaritas
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="4" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 15.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 60.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_006.jpg') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Girasoles Rojos y Amarillos - 6 girasoles
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="12" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 12.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 144.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_007.webp') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Canasta de Rosas e Ilusiones
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="5" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 20.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 100.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_008.jpg') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Rosas Multicolores + Botella de Vino + Chocolates + Oso Teddy
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="8" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 75.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 600.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_009.webp') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Flores Primavera - Rosas y Orquideas
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="2" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 22.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 44.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-4">
                        <img src="{{ asset('assets/products/producto_010.jpg') }}"
                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        Ramo de Rosas Elegante - 1 docena
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div>
                                <input type="number" id="first_product"
                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="1" value="10" required />
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 25.00
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        $ 250.00
                    </td>
                    <td class="px-6 py-4">
                        <a href="#"
                            class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">Editar</a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</x-admin-layout>
