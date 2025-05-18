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
            --primary-color: #FF7F2A; /* Orange */
            --secondary-color: #757575; /* Gris moyen */
            --accent-color: #FFA559; /* Orange clair */
            --dark-color: #424242; /* Gris foncé */
            --light-color: #F5F5F5; /* Gris très clair */
            --gray-color: #BDBDBD; /* Gris clair */
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAFAFA;
            color: var(--dark-color);
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--dark-color), #616161) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.8rem 1rem;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 1px;
        }
        
        .nav-link {
            font-weight: 500;
            margin: 0 5px;
            position: relative;
            transition: all 0.3s;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            left: 0;
            bottom: -2px;
            transition: width 0.3s;
        }
        
        .nav-link:hover:after, .nav-link.active:after {
            width: 100%;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #E65100; /* Orange plus foncé */
            border-color: #E65100;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .recipe-card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 25px;
            height: 100%;
        }
        
        .recipe-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
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
            background-color: var(--secondary-color);
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
            color: var(--gray-color);
            max-width: 700px;
            margin: 0 auto;
        }
        
        footer {
            background-color: var(--dark-color) !important;
            color: var(--light-color);
            padding: 2rem 0 !important;
            margin-top: 4rem !important;
        }
        
        .alert {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        /* Form styling */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            border: 1px solid var(--gray-color);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 127, 42, 0.25); /* Orange transparent */
        }
        
        label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
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
        
        .breadcrumb-item.active {
            color: var(--secondary-color);
        }
        
        /* Badge pour les catégories */
        .card-category {
            background-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-0">
        <div class="container">
            <a class="navbar-brand" href="{{ route('recipes.index') }}">
                <i class="bi bi-book me-2"></i>{{ config('app.name', 'Cookbook') }}
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
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('recipes.create') ? 'active' : '' }}" href="{{ route('recipes.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Nouvelle Recette
                        </a>
                    </li>
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
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">À propos</h5>
                    <p class="small">Cookbook est votre application de gestion de recettes de cuisine. Organisez, découvrez et partagez vos meilleures créations culinaires.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('recipes.index') }}" class="text-white text-decoration-none">Recettes</a></li>
                        <li><a href="{{ route('categories.index') }}" class="text-white text-decoration-none">Catégories</a></li>
                        <li><a href="{{ route('ingredients.index') }}" class="text-white text-decoration-none">Ingrédients</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Contact</h5>
                    <p class="small">Si vous avez des questions ou des suggestions, n'hésitez pas à nous contacter.</p>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: rgba(255,255,255,0.1);">
            <p class="mb-0">&copy; {{ date('Y') }} Cookbook. Tous droits réservés.</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    @yield('scripts')
</body>
</html> 