<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeVideo extends Model
{
    use HasFactory;

    protected $table = 'themes_video';
    protected $primaryKey = 'id_theme';
    public $timestamps = false; // karena tidak ada kolom created_at / updated_at

    protected $fillable = [
        'nama_tema',
        'harga',
        'preview',
        'url_video',
        'category_id',
    ];
}
