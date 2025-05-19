<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté et est un administrateur
        if (!$request->user() || !$request->user()->isAdmin()) {
            return redirect()->route('recipes.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation d\'accéder à cette page. Seuls les administrateurs peuvent y accéder.');
        }

        return $next($request);
    }
}
