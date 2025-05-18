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
    ];
    
    /**
     * Get the category that owns the recipe.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
}
