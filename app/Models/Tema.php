<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $fillable = ['name', 'code'];

    public function assets()
    {
          return $this->hasMany(Asset::class, 'tema_id', 'id');
    }
}
