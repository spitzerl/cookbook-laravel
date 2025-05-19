<?php

namespace App\Http\Middleware;

use App\Models\Recipe;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipeOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtenir la recette depuis la route
        $recipe = $request->route('recipe');
        
        // Vérifier si c'est bien un objet Recipe
        if (!$recipe instanceof Recipe) {
            $recipe = Recipe::findOrFail($recipe);
        }
        
        // Vérifier si l'utilisateur est connecté
        if (!$request->user()) {
            return redirect()->route('login');
        }
        
        // Vérifier si l'utilisateur est un administrateur
        if ($request->user()->is_admin) {
            return $next($request);
        }
        
        // Vérifier si l'utilisateur est le propriétaire de la recette
        if ($request->user()->id === $recipe->user_id) {
            return $next($request);
        }
        
        // Rediriger avec un message d'erreur
        return redirect()->route('recipes.show', $recipe)
            ->with('error', 'Vous n\'avez pas l\'autorisation de modifier cette recette. Seul le créateur de la recette ou un administrateur peut la modifier.');
    }
}
