<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mi Proyecto Laravel')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <!-- Header -->
    @include('partials.header')

    <!-- Menu -->
    @include('partials.menu')

    <!-- Main Content -->
    <main class="container mx-auto py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>