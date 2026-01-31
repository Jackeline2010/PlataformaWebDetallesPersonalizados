<aside id="admin-sidebar"
    class="fixed top-0 left-0 z-40 h-screen pt-20
           bg-gray-900 border-r border-gray-800
           transition-all duration-300
           w-20 hover:w-64 group">

    <div class="h-full px-3 pb-4 overflow-y-auto">
        <ul class="space-y-2 font-medium text-gray-300">

            {{-- DASHBOARD --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                              d="M3 12l2-2 7-7 7 7M5 10v10h14V10" />
                    </svg>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>

            {{-- VENTAS --}}
            <li>
                <button class="sidebar-link" data-collapse-toggle="ventas">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                              d="M4 19V5m4 14V9m4 10V5m4 14V9" />
                    </svg>
                    <span class="sidebar-text">Ventas</span>
                </button>

                <ul id="ventas" class="submenu">
                    <li><a href="{{ route('admin.orders') }}">Órdenes</a></li>
                    <li><a href="{{ route('admin.shipments') }}">Envíos</a></li>
                    <li><a href="{{ route('admin.invoices') }}">Facturas</a></li>
                </ul>
            </li>

            {{-- CATÁLOGO --}}
            <li>
                <button class="sidebar-link" data-collapse-toggle="catalogo">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                              d="M3 7l9-4 9 4v10l-9 4-9-4z" />
                    </svg>
                    <span class="sidebar-text">Catálogo</span>
                </button>

                <ul id="catalogo" class="submenu">
                    <li><a href="{{ route('admin.products') }}">Productos</a></li>
                    <li><a href="{{ route('admin.categories') }}">Categorías</a></li>
                    <li><a href="{{ route('admin.inventory') }}">Inventario</a></li>
                </ul>
            </li>

            {{-- CLIENTES --}}
            <li>
                <a href="{{ route('admin.customers') }}" class="sidebar-link">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                              d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-6 8a6 6 0 0 1 12 0" />
                    </svg>
                    <span class="sidebar-text">Clientes</span>
                </a>
            </li>

            {{-- CONFIGURACIÓN --}}
            <li>
                <a href="{{ route('admin.userssettings') }}" class="sidebar-link">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                              d="M12 15a3 3 0 1 0 0-6m8 3h-2.1a6.7 6.7 0 0 0-.6-1.5l1.5-1.5-1.4-1.4-1.5 1.5a6.7 6.7 0 0 0-1.5-.6V4h-2v2.1a6.7 6.7 0 0 0-1.5.6L7.5 5.2 6.1 6.6l1.5 1.5a6.7 6.7 0 0 0-.6 1.5H4v2h2.1a6.7 6.7 0 0 0 .6 1.5l-1.5 1.5 1.4 1.4 1.5-1.5a6.7 6.7 0 0 0 1.5.6V20h2v-2.1a6.7 6.7 0 0 0 1.5-.6l1.5 1.5 1.4-1.4-1.5-1.5a6.7 6.7 0 0 0 .6-1.5H20v-2Z" />
                    </svg>
                    <span class="sidebar-text">Configuración</span>
                </a>
            </li>

        </ul>
    </div>
</aside>
