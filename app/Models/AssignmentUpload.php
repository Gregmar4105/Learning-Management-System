<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentUpload extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'file_path',
        'original_name',
        'assignment_post_id', // Foreign key for the assignment post
    ];

    public function assignmentPost()
    {
        return $this->belongsTo(AssignmentPost::class);
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
