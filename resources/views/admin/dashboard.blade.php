@extends('layouts.app')

@section('title', 'Administration')

@section('header')
    <div class="text-center mb-4">
        <h1 class="display-5">Administration</h1>
        <p class="lead">Gérez facilement le contenu de SIO Cookbook</p>
    </div>
@endsection

@section('content')
    @include('layouts.admin_tabs')
    
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm admin-dashboard-card">
                <div class="card-body text-center p-4">
                    <div class="icon-circle bg-primary-subtle mb-3">
                        <i class="bi bi-people fs-3 text-primary"></i>
                    </div>
                    <h2 class="display-6 fw-bold mb-0">{{ $stats['users'] }}</h2>
                    <p class="text-muted">Utilisateurs</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm mt-2">
                        Gérer les utilisateurs
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm admin-dashboard-card">
                <div class="card-body text-center p-4">
                    <div class="icon-circle bg-success-subtle mb-3">
                        <i class="bi bi-journal-richtext fs-3 text-success"></i>
                    </div>
                    <h2 class="display-6 fw-bold mb-0">{{ $stats['recipes'] }}</h2>
                    <p class="text-muted">Recettes</p>
                    <a href="{{ route('admin.recipes') }}" class="btn btn-outline-success btn-sm mt-2">
                        Gérer les recettes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm admin-dashboard-card">
                <div class="card-body text-center p-4">
                    <div class="icon-circle bg-info-subtle mb-3">
                        <i class="bi bi-tag fs-3 text-info"></i>
                    </div>
                    <h2 class="display-6 fw-bold mb-0">{{ $stats['categories'] }}</h2>
                    <p class="text-muted">Catégories</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-info btn-sm mt-2">
                        Gérer les catégories
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm admin-dashboard-card">
                <div class="card-body text-center p-4">
                    <div class="icon-circle bg-warning-subtle mb-3">
                        <i class="bi bi-cart3 fs-3 text-warning"></i>
                    </div>
                    <h2 class="display-6 fw-bold mb-0">{{ $stats['ingredients'] }}</h2>
                    <p class="text-muted">Ingrédients</p>
                    <a href="{{ route('ingredients.index') }}" class="btn btn-outline-warning btn-sm mt-2">
                        Gérer les ingrédients
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="bi bi-people me-2"></i>Derniers utilisateurs</h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary rounded-pill">
                        Voir tous <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($latestUsers as $user)
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initials me-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-secondary' }} rounded-pill">
                                        {{ $user->isAdmin() ? 'Admin' : 'Membre' }}
                                    </span>
                                    <small class="ms-2 text-muted">{{ $user->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item py-4 text-center">
                                <p class="mb-0 text-muted">Aucun utilisateur trouvé</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="bi bi-journal-richtext me-2"></i>Dernières recettes</h5>
                    <a href="{{ route('admin.recipes') }}" class="btn btn-sm btn-success rounded-pill">
                        Voir toutes <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($latestRecipes as $recipe)
                            <div class="list-group-item py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $recipe->title }}</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">{{ $recipe->category ? $recipe->category->name : 'N/A' }}</span>
                                            <small class="text-muted">par {{ $recipe->user ? $recipe->user->name : 'N/A' }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-outline-success rounded-pill">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item py-4 text-center">
                                <p class="mb-0 text-muted">Aucune recette trouvée</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.bg-primary-subtle {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}

.bg-success-subtle {
    background-color: rgba(var(--bs-success-rgb), 0.1);
}

.bg-info-subtle {
    background-color: rgba(var(--bs-info-rgb), 0.1);
}

.bg-warning-subtle {
    background-color: rgba(var(--bs-warning-rgb), 0.1);
}

.avatar-initials {
    width: 35px;
    height: 35px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}
</style> 