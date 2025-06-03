<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'recipe_id',
        'rating',
        'comment'
    ];
    
    /**
     * Obtenir l'utilisateur qui a créé cette note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Obtenir la recette notée.
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
