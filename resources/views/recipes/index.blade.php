@extends('layouts.app')

@section('title', 'Liste des Recettes')

@section('header')
    <h1>Découvrez nos recettes</h1>
    <p>Explorez notre collection de délicieuses recettes et trouvez l'inspiration pour votre prochain repas</p>
@endsection

@section('content')
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6 col-lg-8">
                    <form action="{{ route('recipes.index') }}" method="GET" class="search-form">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control border-start-0 ps-0" 
                                   placeholder="Rechercher par nom, description ou catégorie..." 
                                   value="{{ request('search') }}"
                                   aria-label="Rechercher une recette">
                            <button type="submit" class="btn btn-primary">
                                Rechercher
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex gap-3 justify-content-md-end">
                        <div class="input-group">
                            <label class="input-group-text bg-white" for="sort">
                                <i class="bi bi-sort-down text-muted"></i>
                            </label>
                            <select class="form-select border-start-0 ps-0" 
                                    id="sort" 
                                    name="sort" 
                                    onchange="window.location.href = '{{ route('recipes.index') }}?sort=' + this.value + '{{ request('search') ? '&search=' . request('search') : '' }}'">
                                @foreach($sortOptions as $value => $label)
                                    <option value="{{ $value }}" {{ request('sort', 'newest') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @auth
                        <a href="{{ route('recipes.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bi bi-plus-circle me-2"></i> Nouvelle Recette
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($recipes->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            @if(request('search'))
                Aucune recette ne correspond à votre recherche.
            @else
                Aucune recette n'a été ajoutée pour le moment.
                <a href="{{ route('recipes.create') }}" class="alert-link">Créez votre première recette</a> !
            @endif
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
            @foreach($recipes as $recipe)
                <div class="col">
                    <div class="card h-100 recipe-card border-0 shadow-sm">
                        <div class="position-relative">
                            @if($recipe->image_path)
                                <img src="{{ asset('storage/' . $recipe->image_path) }}" 
                                     class="card-img-top recipe-image" 
                                     alt="{{ $recipe->title }}">
                            @else
                                <div class="bg-light d-flex justify-content-center align-items-center recipe-image">
                                    <i class="bi bi-camera text-muted" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            <form action="{{ route('recipes.like', $recipe) }}" method="POST" class="position-absolute" style="top: 10px; right: 10px;">
                                @csrf
                                <button type="submit" class="btn btn-like {{ $recipe->isLikedBy(Auth::user()) ? 'liked' : '' }}">
                                    <i class="bi bi-heart-fill"></i>
                                    <span class="likes-count">{{ $recipe->likes_count }}</span>
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary">{{ $recipe->category->name }}</span>
                                <div class="recipe-meta text-muted">
                                    <small><i class="bi bi-clock me-1"></i>{{ ($recipe->prep_time ?? 0) + ($recipe->cooking_time ?? 0) }} min</small>
                                </div>
                            </div>
                            <h5 class="card-title mb-3">{{ $recipe->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($recipe->description, 100) }}</p>
                            
                            <!-- Affichage de la note moyenne -->
                            <div class="recipe-rating mb-3">
                                @php
                                    $avgRating = isset($recipe->ratings_avg_rating) ? $recipe->ratings_avg_rating : $recipe->averageRating();
                                @endphp
                                
                                <div class="d-flex align-items-center">
                                    <div class="rating-stars me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill' : 'bi-star' }} text-warning"></i>
                                        @endfor
                                    </div>
                                    <span class="small text-muted">
                                        {{ number_format($avgRating, 1) }} ({{ $recipe->ratings()->count() }})
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-eye me-1"></i> Voir la recette
                                </a>
                                @if(Auth::check() && (Auth::id() === $recipe->user_id || Auth::user()->isAdmin()))
                                <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $recipes->links() }}
        </div>
    @endif
@endsection

@section('scripts')
<style>
.search-form .input-group {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.search-form .form-control,
.search-form .input-group-text {
    border-color: #e9ecef;
}

.search-form .form-control:focus {
    box-shadow: none;
}

.recipe-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.recipe-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.08) !important;
}

.btn-like {
    background: white;
    border-radius: 20px;
    padding: 0.5rem 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    color: var(--text-muted);
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

.recipe-image {
    height: 200px;
    object-fit: cover;
}

.recipe-meta {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.form-select,
.input-group-text {
    border-color: #e9ecef;
}

.form-select:focus {
    box-shadow: none;
    border-color: var(--primary-color);
}

.btn-primary {
    color: #333333;  /* Couleur plus foncée pour un meilleur contraste */
}

.rating-stars {
    font-size: 0.8rem;
    letter-spacing: 1px;
}
</style>
@endsection 