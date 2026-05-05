<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    public function asset()
    {
        return $this->hasMany(Asset::class, 'tema_id', 'id');
    }
}
