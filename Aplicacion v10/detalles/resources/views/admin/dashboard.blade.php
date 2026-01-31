@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="flex min-h-screen bg-[#FFF0F5]">

    <!-- Sidebar / Menú vertical rosa pastel -->
    <aside class="w-64 bg-[#FBD4D2] p-6 space-y-6 flex-shrink-0">
        <!-- Logo o título del sidebar -->
        <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">

        </h2>

        <!-- Menú -->
        <nav class="space-y-4">
            <a href="#" class="block py-2 px-4 rounded-xl text-gray-800 font-medium hover:bg-[#F18C86] hover:text-white transition">Dashboard</a>
            <a href="#" class="block py-2 px-4 rounded-xl text-gray-800 font-medium hover:bg-[#F18C86] hover:text-white transition">Pedidos</a>
            <a href="#" class="block py-2 px-4 rounded-xl text-gray-800 font-medium hover:bg-[#F18C86] hover:text-white transition">Clientes</a>
            <a href="#" class="block py-2 px-4 rounded-xl text-gray-800 font-medium hover:bg-[#F18C86] hover:text-white transition">Productos</a>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <div class="flex-1 p-6">

        <!-- Cabecera con título -->
        <header class="mb-12">
            <h1 class="text-5xl md:text-6xl font-extrabold text-center bg-clip-text text-transparent"
                style="background-image: linear-gradient(90deg, #FF7EB9, #FFB3C6); font-family: 'Inter', sans-serif;">
                Panel de Administración
            </h1>
        </header>

        <!-- Cards métricas -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-12">
            <!-- Pedidos -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-8 border-[#007BFF] flex items-center space-x-4 hover:scale-105 transition-transform duration-300">
                <div class="text-[#007BFF] text-4xl">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pedidos</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalOrders ?? 0 }}</p>
                </div>
            </div>

            <!-- Ventas Totales -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-8 border-[#28A745] flex items-center space-x-4 hover:scale-105 transition-transform duration-300">
                <div class="text-[#28A745] text-4xl">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Ventas Totales</p>
                    <p class="text-3xl font-bold text-gray-800">
                        $ {{ number_format($totalSales ?? 0, 2) }}
                    </p>
                </div>
            </div>

            <!-- Clientes -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-8 border-[#6F42C1] flex items-center space-x-4 hover:scale-105 transition-transform duration-300">
                <div class="text-[#6F42C1] text-4xl">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Clientes</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $customers ?? 0 }}</p>
                </div>
            </div>

            <!-- Productos Activos -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-8 border-[#FD7E14] flex items-center space-x-4 hover:scale-105 transition-transform duration-300">
                <div class="text-[#FD7E14] text-4xl">
                    <i class="fas fa-box-open"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Productos Activos</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $products ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Sección inferior: Actividad y Estado -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Actividad reciente -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center space-x-2">
                    <i class="fas fa-chart-line text-blue-500"></i>
                    <span>Actividad reciente</span>
                </h2>
                <p class="text-gray-500 text-sm">
                    Próximamente podrás ver pedidos recientes, ventas y movimientos.
                </p>
            </div>

            <!-- Estado del sistema -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center space-x-2">
                    <i class="fas fa-cogs text-purple-500"></i>
                    <span>Estado del sistema</span>
                </h2>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>✅ Sistema operativo</li>
                    <li>✅ Base de datos conectada</li>
                    <li>✅ Usuario administrador activo</li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
