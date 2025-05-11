<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException; // Import ValidationException

class EnrollSearchBar extends Component
{
    public $search = '';
    public $courses = [];
    public $enrollCourses;
    public $course_id;
    public $course_name;
    public $description;
    public $course_key;

    protected $listeners = ['enroll'];

    public function mount()
    {
        $this->courses = [];
        $this->enrollCourses = Course::all();
    }

    public function render()
    {
        $this->loadSearchCourses();

        return view('livewire.enroll-search-bar', [
            'courses' => $this->courses,
            'enrollCourses' => $this->enrollCourses,
        ]);
    }

    private function loadSearchCourses()
    {
        if ($this->search) {
            $this->courses = Course::where('course_name', 'like', '%' . $this->search . '%')
                ->orWhere('course_description', 'like', '%' . $this->search . '%')
                ->get();
        } else {
            $this->courses = [];
        }
    }

    public function CourseKey($id)
    {
        $course = Course::find($id);
        $this->course_id = $id;
        $this->course_name = $course->course_name;
        $this->description = $course->course_description;
        Flux::modal('course-passkey')->show();
    }

    public function enroll()
    {
        $course = Course::find($this->course_id);

        if ($course->course_key === $this->course_key) {
            // Correct Key: Enroll the user
            $user = Auth::user();

            if ($user) {
                try {
                    $user->enrolledCourses()->attach($this->course_id);
                    session()->flash('message', 'Successfully enrolled in ' . $this->course_name);
                    Flux::modal('course-passkey')->close();
                    Flux::modal('search')->close();
                    $this->resetInputFields();
                    
                } catch (\Exception $e) {
                    Log::error('Enrollment Error: ' . $e->getMessage(), [
                        'user_id' => Auth::id(),
                        'course_id' => $this->course_id,
                    ]);
                    session()->flash('error', 'Failed to enroll. Please try again.');
                    Flux::modal('course-passkey')->close();
                }
            } else {
                Log::warning('Enrollment attempted with no user.', [
                    'course_id' => $this->course_id,
                ]);
                session()->flash('error', 'No user is logged in. Please log in and try again.');
                Flux::modal('course-passkey')->close();
            }
        } else {
            // Incorrect Key: Show an error message
           try {
                $this->addError('course_key', 'Incorrect course key.');
                return;
            } catch (ValidationException $e) {
                 session()->flash('error', $e->validator->getMessageBag()->first());
                Flux::modal('course-passkey')->close();
            }
        }
    }

    private function resetInputFields()
    {
        $this->course_key = '';
        $this->course_id = null;
        $this->course_name = '';
        $this->description = '';
    }
}
