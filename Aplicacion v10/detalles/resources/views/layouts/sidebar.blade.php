<aside id="admin-sidebar"
       class="fixed top-24 left-0 z-40 h-[calc(100vh-6rem)]
              bg-[#F7A8A6] shadow-lg rounded-r-3xl
              overflow-y-auto
              transition-all duration-200
              w-64">

    <div class="p-6">

        {{-- LOGO --}}
        <div class="flex items-center mb-8">
            <span class="text-2xl font-bold text-white tracking-wide sidebar-text">
                SandyDecor
            </span>
            <span class="text-2xl font-bold text-white tracking-wide hidden sidebar-mini">
                SD
            </span>
        </div>

        @if(auth()->check() && auth()->user()->role === 'admin')

        <nav class="space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link text-white">
                <span class="sidebar-icon">🏠</span>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <div class="group">
                <button type="button"
                        onclick="toggleSubmenu('catalogo')"
                        class="sidebar-link text-white w-full">
                    <span class="sidebar-icon">📦</span>
                    <span class="sidebar-text">Catálogo</span>
                </button>

                <div id="submenu-catalogo" class="submenu">
                    <a href="{{ route('admin.products.index') }}">Productos</a>
                    <a href="{{ route('admin.categories') }}">Categorías</a>
                    <a href="{{ route('admin.inventory') }}">Inventario</a>
                </div>
            </div>

            <div class="group">
                <button type="button"
                        onclick="toggleSubmenu('ventas')"
                        class="sidebar-link text-white w-full">
                    <span class="sidebar-icon">🛒</span>
                    <span class="sidebar-text">Pedidos y Ventas</span>
                </button>

                <div id="submenu-ventas" class="submenu">
                    <a href="{{ route('admin.orders') }}">Pedidos</a>
                    <a href="{{ route('admin.invoices') }}">Facturas</a>
                    <a href="{{ route('admin.transactions') }}">Pagos</a>
                    <a href="{{ route('admin.shipments') }}">Envíos</a>
                </div>
            </div>

            <div class="group">
                <button type="button"
                        onclick="toggleSubmenu('usuarios')"
                        class="sidebar-link text-white w-full">
                    <span class="sidebar-icon">👥</span>
                    <span class="sidebar-text">Gestión de Usuarios</span>
                </button>

                <div id="submenu-usuarios" class="submenu">
                    <a href="{{ route('admin.customers') }}">Clientes</a>
                    <a href="{{ route('admin.reviews') }}">Reseñas</a>
                </div>
            </div>

            <div class="group">
                <button type="button"
                        onclick="toggleSubmenu('reportes')"
                        class="sidebar-link text-white w-full">
                    <span class="sidebar-icon">📊</span>
                    <span class="sidebar-text">Reportes</span>
                </button>

                <div id="submenu-reportes" class="submenu">
                    <a href="{{ route('admin.reports.sales') }}">Ventas</a>
                    <a href="{{ route('admin.reports.products') }}">Productos</a>
                </div>
            </div>

        </nav>

        @else

        <nav class="space-y-2">
            <a href="{{ route('home') }}" class="sidebar-link text-white">
                <span class="sidebar-icon">🏠</span>
                <span class="sidebar-text">Inicio</span>
            </a>

            <a href="{{ route('products') }}" class="sidebar-link text-white">
                <span class="sidebar-icon">🛍️</span>
                <span class="sidebar-text">Tienda</span>
            </a>

            <a href="{{ route('order') }}" class="sidebar-link text-white">
                <span class="sidebar-icon">📦</span>
                <span class="sidebar-text">Mis pedidos</span>
            </a>

            <a href="{{ route('profile') }}" class="sidebar-link text-white">
                <span class="sidebar-icon">👤</span>
                <span class="sidebar-text">Mi perfil</span>
            </a>
        </nav>

        @endif
    </div>
</aside>

<script>
    function toggleSubmenu(name) {
        const el = document.getElementById('submenu-' + name);
        if (!el) return;
        el.classList.toggle('submenu-open');
    }
</script>
