<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur qui note
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade'); // Recette notée
            $table->integer('rating')->comment('Note de 1 à 5 étoiles');
            $table->text('comment')->nullable(); // Commentaire optionnel
            $table->timestamps(); // Date de création et de mise à jour
            
            // Empecher plusieurs notations
            $table->unique(['user_id', 'recipe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
