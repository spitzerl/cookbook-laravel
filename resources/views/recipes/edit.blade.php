@extends('layouts.app')

@section('title', 'Modifier ' . $recipe->title)

@section('content')
    <div class="mb-4">
        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la recette
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Modifier la recette</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $recipe->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $recipe->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="prep_time" class="form-label">Temps de préparation (min) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('prep_time') is-invalid @enderror" id="prep_time" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}" min="1" required>
                        @error('prep_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="cooking_time" class="form-label">Temps de cuisson (min) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('cooking_time') is-invalid @enderror" id="cooking_time" name="cooking_time" value="{{ old('cooking_time', $recipe->cooking_time) }}" min="0" required>
                        @error('cooking_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="servings" class="form-label">Nombre de portions <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('servings') is-invalid @enderror" id="servings" name="servings" value="{{ old('servings', $recipe->servings) }}" min="1" required>
                        @error('servings')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="difficulty" class="form-label">Difficulté <span class="text-danger">*</span></label>
                    <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty" required>
                        <option value="easy" {{ old('difficulty', $recipe->difficulty) == 'easy' ? 'selected' : '' }}>Facile</option>
                        <option value="medium" {{ old('difficulty', $recipe->difficulty) == 'medium' ? 'selected' : '' }}>Moyenne</option>
                        <option value="hard" {{ old('difficulty', $recipe->difficulty) == 'hard' ? 'selected' : '' }}>Difficile</option>
                    </select>
                    @error('difficulty')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    @if($recipe->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="img-thumbnail" style="max-height: 200px">
                            <p class="text-muted mt-1">Image actuelle</p>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ingrédients <span class="text-danger">*</span></label>
                    <div class="ingredients-container border rounded p-3">
                        <div id="ingredients-list">
                            <!-- Les ingrédients existants et nouveaux seront ajoutés ici -->
                        </div>
                        <button type="button" id="add-ingredient" class="btn btn-outline-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Ajouter un ingrédient
                        </button>
                    </div>
                    @error('ingredients')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="instructions" class="form-label">Instructions <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions" rows="6" required>{{ old('instructions', $recipe->instructions) }}</textarea>
                    @error('instructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour la recette</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ingredientsList = document.getElementById('ingredients-list');
            const addIngredientButton = document.getElementById('add-ingredient');
            
            // Liste des ingrédients disponibles
            const ingredients = [
                @foreach($ingredients as $ingredient)
                    { id: {{ $ingredient->id }}, name: "{{ $ingredient->name }}" },
                @endforeach
            ];
            
            // Ingrédients existants de la recette
            const recipeIngredients = [
                @foreach($recipe->ingredients as $ingredient)
                    { 
                        id: {{ $ingredient->id }}, 
                        name: "{{ $ingredient->name }}", 
                        quantity: "{{ $ingredient->pivot->quantity }}", 
                        unit: "{{ $ingredient->pivot->unit }}" 
                    },
                @endforeach
            ];
            
            // Fonction pour ajouter un nouvel ingrédient au formulaire
            function addIngredient(ingredientData = null) {
                const index = document.querySelectorAll('.ingredient-row').length;
                
                const row = document.createElement('div');
                row.className = 'ingredient-row row g-3 mb-2 align-items-end';
                
                row.innerHTML = `
                    <div class="col-md-4">
                        <label for="ingredients[${index}][id]" class="form-label">Ingrédient</label>
                        <select class="form-select" name="ingredients[${index}][id]" required>
                            <option value="">Sélectionner un ingrédient</option>
                            ${ingredients.map(ing => `<option value="${ing.id}" ${ingredientData && ingredientData.id === ing.id ? 'selected' : ''}>${ing.name}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="ingredients[${index}][quantity]" class="form-label">Quantité</label>
                        <input type="text" class="form-control" name="ingredients[${index}][quantity]" value="${ingredientData ? ingredientData.quantity : ''}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="ingredients[${index}][unit]" class="form-label">Unité</label>
                        <input type="text" class="form-control" name="ingredients[${index}][unit]" value="${ingredientData ? ingredientData.unit : ''}" placeholder="g, ml, pièce...">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger remove-ingredient">
                            <i class="bi bi-trash"></i> Retirer
                        </button>
                    </div>
                `;
                
                ingredientsList.appendChild(row);
                
                // Ajouter un écouteur d'événement pour le bouton de suppression
                const removeButton = row.querySelector('.remove-ingredient');
                removeButton.addEventListener('click', function() {
                    row.remove();
                });
            }
            
            // Ajouter les ingrédients existants
            if (recipeIngredients.length > 0) {
                recipeIngredients.forEach(ingredient => {
                    addIngredient(ingredient);
                });
            } else {
                // Ajouter un ingrédient vide si aucun n'existe
                addIngredient();
            }
            
            // Ajouter un écouteur d'événement pour le bouton d'ajout d'ingrédient
            addIngredientButton.addEventListener('click', function() {
                addIngredient();
            });
        });
    </script>
@endsection