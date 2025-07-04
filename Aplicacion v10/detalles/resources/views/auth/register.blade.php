<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ingreso de Clientes')</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet"/>
</head>

<body class="bg-gray-100 mt-20 max-1180:px-5 max-md:mt-12">
    <!-- Form Container -->
    <div
        class="bg-white m-auto w-full max-w-[870px] rounded-xl border border-zinc-200 p-12 px-[90px] max-md:px-6 max-md:py-6 max-sm:border-none max-sm:p-0">
        <form class="space-y-6" method="POST" action="{{ route('register') }}">
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
            @csrf
            <div>
                <label for="name"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Nombre:</label>
                <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl text-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('name') is-invalid @enderror"
                    placeholder="Primer nombre" required />
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div>
                <label for="apellido"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Apellido:</label>
                <input type="text" name="lastname" id="apellido"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl text-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('lastname') is-invalid @enderror"
                    placeholder="Apellido paterno" required />
                     @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div>
                <label for="email"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Correo:</label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl text-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('email') is-invalid @enderror"
                    placeholder="nombre@ejemplo.com" required />
                     @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div>
                <label for="password"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xl rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-whiteb @error('password') is-invalid @enderror"
                    required />
                     @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div>
                <label for="password-confirm"
                    class="block mb-3 text-xl font-medium text-gray-900 dark:text-white">Confirmar contraseña:</label>
                <input type="password" name="password_confirmation" id="password-confirm" placeholder="••••••••"
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
                        class="ms-2 text-xl font-medium text-gray-600 dark:text-gray-300">Estoy de acuerdo con los términos y condiciones.</label><button data-modal-target="default-modal" data-modal-toggle="default-modal" class="ms-2 block text-indigo-500 hover:underline focus:ring-blue-300 rounded-lg text-xl px-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Haga clic aquí</button>
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
    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Términos y condiciones
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="default-modal" type="button" class="text-white bg-pink-600 hover:bg-indigo-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
