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
                'nombre' => 'Arreglos',
                'descripcion' => 'Hermosos arreglos florales para toda ocasión',
                'orden' => 1,
                'activo' => true,
            ],
            [
                'nombre' => 'Desayunos',
                'descripcion' => 'Deliciosos desayunos sorpresa para consentir',
                'orden' => 2,
                'activo' => true,
            ],
            [
                'nombre' => 'Detalles',
                'descripcion' => 'Pequeños detalles que hacen la diferencia',
                'orden' => 3,
                'activo' => true,
            ],
            [
                'nombre' => 'Peluches',
                'descripcion' => 'Tiernos peluches para regalar amor',
                'orden' => 4,
                'activo' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
