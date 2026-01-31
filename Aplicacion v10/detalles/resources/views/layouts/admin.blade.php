<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="font-[Inter] bg-[#FFF0F5]">

<!-- ================= HEADER ================= -->
<header
    class="fixed top-0 left-0 right-0 z-50
           bg-gradient-to-r from-pink-100 via-pink-50 to-pink-100
           px-6 py-4
           flex items-center justify-between
           border-b-2 border-pink-300
           shadow-md">

    <div class="flex items-center gap-4">
        <img
            src="{{ asset('images/Logo-Transparente.png') }}"
            alt="SandyDecor"
            class="h-16 w-auto object-contain"
        >

        <h1 class="text-2xl font-extrabold text-pink-500 tracking-wide">
            SandyDecor
        </h1>
    </div>

    <div class="relative">
        <button
            onclick="document.getElementById('userMenu').classList.toggle('hidden')"
            class="flex items-center space-x-3 focus:outline-none"
        >
            <span class="text-sm font-medium text-gray-600">
                {{ Auth::user()->name ?? 'Administrador' }}
            </span>

            <div class="w-10 h-10 rounded-full bg-pink-400 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>

            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
        </button>

        <div
            id="userMenu"
            class="hidden absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-lg z-50">

            <a href="{{ route('admin.profile') }}"
               class="block px-4 py-2 text-sm hover:bg-pink-50">
                Perfil
            </a>

            <div class="border-t my-1"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>

<!-- ================= LAYOUT ================= -->
<div class="flex pt-24 min-h-screen">

    <!-- SIDEBAR -->
    @include('layouts.sidebar')

    <!-- CONTENIDO -->
    <main class="flex-1 px-6 py-4">
        @yield('content')
    </main>

</div>

<!-- ================= FOOTER ================= -->
<footer class="text-center text-sm text-gray-500 py-4">
    © {{ date('Y') }} <span class="font-semibold">Sandy Decor</span>. Todos los derechos reservados.
</footer>

</body>
</html>
