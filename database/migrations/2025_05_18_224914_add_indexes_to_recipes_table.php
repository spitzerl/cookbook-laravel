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
        Schema::table('recipes', function (Blueprint $table) {
            $table->index('title');
            $table->index('description');
            $table->index('created_at');
            $table->index('category_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['description']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['user_id']);
        });
    }
};
