@extends('layouts.app')

@section('title', 'Liste des Recettes')

@section('header')
    <h1>Découvrez nos recettes</h1>
    <p>Explorez notre collection de délicieuses recettes et trouvez l'inspiration pour votre prochain repas</p>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}" class="text-decoration-none">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Recettes</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('recipes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nouvelle Recette
        </a>
    </div>

    @if($recipes->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Aucune recette n'a été ajoutée pour le moment. 
            <a href="{{ route('recipes.create') }}" class="alert-link">Créez votre première recette</a> !
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
            @foreach($recipes as $recipe)
                <div class="col">
                    <div class="card h-100 recipe-card">
                        @if($recipe->image_path)
                            <img src="{{ asset('storage/' . $recipe->image_path) }}" class="card-img-top recipe-image" alt="{{ $recipe->title }}">
                        @else
                            <div class="bg-light d-flex justify-content-center align-items-center recipe-image">
                                <i class="bi bi-camera text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <span class="card-category">{{ $recipe->category->name }}</span>
                            <h5 class="card-title">{{ $recipe->title }}</h5>
                            <p class="card-text">{{ Str::limit($recipe->description, 100) }}</p>
                            
                            <div class="recipe-info">
                                <span><i class="bi bi-clock"></i> {{ $recipe->prep_time }} min préparation</span>
                                <span><i class="bi bi-fire"></i> {{ $recipe->cooking_time }} min cuisson</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i> Voir
                                </a>
                                <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil me-1"></i> Modifier
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection 