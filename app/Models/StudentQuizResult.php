<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class StudentQuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'correct_answers',
        'total_questions',
        'score',
    ];

    /**
     * Get the student who took the quiz.
     */
    public function student(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}

    /**
     * Get the quiz that was taken.
     */
    public function quiz(): BelongsTo
{
    return $this->belongsTo(Quiz::class);
}
}