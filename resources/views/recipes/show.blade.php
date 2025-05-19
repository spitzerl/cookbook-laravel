@extends('layouts.app')

@section('title', $recipe->title)

@php
use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
    <div class="mb-4">
        <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour aux recettes
        </a>
    </div>

    <div class="row g-4">
        <!-- Image et infos générales -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="position-relative">
                    @if($recipe->image_path)
                        <img src="{{ asset('storage/' . $recipe->image_path) }}" class="card-img-top img-fluid rounded-top" alt="{{ $recipe->title }}" style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center rounded-top" style="height: 300px;">
                            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <form action="{{ route('recipes.like', $recipe) }}" method="POST" class="position-absolute" style="top: 15px; right: 15px;">
                        @csrf
                        <button type="submit" class="btn btn-like {{ $recipe->isLikedBy(Auth::user()) ? 'liked' : '' }}">
                            <i class="bi bi-heart-fill"></i>
                            <span class="likes-count">{{ $recipe->likes_count }}</span>
                        </button>
                    </form>
                </div>
                
                <div class="card-body">
                    <div class="recipe-meta mb-4">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary">{{ $recipe->category->name }}</span>
                            <span class="badge bg-secondary"><i class="bi bi-clock me-1"></i>Préparation: {{ $recipe->prep_time }} min</span>
                            <span class="badge bg-secondary"><i class="bi bi-fire me-1"></i>Cuisson: {{ $recipe->cooking_time }} min</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-info text-dark"><i class="bi bi-speedometer me-1"></i>
                                @if($recipe->difficulty === 'easy')
                                    Facile
                                @elseif($recipe->difficulty === 'medium')
                                    Moyen
                                @else
                                    Difficile
                                @endif
                            </span>
                            <span class="badge bg-success"><i class="bi bi-people-fill me-1"></i>{{ $recipe->servings }} portions</span>
                        </div>
                    </div>
                    
                    <h5 class="border-bottom pb-2 mb-3">Description</h5>
                    <p class="mb-4">{{ $recipe->description }}</p>
                    
                    @if(Auth::check() && (Auth::id() === $recipe->user_id || Auth::user()->isAdmin()))
                    <div class="d-flex gap-2 mt-auto">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-warning flex-grow-1">
                            <i class="bi bi-pencil me-1"></i> Modifier
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash me-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Contenu principal -->
        <div class="col-lg-7">
            <div class="mb-4">
                <h1 class="mb-4 pb-2 border-bottom">{{ $recipe->title }}</h1>
                
                <!-- Ingrédients -->
                <h4 class="d-flex align-items-center mb-3">
                    <i class="bi bi-basket me-2 text-primary"></i>Ingrédients
                </h4>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($recipe->ingredients as $ingredient)
                                <li class="list-group-item d-flex justify-content-between align-items-center ps-0 pe-0 border-bottom">
                                    <span>{{ $ingredient->name }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!-- Instructions -->
                <h4 class="d-flex align-items-center mb-3">
                    <i class="bi bi-list-check me-2 text-primary"></i>Instructions
                </h4>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="instructions-container">
                            @php
                                $instructionLines = explode("\n", $recipe->instructions);
                            @endphp
                            
                            @foreach($instructionLines as $index => $line)
                                @if(trim($line) !== '')
                                    <div class="instruction-step mb-3">
                                        <div class="d-flex">
                                            <div class="step-number me-3">
                                                <span class="badge bg-primary rounded-circle p-2" style="width: 30px; height: 30px;">{{ $index + 1 }}</span>
                                            </div>
                                            <div class="step-content">
                                                {{ $line }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
.btn-like {
    background: white;
    border-radius: 20px;
    padding: 0.5rem 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    color: #6c757d;
    border: none;
    transition: all 0.2s ease;
}

.btn-like:hover,
.btn-like.liked {
    color: var(--danger-color);
    background: white;
}

.btn-like i {
    margin-right: 5px;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}

.card {
    overflow: hidden;
}

.instructions-container {
    counter-reset: instruction;
}

.step-content {
    line-height: 1.6;
}

.list-group-item {
    padding-top: 0.8rem;
    padding-bottom: 0.8rem;
}
</style>
@endsection 