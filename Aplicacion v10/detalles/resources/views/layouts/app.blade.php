<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mi Cuenta | Sandy Decor')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Flowbite --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet"/>

    @stack('styles')
</head>

<body class="bg-[#FFF4F8] text-gray-800 overflow-x-hidden">

    {{-- Navbar cliente --}}
    @include('client.partials.navigation')

    {{-- IMPORTANTE: sin max-w-screen-xl para que NO se centre/distorsione --}}
    <main class="w-full px-4 py-6">
        @yield('content')
    </main>

    {{-- Flowbite JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    @stack('scripts')
</body>
</html>
