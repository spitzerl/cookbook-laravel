@extends('layouts.app')

@section('title', 'Modifier l\'utilisateur')

@section('header')
    <div class="text-center mb-4">
        <h1 class="display-5">Modifier l'utilisateur</h1>
        <p class="lead">Gérer le profil de {{ $user->name }}</p>
    </div>
@endsection

@section('content')
    @include('layouts.admin_tabs')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Informations de l'utilisateur</h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-initials-lg me-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <div class="text-muted small">Membre depuis {{ $user->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="card bg-light border-0 p-3 mb-4">
                            <h6 class="mb-3"><i class="bi bi-key me-2"></i>Modifier le mot de passe</h6>
                            <p class="text-muted small mb-3">Laissez ces champs vides si vous ne souhaitez pas modifier le mot de passe.</p>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-0">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                            </div>
                        </div>
                        
                        @if(auth()->id() !== $user->id)
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_admin" 
                                   id="is_admin" 
                                   {{ $user->is_admin ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_admin">Administrateur</label>
                            <div class="form-text">Donner des droits d'administration à cet utilisateur</div>
                        </div>
                        @endif
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i>Enregistrer les modifications
                            </button>
                            
                            @if(auth()->id() !== $user->id)
                            <button type="button" class="btn btn-outline-danger" 
                                    onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur? Toutes ses recettes seront également supprimées.')) { 
                                        document.getElementById('delete-form').submit(); 
                                    }">
                                <i class="bi bi-trash me-2"></i>Supprimer cet utilisateur
                            </button>
                            @endif
                        </div>
                    </form>
                    
                    @if(auth()->id() !== $user->id)
                    <form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-journal-richtext me-2"></i>Recettes de l'utilisateur</h5>
                </div>
                <div class="card-body p-0">
                    @if($user->recipes->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($user->recipes as $recipe)
                                <div class="list-group-item py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="recipe-thumbnail me-3">
                                            @if($recipe->image_path)
                                                <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}">
                                            @else
                                                <div class="recipe-thumbnail-placeholder">
                                                    <i class="bi bi-card-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $recipe->title }}</h6>
                                            <div class="d-flex">
                                                <span class="badge bg-primary me-2">{{ $recipe->category ? $recipe->category->name : 'N/A' }}</span>
                                                <small class="text-muted">{{ $recipe->created_at->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-2 justify-content-end">
                                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                        <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-journal-richtext text-muted mb-3" style="font-size: 2rem;"></i>
                            <h6>Aucune recette</h6>
                            <p class="text-muted">Cet utilisateur n'a pas encore créé de recettes.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
.avatar-initials-lg {
    width: 60px;
    height: 60px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
}

.recipe-thumbnail {
    width: 40px;
    height: 40px;
    border-radius: 6px;
    overflow: hidden;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.recipe-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.recipe-thumbnail-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
}
</style> 