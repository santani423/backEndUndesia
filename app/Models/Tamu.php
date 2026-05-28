<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $table = 'tamu';
    protected $primaryKey = 'id_tamu';
    public $timestamps = false;
    protected $fillable = ['nama_tamu', 'nama_slug', 'alamat_tamu', 'alamat_slug', 'no_wa', 'qrcode', 'id_user', 'tgl_kirim', 'status_kirim', 'status', 'waktu_hadir'];


     public function rsvp()
     {
         return $this->hasOne(Rsvp::class, 'tamu_id');
     }
}
