<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $table = 'themes';
    protected $primaryKey = 'id';

    public $timestamps = true; // karena ada created_at & updated_at

    protected $fillable = [
        'nama_theme',
        'kode_theme',
        'status',
        'category_id',
    ];

    /**
     * Relasi ke tabel tema_categories
     */
    public function category()
    {
        return $this->belongsTo(TemaCategory::class, 'category_id', 'id');
    }
}
