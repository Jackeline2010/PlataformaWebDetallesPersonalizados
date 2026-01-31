<nav class="space-y-2">

    <h3 class="text-sm font-bold text-gray-600 uppercase mb-3">
        Mi Cuenta
    </h3>

    <a href="{{ route('client.dashboard') }}"
       class="block px-3 py-2 rounded hover:bg-pink-200 text-gray-700">
        🏠 Panel principal
    </a>

    <a href="{{ route('client.orders') }}"
       class="block px-3 py-2 rounded hover:bg-pink-200 text-gray-700">
        📦 Mis órdenes
    </a>

    <a href="{{ route('client.profile') }}"
       class="block px-3 py-2 rounded hover:bg-pink-200 text-gray-700">
        👤 Información de la cuenta
    </a>

    <hr>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="w-full text-left px-3 py-2 rounded text-red-500 hover:bg-red-100">
            🚪 Cerrar sesión
        </button>
    </form>

</nav>
