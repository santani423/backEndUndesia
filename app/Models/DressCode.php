<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DressCode extends Model
{
    protected $table = 'dress_code';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function codeItem()
    {
        return $this->hasOne(DressCodeItem::class, 'dress_code_id ');
    }
    public function codePalette()
    {
        return $this->hasOne(DressCodePalette::class, 'dress_code_id ');
    }
}
