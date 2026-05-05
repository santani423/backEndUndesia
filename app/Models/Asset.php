<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function assetSizes()
    {
        return $this->hasMany(AssetSize::class, 'asset_id', 'id');
    }
}
