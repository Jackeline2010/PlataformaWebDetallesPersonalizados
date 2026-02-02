<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="font-[Inter] bg-[#FFF0F5]">

<header class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-pink-100 via-pink-50 to-pink-100
px-6 py-4 flex items-center justify-between border-b-2 border-pink-300 shadow-md">

{{-- IZQUIERDA --}}
<div class="flex items-center gap-3">

<button id="toggleSidebar"
class="w-9 h-9 rounded-lg bg-white/70 hover:bg-white shadow-sm flex items-center justify-center text-pink-500">
<i id="menuIcon" class="fas fa-bars text-sm"></i>
</button>

<img src="{{ asset('images/Logo-Transparente.png') }}" class="h-10">

<span class="text-lg font-extrabold text-pink-500">SandyDecor</span>

</div>

{{-- BUSCADOR --}}
<div class="hidden md:flex flex-1 px-6">
<div class="w-full max-w-2xl relative">
<i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-pink-300"></i>
<input type="text" placeholder="Buscar productos, pedidos, clientes..."
class="w-full pl-11 pr-4 py-2.5 rounded-full bg-white/80 border border-pink-200
focus:outline-none focus:ring-2 focus:ring-pink-300 text-sm">
</div>
</div>

{{-- DERECHA --}}
<div class="flex items-center gap-3">

{{-- CARRITO --}}
<button class="relative w-10 h-10 rounded-full bg-white/70 hover:bg-white shadow-sm flex items-center justify-center text-pink-500">
    <i class="fas fa-shopping-cart"></i>

    @if(($pendingOrders ?? 0) > 0)
        <span class="absolute -top-1 -right-1 bg-pink-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
            {{ $pendingOrders }}
        </span>
    @endif
</button>

{{-- NOTIFICACIONES --}}
<button class="relative w-10 h-10 rounded-full bg-white/70 hover:bg-white shadow-sm flex items-center justify-center text-pink-500">
    <i class="fas fa-bell"></i>

    @if(($newOrdersToday ?? 0) > 0)
        <span class="absolute -top-1 -right-1 bg-pink-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
            {{ $newOrdersToday }}
        </span>
    @endif
</button>


{{-- USUARIO --}}
<div class="relative">
<button id="userMenuBtn" class="flex items-center gap-2">

<span class="hidden sm:inline text-sm text-gray-600">
{{ Auth::user()->name ?? 'Administrador' }}
</span>

<div class="w-10 h-10 rounded-full bg-pink-400 text-white flex items-center justify-center font-bold">
{{ strtoupper(substr(Auth::user()->name ?? 'A',0,1)) }}
</div>

<i class="fas fa-chevron-down text-xs"></i>
</button>

<div id="userMenu" class="hidden absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-lg">

<a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm hover:bg-pink-50">Perfil</a>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
Cerrar sesión
</button>
</form>

</div>
</div>

</div>

</header>

<div class="pt-24 min-h-screen">

@include('layouts.sidebar')

<main id="mainContent" class="transition-all duration-200 ml-64 px-6 py-4">
    {{-- ALERTA DE CONFIRMACIÓN --}}

@if(session('success'))
<div id="flashSuccess"
     class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-sm">
    <i class="fas fa-circle-check mt-0.5"></i>

    <div class="flex-1 text-sm font-medium">
        {{ session('success') }}
    </div>

    <button type="button"
            onclick="document.getElementById('flashSuccess').remove()"
            class="text-green-700 hover:text-green-900">
        <i class="fas fa-xmark"></i>
    </button>
</div>
@endif

@if(session('error'))
<div id="flashError"
     class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
    <i class="fas fa-triangle-exclamation mt-0.5"></i>

    <div class="flex-1 text-sm font-medium">
        {{ session('error') }}
    </div>

    <button type="button"
            onclick="document.getElementById('flashError').remove()"
            class="text-red-700 hover:text-red-900">
        <i class="fas fa-xmark"></i>
    </button>
</div>
@endif

@yield('content')
</main>

</div>

<footer class="text-center text-sm text-gray-500 py-4">
© {{ date('Y') }} Sandy Decor
</footer>

<script>
document.addEventListener('DOMContentLoaded',()=>{

const sidebar=document.getElementById('admin-sidebar');
const main=document.getElementById('mainContent');
const btn=document.getElementById('toggleSidebar');
const userBtn=document.getElementById('userMenuBtn');
const userMenu=document.getElementById('userMenu');

userBtn?.addEventListener('click',e=>{
e.stopPropagation();
userMenu.classList.toggle('hidden');
});

document.addEventListener('click',()=>{
userMenu?.classList.add('hidden');
});

let collapsed=false;

btn?.addEventListener('click',()=>{

collapsed=!collapsed;

if(collapsed){
sidebar.classList.replace('w-64','w-20');
main.classList.replace('ml-64','ml-20');
document.querySelectorAll('.sidebar-text').forEach(e=>e.classList.add('hidden'));
document.querySelectorAll('.sidebar-mini').forEach(e=>e.classList.remove('hidden'));
document.querySelectorAll('.sidebar-link').forEach(e=>e.classList.add('justify-center'));
}else{
sidebar.classList.replace('w-20','w-64');
main.classList.replace('ml-20','ml-64');
document.querySelectorAll('.sidebar-text').forEach(e=>e.classList.remove('hidden'));
document.querySelectorAll('.sidebar-mini').forEach(e=>e.classList.add('hidden'));
document.querySelectorAll('.sidebar-link').forEach(e=>e.classList.remove('justify-center'));
}

});

});
</script>

</body>
</html>
