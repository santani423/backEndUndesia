<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komen extends Model
{
    protected $table = 'komen';
    protected $fillable = [
        'id_user',
        'nama_komentar',
        'isi_komentar',
    ];
}
