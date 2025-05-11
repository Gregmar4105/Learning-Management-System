<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamItem extends Model
{
    use HasFactory;

    protected $fillable = ['exam_master_id', 'question', 'A', 'B', 'C', 'D', 'question_answer'];

    public function quizMaster(): BelongsTo
    {
        return $this->belongsTo(ExamMaster::class, 'exam_master_id'); // Make sure the foreign key is specified
    }
}
