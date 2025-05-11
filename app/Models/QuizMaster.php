<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizMaster extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'title', 'quiz_key'];

    public function items(): HasMany
    {
        return $this->hasMany(QuizItem::class, 'quiz_master_id'); // Correct foreign key
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}