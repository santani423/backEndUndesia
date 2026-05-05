<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetSize extends Model
{
    public function breakpoint()
    {
        return $this->belongsTo(BreackPoin::class, 'breack_poin_id');
    }

    public function sizeTema()
    {
        return $this->belongsTo(SizeTema::class, 'size_tema_id');
    }
}
