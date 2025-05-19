<div class="admin-nav card shadow-sm border-0 mb-4">
    <div class="card-body p-0">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link rounded-0 py-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-0 py-3 {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <i class="bi bi-people me-2"></i>Utilisateurs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-0 py-3 {{ request()->routeIs('admin.recipes*') ? 'active' : '' }}" href="{{ route('admin.recipes') }}">
                    <i class="bi bi-journal-richtext me-2"></i>Recettes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-0 py-3" href="{{ route('recipes.index') }}">
                    <i class="bi bi-box-arrow-left me-2"></i>Quitter l'admin
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
.admin-nav .nav-link {
    color: var(--text-color);
    transition: all 0.2s ease;
}

.admin-nav .nav-link:hover:not(.active) {
    background-color: #f8f9fa;
}

.admin-nav .nav-link.active {
    background-color: var(--primary-color);
    color: #fff;
}

.card {
    border-radius: 0.75rem;
    overflow: hidden;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
}

.admin-dashboard-card {
    transition: transform 0.2s ease;
}

.admin-dashboard-card:hover {
    transform: translateY(-3px);
}
</style> 