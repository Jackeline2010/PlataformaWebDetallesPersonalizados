<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photos = [
            [
                'foto' => 'assets/photos/photo_01.webp',
                'activo' => true,
                'orden' => 1
            ],
            [
                'foto' => 'assets/photos/photo_02.webp',
                'activo' => true,
                'orden' => 2
            ],
            [
                'foto' => 'assets/photos/photo_03.jpg',
                'activo' => true,
                'orden' => 3
            ],
            [
                'foto' => 'assets/photos/photo_04.jpg',
                'activo' => true,
                'orden' => 4
            ],
            [
                'foto' => 'assets/photos/photo_05.jpg',
                'activo' => true,
                'orden' => 5
            ],
            [
                'foto' => 'assets/photos/photo_06.jpg',
                'activo' => true,
                'orden' => 6
            ],
            [
                'foto' => 'assets/photos/photo_07.webp',
                'activo' => true,
                'orden' => 7
            ],
            [
                'foto' => 'assets/photos/photo_08.jpg',
                'activo' => true,
                'orden' => 8
            ],
            [
                'foto' => 'assets/photos/photo_09.jpg',
                'activo' => true,
                'orden' => 9
            ],
            [
                'foto' => 'assets/photos/photo_10.jpg',
                'activo' => true,
                'orden' => 10
            ],
            [
                'foto' => 'assets/photos/photo_11.jpg',
                'activo' => true,
                'orden' => 11
            ],
            [
                'foto' => 'assets/photos/photo_12.jpg',
                'activo' => true,
                'orden' => 12
            ]
        ];

        foreach ($photos as $photo) {
            Gallery::create($photo);
        }
    }
}
