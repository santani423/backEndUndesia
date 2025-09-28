<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemaCategory extends Model
{
    use HasFactory;

    protected $table = 'tema_categories';

    protected $fillable = [
        'name',
        'slug',
    ];

    // Contoh mutator untuk otomatis membuat slug dari name
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug =  $model->name;
            }
        });
    }

    // Fungsi untuk ambil semua kategori
    public static function getAllCategories()
    {
        return self::orderBy('name', 'asc')->get();
    }

    // Fungsi untuk ambil kategori berdasarkan slug
    public static function getBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }

    // Fungsi untuk membuat kategori baru
    public static function createCategory($data)
    {
        return self::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);
    }

    // Fungsi update kategori
    public function updateCategory($data)
    {
        $this->name = $data['name'] ?? $this->name;
        $this->slug = $data['slug'] ?? $this->name;
        $this->save();

        return $this;
    }

    // Fungsi delete kategori
    public function deleteCategory()
    {
        return $this->delete();
    }
}
