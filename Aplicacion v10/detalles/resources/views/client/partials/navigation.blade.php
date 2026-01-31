<nav class="bg-pink-600 border-b border-pink-700 fixed w-full z-50">
    <div class="max-w-screen-xl mx-auto px-6 py-3 flex justify-between items-center">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="font-bold text-xl text-white">
            SandyDecor
        </a>

        {{-- Links --}}
        <div class="flex items-center gap-6 text-white">

            <a href="{{ route('products') }}" class="hover:text-pink-200">
                Productos
            </a>

            <a href="{{ route('cart') }}" class="hover:text-pink-200">
                Carrito
            </a>

            @auth
                {{-- Dropdown Mi Cuenta --}}
                <div class="relative">
                    <button
                        id="dropdownCuentaButton"
                        data-dropdown-toggle="dropdownCuenta"
                        class="flex items-center gap-2 font-medium hover:text-pink-200"
                        type="button"
                    >
                        Mi Cuenta
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div id="dropdownCuenta"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg text-gray-700">

                        <a href="{{ route('client.dashboard') }}"
                            class="block px-4 py-2 hover:bg-pink-100">
                            Dashboard
                        </a>

                        <a href="{{ route('client.orders') }}"
                            class="block px-4 py-2 hover:bg-pink-100">
                            Mis pedidos
                        </a>

                        <a href="{{ route('client.profile') }}"
                            class="block px-4 py-2 hover:bg-pink-100">
                            Mi perfil
                        </a>

                        <div class="border-t my-1"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-left px-4 py-2 text-red-500 hover:bg-red-50">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hover:text-pink-200">
                    Login
                </a>
                <a href="{{ route('register') }}" class="hover:text-pink-200">
                    Registro
                </a>
            @endauth
        </div>
    </div>
</nav>
