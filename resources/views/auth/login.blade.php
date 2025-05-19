@extends('layouts.app')

@section('title', 'Connexion')

@section('header')
    <h1>Connexion</h1>
    <p>Connectez-vous pour gérer vos recettes</p>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Connexion
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <p class="mb-0">
                                Vous n'avez pas de compte ? <a href="{{ route('register') }}" class="text-decoration-none">Créer un compte</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 