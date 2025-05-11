<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamMaster extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'title', 'exam_key'];

    public function items(): HasMany
    {
        return $this->hasMany(ExamItem::class, 'exam_master_id'); // Correct foreign key
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
