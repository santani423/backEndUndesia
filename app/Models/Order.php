<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $table = 'order';

     public function getUser()
     {
         return $this->belongsTo(User::class, 'id_user');
     }
}
