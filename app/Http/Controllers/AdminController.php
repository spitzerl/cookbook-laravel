<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Constructor
     * 
     * Note: Dans Laravel 12, le middleware est défini via les routes et non plus
     * dans le constructeur du contrôleur.
     */
    public function __construct()
    {
        // Le middleware est maintenant défini directement dans les routes
    }
    
    /**
     * Affiche le tableau de bord d'administration
     */
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'recipes' => Recipe::count(),
            'categories' => Category::count(),
            'ingredients' => Ingredient::count(),
        ];
        
        $latestUsers = User::latest()->take(5)->get();
        $latestRecipes = Recipe::with(['user', 'category'])->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'latestUsers', 'latestRecipes'));
    }
    
    /**
     * Affiche la liste des utilisateurs pour l'administration
     */
    public function users()
    {
        $users = User::withCount('recipes')->latest()->get();
        return view('admin.users', compact('users'));
    }
    
    /**
     * Afficher le formulaire pour éditer un utilisateur
     */
    public function editUser(User $user)
    {
        // Charger les recettes de l'utilisateur avec leurs catégories
        $user->load(['recipes.category']);
        
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Mettre à jour un utilisateur
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Mettre à jour le statut d'administrateur si l'utilisateur n'est pas en train de se modifier lui-même
        if (auth()->id() !== $user->id && $request->has('is_admin')) {
            $user->is_admin = $request->boolean('is_admin');
        }
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('admin.users')
            ->with('success', 'L\'utilisateur a été mis à jour avec succès.');
    }
    
    /**
     * Supprimer un utilisateur
     */
    public function destroyUser(User $user)
    {
        // Ne pas permettre de supprimer soi-même
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        // Supprimer les images des recettes de l'utilisateur
        foreach ($user->recipes as $recipe) {
            if ($recipe->image_path) {
                Storage::disk('public')->delete($recipe->image_path);
            }
        }
        
        // Supprimer l'utilisateur (les recettes seront supprimées par cascade)
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('success', 'L\'utilisateur et toutes ses recettes ont été supprimés.');
    }
    
    /**
     * Mettre à jour le statut administrateur d'un utilisateur
     */
    public function toggleAdmin(User $user)
    {
        // Ne pas permettre de se rétrograder soi-même
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users')
                ->with('error', 'Vous ne pouvez pas modifier votre propre statut d\'administrateur.');
        }
        
        $user->is_admin = !$user->is_admin;
        $user->save();
        
        return redirect()->route('admin.users')
            ->with('success', 'Le statut d\'administrateur de ' . $user->name . ' a été mis à jour.');
    }
    
    /**
     * Affiche la liste des recettes pour l'administration
     */
    public function recipes()
    {
        $recipes = Recipe::with(['user', 'category'])
                         ->withCount('likedBy')
                         ->latest()
                         ->get();
        
        return view('admin.recipes', compact('recipes'));
    }
    
    /**
     * Afficher le formulaire pour éditer une recette
     */
    public function editRecipe(Recipe $recipe)
    {
        $recipe->load('ingredients');
        $categories = Category::all();
        $ingredients = Ingredient::all();
        
        return view('admin.recipes.edit', compact('recipe', 'categories', 'ingredients'));
    }
    
    /**
     * Mettre à jour une recette
     */
    public function updateRecipe(Request $request, Recipe $recipe)
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
        
        return redirect()->route('admin.recipes')
            ->with('success', 'Recette mise à jour avec succès!');
    }
    
    /**
     * Supprimer une recette
     */
    public function destroyRecipe(Recipe $recipe)
    {
        // Delete the recipe image if exists
        if ($recipe->image_path) {
            Storage::disk('public')->delete($recipe->image_path);
        }
        
        $recipe->delete();
        
        return redirect()->route('admin.recipes')
            ->with('success', 'Recette supprimée avec succès!');
    }
} 