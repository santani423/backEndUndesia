<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['tema_id', 'path', 'name', 'type'];

    public function assetSizes()
    {
        return $this->hasMany(AssetSize::class, 'asset_id', 'id');
    }
}
