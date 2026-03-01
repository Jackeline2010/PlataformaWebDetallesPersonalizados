@php
  use Illuminate\Support\Facades\Route;

  $current = request()->route()?->getName();

  // Verifica si estás en una ruta (para resaltar)
  $is = fn($name) => $current === $name || str_starts_with((string)$current, $name.'.');

  // Clase del item activo / inactivo
  $cls = fn($name) => $is($name)
      ? 'bg-white text-pink-600 font-extrabold shadow-sm'
      : 'text-gray-800 hover:bg-white hover:text-pink-600';

  // Helper: si existe la ruta -> route(), si no -> fallback
  $safeRoute = function(string $name, string $fallback) {
      return Route::has($name) ? route($name) : $fallback;
  };

  // Fallbacks seguros
  $urlDashboard = $safeRoute('client.dashboard', route('home'));
  $urlCatalog   = $safeRoute('client.catalog', route('products'));
  $urlOrders    = $safeRoute('client.orders', route('home'));
  $urlCart      = $safeRoute('client.cart', route('cart'));

  $urlProfile   = $safeRoute('client.profile', $urlDashboard);

  $urlAddresses = $safeRoute('client.addresses', $urlDashboard);
  $urlPayments  = $safeRoute('client.payments', $urlDashboard);
  $urlPromos    = $safeRoute('client.promos', route('products'));

  // Si una ruta NO existe, no queremos marcarla como activa nunca
  $exists = fn($name) => Route::has($name);
@endphp

<nav class="space-y-2">

  <a href="{{ $urlDashboard }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $cls('client.dashboard') }}">
    <span class="text-lg">🏠</span> <span>Inicio</span>
  </a>

  <a href="{{ $urlCatalog }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $exists('client.catalog') ? $cls('client.catalog') : 'text-gray-800 hover:bg-white hover:text-pink-600' }}">
    <span class="text-lg">🧩</span> <span>Catálogo</span>
  </a>

  <a href="{{ $urlOrders }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $cls('client.orders') }}">
    <span class="text-lg">📦</span> <span>Mis Pedidos</span>
  </a>

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

  <a href="{{ $urlAddresses }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $exists('client.addresses') ? $cls('client.addresses') : 'text-gray-800 hover:bg-white hover:text-pink-600' }}">
    <span class="text-lg">📍</span>
    <span>Direcciones</span>
  </a>

  <a href="{{ $urlPayments }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $exists('client.payments') ? $cls('client.payments') : 'text-gray-800 hover:bg-white hover:text-pink-600' }}">
    <span class="text-lg">💳</span>
    <span>Métodos de Pago</span>
  </a>

  <a href="{{ $urlPromos }}"
     class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $exists('client.promos') ? $cls('client.promos') : 'text-gray-800 hover:bg-white hover:text-pink-600' }}">
    <span class="text-lg">🏷️</span>
    <span>Promociones</span>
  </a>

<a href="{{ $urlProfile }}"
   class="flex items-center gap-3 px-5 py-3 rounded-2xl transition {{ $cls('client.profile') }}">
  <span class="text-lg">👤</span>
  <span>Mi Perfil</span>
</a>

  <div class="pt-4 mt-4 border-t border-pink-200">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit"
        class="w-full text-left flex items-center gap-3 px-5 py-3 rounded-2xl text-gray-800 hover:bg-white hover:text-red-600 transition">
        <span class="text-lg">🚪</span> <span>Cerrar Sesión</span>
      </button>
    </form>
  </div>

</nav>
