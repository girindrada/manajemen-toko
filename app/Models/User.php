<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // for jwt
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    // for jwt end

    // user bekerja di banyak store
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_users')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function storeUsers()
    {
        return $this->hasMany(Store_user::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // helper to cek role user in middleware and controller
    public function hasRole(string $roleName): bool
    {
        // return true/false
        return $this->storeUsers()->whereHas('role', fn($q) => $q->where('name', $roleName))->exists();
    }

    public function getRoleInStore(int $storeId)
    {
        return $this->storeUsers()->with('role')->where('store_id', $storeId)->first()?->role?->name;
    }
}
