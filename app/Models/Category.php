<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori', 'tipe'];

    // tipe: mapel_umum | mapel_jurusan

    public function ebooks()
    {
        return $this->hasMany(Ebook::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }
}
