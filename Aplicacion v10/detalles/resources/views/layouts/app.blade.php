<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mi Cuenta | Sandy Decor')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ✅ VITE: CSS + JS (usa app.css porque es lo que estás compilando ahora) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Flowbite --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet"/>

    @stack('styles')
</head>

<body class="bg-gray-100">

    {{-- Navbar cliente --}}
    @include('client.partials.navigation')

    <div class="max-w-screen-xl mx-auto px-4 py-6">
        @yield('content')
    </div>

    {{-- Flowbite JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    @stack('scripts')
</body>
</html>
