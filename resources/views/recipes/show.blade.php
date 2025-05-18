@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <div class="mb-4">
        <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour aux recettes
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <h1>{{ $recipe->title }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-primary">{{ $recipe->category->name }}</span>
                <span class="badge bg-info text-dark">Préparation: {{ $recipe->prep_time }} min</span>
                <span class="badge bg-info text-dark">Cuisson: {{ $recipe->cooking_time }} min</span>
                <span class="badge bg-warning text-dark">{{ ucfirst($recipe->difficulty) }}</span>
                <span class="badge bg-success">{{ $recipe->servings }} portions</span>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Description</h4>
                </div>
                <div class="card-body">
                    {{ $recipe->description }}
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Ingrédients</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($recipe->ingredients as $ingredient)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $ingredient->name }}</span>
                                <span class="badge bg-primary rounded-pill">{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Instructions</h4>
                </div>
                <div class="card-body">
                    {!! nl2br(e($recipe->instructions)) !!}
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                @if($recipe->image_path)
                    <img src="{{ asset('storage/' . $recipe->image_path) }}" class="card-img-top" alt="{{ $recipe->title }}">
                @else
                    <div class="bg-light d-flex justify-content-center align-items-center p-5">
                        <span class="text-muted">Aucune image</span>
                    </div>
                @endif
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 