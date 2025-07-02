<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ingreso de Clientes')</title>
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
                                d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                </li>
                <li>
                    <h1 class="ms-4 text-xl font-bold text-gray-900 dark:text-white">Conviértete en usuario</h1>
                </li>
            </ul>
            <p class="text-xl text-gray-400 dark:text-white">Si eres nuevo en nuestra tienda, nos complace tenerte como miembro.</p>
            <div>
                <label for="name"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Nombre:</label>
                <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl text-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Primer nombre" required />
            </div>
            <div>
                <label for="apellido"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Apellido:</label>
                <input type="text" name="apellido" id="apellido"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl text-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Apellido paterno" required />
            </div>
            <div>
                <label for="email"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Correo:</label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl text-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="nombre@ejemplo.com" required />
            </div>
            <div>
                <label for="password"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xl rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required />
            </div>
            <div>
                <label for="repeatpassword"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Confirmar contraseña:</label>
                <input type="password" name="repeatpassword" id="repeatpassword" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xl rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required />
            </div>
            <div class="flex items-start">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" type="checkbox" value=""
                            class="w-5 h-6 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                            required />
                    </div>
                    <label for="terms"
                        class="ms-2 text-xl font-medium text-gray-600 dark:text-gray-300">Estoy de acuerdo con los términos y condiciones.</label><a href="#" class="ms-2 text-xl text-indigo-500 hover:underline dark:text-blue-500">Haga clic aquí</a>
                </div>
                
            </div>
            <button type="submit"
                class="text-white bg-pink-600 hover:bg-indigo-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xl px-24 py-3.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar usuario</button>
            <div class="text-xl font-medium text-gray-600 dark:text-gray-300">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-indigo-500 hover:underline dark:text-white-500">Iniciar sesión</a>
            </div>
        </form>
    </div>
    <p class="mb-4 mt-8 text-center text-xl text-gray-700">© 2025 <strong>Sandy Decor</strong>. Todos los derechos
        reservados.
    </p>

</body>

</html>
