<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('recipes', RecipeController::class);
Route::resource('categories', CategoryController::class);
Route::resource('ingredients', IngredientController::class);

// Route pour la page d'accueil qui redirige vers les recettes
Route::get('/', function () {
    return redirect()->route('recipes.index');
});
