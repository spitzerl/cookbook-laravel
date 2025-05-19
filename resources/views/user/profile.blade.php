@extends('layouts.app')

@section('title', 'Mon Profil')

@section('header')
    <h1>Mon Profil</h1>
    <p>Gérez vos informations personnelles</p>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="position-relative mb-4">
                                <div class="user-avatar-large mx-auto d-flex align-items-center justify-content-center bg-primary text-white rounded-circle" style="width: 150px; height: 150px; font-size: 3rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            </div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-2">{{ $user->email }}</p>
                            <div class="mb-3">
                                <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'secondary' }} p-2">
                                    {{ $user->isAdmin() ? 'Administrateur' : 'Membre' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('user.recipes') }}" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-journal-text me-1"></i>Mes Recettes
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Statistiques</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="py-2">
                                                <h2 class="mb-0 text-primary">{{ $recipesCount }}</h2>
                                                <p class="text-muted mb-0">Recettes créées</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="py-2">
                                                <h2 class="mb-0 text-primary">{{ $user->created_at->diffForHumans(null, true) }}</h2>
                                                <p class="text-muted mb-0">Membre depuis</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Mes Informations</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="#">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nom</label>
                                            <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Adresse e-mail</label>
                                            <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                        </div>
                                        
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary" disabled>
                                                <i class="bi bi-save me-1"></i>Mettre à jour
                                            </button>
                                            <small class="text-muted text-center mt-2">La mise à jour du profil sera disponible prochainement</small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 