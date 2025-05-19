<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'instructions',
        'prep_time',
        'cooking_time',
        'servings',
        'difficulty',
        'image_path',
        'category_id',
        'user_id',
    ];
    
    /**
     * Get the category that owns the recipe.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get the user that owns the recipe.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * The ingredients that belong to the recipe.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
                    ->withPivot('quantity', 'unit')
                    ->withTimestamps();
    }

    /**
     * Les utilisateurs qui ont liké la recette.
     */
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'recipe_likes')
                    ->withTimestamps();
    }

    /**
     * Vérifie si un utilisateur a liké la recette.
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        return $this->likedBy()->where('user_id', $user->id)->exists();
    }

    /**
     * Nombre total de likes.
     */
    public function getLikesCountAttribute(): int
    {
        return $this->likedBy()->count();
    }
}
