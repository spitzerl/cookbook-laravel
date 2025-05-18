<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
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
        $ingredient->delete();
        
        return redirect()->route('ingredients.index')
            ->with('success', 'Ingrédient supprimé avec succès!');
    }
}
