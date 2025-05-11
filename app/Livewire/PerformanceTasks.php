<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PerformanceTaskPost;
use App\Models\PerformanceTaskAttachment;
use App\Models\PerformanceTaskUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class PerformanceTasks extends Component
{
    use WithFileUploads;

    public $course = '';

    // Properties for the Create Assignment Modal Form
    public $newPerformanceTaskCourseId = null;
    public $title = '';
    public $body = '';
    public $attachments = [];
    public $performanceTaskPostId;

    // Validation Rules
    protected function rules()
    {
        return [
            'newPerformanceTaskCourseId' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,mov,avi,webm|max:50200',
        ];
    }

    // Render Method
    public function render()
    {
        $user = Auth::user();
        $courses = $user->enrolledCourses()->orderBy('course_name')->get();
        $performancetasks = PerformanceTaskPost::with(['creator', 'course', 'attachments'])
            ->whereHas('course', function ($query) use ($user) {
                $query->whereIn('id', $user->enrolledCourses->pluck('id'));
            })
            ->when($this->course, function ($query, $selectedCourseId) use ($user) {
                $query->where('course_id', $selectedCourseId);
                $query->whereIn('course_id', $user->enrolledCourses->pluck('id'));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.performance-tasks', compact('performancetasks', 'courses'));
    }

    // Submit Method (for creating a new performance task)
    public function submit()
    {
        $validatedData = $this->validate();

        $performanceTaskPost = PerformanceTaskPost::create([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'user_id' => Auth::id(),
            'course_id' => $validatedData['newPerformanceTaskCourseId'],
        ]);

        // Handle Attachments
        if ($this->attachments) {
            foreach ($this->attachments as $attachmentFile) {
                $filePath = $attachmentFile->store('performance_tasks_attachments', 'public');
                $originalName = $attachmentFile->getClientOriginalName();

                PerformanceTaskAttachment::create([
                    'performance_task_post_id' => $performanceTaskPost->id,
                    'file_path' => $filePath,
                    'original_name' => $originalName,
                ]);
            }
            $this->attachments = []; // Clear attachments after processing
        }

        session()->flash('message', 'Performance task created successfully.');
        $this->resetForm();
        Flux::modal("create-performance-task")->close();
    }

    public function resetForm()
    {
        $this->reset(['title', 'body', 'newPerformanceTaskCourseId', 'attachments']);
        $this->resetErrorBag();
    }

    // Method to show the upload modal (student)
    public function uploadshow($id)
    {
        $this->performanceTaskPostId = $id;
        Flux::modal("upload-performance-task")->show();
    }

    // Method to handle student assignment uploads
    public function uploadPerformanceTask()
    {
        //dd($this->performanceTaskPostId);
        $validatedData = $this->validate([ // Added $validatedData
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,mov,avi,webm|max:50200',
            'performanceTaskPostId' => 'required|exists:performance_task_posts,id',
        ]);

        //dd($validatedData);

        if ($this->attachments) {
            foreach ($this->attachments as $attachmentFile) {
                $filePath = $attachmentFile->store('performance_tasks_attachments', 'public');
                $originalName = $attachmentFile->getClientOriginalName();

                PerformanceTaskUpload::create([
                    
                    'user_id' => Auth::id(),
                    'title' => $validatedData['title'], // Use validated data
                    'description' => $validatedData['body'], // Use validated data
                    'file_path' => $filePath,
                    'original_name' => $originalName,
                ]);
            }
             $this->attachments = [];  //clear 
        }

        $this->reset(['title', 'body', 'attachments']);
        Flux::modal("upload-performance-task")->close();
        session()->flash('message', 'Performance task uploaded successfully!');
    }
}

