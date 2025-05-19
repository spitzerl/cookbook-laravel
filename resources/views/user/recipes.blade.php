@extends('layouts.app')

@section('title', 'Mes Recettes')

@section('header')
    <h1>Mes Recettes</h1>
    <p>Gérez vos recettes personnelles</p>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mes Recettes</li>
            </ol>
        </nav>
        <a href="{{ route('recipes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle Recette
        </a>
    </div>

    @if($recipes->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>Vous n'avez pas encore créé de recettes. 
            <a href="{{ route('recipes.create') }}" class="alert-link">Créez votre première recette</a> !
        </div>
    @else
        <div class="row">
            @foreach($recipes as $recipe)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card recipe-card h-100">
                        @if($recipe->image_path)
                            <img src="{{ asset('storage/' . $recipe->image_path) }}" class="card-img-top recipe-image" alt="{{ $recipe->title }}">
                        @else
                            <div class="card-img-top recipe-image bg-secondary d-flex align-items-center justify-content-center text-white">
                                <i class="bi bi-camera" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div>
                                <span class="card-category">{{ $recipe->category->name }}</span>
                                <h5 class="card-title">{{ $recipe->title }}</h5>
                                <p class="card-text text-truncate">{{ $recipe->description }}</p>
                            </div>
                            <div class="recipe-info mt-auto mb-2">
                                <span><i class="bi bi-clock"></i> {{ $recipe->prep_time + $recipe->cooking_time }} min</span>
                                <span><i class="bi bi-speedometer2"></i> {{ ucfirst($recipe->difficulty) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mt-auto">
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Voir
                                </a>
                                <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection 