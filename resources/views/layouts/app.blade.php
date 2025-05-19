<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Cookbook') }} - @yield('title')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #B47846; /* Marron-orange plus terne */
            --secondary-color: #5A6678; /* Gris bleuté plus terne */
            --accent-color: #D0A87F; /* Beige-orange très doux */
            --dark-color: #2D3748; /* Gris très foncé pour plus de contraste */
            --light-color: #F8F9FA; /* Gris très clair */
            --gray-color: #6B7280; /* Gris moyen plus foncé pour meilleur contraste */
            --success-color: #047857; /* Vert sapin plus terne */
            --warning-color: #B45309; /* Ambre foncé */
            --danger-color: #B91C1C; /* Rouge brique */
            --text-muted: #4B5563; /* Gris foncé pour les textes secondaires */
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            color: var(--dark-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 1rem;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--dark-color) !important;
            letter-spacing: -0.5px;
        }
        
        .navbar-brand i {
            color: var(--primary-color);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-muted) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: var(--dark-color) !important;
            background-color: var(--light-color);
        }
        
        .btn {
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #FFFFFF;
        }
        
        .btn-primary:hover {
            background-color: #8D5B35; /* Version plus foncée de la couleur primaire */
            border-color: #8D5B35;
            transform: translateY(-1px);
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        main {
            flex: 1;
        }
        
        footer {
            background-color: var(--light-color) !important;
            color: var(--dark-color);
            padding: 3rem 0 !important;
            margin-top: 4rem !important;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 15px;
            padding: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 500;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            color: var(--dark-color);
            background-color: var(--light-color);
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--light-color);
            color: var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            margin-right: 10px;
        }
        
        .nav-link.dropdown-toggle {
            display: flex;
            align-items: center;
            background: transparent;
        }
        
        .nav-link.dropdown-toggle:hover {
            background-color: var(--light-color);
        }
        
        .alert {
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
        }
        
        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid var(--light-color);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 127, 42, 0.1);
        }
        
        .recipe-card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 25px;
            height: 100%;
        }
        
        .recipe-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
        }
        
        .recipe-image {
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        
        .card-title {
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .card-category {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            font-size: 0.7rem;
            padding: 3px 10px;
            border-radius: 15px;
            margin-bottom: 10px;
        }
        
        .recipe-info {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .recipe-info i {
            color: var(--primary-color);
            margin-right: 5px;
        }
        
        .page-header {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 30px 30px;
            text-align: center;
        }
        
        .page-header h1 {
            font-weight: 700;
            color: var(--light-color);
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: #9CA3AF; /* Gris plus clair pour le contraste sur fond foncé */
            max-width: 700px;
            margin: 0 auto;
        }
        
        .breadcrumb-item.active {
            color: var(--text-muted);
        }
        
        /* Badge pour les catégories */
        .card-category {
            background-color: var(--primary-color);
        }
        
        /* Animation pour les alerts */
        @keyframes slideInDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .alert {
            animation: slideInDown 0.4s ease;
        }
        
        /* Style spécifique pour les liens */
        a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        a:hover {
            color: #E65100;
        }
        
        /* Ajustement global de la navbar */
        .navbar-nav {
            display: flex;
            align-items: center;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
        }
        
        /* Ajustement des icônes dans la navbar */
        .nav-link i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-like:hover,
        .btn-like.liked {
            color: var(--danger-color);
            background: white;
        }
        
        .footer-links a {
            color: #2c3e50;  /* Couleur plus foncée pour un meilleur contraste */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Bandeau d'information projet -->
    <div id="info-banner" class="bg-warning text-dark py-2 text-center" style="font-weight: 500; position: relative;">
        <div class="container">
            <i class="bi bi-info-circle-fill me-2"></i> Ceci est un projet d'entraînement développé dans le cadre du BTS SIO SLAM - CCI de Nîmes
            <button type="button" class="btn-close btn-sm position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%);" aria-label="Fermer" onclick="document.getElementById('info-banner').style.display='none';"></button>
        </div>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-dark mb-0">
        <div class="container">
            <a class="navbar-brand" href="{{ route('recipes.index') }}">
                <i class="bi bi-book me-2"></i><span class="fw-bold">SIO</span> Cookbook <small class="fs-6 fw-light">(Projet étudiant)</small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('recipes.index') ? 'active' : '' }}" href="{{ route('recipes.index') }}">
                            <i class="bi bi-grid me-1"></i>Recettes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="bi bi-tag me-1"></i>Catégories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ingredients.*') ? 'active' : '' }}" href="{{ route('ingredients.index') }}">
                            <i class="bi bi-basket me-1"></i>Ingrédients
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link btn-new-recipe {{ request()->routeIs('recipes.create') ? 'active' : '' }}" href="{{ route('recipes.create') }}">
                                <i class="bi bi-plus-circle me-1"></i> Nouvelle Recette
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                                        <i class="bi bi-person me-2"></i>Mon profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.recipes') }}">
                                        <i class="bi bi-list-check me-2"></i>Mes recettes
                                    </a>
                                </li>
                                @if(Auth::user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-gear me-2"></i>Administration
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>Inscription
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    @hasSection('header')
        <header class="page-header">
            <div class="container">
                @yield('header')
            </div>
        </header>
    @endif
    
    <main class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <footer class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h5 class="mb-3">À propos</h5>
                    <p class="small">SIO Cookbook est une application de gestion de recettes de cuisine développée comme <strong>projet d'entraînement</strong> par un étudiant en BTS SIO SLAM de la CCI de Nîmes.</p>
                </div>
                <div class="col-md-6 footer-links">
                    <h5 class="mb-3">Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('recipes.index') }}">Recettes</a></li>
                        <li><a href="{{ route('categories.index') }}">Catégories</a></li>
                        <li><a href="{{ route('ingredients.index') }}">Ingrédients</a></li>
                        <li><a href="https://github.com/spitzerl/cookbook-laravel" target="_blank"><i class="bi bi-github me-1"></i>Code source</a></li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: rgba(0,0,0,0.1);">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <p class="mb-0">&copy; {{ date('Y') }} SIO Cookbook - Projet d'entraînement</p>
                <p class="mb-0 small"><i class="bi bi-code-square me-1"></i> BTS SIO SLAM - CCI Nîmes</p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    @yield('scripts')
</body>
</html> 