<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'address',
        'store_level_id',
    ];

    public function level()
    {
        return $this->belongsTo(Store_level::class, 'store_level_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'store_users')
            ->withPivot('role_id')
            ->withTimestamps();
    }
}
