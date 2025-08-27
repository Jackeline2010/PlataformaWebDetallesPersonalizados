<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\History;

class HistoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $histories = [
            [
                'nombre' => 'María González',
                'comentario' => 'Excelente servicio, las flores llegaron muy frescas y hermosas. El arreglo superó mis expectativas y mi mamá quedó encantada. Definitivamente volveré a comprar aquí.',
                'estrellas' => 5
            ],
            [
                'nombre' => 'Carlos Rodríguez',
                'comentario' => 'Muy buen producto y atención al cliente. La entrega fue puntual y las flores estaban en perfecto estado. Solo una pequeña observación: me hubiera gustado más variedad en los colores.',
                'estrellas' => 4
            ],
            [
                'nombre' => 'Ana López',
                'comentario' => 'Las flores estaban perfectas, mi esposa quedó encantada con el ramo de rosas. El peluche que venía incluido era muy tierno. ¡Gracias por hacer especial nuestro aniversario!',
                'estrellas' => 5
            ],
            [
                'nombre' => 'Pedro Martínez',
                'comentario' => 'Servicio regular, las flores estaban bien pero esperaba algo mejor por el precio. La presentación podría mejorar un poco más.',
                'estrellas' => 3
            ],
            [
                'nombre' => 'Lucía Fernández',
                'comentario' => 'Increíble experiencia de compra. El combo de San Valentín fue perfecto: flores hermosas, chocolates deliciosos y un peluche adorable. Mi novio acertó completamente.',
                'estrellas' => 5
            ],
            [
                'nombre' => 'Roberto Silva',
                'comentario' => 'Buena calidad en general. Los girasoles estaban frescos y el arreglo bien presentado. La entrega fue rápida. Recomendado para ocasiones especiales.',
                'estrellas' => 4
            ],
            [
                'nombre' => 'Carmen Morales',
                'comentario' => 'Excelente atención y productos de calidad. La canasta primaveral que pedí para el Día de la Madre fue un éxito total. Las flores duraron más de una semana.',
                'estrellas' => 5
            ],
            [
                'nombre' => 'Diego Herrera',
                'comentario' => 'Buen servicio aunque tuve que esperar un poco más de lo previsto. Las orquídeas estaban hermosas y el empaque muy elegante. Volveré a comprar.',
                'estrellas' => 4
            ],
            [
                'nombre' => 'Sofía Ramírez',
                'comentario' => 'Me encantó la variedad de productos. Compré el ramo de girasoles y margaritas para alegrar mi oficina. Los colores eran vibrantes y las flores muy frescas.',
                'estrellas' => 5
            ],
            [
                'nombre' => 'Andrés Castro',
                'comentario' => 'Experiencia satisfactoria. El ramo elegante de rosas fue perfecto para la graduación de mi hija. La calidad justifica el precio. Servicio recomendado.',
                'estrellas' => 4
            ]
        ];

        foreach ($histories as $history) {
            History::create($history);
        }
    }
}
