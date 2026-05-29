<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DressCode extends Model
{
    protected $table = 'dress_codes';

    
    public function codeItem()
    {
        return $this->hasMany(DressCodeItem::class, 'dress_code_id');
    }
    public function codePalette()
    {
        return $this->hasMany(DressCodePalette::class, 'dress_code_id');
    }
}
