<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function mempelai()
    {
        return $this->hasOne(Mempelai::class, 'id_user');
    }

    public function album()
    {
        return $this->hasMany(Album::class, 'id_user');
    }

    public function cerita()
    {
        return $this->hasMany(Cerita::class, 'id_user');
    }

    public function quote()
    {
        return $this->hasOne(Quote::class, 'id_user');
    }

    public function data()
    {
        return $this->hasOne(Data::class, 'id_user');
    }

    public function acara()
    {
        return $this->hasMany(Acara::class, 'id_user');
    }

    public function rekening()
    {
        return $this->hasMany(Rekening::class, 'id_user');
    }

    public function rules()
    {
        return $this->hasOne(Rules::class, 'id_user');
    }

    public function dressCode()
    {
        return $this->hasOne(DressCode::class, 'id_user');
    }

    
}
