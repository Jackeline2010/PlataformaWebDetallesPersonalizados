@extends('layouts.app')

@section('title', 'SandyDecor - Contáctenos')

@section('content')
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Contact Section -->
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-4xl px-4 2xl:px-0">
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-12">
                
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-pink-600 dark:text-pink-400 mb-4">
                        Contáctanos
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        ¿Tienes dudas sobre algún producto, tu pedido o necesitas ayuda? Completa el formulario y te responderemos lo antes posible.
                    </p>
                </div>

                <!-- Contact Form -->
                <form id="contact-form" class="space-y-6" novalidate>
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nombre" name="nombre"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-pink-400"
                            required>
                        <p class="text-red-500 text-sm mt-1 hidden" id="error-nombre">Por favor ingresa tu nombre.</p>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Correo electrónico <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-pink-400"
                            required placeholder="ejemplo@correo.com">
                        <p class="text-red-500 text-sm mt-1 hidden" id="error-email">Ingresa un correo electrónico válido.</p>
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Teléfono (opcional)
                        </label>
                        <input type="tel" id="telefono" name="telefono"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-pink-400"
                            placeholder="098-123-4567">
                        <p class="text-red-500 text-sm mt-1 hidden" id="error-telefono"></p>
                    </div>

                    <!-- Subject Field -->
                    <div>
                        <label for="asunto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Asunto <span class="text-red-500">*</span>
                        </label>
                        <select id="asunto" name="asunto"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-pink-400"
                            required>
                            <option value="">Selecciona un asunto</option>
                            <option value="consulta">Consulta de producto</option>
                            <option value="pedido">Estado de mi pedido</option>
                            <option value="soporte">Soporte y ayuda</option>
                            <option value="otro">Otro</option>
                        </select>
                        <p class="text-red-500 text-sm mt-1 hidden" id="error-asunto">Selecciona un asunto.</p>
                    </div>

                    <!-- Message Field -->
                    <div>
                        <label for="mensaje" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mensaje <span class="text-red-500">*</span>
                        </label>
                        <textarea id="mensaje" name="mensaje"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-pink-400 resize-none"
                            required rows="5" placeholder="Describe tu consulta o problema en detalle..."></textarea>
                        <p class="text-red-500 text-sm mt-1 hidden" id="error-mensaje">Por favor ingresa un mensaje.</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit" id="submit-btn"
                            class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="btn-text">Enviar Mensaje</span>
                            <span id="btn-loading" class="hidden">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Enviando...
                            </span>
                        </button>
                    </div>

                    <!-- Success/Error Messages -->
                    <div id="form-success" class="text-green-600 text-center hidden font-semibold bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                        ¡Gracias! Tu mensaje ha sido enviado con éxito.
                    </div>
                    <div id="form-error" class="text-red-600 text-center hidden font-semibold bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                        Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.
                    </div>
                </form>

                <!-- Direct Contact Information -->
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-pink-600 dark:text-pink-400 mb-4 text-center">
                            O contáctanos directamente:
                        </h2>
                        <div class="grid md:grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-gray-600 dark:text-gray-300 mb-2">
                                    <strong>📧 Email:</strong>
                                </div>
                                <a href="mailto:soporte@sandydecor.com" 
                                   class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    soporte@sandydecor.com
                                </a>
                            </div>
                            <div>
                                <div class="text-gray-600 dark:text-gray-300 mb-2">
                                    <strong>📞 Teléfono:</strong>
                                </div>
                                <a href="tel:0981234567" 
                                   class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    098-123-4567
                                </a>
                            </div>
                            <div>
                                <div class="text-gray-600 dark:text-gray-300 mb-2">
                                    <strong>🕒 Horario:</strong>
                                </div>
                                <span class="text-gray-600 dark:text-gray-300">
                                    Lun - Vie: 09:00 - 18:00
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Contact Form -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contact-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const successMsg = document.getElementById('form-success');
            const errorMsg = document.getElementById('form-error');
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Clear previous errors
                clearErrors();
                
                // Get form data
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                
                // Basic client-side validation
                if (!validateForm(data)) {
                    return;
                }
                
                // Show loading state
                setLoadingState(true);
                
                // Send AJAX request
                fetch('/contact/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess(data.message);
                        form.reset();
                    } else {
                        if (data.errors) {
                            showValidationErrors(data.errors);
                        } else {
                            showError(data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.');
                })
                .finally(() => {
                    setLoadingState(false);
                });
            });
            
            function validateForm(data) {
                let isValid = true;
                
                if (!data.nombre.trim()) {
                    showFieldError('nombre', 'Por favor ingresa tu nombre.');
                    isValid = false;
                }
                
                if (!data.email.trim()) {
                    showFieldError('email', 'Por favor ingresa tu correo electrónico.');
                    isValid = false;
                } else if (!isValidEmail(data.email)) {
                    showFieldError('email', 'Ingresa un correo electrónico válido.');
                    isValid = false;
                }
                
                if (!data.asunto) {
                    showFieldError('asunto', 'Selecciona un asunto.');
                    isValid = false;
                }
                
                if (!data.mensaje.trim()) {
                    showFieldError('mensaje', 'Por favor ingresa un mensaje.');
                    isValid = false;
                }
                
                return isValid;
            }
            
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            
            function showFieldError(fieldName, message) {
                const errorElement = document.getElementById(`error-${fieldName}`);
                const inputElement = document.getElementById(fieldName);
                
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.classList.remove('hidden');
                }
                
                if (inputElement) {
                    inputElement.classList.add('border-red-500');
                }
            }
            
            function clearErrors() {
                const errorElements = document.querySelectorAll('[id^="error-"]');
                errorElements.forEach(element => {
                    element.classList.add('hidden');
                });
                
                const inputElements = form.querySelectorAll('input, select, textarea');
                inputElements.forEach(element => {
                    element.classList.remove('border-red-500');
                });
                
                successMsg.classList.add('hidden');
                errorMsg.classList.add('hidden');
            }
            
            function showValidationErrors(errors) {
                Object.keys(errors).forEach(field => {
                    showFieldError(field, errors[field][0]);
                });
            }
            
            function showSuccess(message) {
                successMsg.textContent = message;
                successMsg.classList.remove('hidden');
                successMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            function showError(message) {
                errorMsg.textContent = message;
                errorMsg.classList.remove('hidden');
                errorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            function setLoadingState(loading) {
                submitBtn.disabled = loading;
                
                if (loading) {
                    btnText.classList.add('hidden');
                    btnLoading.classList.remove('hidden');
                } else {
                    btnText.classList.remove('hidden');
                    btnLoading.classList.add('hidden');
                }
            }
        });
    </script>
@endsection
