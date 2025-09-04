<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'id' => 1,
                'nombre' => 'Efectivo',
                'codigo' => 'CASH',
                'descripcion' => 'Pago en efectivo al momento de la entrega',
                'activo' => true,
                'requiere_verificacion' => false,
                'dias_procesamiento' => 0,
                'comision_porcentaje' => 0.00,
                'comision_fija' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'Transferencia Bancaria',
                'codigo' => 'TRANSFER',
                'descripcion' => 'Transferencia bancaria directa',
                'activo' => true,
                'requiere_verificacion' => true,
                'dias_procesamiento' => 1,
                'comision_porcentaje' => 0.00,
                'comision_fija' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'Tarjeta de Crédito',
                'codigo' => 'CREDIT_CARD',
                'descripcion' => 'Pago con tarjeta de crédito',
                'activo' => true,
                'requiere_verificacion' => true,
                'dias_procesamiento' => 0,
                'comision_porcentaje' => 3.50,
                'comision_fija' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
