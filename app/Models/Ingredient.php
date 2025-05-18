<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
    ];
    
    /**
     * The recipes that belong to the ingredient.
     */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)
                    ->withPivot('quantity', 'unit')
                    ->withTimestamps();
    }
}
