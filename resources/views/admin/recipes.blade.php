@extends('layouts.app')

@section('title', 'Gestion des Recettes')

@section('header')
    <div class="text-center mb-4">
        <h1 class="display-5">Gestion des Recettes</h1>
        <p class="lead">Administrez toutes les recettes de la plateforme</p>
    </div>
@endsection

@section('content')
    @include('layouts.admin_tabs')
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="bi bi-journal-richtext me-2"></i>Recettes ({{ count($recipes) }})</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('recipes.create') }}" class="btn btn-sm btn-success rounded-pill">
                    <i class="bi bi-plus-lg me-1"></i>Nouvelle recette
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i>Tableau de bord
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Recette</th>
                            <th class="py-3">Catégorie</th>
                            <th class="py-3">Auteur</th>
                            <th class="py-3"><i class="bi bi-clock me-1"></i>Temps</th>
                            <th class="py-3"><i class="bi bi-heart me-1"></i>Likes</th>
                            <th class="text-end pe-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($recipes as $recipe)
                            <tr>
                                <td class="px-4 py-3">
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
                                            <div class="fw-semibold">{{ $recipe->title }}</div>
                                            <div class="text-muted small">{{ $recipe->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-primary rounded-pill">{{ $recipe->category ? $recipe->category->name : 'N/A' }}</span>
                                </td>
                                <td class="py-3">
                                    @if($recipe->user)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-initials-sm me-2">{{ strtoupper(substr($recipe->user->name, 0, 1)) }}</div>
                                            <span>{{ $recipe->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">Non défini</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-dark rounded-pill">
                                        {{ ($recipe->prep_time ?? 0) + ($recipe->cooking_time ?? 0) }} min
                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-danger text-white rounded-pill">
                                        {{ $recipe->likedBy_count }}
                                    </span>
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-action btn-sm btn-outline-primary" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-action btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action btn-sm btn-outline-danger" 
                                                    title="Supprimer" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-journal-richtext text-muted mb-3" style="font-size: 2rem;"></i>
                                        <h5>Aucune recette trouvée</h5>
                                        <p class="text-muted mb-3">Il n'y a pas encore de recettes sur la plateforme.</p>
                                        <a href="{{ route('recipes.create') }}" class="btn btn-sm btn-success rounded-pill">
                                            <i class="bi bi-plus-lg me-1"></i>Créer une recette
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<style>
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

.avatar-initials-sm {
    width: 26px;
    height: 26px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}
</style> 