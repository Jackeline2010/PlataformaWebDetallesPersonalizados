<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin | SandyDecor')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tipografía + iconos --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('styles')
</head>

<body class="font-[Inter] bg-[#FFF0F5]">

<header class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-pink-100 via-pink-50 to-pink-100
px-6 py-4 flex items-center justify-between border-b border-pink-200 shadow-sm">

    <div class="flex items-center gap-3 min-w-[220px]">
        <button id="toggleSidebar"
                type="button"
                class="w-9 h-9 rounded-lg bg-white/70 hover:bg-white shadow-sm flex items-center justify-center text-pink-500"
                aria-label="Alternar menú">
            <i id="menuIcon" class="fas fa-bars text-sm"></i>
        </button>

        <img src="{{ asset('images/Logo-Transparente.png') }}" class="h-10" alt="Logo">
        <span class="text-lg font-extrabold text-pink-500">SandyDecor</span>
    </div>

    <div class="hidden md:flex flex-1 px-6">
        <div class="w-full max-w-2xl relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-pink-300"></i>
            <input type="text"
                   placeholder="Buscar productos, pedidos, clientes..."
                   class="w-full pl-11 pr-4 py-2.5 rounded-full bg-white/80 border border-pink-200
                   focus:outline-none focus:ring-2 focus:ring-pink-300 text-sm">
        </div>
    </div>

    <div class="flex items-center gap-3">
        <div class="relative">
            <button id="userMenuBtn" type="button" class="flex items-center gap-2">
                <span class="hidden sm:inline text-sm text-gray-600">
                    {{ Auth::user()->name ?? 'Administrador' }}
                </span>

                <div class="w-10 h-10 rounded-full bg-pink-400 text-white flex items-center justify-center font-bold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A',0,1)) }}
                </div>

                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
            </button>

            <div id="userMenu" class="hidden absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-lg border border-pink-100 overflow-hidden">
                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm hover:bg-pink-50">
                    Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="pt-24 min-h-screen flex">

    @include('layouts.sidebar')

    <main id="mainContent" class="flex-1 transition-all duration-200 px-6 py-4 ml-0 md:ml-64">

        {{-- ✅ Flash messages globales (auto-hide + botón cerrar) --}}
        @if(session('success'))
            <div id="flash-success"
                 class="fixed top-24 right-6 z-[9999] min-w-[280px] max-w-[420px]
                        p-4 rounded-2xl bg-green-50 text-green-800 border border-green-200 shadow-lg
                        flex items-start justify-between gap-4">
                <div class="text-sm font-semibold leading-snug">
                    {{ session('success') }}
                </div>

                <button type="button"
                        class="text-green-700/60 hover:text-green-900"
                        onclick="window.__closeFlash('flash-success')"
                        aria-label="Cerrar">
                    ✕
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="flash-error"
                 class="fixed top-24 right-6 z-[9999] min-w-[280px] max-w-[420px]
                        p-4 rounded-2xl bg-red-50 text-red-800 border border-red-200 shadow-lg
                        flex items-start justify-between gap-4">
                <div class="text-sm font-semibold leading-snug">
                    {{ session('error') }}
                </div>

                <button type="button"
                        class="text-red-700/60 hover:text-red-900"
                        onclick="window.__closeFlash('flash-error')"
                        aria-label="Cerrar">
                    ✕
                </button>
            </div>
        @endif

        <script>
            window.__closeFlash = function(id) {
                const el = document.getElementById(id);
                if (!el) return;

                el.style.transition = 'opacity .35s ease, transform .35s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-8px)';
                setTimeout(() => el.remove(), 350);
            };

            setTimeout(() => window.__closeFlash('flash-success'), 3000);
            setTimeout(() => window.__closeFlash('flash-error'), 5000);
        </script>

        @yield('content')
    </main>
</div>

<footer class="text-center text-sm text-gray-500 py-4">
    © {{ date('Y') }} Sandy Decor
</footer>

