<aside id="admin-sidebar"
       class="fixed top-24 left-0 z-40 h-[calc(100vh-6rem)]
              bg-[#F7A8A6] shadow-lg rounded-r-3xl
              overflow-y-auto
              transition-all duration-200
              w-64">

    <div class="p-6">

        {{-- LOGO --}}
        <div class="flex items-center mb-8">
            <span class="text-2xl font-bold text-pink-900 tracking-wide sidebar-text">
                SandyDecor
            </span>
            <span class="text-2xl font-bold text-pink-900 tracking-wide hidden sidebar-mini">
                SD
            </span>
        </div>

        @if(auth()->check() && auth()->user()->role === 'admin')

            <nav class="space-y-2">

                {{-- DASHBOARD --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition text-pink-900">
                    <span class="text-lg">🏠</span>
                    <span class="sidebar-text font-semibold">Dashboard</span>
                </a>

                {{-- CATÁLOGO --}}
                <div class="mt-5">

                    <div class="text-xs uppercase tracking-wider text-pink-900/70 px-2 mb-2 sidebar-text">
                        CATÁLOGO
                    </div>

                    {{-- PRODUCTOS --}}
                    <a href="{{ route('admin.products.index') }}"
                       class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition text-pink-900">
                        <span class="text-lg">🎁</span>
                        <span class="sidebar-text font-semibold">Productos</span>
                    </a>

                    {{-- CATEGORÍAS --}}
                    <div class="mt-1">

                        <button type="button"
                                data-submenu="categorias"
                                class="sidebar-link flex items-center gap-3 w-full px-4 py-3 rounded-xl hover:bg-white/30 transition text-pink-900">
                            <span class="text-lg">🧩</span>
                            <span class="sidebar-text font-semibold">Categorías</span>
                            <span class="sidebar-text ml-auto">▾</span>
                        </button>

                        <div id="submenu-categorias"
                             class="ml-4 mt-1 space-y-1 hidden">

                            <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                               href="{{ route('admin.categories.index', ['type' => 'tipo_producto']) }}">
                                Tipo de producto
                            </a>

                            <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                               href="{{ route('admin.categories.index', ['type' => 'ocasion']) }}">
                                Ocasión especial
                            </a>

                        </div>
                    </div>

                    {{-- INVENTARIO --}}
                    <a href="{{ route('admin.inventory.index') }}"
                       class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition text-pink-900 mt-1">
                        <span class="text-lg">📦</span>
                        <span class="sidebar-text font-semibold">Inventario</span>
                    </a>

                </div>

                {{-- PEDIDOS Y VENTAS --}}
                <div class="mt-3">

                    <button type="button"
                            data-submenu="ventas"
                            class="sidebar-link flex items-center gap-3 w-full px-4 py-3 rounded-xl hover:bg-white/30 transition text-pink-900">
                        <span class="text-lg">🛒</span>
                        <span class="sidebar-text font-semibold">Pedidos y Ventas</span>
                        <span class="sidebar-text ml-auto">▾</span>
                    </button>

                    <div id="submenu-ventas" class="ml-4 mt-1 space-y-1 hidden">
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.orders.index') }}">
                            Pedidos
                        </a>
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.invoices.index') }}">
                            Facturas
                        </a>
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.transactions.index') }}">
                            Pagos
                        </a>
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.shipments.index') }}">
                            Envíos
                        </a>
                    </div>

                </div>

                {{-- USUARIOS --}}
                <div class="mt-1">

                    <button type="button"
                            data-submenu="usuarios"
                            class="sidebar-link flex items-center gap-3 w-full px-4 py-3 rounded-xl hover:bg-white/30 transition text-pink-900">
                        <span class="text-lg">👥</span>
                        <span class="sidebar-text font-semibold">Gestión de Usuarios</span>
                        <span class="sidebar-text ml-auto">▾</span>
                    </button>

                    <div id="submenu-usuarios" class="ml-4 mt-1 space-y-1 hidden">
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.customers.index') }}">
                            Clientes
                        </a>
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.reviews.index') }}">
                            Reseñas
                        </a>
                    </div>

                </div>

                {{-- REPORTES --}}
                <div class="mt-1">

                    <button type="button"
                            data-submenu="reportes"
                            class="sidebar-link flex items-center gap-3 w-full px-4 py-3 rounded-xl hover:bg-white/30 transition text-pink-900">
                        <span class="text-lg">📊</span>
                        <span class="sidebar-text font-semibold">Reportes</span>
                        <span class="sidebar-text ml-auto">▾</span>
                    </button>

                    <div id="submenu-reportes" class="ml-4 mt-1 space-y-1 hidden">
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.reports.sales') }}">
                            Ventas
                        </a>
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.reports.products') }}">
                            Productos
                        </a>
                        <a class="block px-4 py-2 rounded-xl text-pink-900 hover:bg-white/30 transition"
                           href="{{ route('admin.reports.customers') }}">
                            Clientes
                        </a>
                    </div>

                </div>

            </nav>

        @endif

    </div>
</aside>
