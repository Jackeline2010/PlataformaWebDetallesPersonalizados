<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        Promotion::updateOrCreate(
            ['codigo' => 'DIA_MUJER_10'],
            [
                'nombre' => 'Día de la Mujer',
                'descripcion' => 'Descuento del 10% en compras desde $30.',
                'tipo_descuento' => 'porcentaje',
                'valor_descuento' => 10,
                'compra_minima' => 30,
                'fecha_inicio' => Carbon::now()->subDays(5),
                'fecha_fin' => Carbon::now()->addDays(30),
                'activo' => true,
            ]
        );
    }
}
