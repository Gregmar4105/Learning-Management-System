<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceTaskUpload extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'file_path',
        'original_name',
        'performance_task_post_id', // Foreign key for the assignment post
    ];

    public function performanceTasktPost()
    {
        return $this->belongsTo(PerformanceTaskPost::class);
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
