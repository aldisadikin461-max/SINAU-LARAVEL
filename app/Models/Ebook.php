<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'judul',
        'penulis',
        'file_path',
        'cover',
        'jurusan',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
