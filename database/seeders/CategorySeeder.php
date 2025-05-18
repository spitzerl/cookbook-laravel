<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Entrées',
                'description' => 'Plats servis au début du repas'
            ],
            [
                'name' => 'Plats principaux',
                'description' => 'Plats principaux d\'un repas'
            ],
            [
                'name' => 'Desserts',
                'description' => 'Plats sucrés servis en fin de repas'
            ],
            [
                'name' => 'Boissons',
                'description' => 'Boissons et cocktails'
            ],
            [
                'name' => 'Soupes',
                'description' => 'Soupes et potages'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
