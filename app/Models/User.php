<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nickname',
        'username',
        'email',
        'password',
        'current_weight',
        'target_weight',
        'google_id',
        'avatar',
        'subscription_plan',
        'subscription_ends_at',
        'role',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'current_weight' => 'float',
        'target_weight' => 'float',
        'subscription_ends_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    // ========== HELPER METHODS ==========

    public function isPremium()
    {
        return in_array($this->subscription_plan, ['starter', 'starter_plus']);
    }

    public function isStarterPlus()
    {
        return $this->subscription_plan === 'starter_plus';
    }

    public function isStarter()
    {
        return $this->subscription_plan === 'starter';
    }

    public function isFree()
    {
        return $this->subscription_plan === 'free';
    }

        public function isAdmin(): bool
    {
         return ($this->role ?? null) === 'admin' || (bool) ($this->is_admin ?? false);
    }


    // ========== RELATIONSHIPS ==========

    // Relationship dengan Recipe
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'user_id');
    }


}
