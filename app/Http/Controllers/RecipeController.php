<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::with('category')->get();
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        return view('recipes.create', compact('categories', 'ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'prep_time' => 'required|integer|min:1',
            'cooking_time' => 'required|integer|min:0',
            'servings' => 'required|integer|min:1',
            'difficulty' => 'required|string|in:easy,medium,hard',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|string',
            'ingredients.*.unit' => 'nullable|string',
        ]);

        $recipe = new Recipe($request->except('image', 'ingredients'));
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipe-images', 'public');
            $recipe->image_path = $path;
        }
        
        $recipe->save();
        
        // Attach ingredients with pivot data
        $ingredientsData = [];
        foreach ($request->ingredients as $ingredient) {
            $ingredientsData[$ingredient['id']] = [
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'] ?? null,
            ];
        }
        $recipe->ingredients()->attach($ingredientsData);
        
        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recette créée avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        $recipe->load('category', 'ingredients');
        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        $recipe->load('ingredients');
        $categories = Category::all();
        $ingredients = Ingredient::all();
        return view('recipes.edit', compact('recipe', 'categories', 'ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'prep_time' => 'required|integer|min:1',
            'cooking_time' => 'required|integer|min:0',
            'servings' => 'required|integer|min:1',
            'difficulty' => 'required|string|in:easy,medium,hard',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|string',
            'ingredients.*.unit' => 'nullable|string',
        ]);
        
        $recipe->fill($request->except('image', 'ingredients'));
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($recipe->image_path) {
                Storage::disk('public')->delete($recipe->image_path);
            }
            $path = $request->file('image')->store('recipe-images', 'public');
            $recipe->image_path = $path;
        }
        
        $recipe->save();
        
        // Sync ingredients with pivot data
        $ingredientsData = [];
        foreach ($request->ingredients as $ingredient) {
            $ingredientsData[$ingredient['id']] = [
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'] ?? null,
            ];
        }
        $recipe->ingredients()->sync($ingredientsData);
        
        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recette mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        // Delete the recipe image if exists
        if ($recipe->image_path) {
            Storage::disk('public')->delete($recipe->image_path);
        }
        
        $recipe->delete();
        
        return redirect()->route('recipes.index')
            ->with('success', 'Recette supprimée avec succès!');
    }
}
