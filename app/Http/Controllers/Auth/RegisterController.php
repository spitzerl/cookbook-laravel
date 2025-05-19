<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    /**
     * Traiter la demande d'inscription
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false, // Par défaut, un nouvel utilisateur n'est pas administrateur
        ]);
        
        Auth::login($user);
        
        return redirect()->route('recipes.index')
            ->with('success', 'Bienvenue ! Votre compte a été créé avec succès.');
    }
}
