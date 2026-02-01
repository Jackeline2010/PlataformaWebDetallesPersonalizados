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

    <div class="flex items-center gap-3">

    {{-- BOTÓN SIDEBAR --}}
    <button
        id="toggleSidebar"
        type="button"
        class="w-9 h-9 rounded-lg bg-white/70 hover:bg-white
               shadow-sm flex items-center justify-center
               text-pink-500 transition">
        <i id="menuIcon" class="fas fa-bars text-sm"></i>
    </button>

    <img
        src="{{ asset('images/Logo-Transparente.png') }}"
        alt="SandyDecor"
        class="h-10 w-auto object-contain">

    <span class="text-lg font-extrabold text-pink-500 tracking-wide">
        SandyDecor </span>

        </div>


    <div class="flex items-center gap-3">



        {{-- MENU USUARIO --}}
        <div class="relative">
            <button
                id="userMenuBtn"
                type="button"
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

    </div>
</header>

<!-- ================= LAYOUT ================= -->
<div class="pt-24 min-h-screen">

    {{-- SIDEBAR: OJO -> tu include YA trae <aside id="admin-sidebar"> --}}
    @include('layouts.sidebar')

    {{-- CONTENIDO: se empuja según el ancho del sidebar --}}
    <main id="mainContent"
          class="transition-all duration-200 ml-64 px-6 py-4 min-w-0">
        @yield('content')
    </main>

</div>

<!-- ================= FOOTER ================= -->
<footer class="text-center text-sm text-gray-500 py-4">
    © {{ date('Y') }} <span class="font-semibold">Sandy Decor</span>. Todos los derechos reservados.
</footer>

{{-- JS: colapsar/expandir sidebar + dropdown usuario --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const sidebar = document.getElementById('admin-sidebar'); // <-- ID real del sidebar include
    const main = document.getElementById('mainContent');
    const btn = document.getElementById('toggleSidebar');

    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenu = document.getElementById('userMenu');

    // Por si aún no cargó el include o no existe:
    if (userMenuBtn && userMenu) {
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });
    }

    // Cerrar menú usuario al click fuera
    document.addEventListener('click', (e) => {
        if (!userMenu || userMenu.classList.contains('hidden')) return;
        const inside = e.target.closest('#userMenu') || e.target.closest('#userMenuBtn');
        if (!inside) userMenu.classList.add('hidden');
    });

    if (!sidebar || !main || !btn) return;

    // Estado inicial (expandido)
    let collapsed = false;

    btn.addEventListener('click', () => {
        collapsed = !collapsed;

        if (collapsed) {
            // Sidebar mini
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');

            // Empujar contenido menos
            main.classList.remove('ml-64');
            main.classList.add('ml-20');

            // Ocultar textos, mostrar mini logo (si existe)
            document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.sidebar-mini').forEach(el => el.classList.remove('hidden'));

            // Centrar links (si tu .sidebar-link ya es flex)
            document.querySelectorAll('.sidebar-link').forEach(el => el.classList.add('justify-center'));

        } else {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');

            main.classList.remove('ml-20');
            main.classList.add('ml-64');

            document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.sidebar-mini').forEach(el => el.classList.add('hidden'));

            document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('justify-center'));
        }
    });

});
</script>

</body>
</html>
