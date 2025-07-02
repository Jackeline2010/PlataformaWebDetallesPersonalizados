<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Recuperar contraseña')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 mt-20 max-1180:px-5 max-md:mt-12">
    <!-- Form Container -->
    <div
        class="bg-white m-auto w-full max-w-[870px] rounded-xl border border-zinc-200 p-12 px-[90px] max-md:px-6 max-md:py-6 max-sm:border-none max-sm:p-0">
        <form class="space-y-6" action="#">
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                <li>
                    <div class="flex items-center justify-center h-14 w-14 rounded-md bg-indigo-500 text-white">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                        </svg>
                    </div>
                </li>
                <li>
                    <h1 class="ms-4 text-xl font-bold text-gray-900 dark:text-white">Recuperar constraseña</h1>
                </li>
            </ul>
            <p class="text-xl text-gray-400 dark:text-white">Si olvidó su contraseña, recupérela ingresando su dirección de correo electrónico.</p>

            <div>
                <label for="email"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Correo:</label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl text-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="nombre@ejemplo.com" required />
            </div>

            <button type="submit"
                class="text-white bg-pink-600 hover:bg-indigo-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xl px-24 py-3.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Recuperar
                contraseña</button>
            <div class="text-xl font-medium text-gray-600 dark:text-gray-300">
                ¿Volver al inicio de sesión? <a href="{{ route('login') }}" class="text-indigo-500 hover:underline dark:text-white-500">Iniciar sesión</a>
            </div>
        </form>
    </div>
    <p class="mb-4 mt-8 text-center text-xl text-gray-700">© 2025 <strong>Sandy Decor</strong>. Todos los derechos reservados.
    </p>

</body>

</html>
