<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{    
    /**
     * Enregistrer une nouvelle note pour une recette.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Recipe $recipe)
    {
        // Validation des données
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        // Création ou mise à jour de la note
        // Utilisation de updateOrCreate pour gérer le cas où l'utilisateur a déjà noté la recette
        $recipe->ratings()->updateOrCreate(
            ['user_id' => auth()->id()], // Critères de recherche
            [
                'rating' => $validatedData['rating'],
                'comment' => $validatedData['comment'],
            ]
        );
        
        // Redirection avec un message de succès
        return redirect()->back()->with('success', 'Votre note a été enregistrée avec succès !');
    }
}
