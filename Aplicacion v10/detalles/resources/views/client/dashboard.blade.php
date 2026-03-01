@extends('layouts.client')

@section('title', 'Mi Cuenta | SandyDecor')

@section('content')
@php
  use Illuminate\Support\Facades\Route;

  $r = fn($name) => Route::has($name) ? route($name) : null;

  // Fallbacks seguros (si aún no existen rutas del cliente)
  $urlOrders      = $r('client.orders')      ?? route('home');
  $urlOrderShow   = fn($id) => (Route::has('client.orders.show') ? route('client.orders.show', $id) : $urlOrders);

  $urlCatalog     = $r('client.catalog')     ?? route('products');
  $urlCart        = $r('client.cart')        ?? route('cart');
  $urlPromos      = $r('client.promos')      ?? route('products');

  $activeOrdersCount = isset($orders)
    ? $orders->whereIn('estado', ['ING','PEN','PRO'])->count()
    : 0;

  $points = $points ?? 0;
  $cartCountLocal = $cartCount ?? 0;
@endphp

<div class="w-full min-w-0 space-y-6">

  {{-- Cards superiores --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

    {{-- Saludo --}}
    <div class="bg-white/80 border border-pink-100 rounded-3xl p-5 shadow-sm">
      <p class="text-2xl font-extrabold text-gray-900">
        Hola, {{ auth()->user()->name }} 👋
      </p>
      <p class="text-sm text-gray-500 mt-1">
        Bienvenida a <span class="text-pink-600 font-semibold">SandyDecor</span>
      </p>
    </div>

    {{-- Pedidos Activos --}}
    <div class="bg-white/80 border border-pink-100 rounded-3xl p-5 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-sm text-gray-500">Pedidos Activos</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $activeOrdersCount }}</p>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-xl">
        📦
      </div>
    </div>

    {{-- Puntos --}}
    <div class="bg-white/80 border border-pink-100 rounded-3xl p-5 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-sm text-gray-500">Puntos</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1">
          {{ $points }} <span class="text-base font-semibold text-gray-500">pts</span>
        </p>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-xl">
        ⭐
      </div>
    </div>

  </div>

  {{-- Cuerpo: pedidos + right column --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start w-full min-w-0">

    {{-- Pedidos recientes --}}
    <div class="lg:col-span-2 bg-white/80 border border-pink-100 rounded-3xl p-5 shadow-sm min-w-0">
      <div class="flex items-center justify-between mb-4 gap-3">
        <h2 class="text-lg font-extrabold text-gray-900">Pedidos Recientes</h2>

        <a href="{{ $urlOrders }}"
           class="shrink-0 text-sm font-semibold text-pink-600 hover:text-pink-700">
          Ver todos
        </a>
      </div>

      @if(isset($orders) && $orders->count())
        <div class="space-y-4">

          @foreach($orders as $order)
            @php
              $badge = match($order->estado) {
                'ING' => ['Ingresado',  'bg-gray-100 text-gray-700'],
                'PEN' => ['Pendiente',  'bg-orange-100 text-orange-700'],
                'PRO' => ['En proceso', 'bg-yellow-100 text-yellow-800'],
                'COM' => ['Completado', 'bg-green-100 text-green-700'],
                'CAN' => ['Cancelado',  'bg-red-100 text-red-700'],
                default => ['Desconocido','bg-gray-100 text-gray-700'],
              };
            @endphp

            <div class="bg-white border border-pink-100 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
              <div class="flex items-center gap-3 min-w-0">
                <div class="w-14 h-14 rounded-2xl bg-pink-50 border border-pink-100 flex items-center justify-center shrink-0">
                  🧾
                </div>

                <div class="min-w-0">
                  <p class="font-extrabold text-gray-900 truncate">
                    Pedido #{{ $order->numero_orden ?? $order->id }}
                  </p>
                  <p class="text-sm text-gray-500 mt-0.5">
                    {{ optional($order->fpedido)->format('d M Y') ?? $order->created_at->format('d M Y') }}
                  </p>
                </div>
              </div>

              <div class="flex flex-wrap items-center gap-3 sm:justify-end">
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badge[1] }}">
                  {{ $badge[0] }}
                </span>

                <span class="font-extrabold text-gray-900">
                  ${{ number_format((float)$order->total, 2) }}
                </span>

                <a href="{{ $urlOrderShow($order->id) }}"
                   class="inline-flex rounded-xl border border-pink-200 bg-pink-50 px-4 py-2 text-sm font-bold text-pink-700 hover:bg-pink-100">
                  Ver detalle
                </a>
              </div>
            </div>
          @endforeach

        </div>
      @else
        <div class="bg-white border border-pink-100 rounded-2xl p-6 text-center">
          <p class="text-gray-500">No tienes pedidos aún.</p>

          <a href="{{ $urlCatalog }}"
             class="inline-flex mt-4 rounded-xl bg-pink-600 px-5 py-2.5 text-sm font-extrabold text-white hover:bg-pink-700">
            Ver productos
          </a>
        </div>
      @endif
    </div>

    {{-- Columna derecha --}}
    <div class="space-y-6 min-w-0">

      {{-- Mi carrito --}}
      <div class="bg-white/80 border border-pink-100 rounded-3xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-extrabold text-gray-900">Mi Carrito</h3>
          <span class="text-xl">🛒</span>
        </div>

        <p class="text-sm text-gray-500 mt-1">{{ $cartCountLocal }} productos</p>

        <a href="{{ $urlCart }}"
           class="inline-flex w-full justify-center mt-4 rounded-xl bg-pink-600 px-5 py-2.5 text-sm font-extrabold text-white hover:bg-pink-700">
          Ver carrito
        </a>
      </div>

      {{-- Promociones --}}
      <div class="bg-white/80 border border-pink-100 rounded-3xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-extrabold text-gray-900">Promociones</h3>
          <span class="text-xl">🏷️</span>
        </div>

        <div class="mt-4 bg-pink-50 border border-pink-100 rounded-2xl p-4">
          <p class="text-pink-700 font-extrabold text-xl">20% Descuento</p>
          <p class="text-gray-600 text-sm mt-1">Bodas y Cumpleaños</p>

          <a href="{{ $urlPromos }}"
             class="inline-flex mt-3 rounded-xl bg-pink-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-pink-700">
            Ver más
          </a>
        </div>
      </div>

      {{-- Envío --}}
      <div class="bg-white/80 border border-pink-100 rounded-3xl p-5 shadow-sm">
        <p class="text-2xl font-extrabold text-orange-600">Envío Gratis</p>
        <p class="text-gray-600 mt-1">Desde $300</p>
      </div>

    </div>
  </div>

</div>
@endsection
