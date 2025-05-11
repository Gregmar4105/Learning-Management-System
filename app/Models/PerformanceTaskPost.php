<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Belongsto;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerformanceTaskPost extends Model
{
    
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'course_id', // Assuming you have a user_id field for the foreign key
       
    ];

    // Your existing relationships (creator, course)
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get all attachments for the assignment post.
     */
    public function attachments(): HasMany // Define the new relationship
    {
        return $this->hasMany(PerformanceTaskAttachment::class);
    }
    
    public function uploads(): HasMany
    {
        return $this->hasMany(PerformanceTaskUpload::class);
    }
}

