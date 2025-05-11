<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityUpload extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'file_path',
        'original_name',
        'activity_post_id', // Foreign key for the assignment post
    ];

    public function activityPost()
    {
        return $this->belongsTo(ActivityPost::class);
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
