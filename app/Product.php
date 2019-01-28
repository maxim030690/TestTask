<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'users', 'user_id');
    }

    public function type()
    {
        return $this->BelongsTo(Types::class);
    }
}
