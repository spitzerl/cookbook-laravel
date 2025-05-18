<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            [
                'name' => 'Farine',
                'description' => 'Farine de blé'
            ],
            [
                'name' => 'Sucre',
                'description' => 'Sucre blanc'
            ],
            [
                'name' => 'Oeufs',
                'description' => 'Oeufs de poule'
            ],
            [
                'name' => 'Lait',
                'description' => 'Lait de vache'
            ],
            [
                'name' => 'Beurre',
                'description' => 'Beurre doux'
            ],
            [
                'name' => 'Sel',
                'description' => 'Sel de table'
            ],
            [
                'name' => 'Tomates',
                'description' => 'Tomates fraîches'
            ],
            [
                'name' => 'Poulet',
                'description' => 'Filets de poulet'
            ],
            [
                'name' => 'Chocolat',
                'description' => 'Chocolat noir'
            ],
            [
                'name' => 'Pommes de terre',
                'description' => 'Pommes de terre'
            ],
            [
                'name' => 'Oignon',
                'description' => 'Oignon jaune'
            ],
            [
                'name' => 'Ail',
                'description' => 'Gousses d\'ail'
            ],
            [
                'name' => 'Poivron',
                'description' => 'Poivrons colorés'
            ],
            [
                'name' => 'Carotte',
                'description' => 'Carottes fraîches'
            ],
            [
                'name' => 'Fromage',
                'description' => 'Fromage râpé'
            ],
            [
                'name' => 'Huile d\'olive',
                'description' => 'Huile d\'olive extra vierge'
            ],
            [
                'name' => 'Riz',
                'description' => 'Riz blanc'
            ],
            [
                'name' => 'Pâtes',
                'description' => 'Pâtes alimentaires'
            ],
            [
                'name' => 'Thon',
                'description' => 'Thon en conserve'
            ],
            [
                'name' => 'Saumon',
                'description' => 'Filet de saumon frais'
            ],
            [
                'name' => 'Poivre',
                'description' => 'Poivre noir moulu'
            ],
            [
                'name' => 'Crème fraîche',
                'description' => 'Crème fraîche épaisse'
            ],
            [
                'name' => 'Citron',
                'description' => 'Citron jaune'
            ],
            [
                'name' => 'Basilic',
                'description' => 'Basilic frais'
            ],
            [
                'name' => 'Courgette',
                'description' => 'Courgette verte'
            ],
            [
                'name' => 'Champignons',
                'description' => 'Champignons de Paris'
            ],
            [
                'name' => 'Miel',
                'description' => 'Miel liquide'
            ],
            [
                'name' => 'Viande hachée',
                'description' => 'Viande hachée de bœuf'
            ],
            [
                'name' => 'Haricots verts',
                'description' => 'Haricots verts frais'
            ],
            [
                'name' => 'Concombre',
                'description' => 'Concombre frais'
            ],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
