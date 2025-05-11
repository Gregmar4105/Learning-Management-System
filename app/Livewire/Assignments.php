<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AssignmentPost;
use App\Models\Course;
use App\Models\AssignmentAttachment; // Import the new model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\AssignmentUpload;


class Assignments extends Component
{
    use WithFileUploads;

    public $course = '';

    // Properties for the Create Assignment Modal Form
    public $newAssignmentCourseId = null;
    public $title = '';
    public $body = '';
    public $attachments = []; // Initialize as empty array for multiple files
    public $assignmentPostId;
    

    // Validation Rules - UPDATED for multiple files
    protected function rules()
    {
        return [
            'newAssignmentCourseId' => 'required|exists:courses,id',
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
        $assignments = AssignmentPost::with(['creator', 'course', 'attachments'])
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
    
        return view('livewire.assignments', compact('assignments', 'courses'));
    }

    // Submit method - UPDATED Logic
    public function submit()
    {
        $validatedData = $this->validate([
            'newAssignmentCourseId' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,mov,avi,webm|max:50200',
        ]);

        // 1. Create the Assignment Post (faculty)
        $assignmentPost = AssignmentPost::create([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'user_id' => Auth::id(),
            'course_id' => $validatedData['newAssignmentCourseId'],
        ]);

        // 2. Handle Attachments (faculty)
        if ($this->attachments) {
            foreach ($this->attachments as $attachmentFile) {
                $filePath = $attachmentFile->store('assignment_attachments', 'public');
                $originalName = $attachmentFile->getClientOriginalName();

                AssignmentAttachment::create([
                    'assignment_post_id' => $assignmentPost->id,
                    'file_path' => $filePath,
                    'original_name' => $originalName,
                ]);
            }
        }

        session()->flash('message', 'Assignment created successfully.');
        $this->resetForm();
        Flux::modal("create-assignment")->close();
        // $this->emitSelf('refresh-assignments'); // Removed this line
    }

    public function viewAssignment($id)
    {
        session()->flash('info', "Viewing assignment ID: $id (implement view logic)");
    }

    public function resetForm()
    {
        $this->reset(['title', 'body', 'newAssignmentCourseId', 'attachments']);
        $this->resetErrorBag();
    }

    // Method to show the upload modal (student)
    public function uploadshow($id)
    {
        $this->assignmentPostId = $id;
        Flux::modal("upload-assignment")->show();
    }

    // Method to handle student assignment uploads
    public function uploadAssignment()
    {
        $this->validate([
            
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array', // Expect an array (or null)
             // Validate EACH file in the array (adjust size/mimes as needed)
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,mov,avi,webm|max:50200',
            'assignmentPostId' => 'required|exists:assignment_posts,id',
        ]);

        //dd($this->title,$this->body,$this->attachments,$this->assignmentPostId);
        
        if ($this->attachments) {
            foreach ($this->attachments as $attachmentFile) {
                //dd($attachmentFile);
                $filePath = $attachmentFile->store('assignment_attachments', 'public');
                $originalName = $attachmentFile->getClientOriginalName();

                AssignmentUpload::create([
                    'assignment_post_id' => $this->assignmentPostId,
                    'user_id' => Auth::id(),
                    'title' => $this->title,
                    'description' => $this->body,
                    'file_path' => $filePath,
                    'original_name' => $originalName,
                ]);
                
            }
        }
        $this->reset(['title', 'body', 'attachments']); // Reset student form
        Flux::modal("upload-assignment")->close();

        session()->flash('message', 'Assignment uploaded successfully!');
        // $this->emitSelf('refresh-assignments'); // Removed this line
    }
}