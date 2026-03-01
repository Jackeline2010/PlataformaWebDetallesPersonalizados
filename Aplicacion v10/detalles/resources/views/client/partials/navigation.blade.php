<nav class="bg-pink-600 border-b border-pink-700 fixed top-0 left-0 right-0 w-full z-50">
    {{-- IMPORTANTE: w-full (sin max-w-screen-xl) --}}
    <div class="w-full px-6 py-3 flex justify-between items-center">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="font-extrabold text-xl text-white tracking-wide">
            SandyDecor
        </a>

        {{-- Links --}}
        <div class="flex items-center gap-6 text-white">

            <a href="{{ route('products') }}" class="font-medium hover:text-pink-200 transition">
                Productos
            </a>

            <a href="{{ route('cart') }}" class="font-medium hover:text-pink-200 transition">
                Carrito
            </a>

            @auth
                {{-- Dropdown Mi Cuenta --}}
                <div class="relative">
                    <button
                        id="dropdownCuentaButton"
                        data-dropdown-toggle="dropdownCuenta"
                        class="flex items-center gap-2 font-semibold hover:text-pink-200 transition"
                        type="button"
                    >
                        Mi Cuenta
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div id="dropdownCuenta"
                        class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg text-gray-700 overflow-hidden border border-pink-100">

                        <a href="{{ route('client.dashboard') }}"
                           class="block px-4 py-2 hover:bg-pink-50 transition">
                            Dashboard
                        </a>

                        <a href="{{ route('client.orders') }}"
                           class="block px-4 py-2 hover:bg-pink-50 transition">
                            Mis pedidos
                        </a>

                        <a href="{{ route('client.profile') }}"
                           class="block px-4 py-2 hover:bg-pink-50 transition">
                            Mi perfil
                        </a>

                        <div class="border-t border-pink-100 my-1"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="font-medium hover:text-pink-200 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="font-medium hover:text-pink-200 transition">
                    Registro
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- ESPACIO para que el contenido no quede debajo del nav fixed --}}
<div class="h-[72px]"></div>
