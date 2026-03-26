<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'judul', 'target_date', 'status'];

    // status: pending | done

    protected function casts(): array
    {
        return ['target_date' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
