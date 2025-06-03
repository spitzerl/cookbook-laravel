<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Recipe::query()
            ->with(['category', 'user'])
            ->select(['id', 'title', 'description', 'image_path', 'category_id', 'user_id', 'created_at']);

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Tri
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'alphabetical':
                $query->orderBy('title');
                break;
            case 'most_liked':
                $query->withCount('likedBy')
                      ->orderByDesc('liked_by_count');
                break;
            case 'highest_rated':
                $query->withAvg('ratings', 'rating')
                      ->orderByDesc('ratings_avg_rating');
                break;
            case 'lowest_rated':
                $query->withAvg('ratings', 'rating')
                      ->orderBy('ratings_avg_rating');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $recipes = $query->paginate(12)->withQueryString();
        $categories = Category::select(['id', 'name'])->get();
        $sortOptions = [
            'newest' => 'Plus récentes',
            'oldest' => 'Plus anciennes',
            'alphabetical' => 'Ordre alphabétique',
            'most_liked' => 'Plus likées',
            'highest_rated' => 'Mieux notées',
            'lowest_rated' => 'Moins bien notées'
        ];

        return view('recipes.index', compact('recipes', 'categories', 'sortOptions'));
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
        
        // Associer la recette à l'utilisateur connecté
        $recipe->user_id = auth()->id();
        
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
        // Vérifier si l'utilisateur est le propriétaire de la recette ou un administrateur
        if (auth()->id() !== $recipe->user_id && !auth()->user()->is_admin) {
            return redirect()->route('recipes.show', $recipe)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette recette.');
        }
        
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
        // Vérifier si l'utilisateur est le propriétaire de la recette ou un administrateur
        if (auth()->id() !== $recipe->user_id && !auth()->user()->is_admin) {
            return redirect()->route('recipes.show', $recipe)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette recette.');
        }
        
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
        // Vérifier si l'utilisateur est le propriétaire de la recette ou un administrateur
        if (auth()->id() !== $recipe->user_id && !auth()->user()->is_admin) {
            return redirect()->route('recipes.show', $recipe)
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette recette.');
        }
        
        // Delete the recipe image if exists
        if ($recipe->image_path) {
            Storage::disk('public')->delete($recipe->image_path);
        }
        
        $recipe->delete();
        
        return redirect()->route('recipes.index')
            ->with('success', 'Recette supprimée avec succès!');
    }
}
