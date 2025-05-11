<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Module;
use App\Models\Course;
use App\Models\ModuleAttachment; // Import the new model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Modules extends Component
{
    use WithFileUploads;

    public $course = '';

    // Properties for the Create Assignment Modal Form
    public $newModuleCourseId = null;
    public $title = '';
    public $body = '';
    public $attachments = []; // Initialize as empty array for multiple files
    public $ModuleId;
    public $module;

    public function render()
    {
        // Get the currently logged-in user
        $user = Auth::user();
    
        // Get the courses that the user is enrolled in
        $courses = $user->enrolledCourses()->orderBy('course_name')->get();
    
        // Eager load assignments along with creator and course
        $modules = Module::with(['creator', 'course', 'attachments'])
            ->whereHas('course', function ($query) use ($user) {
                // Filter assignments to only include those from courses the user is enrolled in
                $query->whereIn('id', $user->enrolledCourses->pluck('id'));
            })
            ->when($this->course, function ($query, $selectedCourseId) use ($user) {
                // If a course is selected, further filter assignments to that course AND ensure the user is enrolled in it.
                $query->where('course_id', $selectedCourseId);
                 $query->whereIn('course_id', $user->enrolledCourses->pluck('id'));
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('livewire.modules', compact('modules', 'courses'));
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'newModuleCourseId' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,mov,avi,webm|max:50200',
        ]);
        //dd($this->validatedData);

        // 1. Create the Assignment Post (faculty)
        $module = Module::create([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'user_id' => Auth::id(),
            'course_id' => $validatedData['newModuleCourseId'],
        ]);

        //dd($module);

        // 2. Handle Attachments (faculty)
        if ($this->attachments) {
            foreach ($this->attachments as $attachmentFile) {
                $filePath = $attachmentFile->store('module_attachments', 'public');
                $originalName = $attachmentFile->getClientOriginalName();

                ModuleAttachment::create([
                    'module_id' => $module->id,
                    'file_path' => $filePath,
                    'original_name' => $originalName,
                ]);
            }
        }

        session()->flash('message', 'Assignment created successfully.');
        $this->resetForm();
        Flux::modal("create-module")->close();
        // $this->emitSelf('refresh-assignments'); // Removed this line
    }
    public function resetForm()
    {
        $this->reset(['title', 'body', 'newModuleCourseId', 'attachments']);
        $this->resetErrorBag();
    }
}
