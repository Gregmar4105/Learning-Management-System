<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Quiz;
use Livewire\Component;
use Illuminate\Support\Facades\Log; // Import the Log facade

class ShowQuizzes extends Component
{
    public $course = '';
    public $availableQuizzes;

    public function mount()
    {
        $this->loadAvailableQuizzes();
    }

    public function loadAvailableQuizzes()
    {
        $query = Quiz::whereNotNull('quiz_key');
        if ($this->course) {
            $query->where('course_id', $this->course);
        }
        $this->availableQuizzes = $query->get();
    }

    public function updatedCourse($value)
    {
        $this->loadAvailableQuizzes();
    }

    public function render()
    {
        $courses = Course::withCount('quizzes')->get();

        // Add logging here to check the contents of $courses
        Log::info('Courses data in render:', ['courses' => $courses]);

        return view('livewire.show-quizzes', compact('courses'));
    }
}
