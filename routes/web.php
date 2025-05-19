<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserRecipesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecipeLikeController;

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route pour la page d'accueil qui redirige vers les recettes
Route::get('/', function () {
    return redirect()->route('recipes.index');
});

// Routes pour les recettes avec middlewares
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/create', [RecipeController::class, 'create'])->middleware('auth')->name('recipes.create');
Route::post('/recipes', [RecipeController::class, 'store'])->middleware('auth')->name('recipes.store');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->middleware('auth')->name('recipes.edit');
Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->middleware('auth')->name('recipes.update');
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->middleware('auth')->name('recipes.destroy');
Route::post('/recipes/{recipe}/like', [RecipeLikeController::class, 'toggle'])->middleware('auth')->name('recipes.like');

// Ressources restantes
Route::resource('categories', CategoryController::class);
Route::resource('ingredients', IngredientController::class);

// Je remplace ces lignes par les routes avec permissions appropriées
// Ressources avec permissions spécifiques
// Catégories - lecture pour tous, création pour utilisateurs connectés, modification/suppression pour admins
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->middleware('auth')->name('categories.store');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->name('categories.destroy');

// Ingrédients - lecture pour tous, création pour utilisateurs connectés, modification/suppression pour admins
Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
Route::post('/ingredients', [IngredientController::class, 'store'])->middleware('auth')->name('ingredients.store');
Route::put('/ingredients/{ingredient}', [IngredientController::class, 'update'])->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->name('ingredients.update');
Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->name('ingredients.destroy');

// Routes pour le profil utilisateur et ses recettes
Route::middleware('auth')->group(function() {
    Route::get('/profile', [UserRecipesController::class, 'profile'])->name('user.profile');
    Route::get('/my-recipes', [UserRecipesController::class, 'index'])->name('user.recipes');
});

// Routes d'administration
Route::prefix('admin')->middleware(['web', 'auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('admin.users.toggle-admin');
    // Gestion des recettes
    Route::get('/recipes', [AdminController::class, 'recipes'])->name('admin.recipes');
    Route::get('/recipes/{recipe}/edit', [AdminController::class, 'editRecipe'])->name('admin.recipes.edit');
    Route::put('/recipes/{recipe}', [AdminController::class, 'updateRecipe'])->name('admin.recipes.update');
    Route::delete('/recipes/{recipe}', [AdminController::class, 'destroyRecipe'])->name('admin.recipes.destroy');
});
