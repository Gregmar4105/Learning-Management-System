<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth; // Corrected namespace
use Flux;
use Illuminate\Validation\Rule;

class ManageCoursePost extends Component
{
    public $course_name; // Add this public property
    public $course_key;  // Add this public property
    public $reload;
    public $course_description; // Add this public property
    public $currentlyEditingId;

    public function render()
    {
        $courses = Course::with('creator')->get(); // Eager load the creator
        return view('livewire.manage-course-post', compact('courses'));
    }

    #[On(("reload"))]
    public function reload()
    {
        $this->reload = Course::with('creator')->get(); // Use get() instead of all() for consistency with render
    }

    public function submit()
    {


        $this->validate([
            'course_name' => 'required|string|max:255',
            'course_key' => 'required|string|max:255',
            'course_description' => 'required|string|max:255',
        ]);

        //dd($this->course_name, $this->course_key, Auth::id());

        Course::create([
            'course_name' => $this->course_name,
            'course_key' => $this->course_key,
            'course_description' => $this->course_description,
            'user_id' => Auth::id(),
        ]);

        $this->resetForm();
        // Assuming resetForm() is a method you have defined in this component
        $this->dispatch('reload'); // Dispatch the reload event
        Flux::modal("create-course")->close();
    }

    public function resetForm()
    {
        $this->course_name = '';
        $this->course_key = '';
        $this->course_description = '';
    }

    public function edit($id)
    {
        $course = Course::find($id);
        $this->currentlyEditingId = $id; // Store the ID of the user being edited
        $this->course_name = $course->course_name;
        $this->course_key = $course->course_key;
        $this->course_description = $course->course_description;
        Flux::modal("edit-course")->show();
    }

    public function update() // we use $this->currentlyEditingId
    {
        $this->validate([
            'course_name' => 'required|string|max:255',
            'course_key' => [
                'required',
                'max:255',
            ],
        ]);

        $course = Course::find($this->currentlyEditingId);
        if ($course) {
            $course->course_name = $this->course_name;
            $course->course_key = $this->course_key;
            
            $course->save();

            $this->resetForm();
            Flux::modal("edit-course")->close();
        } else {
            // Handle the case where the user with the ID is not found
            session()->flash('error', 'User not found.');
        }
    }
}