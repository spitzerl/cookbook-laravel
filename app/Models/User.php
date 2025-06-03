<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
    
    /**
     * Check if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }
    
    /**
     * Get the recipes created by the user.
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
    
    /**
     * Get the ratings created by the user.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
    
    /**
     * Get the recipes liked by the user.
     */
    public function likedRecipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_likes')
                    ->withTimestamps();
    }
}
