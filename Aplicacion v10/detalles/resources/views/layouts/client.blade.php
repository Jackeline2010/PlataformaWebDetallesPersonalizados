<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','SandyDecor')</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>

<body class="bg-[#FFF4F8] text-gray-800 min-h-screen">

  {{-- TOPBAR --}}
  <header class="sticky top-0 z-50 bg-white/70 backdrop-blur border-b border-pink-100">
    <div class="w-full px-4 sm:px-6 py-3 flex items-center gap-4">

      {{-- Logo --}}
      <a href="{{ route('client.dashboard') }}" class="text-pink-600 text-xl font-extrabold tracking-wide">
        SandyDecor
      </a>

      {{-- Buscador --}}
      <form action="{{ \Illuminate\Support\Facades\Route::has('client.catalog') ? route('client.catalog') : route('products') }}"
            method="GET"
            class="flex-1 max-w-2xl">
        <div class="relative">
          <span class="absolute left-3 top-2.5 text-gray-400">🔎</span>
          <input
            name="q"
            value="{{ request('q') }}"
            class="w-full rounded-full bg-pink-50 border border-pink-100 pl-10 pr-4 py-2 outline-none focus:ring-2 focus:ring-pink-200"
            placeholder="Buscar productos, promociones..."
          >
        </div>
      </form>

      {{-- Acciones --}}
      <div class="flex items-center gap-6 ml-auto">

        {{-- Carrito --}}
        <a href="{{ \Illuminate\Support\Facades\Route::has('client.cart') ? route('client.cart') : route('cart') }}"
           class="relative w-10 h-10 rounded-xl hover:bg-pink-50 flex items-center justify-center">
          🛒
          @if(($cartCount ?? 0) > 0)
            <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-xs rounded-full px-1.5">
              {{ $cartCount }}
            </span>
          @endif
        </a>

        {{-- Avatar --}}
        <div class="flex items-center gap-3 ml-2">
  <div class="w-10 h-10 rounded-full bg-pink-600 text-white flex items-center justify-center font-extrabold">
    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
  </div>

         <div class="hidden md:block leading-tight">
         <p class="text-xs text-gray-500">Hola</p>
          <p class="font-semibold text-gray-800">
      {{ auth()->user()->name }}
         </p>
        </div>
        </div>

      </div>

    </div>
  </header>

  {{-- MAIN --}}
  <main class="bg-[#FFF3F6] w-full">
    <div class="w-full px-4 sm:px-6 py-6">
      {{-- En desktop: sidebar fijo + contenido flexible --}}
      <div class="flex flex-col lg:flex-row gap-6 items-start">

        {{-- Sidebar --}}
        <aside class="w-full lg:w-[280px] shrink-0">
          <div class="bg-[#E59A9A] rounded-3xl p-5 shadow-sm lg:sticky lg:top-24">
            @include('client.partials.sidebar')
          </div>
        </aside>

        {{-- Contenido --}}
        <section class="flex-1 min-w-0 w-full">
          @yield('content')
        </section>

      </div>
    </div>
  </main>

  @stack('scripts')
</body>
</html>
