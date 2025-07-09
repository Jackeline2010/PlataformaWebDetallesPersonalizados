<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SandyDecor - Detalles y más')</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <!-- Header -->
    @include('partials.admin.navigation')

    <!-- Menu -->
    @include('partials.admin.sidebar')

    <!-- Main Content -->
    <main>
        <div class="p-4 sm:ml-64">
            <div class="p-4 mt-14">
                {{ $slot }}


            </div>
        </div>
        <div>
            <br>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </main>

    <!-- Footer -->
    @include('partials.admin.footer')
</body>

</html>
