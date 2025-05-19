<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur administrateur
        User::create([
            'name' => 'Admin',
            'email' => 'admin@cookbook.fr',
            'password' => Hash::make('Admin123!'),
            'is_admin' => true,
        ]);
        
        $this->command->info('Utilisateur administrateur créé avec succès !');
        $this->command->info('Email: admin@cookbook.fr');
        $this->command->info('Mot de passe: Admin123!');
    }
} 