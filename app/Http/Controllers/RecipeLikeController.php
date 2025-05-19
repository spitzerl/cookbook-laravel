<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeLikeController extends Controller
{
    public function toggle(Recipe $recipe)
    {
        $user = auth()->user();
        
        // Vérifier si l'utilisateur a déjà liké la recette
        if ($recipe->isLikedBy($user)) {
            // Retirer le like
            $recipe->likedBy()->detach($user->id);
            $message = 'Like retiré';
        } else {
            // Ajouter le like
            $recipe->likedBy()->attach($user->id);
            $message = 'Recette likée';
        }
        
        return redirect()->back()->with('success', $message);
    }
}
