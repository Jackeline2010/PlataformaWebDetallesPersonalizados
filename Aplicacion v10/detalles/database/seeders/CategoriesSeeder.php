<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nombre' => 'Arreglos y Globos',
                'descripcion' => 'Hermosos arreglos florales para toda ocasión',
                'imagen' => '',
                'icono' => 'assets/images/arreglo.svg',
                'orden' => 1,
                'activo' => true,
            ],
            [
                'nombre' => 'Peluches',
                'descripcion' => 'Tiernos peluches para regalar amor',
                'imagen' => '',
                'icono' => 'assets/images/peluche.svg',
                'orden' => 2,
                'activo' => true,
            ],
            [
                'nombre' => 'Chocolates y Dulces',
                'descripcion' => 'Deliciosos chocolates y dulces para endulzar el día',
                'imagen' => '',
                'icono' => 'assets/images/chocolates.svg',
                'orden' => 3,
                'activo' => true,
            ],
            [
                'nombre' => 'Artículos personalizados',
                'descripcion' => 'Articulos con el toque especial para esa persona especial',
                'imagen' => '',
                'icono' => 'assets/images/taza.svg',
                'orden' => 4,
                'activo' => true,
            ],
            [
                'nombre' => 'Cajas sorpresas',
                'descripcion' => 'Cajas llenas de sorpresas para la persona que amas',
                'imagen' => '',
                'icono' => 'assets/images/cajaSorpresa.svg',
                'orden' => 5,
                'activo' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
