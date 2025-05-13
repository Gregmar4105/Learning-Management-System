<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\AssignmentPost;
use App\Models\AssignmentUpload;
use App\Models\ActivityPost;
use App\Models\PerformanceTaskPost;
use App\Models\QuizMaster;
use App\Models\ExamMaster;
use App\Models\Module;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class DashboardFeed extends Component
{
    use WithFileUploads;
    
    public $search = '';
    public $courses = [];
    public $enrollCourses;
    public $course_id;
    public $course_name;
    public $description;
    public $course_key;
    public $selectedQuizId;
    public $quizTitle;
    public $title;
    public $body;
    public $attachments = []; // Initialize as empty array for multiple files
    public $quizKey;
    public $selectedExamId;
    public $examTitle;
    public $examKey;
    public $assignmentPostId;
    public $assignmentTitle;
    public $assignmentBody;
    public $assignmentNow;
    public $currentlyShowingId;

    protected $listeners = ['enroll'];
    public $assignments, $activities, $performanceTasks, $quizzes, $exams, $modules;

public function mount()
{
    $sevenDaysAgo = Carbon::now()->subDays(7);

    $this->assignments = AssignmentPost::where('user_id', Auth::id())
        ->where('created_at', '>=', $sevenDaysAgo)
        ->orderBy('created_at', 'desc')
        ->get();

    $this->activities = ActivityPost::where('user_id', Auth::id())
        ->where('created_at', '>=', $sevenDaysAgo)
        ->orderBy('created_at', 'desc')
        ->get();

    $this->performanceTasks = PerformanceTaskPost::where('user_id', Auth::id())
        ->where('created_at', '>=', $sevenDaysAgo)
        ->orderBy('created_at', 'desc')
        ->get();

    $this->quizzes = QuizMaster::where('user_id', Auth::id())
        ->where('created_at', '>=', $sevenDaysAgo)
        ->orderBy('created_at', 'desc')
        ->get();

    $this->exams = ExamMaster::where('user_id', Auth::id())
        ->where('created_at', '>=', $sevenDaysAgo)
        ->orderBy('created_at', 'desc')
        ->get();

    $this->modules = Module::where('user_id', Auth::id())
        ->where('created_at', '>=', $sevenDaysAgo)
        ->orderBy('created_at', 'desc')
        ->get();
}

    public function render()
    {
        $this->enrollCourses = Auth::user()?->enrolledCourses()->get() ?? collect();
        
        return view('livewire.dashboard-feed', [
        'courses' => $this->courses,
        'enrollCourses' => $this->enrollCourses,
    ]);
    }

    public function showQuizKeyModal($quizId, $quizTitle)
    {
        $this->selectedQuizId = $quizId;
        $this->quizTitle = $quizTitle;
        Flux::modal('quiz-key-modal')->show();
    }

    public function showExamKeyModal($examId, $examTitle)
    {
        $this->selectedExamId = $examId;
        $this->examTitle = $examTitle;
        Flux::modal('exam-key-modal')->show();
    }

    public function takeQuiz()
    {
        $this->validate([
            'quizKey' => 'required|string',
        ]);

        $quiz = QuizMaster::with('items')->findOrFail($this->selectedQuizId); // Eager load items here
        // dd("QuizMaster in takeQuiz", $quiz->toArray(), $quiz->load('items')->toArray());
        if ($quiz->quiz_key && $this->quizKey !== $quiz->quiz_key) {
            $this->addError('quizKey', 'Incorrect quiz key.');
            return;
        }

        return redirect()->to('/take-quiz')->with(['quiz' => $quiz]); // Pass via session
    }

    public function takeExam()
    {
        $this->validate([
            'examKey' => 'required|string',
        ]);

        $exam = ExamMaster::with('items')->findOrFail($this->selectedExamId); // Eager load items here
         //dd("QuizMaster in takeEuiz", $exam->toArray(), $exam->load('items')->toArray());
        if ($exam->exam_key && $this->examKey !== $exam->exam_key) {
            $this->addError('examKey', 'Incorrect exam key.');
            return;
        }

        return redirect()->to('/take-exam')->with(['exam' => $exam]); // Pass via session
    }

    public function showAssignment($id)
    {
        
        $assignment = AssignmentPost::with(['creator', 'course', 'attachments'])->findOrFail($id);
        
        $this->assignmentNow = $assignment;

        $this->currentlyShowingId = $id; // Store the ID of the user being edited
        $this->assignmentTitle = $assignment->title;
        $this->assignmentBody = $assignment->body;
        Flux::modal("assignment-show")->show();
    }

    public function uploadshow($id)
    {
        //dd($this->currentlyShowingId);
        $this->assignmentPostId = $id;
        Flux::modal("upload-assignment")->show();
    }

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
