@extends('layouts.app')

@section('title', 'SandyDecor - Contáctenos')

@section('content')
    <!-- Features Section -->
    <main class="flex-1 w-full flex justify-center items-center">
        <section class="bg-white rounded-lg shadow-lg px-8 py-10 w-full max-w-2xl mt-8 mb-8">
            <div class="text-center">
                <h1 class="text-2xl  font-bold text-pink-600 mb-4">Contáctanos</h1>
                <div class="text-xl text-gray-700">¿Tienes dudas sobre algún producto, tu pedido o necesitas ayuda? Completa el formulario y te responderemos lo antes posible.</div>
            </div>
            <br>
            <br>
            <form id="contact-form" novalidate>
                <div class="mb-6">
                    <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <p class="text-red-500 text-sm mt-2 hidden" id="error-nombre">Por favor ingresa tu nombre.</p>
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Correo electrónico</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required placeholder="ejemplo@correo.com">
                    <p class="text-red-500 text-sm mt-2 hidden" id="error-email">Ingresa un correo electrónico válido.</p>
                </div>

                <div class="mb-6">
                    <label for="telefono" class="block text-gray-700 font-semibold mb-2">Teléfono (opcional)</label>
                    <input type="tel" id="telefono" name="telefono"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label for="asunto" class="block text-gray-700 font-semibold mb-2">Asunto</label>
                    <select id="asunto" name="asunto"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Selecciona un asunto</option>
                        <option value="consulta">Consulta de producto</option>
                        <option value="pedido">Estado de mi pedido</option>
                        <option value="soporte">Soporte y ayuda</option>
                        <option value="otro">Otro</option>
                    </select>
                    <p class="text-red-500 text-sm mt-2 hidden" id="error-asunto">Selecciona un asunto.</p>
                </div>

                <div class="mb-6">
                    <label for="mensaje" class="block text-gray-700 font-semibold mb-2">Mensaje</label>
                    <textarea id="mensaje" name="mensaje"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                        required rows="4" placeholder="Describe tu consulta o problema"></textarea>
                    <p class="text-red-500 text-sm mt-2 hidden" id="error-mensaje">Por favor ingresa un mensaje.</p>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-indigo-500 hover:bg-pink-600 text-white font-bold py-2 px-10 rounded transition duration-200">
                        Enviar Mensaje
                    </button>
                </div>
                <div id="form-success" class="text-green-600 mt-6 text-center hidden font-semibold">
                    ¡Gracias! Tu mensaje ha sido enviado con éxito.
                </div>
            </form>
            <br>
            <br>
            <hr>
            <div class="text-xl p-4 text-center">
                <h2 class="font-bold text-pink-600 mb-4">O contáctanos directamente:</h2>
                <p class="text-gray-700 mb-1">Correo: <a href="mailto:soporte@tienda.com"
                        class="text-indigo-500 hover:underline">soporte@sandydecor.com</a></p>
                <p class="text-gray-700 mb-1">Teléfono: <a href="tel:5551234567"
                        class="text-indigo-500 hover:underline">098-123-4567</a></p>
                <p class="text-gray-600 text-xl">Horario de atención: <strong>Lunes a Viernes de 09:00 a 18:00</strong></p>
            </div>
        </section>


    </main>
    <br>
@endsection
