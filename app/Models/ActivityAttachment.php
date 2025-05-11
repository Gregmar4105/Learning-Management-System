<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'activity_post_id',
        'file_path',
        'original_name',
    ];

    /**
     * Get the assignment post that this attachment belongs to.
     */
    public function activityPost(): BelongsTo
    {
        return $this->belongsTo(ActivityPost::class);
    }
}