@extends('layouts.app')

@section('title', 'Nouvelle Recette')

@section('content')
    <div class="mb-4">
        <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour aux recettes
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Créer une nouvelle recette</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="prep_time" class="form-label">Temps de préparation (min) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('prep_time') is-invalid @enderror" id="prep_time" name="prep_time" value="{{ old('prep_time') }}" min="1" required>
                        @error('prep_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="cooking_time" class="form-label">Temps de cuisson (min) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('cooking_time') is-invalid @enderror" id="cooking_time" name="cooking_time" value="{{ old('cooking_time', 0) }}" min="0" required>
                        @error('cooking_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="servings" class="form-label">Nombre de portions <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('servings') is-invalid @enderror" id="servings" name="servings" value="{{ old('servings', 1) }}" min="1" required>
                        @error('servings')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="difficulty" class="form-label">Difficulté <span class="text-danger">*</span></label>
                    <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty" required>
                        <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Facile</option>
                        <option value="medium" {{ old('difficulty', 'medium') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                        <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Difficile</option>
                    </select>
                    @error('difficulty')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ingrédients <span class="text-danger">*</span></label>
                    <div class="ingredients-container border rounded p-3">
                        <div id="ingredients-list">
                            <!-- Les éléments d'ingrédients seront ajoutés ici dynamiquement -->
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" id="add-ingredient" class="btn btn-outline-primary">
                                <i class="bi bi-plus-circle"></i> Ajouter un ingrédient
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                <i class="bi bi-plus-lg"></i> Nouvel ingrédient
                            </button>
                        </div>
                    </div>
                    @error('ingredients')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="instructions" class="form-label">Instructions <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions" rows="6" required>{{ old('instructions') }}</textarea>
                    @error('instructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-outline-secondary">Réinitialiser</button>
                    <button type="submit" class="btn btn-primary">Enregistrer la recette</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal pour ajouter un nouvel ingrédient -->
    <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newIngredientModalLabel">Ajouter un nouvel ingrédient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new-ingredient-name" class="form-label">Nom de l'ingrédient</label>
                        <input type="text" class="form-control" id="new-ingredient-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-ingredient-description" class="form-label">Description (optionnelle)</label>
                        <textarea class="form-control" id="new-ingredient-description" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="save-new-ingredient">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ingredientsList = document.getElementById('ingredients-list');
            const addIngredientButton = document.getElementById('add-ingredient');
            const saveNewIngredientButton = document.getElementById('save-new-ingredient');
            const newIngredientModal = new bootstrap.Modal(document.getElementById('newIngredientModal'));
            
            // Liste des ingrédients disponibles
            let ingredients = [
                @foreach($ingredients as $ingredient)
                    { id: {{ $ingredient->id }}, name: "{{ $ingredient->name }}" },
                @endforeach
            ];
            
            // Fonction pour ajouter un nouvel ingrédient au formulaire
            function addIngredient() {
                const index = document.querySelectorAll('.ingredient-row').length;
                
                const row = document.createElement('div');
                row.className = 'ingredient-row row g-3 mb-2 align-items-end';
                
                row.innerHTML = `
                    <div class="col-md-4">
                        <label for="ingredients[${index}][id]" class="form-label">Ingrédient</label>
                        <div class="input-group">
                            <input type="text" class="form-control ingredient-search" placeholder="Rechercher..." autocomplete="off">
                            <select class="form-select d-none" name="ingredients[${index}][id]" required>
                                <option value="">Sélectionner un ingrédient</option>
                                ${ingredients.map(ing => `<option value="${ing.id}">${ing.name}</option>`).join('')}
                            </select>
                            <div class="ingredient-dropdown position-absolute w-100 mt-1 d-none" style="z-index: 1000; top: 100%; left: 0; max-height: 200px; overflow-y: auto; background: white; border: 1px solid #ced4da; border-radius: 0.25rem;"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="ingredients[${index}][quantity]" class="form-label">Quantité</label>
                        <input type="text" class="form-control" name="ingredients[${index}][quantity]" required>
                    </div>
                    <div class="col-md-3">
                        <label for="ingredients[${index}][unit]" class="form-label">Unité</label>
                        <input type="text" class="form-control" name="ingredients[${index}][unit]" placeholder="g, ml, pièce...">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger remove-ingredient">
                            <i class="bi bi-trash"></i> Retirer
                        </button>
                    </div>
                `;
                
                ingredientsList.appendChild(row);
                
                // Configuration de la recherche d'ingrédients
                const searchInput = row.querySelector('.ingredient-search');
                const selectElement = row.querySelector('select');
                const dropdownElement = row.querySelector('.ingredient-dropdown');
                
                // Afficher les options au focus
                searchInput.addEventListener('focus', function() {
                    updateIngredientDropdown(searchInput.value, dropdownElement, selectElement);
                    dropdownElement.classList.remove('d-none');
                });
                
                // Gestion de la recherche
                searchInput.addEventListener('input', function() {
                    updateIngredientDropdown(searchInput.value, dropdownElement, selectElement);
                });
                
                // Masquer le dropdown lors d'un clic ailleurs
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !dropdownElement.contains(e.target)) {
                        dropdownElement.classList.add('d-none');
                    }
                });
                
                // Ajouter un écouteur d'événement pour le bouton de suppression
                const removeButton = row.querySelector('.remove-ingredient');
                removeButton.addEventListener('click', function() {
                    row.remove();
                });
            }
            
            // Fonction pour mettre à jour le dropdown des ingrédients
            function updateIngredientDropdown(query, dropdownElement, selectElement) {
                query = query.toLowerCase();
                const filteredIngredients = ingredients.filter(ing => 
                    ing.name.toLowerCase().includes(query)
                );
                
                dropdownElement.innerHTML = '';
                
                if (filteredIngredients.length === 0) {
                    const noResult = document.createElement('div');
                    noResult.className = 'p-2 text-muted';
                    noResult.textContent = 'Aucun résultat';
                    dropdownElement.appendChild(noResult);
                } else {
                    filteredIngredients.forEach(ing => {
                        const option = document.createElement('div');
                        option.className = 'p-2 ingredient-option';
                        option.textContent = ing.name;
                        option.style.cursor = 'pointer';
                        option.style.transition = 'background-color 0.2s';
                        
                        option.addEventListener('mouseover', function() {
                            this.style.backgroundColor = '#f8f9fa';
                        });
                        
                        option.addEventListener('mouseout', function() {
                            this.style.backgroundColor = '';
                        });
                        
                        option.addEventListener('click', function() {
                            const parentRow = dropdownElement.closest('.ingredient-row');
                            const searchInput = parentRow.querySelector('.ingredient-search');
                            searchInput.value = ing.name;
                            selectElement.value = ing.id;
                            dropdownElement.classList.add('d-none');
                        });
                        
                        dropdownElement.appendChild(option);
                    });
                }
            }
            
            // Ajouter un ingrédient par défaut si la liste est vide
            if (document.querySelectorAll('.ingredient-row').length === 0) {
                addIngredient();
            }
            
            // Ajouter un écouteur d'événement pour le bouton d'ajout d'ingrédient
            addIngredientButton.addEventListener('click', addIngredient);
            
            // Ajouter un nouvel ingrédient via le modal
            saveNewIngredientButton.addEventListener('click', function() {
                const nameInput = document.getElementById('new-ingredient-name');
                const descriptionInput = document.getElementById('new-ingredient-description');
                
                if (!nameInput.value.trim()) {
                    nameInput.classList.add('is-invalid');
                    return;
                }
                
                nameInput.classList.remove('is-invalid');
                
                // Simuler l'ajout d'un nouvel ingrédient (dans une application réelle, on ferait une requête AJAX)
                const newIngredientId = Date.now(); // ID temporaire pour la démo
                const newIngredient = {
                    id: newIngredientId,
                    name: nameInput.value.trim()
                };
                
                // Ajouter à la liste d'ingrédients
                ingredients.push(newIngredient);
                
                // Mettre à jour tous les sélecteurs d'ingrédients
                document.querySelectorAll('.ingredient-row select').forEach(select => {
                    const option = document.createElement('option');
                    option.value = newIngredient.id;
                    option.textContent = newIngredient.name;
                    select.appendChild(option);
                });
                
                // Notification du succès
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>Ingrédient "${newIngredient.name}" ajouté avec succès !
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                `;
                document.querySelector('main').insertBefore(alertDiv, document.querySelector('.card'));
                
                // Réinitialiser et fermer le modal
                nameInput.value = '';
                descriptionInput.value = '';
                newIngredientModal.hide();
                
                // Supprimer l'alerte après 3 secondes
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            });
        });
    </script>
@endsection 