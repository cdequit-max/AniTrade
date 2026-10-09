<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'store_name', 'email', 'role', 'phone', 'address', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'phone' => 'encrypted',
            'address' => 'encrypted',
        ];
    }

    public function isStore(): bool
    {
        return $this->role === 'store';
    }

    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    /** Name of the route that holds this user's dashboard. */
    public function dashboardRoute(): string
    {
        return $this->isStore() ? 'store.dashboard' : 'buyer.dashboard';
    }

    /** Name shown in the sidebar / navbar. */
    public function displayName(): string
    {
        return $this->isStore() && $this->store_name ? $this->store_name : $this->name;
    }

    public function produces(): HasMany
    {
        return $this->hasMany(Produce::class, 'store_id');
    }

    /** Orders placed by this user (buyer). */
    public function purchases(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    /** Orders received by this user (store). */
    public function sales(): HasMany
    {
        return $this->hasMany(Order::class, 'store_id');
    }
}
