<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ActivityPost;
use App\Models\Course;
use App\Models\ActivityAttachment; // Import the new model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\ActivityUpload;

class Activities extends Component
{
    use WithFileUploads;

    public $course = '';

    // Properties for the Create Assignment Modal Form
    public $newActivityCourseId = null;
    public $title = '';
    public $body = '';
    public $attachments = []; // Initialize as empty array for multiple files
    public $activityPostId;
    

    // Validation Rules - UPDATED for multiple files
    protected function rules()
    {
        return [
            'newActivityCourseId' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array', // Expect an array (or null)
             // Validate EACH file in the array (adjust size/mimes as needed)
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,mov,avi,webm|max:50200',
        ];
    }

    // Render method - UPDATED Eager Loading
    public function render()
    {
        // Get the currently logged-in user
        $user = Auth::user();
    
        // Get the courses that the user is enrolled in
        $courses = $user->enrolledCourses()->orderBy('course_name')->get();
    
        // Eager load assignments along with creator and course
        $activities = ActivityPost::with(['creator', 'course', 'attachments'])
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
    
        return view('livewire.activities', compact('activities', 'courses'));
    }

    // Submit method - UPDATED Logic
    public function submit()
    {
        $validatedData = $this->validate([
            'newActivityCourseId' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,mov,avi,webm|max:50200',
        ]);

        // 1. Create the Assignment Post (faculty)
        $activityPost = ActivityPost::create([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'user_id' => Auth::id(),
            'course_id' => $validatedData['newActivityCourseId'],
        ]);

        // 2. Handle Attachments (faculty)
        if ($this->attachments) {
            foreach ($this->attachments as $attachmentFile) {
                $filePath = $attachmentFile->store('activity_attachments', 'public');
                $originalName = $attachmentFile->getClientOriginalName();

                ActivityAttachment::create([
                    'activity_post_id' => $activityPost->id,
                    'file_path' => $filePath,
                    'original_name' => $originalName,
                ]);
            }
        }

        session()->flash('message', 'Assignment created successfully.');
        $this->resetForm();
        Flux::modal("create-activity")->close();
        // $this->emitSelf('refresh-assignments'); // Removed this line
    }

    public function resetForm()
    {
        $this->reset(['title', 'body', 'newActivityCourseId', 'attachments']);
        $this->resetErrorBag();
    }

    // Method to show the upload modal (student)
    public function uploadshow($id)
    {
        $this->activityPostId = $id;
        Flux::modal("upload-activity")->show();
    }

    // Method to handle student assignment uploads
    public function uploadActivity()
    {
        $this->validate([
            
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array', // Expect an array (or null)
             // Validate EACH file in the array (adjust size/mimes as needed)
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,mov,avi,webm|max:50200',
            'activityPostId' => 'required|exists:assignment_posts,id',
        ]);

        //dd($this->title,$this->body,$this->attachments,$this->assignmentPostId);
        
        if ($this->attachments) {
            foreach ($this->attachments as $attachmentFile) {
                //dd($attachmentFile);
                $filePath = $attachmentFile->store('activity_attachments', 'public');
                $originalName = $attachmentFile->getClientOriginalName();

                ActivityUpload::create([
                    'activity_post_id' => $this->activityPostId,
                    'user_id' => Auth::id(),
                    'title' => $this->title,
                    'description' => $this->body,
                    'file_path' => $filePath,
                    'original_name' => $originalName,
                ]);
                
            }
        }
        $this->reset(['title', 'body', 'attachments']); // Reset student form
        Flux::modal("upload-activity")->close();

        session()->flash('message', 'Assignment uploaded successfully!');
        // $this->emitSelf('refresh-assignments'); // Removed this line
    }
}


