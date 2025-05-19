<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        $categories = Category::with('recipes')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('categories.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::user()) {
            return redirect()->route('categories.index')
                ->with('error', 'Vous devez être connecté pour créer une catégorie.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        Category::create($validated);
        
        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return redirect()->route('categories.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            return redirect()->route('categories.index')
                ->with('error', 'Seuls les administrateurs peuvent modifier les catégories.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $category->update($validated);
        
        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            return redirect()->route('categories.index')
                ->with('error', 'Seuls les administrateurs peuvent supprimer les catégories.');
        }
        
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès!');
    }
}
