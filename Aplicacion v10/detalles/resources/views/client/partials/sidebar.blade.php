@php
  use Illuminate\Support\Facades\Route;

  $current = request()->route()?->getName();

  // Verifica si estás en una ruta para resaltar el menú activo
  $is = fn($name) => $current === $name || str_starts_with((string) $current, $name . '.');

  // Clase del item activo / inactivo
  $cls = fn($name) => $is($name)
      ? 'bg-white text-pink-600 font-extrabold shadow-sm'
      : 'text-gray-800 hover:bg-white hover:text-pink-600';

  // Helper: si existe la ruta -> route(), si no -> fallback
  $safeRoute = function (string $name, string $fallback) {
      return Route::has($name) ? route($name) : $fallback;
  };

  // Fallbacks seguros
  $urlDashboard = $safeRoute('client.dashboard', route('home'));
  $urlProfile   = $safeRoute('client.profile', $urlDashboard);
  $urlCatalog   = $safeRoute('client.products.index', route('products'));
  $urlCart      = $safeRoute('client.cart', route('cart'));
  $urlOrders    = $safeRoute('client.orders', route('home'));
  $urlPayments  = $safeRoute('client.payments', $urlDashboard);
  $urlPromos    = $safeRoute('client.promos', route('products'));

  // Si una ruta no existe, no queremos marcarla como activa
  $exists = fn($name) => Route::has($name);
@endphp

<nav class="space-y-2">

  {{-- INICIO --}}
  <a href="{{ $urlDashboard }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $cls('client.dashboard') }}">
    <span class="text-lg">🏠</span>
    <span>Inicio</span>
  </a>

  {{-- MI PERFIL --}}
  <a href="{{ $urlProfile }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $cls('client.profile') }}">
    <span class="text-lg">👤</span>
    <span>Mi Perfil</span>
  </a>

  {{-- CATÁLOGO --}}
  <a href="{{ $urlCatalog }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $exists('client.products.index') ? $cls('client.products.index') : 'text-gray-800 hover:bg-white hover:text-pink-600' }}">
    <span class="text-lg">🧩</span>
    <span>Catálogo</span>
  </a>

  {{-- MI CARRITO --}}
  <a href="{{ $urlCart }}"
     class="flex items-center justify-between px-5 py-3 rounded-2xl transition {{ $exists('client.cart') ? $cls('client.cart') : 'text-gray-800 hover:bg-white hover:text-pink-600' }}">
    <span class="flex items-center gap-3">
      <span class="text-lg">🛒</span>
      <span>Mi Carrito</span>
    </span>

    @if(($cartCount ?? 0) > 0)
      <span class="bg-pink-600 text-white text-xs rounded-full px-2 py-1 font-extrabold shadow">
        {{ $cartCount }}
      </span>
    @endif
  </a>

  {{-- MIS PEDIDOS --}}
  <a href="{{ $urlOrders }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $cls('client.orders') }}">
    <span class="text-lg">📦</span>
    <span>Mis Pedidos</span>
  </a>

  {{-- MÉTODOS DE PAGO --}}
  <a href="{{ $urlPayments }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $exists('client.payments') ? $cls('client.payments') : 'text-gray-800 hover:bg-white hover:text-pink-600' }}">
    <span class="text-lg">💳</span>
    <span>Métodos de Pago</span>
  </a>

  {{-- PROMOCIONES --}}
  <a href="{{ $urlPromos }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $exists('client.promos') ? $cls('client.promos') : 'text-gray-800 hover:bg-white hover:text-pink-600' }}">
    <span class="text-lg">🏷️</span>
    <span>Promociones</span>
  </a>

  {{-- CERRAR SESIÓN --}}
  <div class="pt-4 mt-4 border-t border-pink-200">
    <form method="POST" action="{{ route('logout') }}">
      @csrf

      <button type="submit"
        class="w-full text-left flex items-center gap-3 px-5 py-3 rounded-2xl text-gray-800 hover:bg-white hover:text-red-600 transition">
        <span class="text-lg">🚪</span>
        <span>Cerrar Sesión</span>
      </button>
    </form>
  </div>

</nav>
