<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\AssignmentPost;
use App\Models\ActivityPost;
use App\Models\PerformanceTaskPost;
use App\Models\QuizMaster;
use App\Models\ExamMaster;
use App\Models\Module;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardFeed extends Component
{
    public $search = '';
    public $courses = [];
    public $enrollCourses;
    public $course_id;
    public $course_name;
    public $description;
    public $course_key;
    public $selectedQuizId;
    public $quizTitle;
    public $quizKey;
    public $selectedExamId;
    public $examTitle;
    public $examKey;

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
}
