@extends('layouts.app')

@section('title', 'SandyDecor - Términos y Condiciones')

@section('content')
    <!-- Terms and Conditions Section -->
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-4xl px-4 2xl:px-0">
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-12">
                
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-pink-600 dark:text-pink-400 mb-4">
                        Términos y Condiciones
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Última actualización: <strong>01 de enero de 2025</strong>
                    </p>
                </div>

                <!-- Content -->
                <div class="prose prose-gray max-w-none dark:prose-invert">
                    
                    <!-- Section 1 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            1. Definiciones
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-3">
                            A los efectos de los presentes Términos y Condiciones, se entenderá por:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300 ml-4">
                            <li><strong>Tienda</strong> o <strong>Nosotros</strong>: SandyDecor, con domicilio en la ciudad de Loja, inscrita en el Servicio de Rentas Internas - SRI con RUC 1402452014001.</li>
                            <li><strong>Cliente</strong>: Persona física o jurídica que contrata los servicios mediante pedido a través de la página web.</li>
                            <li><strong>Servicio</strong>: Venta de regalos seleccionados y entrega a domicilio.</li>
                            <li><strong>Productos</strong>: Artículos ofrecidos para la venta a través del sitio web.</li>
                        </ul>
                    </section>

                    <!-- Section 2 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            2. Alcance de los Términos
                        </h2>
                        <div class="text-gray-600 dark:text-gray-300 space-y-3">
                            <p>Los presentes Términos y Condiciones regulan la relación contractual entre la Tienda y el Cliente derivada de la compra realizada a través del sitio web.</p>
                            <p>Al realizar un pedido, el Cliente declara haber leído y aceptado expresamente los presentes Términos y Condiciones.</p>
                        </div>
                    </section>

                    <!-- Section 3 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            3. Proceso de Compra
                        </h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300 ml-4">
                            <li><strong>Selección de Productos</strong>: Los productos disponibles, sus descripciones y precios se muestran en el sitio web.</li>
                            <li><strong>Formalización del Pedido</strong>: El proceso de compra implica:
                                <ol class="list-decimal list-inside ml-6 mt-2 space-y-1">
                                    <li>Selección de productos y cantidades</li>
                                    <li>Especificación de datos de envío y facturación</li>
                                    <li>Confirmación y pago</li>
                                </ol>
                            </li>
                            <li><strong>Confirmación</strong>: La Tienda enviará un correo electrónico confirmando la recepción del pedido.</li>
                            <li><strong>Precios</strong>: Todos los precios incluyen IVA y se indican en la moneda correspondiente. Los gastos de envío se calcularán según el destino y se mostrarán antes del pago.</li>
                        </ul>
                    </section>

                    <!-- Section 4 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            4. Plazos y Entregas
                        </h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300 ml-4">
                            <li><strong>Disponibilidad</strong>: Los productos están sujetos a disponibilidad. En caso de agotamiento, informaremos al Cliente para ofrecer alternativas o cancelación.</li>
                            <li><strong>Tiempo de Entrega</strong>: Los pedidos se entregarán en un plazo máximo de 2 días hábiles desde la confirmación del pago.</li>
                            <li><strong>Área de Cobertura</strong>: El Servicio está disponible principalmente en la ciudad de Loja y la provincia de Loja. Para otras zonas, consultar disponibilidad.</li>
                            <li><strong>Recepción</strong>: Es responsabilidad del Cliente asegurar que alguien reciba el pedido en la dirección indicada. No nos hacemos responsables por errores en los datos proporcionados.</li>
                        </ul>
                    </section>

                    <!-- Section 5 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            5. Cancelaciones y Devoluciones
                        </h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300 ml-4">
                            <li><strong>Cancelaciones</strong>: Los pedidos pueden cancelarse sin costo hasta 6 horas antes de la fecha de envío.</li>
                            <li><strong>Devoluciones</strong>: Aceptamos devoluciones de productos defectuosos o que no coincidan con lo pedido dentro de 2 días desde la recepción, previa comunicación.</li>
                            <li><strong>Reembolsos</strong>: Los reembolsos se realizarán mediante el mismo método de pago utilizado, en un plazo máximo de 5 días hábiles.</li>
                            <li><strong>Productos Personalizados</strong>: No aceptamos devoluciones de productos personalizados a menos que presenten defectos.</li>
                        </ul>
                    </section>

                    <!-- Section 6 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            6. Garantías y Responsabilidad
                        </h2>
                        <div class="text-gray-600 dark:text-gray-300 space-y-3">
                            <p>Garantizamos la calidad de nuestros productos y que cumplen con la legislación aplicable.</p>
                            <p>No seremos responsables por:</p>
                            <ul class="list-disc list-inside space-y-1 ml-4">
                                <li>Daños indirectos o pérdida de beneficios</li>
                                <li>Retrasos o incumplimientos por causas ajenas a nuestro control (fuerza mayor)</li>
                                <li>Uso inadecuado de los productos por parte del Cliente</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Section 7 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            7. Protección de Datos
                        </h2>
                        <div class="text-gray-600 dark:text-gray-300 space-y-3">
                            <p>De acuerdo con la legislación vigente en protección de datos, informamos que:</p>
                            <ul class="list-disc list-inside space-y-2 ml-4">
                                <li>Los datos personales proporcionados se incorporarán a un fichero bajo nuestra responsabilidad.</li>
                                <li><strong>Finalidad</strong>: Gestión de pedidos, facturación y comunicación comercial.</li>
                                <li><strong>Conservación</strong>: Se conservarán durante el tiempo necesario para cumplir con las obligaciones legales.</li>
                                <li><strong>Derechos</strong>: Podrá ejercer sus derechos de acceso, rectificación, oposición, supresión, limitación del tratamiento y portabilidad mediante escrito a <strong>administracion@sandydecor.com</strong>.</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Section 8 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            8. Propiedad Intelectual
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">
                            Todos los contenidos del sitio web (textos, imágenes, logotipos) son propiedad de la Tienda o tienen licencia de uso. Queda prohibida la reproducción total o parcial sin autorización expresa.
                        </p>
                    </section>

                    <!-- Section 9 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            9. Ley Aplicable y Jurisdicción
                        </h2>
                        <div class="text-gray-600 dark:text-gray-300 space-y-3">
                            <p>Los presentes Términos y Condiciones se rigen por la legislación ecuatoriana.</p>
                            <p>Para cualquier controversia, las partes se someten a los Juzgados y Tribunales de la ciudad de Loja, con renuncia expresa a cualquier otro fuero que pudiera corresponderles.</p>
                        </div>
                    </section>

                    <!-- Section 10 -->
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            10. Modificaciones
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">
                            Nos reservamos el derecho de modificar estos Términos y Condiciones, publicando los cambios en el sitio web. Los cambios no afectarán a pedidos ya confirmados.
                        </p>
                    </section>

                    <!-- Contact Information -->
                    <section class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                Información de Contacto
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Para cualquier duda o aclaración sobre estos Términos y Condiciones, puede contactarnos a través de:
                            </p>
                            <div class="mt-4 space-y-2">
                                <p class="text-gray-600 dark:text-gray-300">
                                    <strong>Email:</strong> <a href="mailto:ventas@sandydecor.com" class="text-indigo-600 dark:text-indigo-400 hover:underline">ventas@sandydecor.com</a>
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <strong>Teléfono:</strong> <a href="tel:0987358421" class="text-indigo-600 dark:text-indigo-400 hover:underline">0987358421</a>
                                </p>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </section>
@endsection
