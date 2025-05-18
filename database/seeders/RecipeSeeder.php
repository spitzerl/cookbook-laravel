<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Recette 1: Quiche Lorraine
        $recipe1 = Recipe::create([
            'title' => 'Quiche Lorraine',
            'description' => 'Une délicieuse quiche lorraine traditionnelle française.',
            'instructions' => "1. Préchauffer le four à 180°C.\n2. Étaler la pâte dans un moule à tarte.\n3. Faire revenir les lardons à la poêle.\n4. Battre les œufs avec la crème et le lait.\n5. Ajouter les lardons et le fromage râpé.\n6. Verser la préparation sur la pâte.\n7. Cuire pendant 35-40 minutes jusqu'à ce que la quiche soit dorée.",
            'prep_time' => 20,
            'cooking_time' => 40,
            'servings' => 6,
            'difficulty' => 'Facile',
            'image_path' => null,
            'category_id' => Category::where('name', 'Plats principaux')->first()->id,
        ]);

        // Ajouter les ingrédients pour la Quiche Lorraine
        $recipe1->ingredients()->attach([
            Ingredient::where('name', 'Oeufs')->first()->id => ['quantity' => 3, 'unit' => 'unités'],
            Ingredient::where('name', 'Crème fraîche')->first()->id => ['quantity' => 200, 'unit' => 'ml'],
            Ingredient::where('name', 'Lait')->first()->id => ['quantity' => 100, 'unit' => 'ml'],
            Ingredient::where('name', 'Fromage')->first()->id => ['quantity' => 150, 'unit' => 'g'],
            Ingredient::where('name', 'Sel')->first()->id => ['quantity' => 1, 'unit' => 'pincée'],
            Ingredient::where('name', 'Poivre')->first()->id => ['quantity' => 1, 'unit' => 'pincée'],
        ]);

        // Recette 2: Cake au Chocolat
        $recipe2 = Recipe::create([
            'title' => 'Cake au Chocolat',
            'description' => 'Un gâteau au chocolat moelleux et savoureux.',
            'instructions' => "1. Préchauffer le four à 180°C.\n2. Faire fondre le chocolat avec le beurre au bain-marie.\n3. Battre les œufs avec le sucre jusqu'à ce que le mélange blanchisse.\n4. Ajouter le chocolat fondu et mélanger.\n5. Incorporer la farine tamisée.\n6. Verser dans un moule à cake beurré.\n7. Cuire pendant 30-35 minutes.",
            'prep_time' => 15,
            'cooking_time' => 35,
            'servings' => 8,
            'difficulty' => 'Facile',
            'image_path' => null,
            'category_id' => Category::where('name', 'Desserts')->first()->id,
        ]);

        // Ajouter les ingrédients pour le Cake au Chocolat
        $recipe2->ingredients()->attach([
            Ingredient::where('name', 'Chocolat')->first()->id => ['quantity' => 200, 'unit' => 'g'],
            Ingredient::where('name', 'Beurre')->first()->id => ['quantity' => 150, 'unit' => 'g'],
            Ingredient::where('name', 'Oeufs')->first()->id => ['quantity' => 4, 'unit' => 'unités'],
            Ingredient::where('name', 'Sucre')->first()->id => ['quantity' => 150, 'unit' => 'g'],
            Ingredient::where('name', 'Farine')->first()->id => ['quantity' => 80, 'unit' => 'g'],
        ]);

        // Recette 3: Salade Niçoise
        $recipe3 = Recipe::create([
            'title' => 'Salade Niçoise',
            'description' => 'Une salade fraîche et colorée originaire de Nice.',
            'instructions' => "1. Laver et couper les tomates en quartiers.\n2. Éplucher et couper les pommes de terre en rondelles.\n3. Cuire les œufs durs (10 minutes à l'eau bouillante).\n4. Égoutter le thon.\n5. Laver et préparer les haricots verts.\n6. Disposer tous les ingrédients sur un lit de salade.\n7. Préparer une vinaigrette avec l'huile d'olive, le citron, le sel et le poivre.\n8. Assaisonner la salade avec la vinaigrette juste avant de servir.",
            'prep_time' => 25,
            'cooking_time' => 15,
            'servings' => 4,
            'difficulty' => 'Facile',
            'image_path' => null,
            'category_id' => Category::where('name', 'Entrées')->first()->id,
        ]);

        // Ajouter les ingrédients pour la Salade Niçoise
        $recipe3->ingredients()->attach([
            Ingredient::where('name', 'Tomates')->first()->id => ['quantity' => 4, 'unit' => 'unités'],
            Ingredient::where('name', 'Pommes de terre')->first()->id => ['quantity' => 2, 'unit' => 'unités'],
            Ingredient::where('name', 'Oeufs')->first()->id => ['quantity' => 4, 'unit' => 'unités'],
            Ingredient::where('name', 'Thon')->first()->id => ['quantity' => 200, 'unit' => 'g'],
            Ingredient::where('name', 'Haricots verts')->first()->id => ['quantity' => 150, 'unit' => 'g'],
            Ingredient::where('name', 'Huile d\'olive')->first()->id => ['quantity' => 3, 'unit' => 'cuillères à soupe'],
            Ingredient::where('name', 'Citron')->first()->id => ['quantity' => 1, 'unit' => 'unité'],
            Ingredient::where('name', 'Sel')->first()->id => ['quantity' => 1, 'unit' => 'pincée'],
            Ingredient::where('name', 'Poivre')->first()->id => ['quantity' => 1, 'unit' => 'pincée'],
        ]);

        // Recette 4: Risotto aux Champignons
        $recipe4 = Recipe::create([
            'title' => 'Risotto aux Champignons',
            'description' => 'Un risotto crémeux aux champignons frais.',
            'instructions' => "1. Faire revenir l'oignon émincé dans l'huile d'olive.\n2. Ajouter le riz et le faire nacrer.\n3. Verser un peu de bouillon chaud et remuer jusqu'à absorption.\n4. Continuer à ajouter le bouillon petit à petit en remuant.\n5. Pendant ce temps, faire revenir les champignons dans une poêle séparée.\n6. Quand le riz est presque cuit, ajouter les champignons.\n7. Finir avec la crème fraîche et le parmesan.\n8. Assaisonner avec du sel et du poivre.",
            'prep_time' => 10,
            'cooking_time' => 30,
            'servings' => 4,
            'difficulty' => 'Moyen',
            'image_path' => null,
            'category_id' => Category::where('name', 'Plats principaux')->first()->id,
        ]);

        // Ajouter les ingrédients pour le Risotto aux Champignons
        $recipe4->ingredients()->attach([
            Ingredient::where('name', 'Riz')->first()->id => ['quantity' => 300, 'unit' => 'g'],
            Ingredient::where('name', 'Champignons')->first()->id => ['quantity' => 250, 'unit' => 'g'],
            Ingredient::where('name', 'Oignon')->first()->id => ['quantity' => 1, 'unit' => 'unité'],
            Ingredient::where('name', 'Huile d\'olive')->first()->id => ['quantity' => 2, 'unit' => 'cuillères à soupe'],
            Ingredient::where('name', 'Crème fraîche')->first()->id => ['quantity' => 3, 'unit' => 'cuillères à soupe'],
            Ingredient::where('name', 'Fromage')->first()->id => ['quantity' => 50, 'unit' => 'g'],
            Ingredient::where('name', 'Sel')->first()->id => ['quantity' => 1, 'unit' => 'pincée'],
            Ingredient::where('name', 'Poivre')->first()->id => ['quantity' => 1, 'unit' => 'pincée'],
        ]);

        // Recette 5: Soupe de Légumes
        $recipe5 = Recipe::create([
            'title' => 'Soupe de Légumes',
            'description' => 'Une soupe réconfortante aux légumes de saison.',
            'instructions' => "1. Éplucher et couper tous les légumes en morceaux.\n2. Faire revenir l'oignon et l'ail dans l'huile d'olive.\n3. Ajouter les carottes, les pommes de terre et les courgettes.\n4. Couvrir d'eau et porter à ébullition.\n5. Ajouter les herbes et assaisonner.\n6. Laisser mijoter pendant 30 minutes.\n7. Mixer la soupe pour obtenir une texture lisse.",
            'prep_time' => 15,
            'cooking_time' => 35,
            'servings' => 6,
            'difficulty' => 'Facile',
            'image_path' => null,
            'category_id' => Category::where('name', 'Soupes')->first()->id,
        ]);

        // Ajouter les ingrédients pour la Soupe de Légumes
        $recipe5->ingredients()->attach([
            Ingredient::where('name', 'Carotte')->first()->id => ['quantity' => 3, 'unit' => 'unités'],
            Ingredient::where('name', 'Pommes de terre')->first()->id => ['quantity' => 2, 'unit' => 'unités'],
            Ingredient::where('name', 'Courgette')->first()->id => ['quantity' => 1, 'unit' => 'unité'],
            Ingredient::where('name', 'Oignon')->first()->id => ['quantity' => 1, 'unit' => 'unité'],
            Ingredient::where('name', 'Ail')->first()->id => ['quantity' => 2, 'unit' => 'gousses'],
            Ingredient::where('name', 'Huile d\'olive')->first()->id => ['quantity' => 1, 'unit' => 'cuillère à soupe'],
            Ingredient::where('name', 'Sel')->first()->id => ['quantity' => 1, 'unit' => 'pincée'],
            Ingredient::where('name', 'Poivre')->first()->id => ['quantity' => 1, 'unit' => 'pincée'],
        ]);
    }
} 