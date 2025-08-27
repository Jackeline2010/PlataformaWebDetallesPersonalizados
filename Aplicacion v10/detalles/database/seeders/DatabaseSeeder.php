<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories first
        $this->call(CategoriesSeeder::class);

        // Seed products after categories
        $this->call(ProductsSeeder::class);

        // Seed histories (testimonials/reviews)
        $this->call(HistoriesSeeder::class);

        // Seed gallery photos
        $this->call(GallerySeeder::class);

        // Create admin user
        \App\Models\User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@sandydecor.com',
        ]);
    }
}
