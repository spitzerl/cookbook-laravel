<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRecipesController extends Controller
{
    /**
     * Affiche la liste des recettes de l'utilisateur connecté
     */
    public function index()
    {
        $recipes = Auth::user()->recipes()->with('category')->get();
        return view('user.recipes', compact('recipes'));
    }

    /**
     * Crée une vue pour la page de profil utilisateur
     */
    public function profile()
    {
        $user = Auth::user();
        $recipesCount = $user->recipes()->count();
        return view('user.profile', compact('user', 'recipesCount'));
    }
} 