{{-- SCRIPT PRINCIPAL --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const sidebar = document.getElementById('admin-sidebar');
    const main = document.getElementById('mainContent');
    const btn = document.getElementById('toggleSidebar');

    const userBtn = document.getElementById('userMenuBtn');
    const userMenu = document.getElementById('userMenu');

    // Dropdown usuario
    userBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        userMenu?.classList.toggle('hidden');
    });

    userMenu?.addEventListener('click', (e) => e.stopPropagation());

    document.addEventListener('click', () => {
        userMenu?.classList.add('hidden');
    });

    // Toggle submenus
    document.querySelectorAll('[data-submenu]').forEach(button => {
        button.addEventListener('click', function () {
            const name = this.getAttribute('data-submenu');
            const submenu = document.getElementById('submenu-' + name);
            if (!submenu) return;
            submenu.classList.toggle('hidden');
        });
    });

    // Auto abrir Categorías si estás en /admin/categories
    if (window.location.pathname.includes('/admin/categories')) {
        const catMenu = document.getElementById('submenu-categorias');
        if (catMenu) catMenu.classList.remove('hidden');
    }

    // Sidebar collapse
    let collapsed = false;
    btn?.addEventListener('click', () => {
        if (!sidebar) return;

        collapsed = !collapsed;

        if (collapsed) {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');

            main?.classList.remove('md:ml-64');
            main?.classList.add('md:ml-20');

            document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.sidebar-mini').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.sidebar-link').forEach(el => el.classList.add('justify-center'));
        } else {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');

            main?.classList.remove('md:ml-20');
            main?.classList.add('md:ml-64');

            document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.sidebar-mini').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('justify-center'));
        }
    });

});
</script>

{{-- ✅ MODAL CONFIRMACIÓN GLOBAL (Guardar / Editar / Eliminar) --}}
<div id="confirmModal" class="fixed inset-0 z-[10000] hidden">
    <div id="confirmBackdrop" class="absolute inset-0 bg-black/50"></div>

    <div class="relative w-full h-full flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl border border-pink-100">
            <div class="p-5">
                <h3 id="confirmTitle" class="text-lg font-extrabold text-gray-800">Confirmar</h3>
                <p id="confirmMessage" class="mt-2 text-sm text-gray-600">¿Deseas continuar?</p>
            </div>

            <div class="px-5 pb-5 flex gap-3 justify-end">
                <button id="confirmCancel" type="button"
                        class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>

                <button id="confirmOk" type="button"
                        class="px-4 py-2 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600">
                    Sí, continuar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('confirmModal');
    const backdrop = document.getElementById('confirmBackdrop');
    const titleEl = document.getElementById('confirmTitle');
    const msgEl = document.getElementById('confirmMessage');
    const okBtn = document.getElementById('confirmOk');
    const cancelBtn = document.getElementById('confirmCancel');

    if (!modal || !backdrop || !titleEl || !msgEl || !okBtn || !cancelBtn) {
        console.warn('[ConfirmModal] No se encontró el modal en el DOM.');
        return;
    }

    let pendingAction = null;

    function openModal({ title, message, okText, cancelText, danger }) {
        titleEl.textContent = title || 'Confirmar';
        msgEl.textContent = message || '¿Deseas continuar?';
        okBtn.textContent = okText || 'Sí, continuar';
        cancelBtn.textContent = cancelText || 'Cancelar';

        okBtn.classList.remove('bg-pink-500','hover:bg-pink-600','bg-red-600','hover:bg-red-700');
        if (danger) okBtn.classList.add('bg-red-600','hover:bg-red-700');
        else okBtn.classList.add('bg-pink-500','hover:bg-pink-600');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        pendingAction = null;
    }

    // Cerrar con fondo, cancelar o ESC
    backdrop.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });

    okBtn.addEventListener('click', () => {
        if (typeof pendingAction === 'function') pendingAction();
        closeModal();
    });

    // ✅ Detecta botones con data-confirm-submit
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-confirm-submit]');
        if (!btn) return;

        const formId = btn.getAttribute('data-confirm-submit');
        const form = document.getElementById(formId);

        if (!form) {
            console.warn('[ConfirmModal] No existe el form con id:', formId);
            return;
        }

        e.preventDefault();

        pendingAction = () => form.submit();

        openModal({
            title: btn.getAttribute('data-confirm-title') || 'Confirmar',
            message: btn.getAttribute('data-confirm-message') || '¿Deseas continuar?',
            okText: btn.getAttribute('data-confirm-ok') || 'Sí, continuar',
            cancelText: btn.getAttribute('data-confirm-cancel') || 'Cancelar',
            danger: btn.getAttribute('data-confirm-danger') === '1'
        });
    });
});
</script>

{{-- ✅ Scripts de cada vista --}}
@stack('scripts')
</body>
</html>

