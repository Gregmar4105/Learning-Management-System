<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizItem extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_master_id', 'question', 'A', 'B', 'C', 'D', 'question_answer'];

    public function quizMaster(): BelongsTo
    {
        return $this->belongsTo(QuizMaster::class, 'quiz_master_id'); // Make sure the foreign key is specified
    }
}
