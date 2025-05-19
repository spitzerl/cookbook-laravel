@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('header')
    <div class="text-center mb-4">
        <h1 class="display-5">Gestion des Utilisateurs</h1>
        <p class="lead">Gérez les comptes utilisateurs de votre application</p>
    </div>
@endsection

@section('content')
    @include('layouts.admin_tabs')
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="bi bi-people me-2"></i>Utilisateurs ({{ count($users) }})</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i>Tableau de bord
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Utilisateur</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Inscription</th>
                            <th class="py-3">Recettes</th>
                            <th class="py-3">Rôle</th>
                            <th class="text-end pe-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initials me-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <div class="text-muted small">#{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">{{ $user->email }}</td>
                                <td class="py-3"><span class="text-muted">{{ $user->created_at->format('d/m/Y') }}</span></td>
                                <td class="py-3">
                                    <span class="badge bg-light text-dark rounded-pill">{{ $user->recipes_count }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge rounded-pill {{ $user->isAdmin() ? 'bg-danger' : 'bg-secondary' }}">
                                        {{ $user->isAdmin() ? 'Admin' : 'Membre' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4 py-3">
                                    @if(auth()->id() !== $user->id)
                                        <div class="d-flex gap-1 justify-content-end">
                                            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-action btn-sm {{ $user->isAdmin() ? 'btn-outline-warning' : 'btn-outline-success' }}" 
                                                        title="{{ $user->isAdmin() ? 'Rétrograder en membre' : 'Promouvoir en admin' }}">
                                                    <i class="bi bi-{{ $user->isAdmin() ? 'person' : 'person-check-fill' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-action btn-sm btn-outline-primary" title="Modifier l'utilisateur">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-action btn-sm btn-outline-danger" 
                                                        title="Supprimer l'utilisateur" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur? Toutes ses recettes seront également supprimées.')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="d-flex gap-1 justify-content-end">
                                            <button class="btn btn-action btn-sm btn-outline-secondary" disabled title="Vous ne pouvez pas modifier votre propre statut">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                            
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-action btn-sm btn-outline-primary" title="Modifier votre profil">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-people text-muted mb-3" style="font-size: 2rem;"></i>
                                        <h5>Aucun utilisateur trouvé</h5>
                                        <p class="text-muted">Il n'y a pas encore d'utilisateurs enregistrés.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection 