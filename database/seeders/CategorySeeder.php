<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $categories = [
            'Bouquet de Rosas',
            'Bouquet de Girasoles',
            'Bouquet de Flores Amarillas',
            'Fruteros',
            'Topiarios',
            'Arreglos Fúnebres',
            'Variedad',
            'Condolencias',
            'Amor',
            'Rosas',
            'Grado',
            'Chocolates',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );
        }

        $this->command->info('Categorías creadas exitosamente!');
    }
}
