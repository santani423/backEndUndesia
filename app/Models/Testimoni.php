<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimoni';
    protected $primaryKey = 'id_testi';
    public $timestamps = false; // karena tabel tidak ada created_at & updated_at

    protected $fillable = [
        'id_user',
        'nama_lengkap',
        'kota',
        'provinsi',
        'ulasan',
        'status',
    ];
}
