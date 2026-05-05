<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function asset()
    {
        return $this->belongsTo(AssetSize::class, 'asset_id', 'id');
    }
}
