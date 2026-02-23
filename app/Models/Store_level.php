<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store_level extends Model
{
    protected $fillable = [
        'name',
    ];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
