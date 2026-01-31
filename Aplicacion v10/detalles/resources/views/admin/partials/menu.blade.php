<nav class="bg-pink-600">
    <div class="max-w-screen-xl mx-auto px-4 py-3 flex justify-between items-center">

        <!-- LOGO -->
        <a href="{{ route('home') }}" class="text-white text-2xl font-bold">
            Sandy Decor
        </a>

        <!-- RIGHT MENU -->
        <div class="flex items-center space-x-3">

            @guest
                <a href="{{ route('cart') }}"
                   class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm">
                    Carrito
                </a>

                <a href="{{ route('login') }}"
                   class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm">
                    Ingreso
                </a>
            @else
                <a href="{{ route('cart') }}"
                   class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm">
                    Carrito
                </a>

                <div class="relative">
                    <button id="userMenuBtn"
                            data-dropdown-toggle="userMenu"
                            class="text-white font-medium px-4 py-2">
                        {{ Auth::user()->name }}
                    </button>

                    <div id="userMenu"
                         class="hidden absolute right-0 mt-2 w-44 bg-white rounded-lg shadow">

                        @auth
                           <a href="{{ route('client.dashboard') }}">Mi Cuenta</a>
                    @endauth


                        <a href="{{ route('client.profile') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Cerrar sesión
                            </button>
                        </form>

                    </div>
                </div>
            @endguest

        </div>
    </div>
</nav>

