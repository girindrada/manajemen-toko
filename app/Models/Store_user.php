<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store_user extends Model
{
    protected $table = 'store_users';

    protected $fillable = [
        'store_id',
        'user_id',
        'role_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storeUsers()
    {
        return $this->hasMany(Store_user::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
