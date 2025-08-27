<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the "Arreglos" category
        $arreglosCategory = Category::where('nombre', 'Arreglos')->first();
        $peluchesCategory = Category::where('nombre', 'Peluches')->first();
        $detallesCategory = Category::where('nombre', 'Detalles')->first();

        $products = [
            [
                'nombre' => 'Ramo de Flores con Oso de Peluche',
                'descripcion' => 'Hermoso ramo de flores frescas acompañado de un tierno oso de peluche. Perfecto para expresar amor y cariño en cualquier ocasión especial.',
                'descripcion_corta' => 'Ramo de flores con oso de peluche incluido',
                'precio' =>30.00,
                'stock' => 25,
                'stock_minimo' => 5,
                'fingreso' => Carbon::now(),
                'descuento' => 10.00,
                'imagen_principal' => 'assets/products/producto_001.jpg',
                'peso' => 1.2,
                'activo' => true,
                'destacado' => true,
                'personalizable' => true,
                'opciones_personalizacion' => [
                    'colores' => ['Rojo', 'Rosa', 'Blanco', 'Mixto'],
                    'mensaje_tarjeta' => true,
                    'tamaño_peluche' => ['Pequeño', 'Mediano', 'Grande']
                ],
                'orden' => 1,
                'categories' => [$arreglosCategory->id, $peluchesCategory->id]
            ],
            [
                'nombre' => 'Ramo de Girasoles con Azucenas',
                'descripcion' => 'Radiante combinación de girasoles y azucenas que transmite alegría y elegancia. Ideal para celebraciones y momentos especiales.',
                'descripcion_corta' => 'Combinación perfecta de girasoles y azucenas',
                'precio' => 15.00,
                'stock' => 30,
                'stock_minimo' => 8,
                'fingreso' => Carbon::now(),
                'descuento' => 10.00,
                'imagen_principal' => 'assets/products/producto_002.webp',
                'peso' => 0.8,
                'activo' => true,
                'destacado' => true,
                'personalizable' => false,
                'orden' => 2,
                'categories' => [$arreglosCategory->id]
            ],
            [
                'nombre' => 'Ramo de Girasoles y Rosas - Estilo Nocturno',
                'descripcion' => 'Elegante arreglo nocturno que combina la calidez de los girasoles con la pasión de las rosas. Perfecto para cenas románticas y ocasiones especiales.',
                'descripcion_corta' => 'Arreglo nocturno de girasoles y rosas',
                'precio' => 18.00,
                'stock' => 20,
                'stock_minimo' => 5,
                'fingreso' => Carbon::now(),
                'descuento' => 5.00,
                'imagen_principal' => 'assets/products/producto_003.webp',
                'peso' => 1.0,
                'activo' => true,
                'destacado' => false,
                'personalizable' => true,
                'opciones_personalizacion' => [
                    'colores_rosas' => ['Rojas', 'Rosadas', 'Blancas'],
                    'mensaje_tarjeta' => true,
                    'envoltorio' => ['Papel kraft', 'Papel negro elegante', 'Tela']
                ],
                'orden' => 3,
                'categories' => [$arreglosCategory->id]
            ],
            [
                'nombre' => 'Ramo de Rosas y Orquideas + Chocolates Noggy',
                'descripcion' => 'Lujoso ramo que combina rosas premium con orquídeas exóticas, acompañado de deliciosos chocolates Noggy. El regalo perfecto para impresionar.',
                'descripcion_corta' => 'Ramo premium con rosas, orquídeas y chocolates',
                'precio' => 25.00,
                'stock' => 15,
                'stock_minimo' => 3,
                'fingreso' => Carbon::now(),
                'descuento' => 5.00,
                'imagen_principal' => 'assets/products/producto_004.jpg',
                'peso' => 1.5,
                'activo' => true,
                'destacado' => true,
                'personalizable' => true,
                'opciones_personalizacion' => [
                    'tipo_chocolates' => ['Clásicos', 'Premium', 'Sin azúcar'],
                    'colores_rosas' => ['Rojas', 'Rosadas', 'Blancas'],
                    'mensaje_tarjeta' => true
                ],
                'orden' => 4,
                'categories' => [$arreglosCategory->id, $detallesCategory->id]
            ],
            [
                'nombre' => 'Ramo de Flores Amarillas - Girasoles y Margaritas',
                'descripcion' => 'Vibrante ramo en tonos amarillos que combina girasoles y margaritas. Transmite alegría, optimismo y energía positiva.',
                'descripcion_corta' => 'Ramo amarillo de girasoles y margaritas',
                'precio' => 15.00,
                'stock' => 35,
                'stock_minimo' => 10,
                'fingreso' => Carbon::now(),
                'descuento' => 0.00,
                'imagen_principal' => 'assets/products/producto_005.webp',
                'peso' => 0.7,
                'activo' => true,
                'destacado' => false,
                'personalizable' => false,
                'orden' => 5,
                'categories' => [$arreglosCategory->id]
            ],
            [
                'nombre' => 'Ramo de Girasoles Rojos y Amarillos - 6 girasoles',
                'descripcion' => 'Espectacular ramo de 6 girasoles en tonos rojos y amarillos. Una combinación única que destaca por su originalidad y belleza.',
                'descripcion_corta' => 'Ramo de 6 girasoles rojos y amarillos',
                'precio' => 12.00,
                'stock' => 28,
                'stock_minimo' => 8,
                'fingreso' => Carbon::now(),
                'descuento' => 0.00,
                'imagen_principal' => 'assets/products/producto_006.jpg',
                'peso' => 0.6,
                'activo' => true,
                'destacado' => false,
                'personalizable' => true,
                'opciones_personalizacion' => [
                    'cantidad' => ['6 girasoles', '9 girasoles', '12 girasoles'],
                    'mensaje_tarjeta' => true
                ],
                'orden' => 6,
                'categories' => [$arreglosCategory->id]
            ],
            [
                'nombre' => 'Canasta Primavera - Rosas e Ilusiones',
                'descripcion' => 'Encantadora canasta primaveral llena de rosas frescas y flores de temporada. Evoca la belleza y renovación de la primavera.',
                'descripcion_corta' => 'Canasta primaveral con rosas y flores de temporada',
                'precio' => 20.00,
                'stock' => 22,
                'stock_minimo' => 6,
                'fingreso' => Carbon::now(),
                'descuento' => 0.00,
                'imagen_principal' => 'assets/products/producto_007.webp',
                'peso' => 1.3,
                'activo' => true,
                'destacado' => true,
                'personalizable' => true,
                'opciones_personalizacion' => [
                    'tipo_canasta' => ['Mimbre natural', 'Mimbre blanco', 'Cesta decorativa'],
                    'colores_rosas' => ['Mixtas', 'Rosadas', 'Blancas'],
                    'mensaje_tarjeta' => true
                ],
                'orden' => 7,
                'categories' => [$arreglosCategory->id]
            ],
            [
                'nombre' => 'Combo San Valentin - Flores, Peluche y Chocolates',
                'descripcion' => 'Combo completo para San Valentín que incluye hermosas flores, un tierno peluche y deliciosos chocolates. El regalo perfecto para el día del amor.',
                'descripcion_corta' => 'Combo completo: flores, peluche y chocolates',
                'precio' => 75.00,
                'stock' => 18,
                'stock_minimo' => 4,
                'fingreso' => Carbon::now(),
                'descuento' => 0.00,
                'imagen_principal' => 'assets/products/producto_008.jpg',
                'peso' => 1.8,
                'activo' => true,
                'destacado' => true,
                'personalizable' => true,
                'opciones_personalizacion' => [
                    'tipo_flores' => ['Rosas rojas', 'Rosas rosadas', 'Mixtas'],
                    'tamaño_peluche' => ['Mediano', 'Grande'],
                    'tipo_chocolates' => ['Clásicos', 'Premium'],
                    'mensaje_tarjeta' => true
                ],
                'orden' => 8,
                'categories' => [$arreglosCategory->id, $peluchesCategory->id, $detallesCategory->id]
            ],
            [
                'nombre' => 'Ramo de Flores Primavera - Rosas y Orquideas',
                'descripcion' => 'Elegante ramo primaveral que combina la clásica belleza de las rosas con la exótica elegancia de las orquídeas.',
                'descripcion_corta' => 'Ramo primaveral de rosas y orquídeas',
                'precio' => 22.00,
                'stock' => 16,
                'stock_minimo' => 4,
                'fingreso' => Carbon::now(),
                'descuento' => 0.00,
                'imagen_principal' => 'assets/products/producto_009.webp',
                'peso' => 1.1,
                'activo' => true,
                'destacado' => false,
                'personalizable' => true,
                'opciones_personalizacion' => [
                    'colores_rosas' => ['Rosadas', 'Blancas', 'Mixtas'],
                    'tipo_orquideas' => ['Blancas', 'Moradas', 'Mixtas'],
                    'mensaje_tarjeta' => true
                ],
                'orden' => 9,
                'categories' => [$arreglosCategory->id]
            ],
            [
                'nombre' => 'Ramo de Rosas Elegante - 1 docena',
                'descripcion' => 'Clásico y elegante ramo de una docena de rosas premium. Símbolo eterno de amor y elegancia, perfecto para ocasiones especiales.',
                'descripcion_corta' => 'Ramo elegante de 12 rosas premium',
                'precio' => 25.00,
                'stock' => 40,
                'stock_minimo' => 12,
                'fingreso' => Carbon::now(),
                'descuento' => 0.00,
                'imagen_principal' => 'assets/products/producto_010.jpg',
                'peso' => 0.9,
                'activo' => true,
                'destacado' => true,
                'personalizable' => true,
                'opciones_personalizacion' => [
                    'colores' => ['Rojas', 'Rosadas', 'Blancas', 'Amarillas'],
                    'envoltorio' => ['Papel elegante', 'Papel kraft', 'Tela'],
                    'mensaje_tarjeta' => true
                ],
                'orden' => 10,
                'categories' => [$arreglosCategory->id]
            ]
        ];

        foreach ($products as $productData) {
            // Extract categories before creating product
            $categoryIds = $productData['categories'];
            unset($productData['categories']);

            // Create the product
            $product = Product::create($productData);

            // Attach categories
            $product->categories()->attach($categoryIds);
        }
    }
}
