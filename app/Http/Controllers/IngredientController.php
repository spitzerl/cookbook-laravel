<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngredientController extends Controller
{
    /**
     * Constructor to set middleware for specific actions
     */
    public function __construct()
    {
        // Les routes sont déjà protégées par les middlewares dans routes/web.php
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::with('recipes')->get();
        return view('ingredients.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('ingredients.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::user()) {
            return redirect()->route('ingredients.index')
                ->with('error', 'Vous devez être connecté pour créer un ingrédient.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        Ingredient::create($validated);
        
        return redirect()->route('ingredients.index')
            ->with('success', 'Ingrédient créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {
        return redirect()->route('ingredients.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient)
    {
        return redirect()->route('ingredients.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            return redirect()->route('ingredients.index')
                ->with('error', 'Seuls les administrateurs peuvent modifier les ingrédients.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $ingredient->update($validated);
        
        return redirect()->route('ingredients.index')
            ->with('success', 'Ingrédient mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            return redirect()->route('ingredients.index')
                ->with('error', 'Seuls les administrateurs peuvent supprimer les ingrédients.');
        }
        
        $ingredient->delete();
        
        return redirect()->route('ingredients.index')
            ->with('success', 'Ingrédient supprimé avec succès!');
    }
}
