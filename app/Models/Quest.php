<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi', 'target', 'poin_reward', 'tipe'];

    public function userQuests()
    {
        return $this->hasMany(UserQuest::class);
    }
}
