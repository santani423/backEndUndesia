<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id', 'tema_id');
    }
}
