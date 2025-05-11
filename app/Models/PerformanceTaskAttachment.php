<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceTaskAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'performance_task_post_id',
        'file_path',
        'original_name',
    ];

    /**
     * Get the assignment post that this attachment belongs to.
     */
    public function performanceTaskPost(): BelongsTo
    {
        return $this->belongsTo(PerformanceTaskPost::class);
    }
}
