@extends('layouts.app')

@section('title', 'SandyDecor - Acerca de nosotros')

@section('content')
    <!-- About Section -->
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-4xl px-4 2xl:px-0">
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-12">

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-pink-600 dark:text-pink-400 mb-4">
                        Acerca de Sandy Decor
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Tu tienda de detalles favorita en Loja, Ecuador
                    </p>
                </div>

                <!-- About Content -->
                <div class="space-y-8">

                    <!-- Introduction -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-pink-600 dark:text-pink-400 mb-4">
                            ¿Quiénes somos?
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            Sandy Decor es una tienda especializada en detalles y regalos ubicada en el corazón de Loja, Ecuador.
                            Nos dedicamos a ofrecer productos únicos y de calidad que hacen especiales tus momentos más importantes.
                            Desde regalos para ocasiones especiales hasta detalles para el hogar, tenemos todo lo que necesitas
                            para expresar tus sentimientos de la mejor manera.
                        </p>
                    </div>

                    <!-- Location and Delivery -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-pink-600 dark:text-pink-400 mb-3">
                                📍 Nuestra Ubicación
                            </h3>
                            <p class="text-gray-700 dark:text-gray-300">
                                Estamos ubicados en la hermosa ciudad de Loja, Ecuador, un lugar conocido por su rica cultura
                                y tradiciones. Nuestra tienda física te espera para que puedas ver y tocar nuestros productos
                                antes de llevarlos a casa.
                            </p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-pink-600 dark:text-pink-400 mb-3">
                                🚚 Entrega Nacional
                            </h3>
                            <p class="text-gray-700 dark:text-gray-300">
                                Realizamos entregas en todo el territorio ecuatoriano. Ya sea que estés en Quito, Guayaquil
                                o cualquier otra ciudad, nos aseguramos de que tus pedidos lleguen de manera segura y oportuna.
                                ¡Tu detalle favorito está a solo un clic de distancia!
                            </p>
                        </div>
                    </div>

                    <!-- Mission -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-pink-600 dark:text-pink-400 mb-4">
                            Nuestra Misión
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            En Sandy Decor, nuestra misión es hacer que cada momento especial sea inolvidable.
                            Nos esforzamos por ofrecer productos de la más alta calidad, con un servicio personalizado
                            que haga sentir a nuestros clientes como parte de nuestra familia. Creemos que los detalles
                            marcan la diferencia, y estamos aquí para ayudarte a encontrar el regalo perfecto para
                            expresar tus emociones.
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-pink-600 dark:text-pink-400 mb-4 text-center">
                            Contáctanos
                        </h2>
                        <div class="grid md:grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-gray-600 dark:text-gray-300 mb-2">
                                    <strong>📧 Email:</strong>
                                </div>
                                <a href="mailto:info@sandydecor.com"
                                   class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    info@sandydecor.com
                                </a>
                            </div>
                            <div>
                                <div class="text-gray-600 dark:text-gray-300 mb-2">
                                    <strong>📞 Teléfono:</strong>
                                </div>
                                <a href="tel:072563847"
                                   class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    07-256-3847
                                </a>
                            </div>
                            <div>
                                <div class="text-gray-600 dark:text-gray-300 mb-2">
                                    <strong>📍 Dirección:</strong>
                                </div>
                                <span class="text-gray-600 dark:text-gray-300">
                                    Loja, Ecuador
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
