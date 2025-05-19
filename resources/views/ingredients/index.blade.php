@extends('layouts.app')

@section('title', 'Ingrédients')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ingrédients</h1>
        @auth
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
            <i class="bi bi-plus-circle"></i> Nouvel Ingrédient
        </button>
        @endauth
    </div>

    @if($ingredients->isEmpty())
        <div class="alert alert-info">
            Aucun ingrédient n'a été ajouté pour le moment.
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Utilisé dans</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ingredients as $ingredient)
                                <tr>
                                    <td>{{ $ingredient->id }}</td>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>{{ Str::limit($ingredient->description, 100) }}</td>
                                    <td>{{ $ingredient->recipes->count() }} recettes</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @auth
                                                @if(auth()->user()->isAdmin())
                                                <button class="btn btn-sm btn-outline-primary edit-ingredient" 
                                                        data-id="{{ $ingredient->id }}"
                                                        data-name="{{ $ingredient->name }}"
                                                        data-description="{{ $ingredient->description }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editIngredientModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                
                                                <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet ingrédient ? Il sera retiré de toutes les recettes.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal pour ajouter un ingrédient -->
    <div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ingredients.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addIngredientModalLabel">Ajouter un ingrédient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour modifier un ingrédient -->
    <div class="modal fade" id="editIngredientModal" tabindex="-1" aria-labelledby="editIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editIngredientForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editIngredientModalLabel">Modifier l'ingrédient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion du modal d'édition
            const editButtons = document.querySelectorAll('.edit-ingredient');
            const editForm = document.getElementById('editIngredientForm');
            const editNameInput = document.getElementById('edit_name');
            const editDescriptionInput = document.getElementById('edit_description');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description');
                    
                    // Mise à jour du formulaire
                    editForm.action = `/ingredients/${id}`;
                    editNameInput.value = name;
                    editDescriptionInput.value = description;
                });
            });
        });
    </script>
@endsection 