<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeColor extends Model
{
    protected $fillable = ['tema_id', 'key', 'value', 'label', 'group'];
}
