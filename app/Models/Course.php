<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'course_key',
        'course_description',
        'user_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignmentPosts()
    {
        return $this->hasMany(AssignmentPost::class); // Adjust the class name if needed
    }
    public function Module()
    {
        return $this->hasMany(Module::class); // Adjust the class name if needed
    }

    public function enrolledUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_enrolled', 'course_id', 'user_id');
    }

    // app/Models/Course.php

    public function quizzes(): HasMany
    {
        return $this->hasMany(QuizMaster::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(ExamMaster::class);
    }
}
