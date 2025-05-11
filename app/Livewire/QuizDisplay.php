<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\QuizItem;
use App\Models\QuizMaster;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Flux\Flux;

class QuizDisplay extends Component
{
    public $course = null;
    public $courses;
    public $availableQuizzes;
    public $quizKey;
    public $selectedQuizId;
    public $quizTitle;

    // Properties for creating a new quiz
    public $newQuizCourseId;
    public $title;
    public $quizNumberOfItems = 5;
    public Collection $quizItems;

    public function __construct()
    {
        $this->quizItems = collect(range(1, $this->quizNumberOfItems))->map(function ($i) {
            return [
                'question' => '',
                'A' => '',
                'B' => '',
                'C' => '',
                'D' => '',
                'question_answer' => '',
            ];
        });
    }

    public function mount()
{
    $user = Auth::user();

    // Load only courses the user is enrolled in, with quiz count
    $this->courses = $user?->enrolledCourses()->withCount('quizzes')->get() ?? collect();

    $this->loadQuizzes();

    if (!$this->quizItems) {
        $this->initializeQuizItems();
    }
}

    public function initializeQuizItems()
    {
        $this->quizItems = collect(range(1, $this->quizNumberOfItems))->map(function ($i) {
            return [
                'question' => '',
                'A' => '',
                'B' => '',
                'C' => '',
                'D' => '',
                'question_answer' => '',
            ];
        });
    }

    public function updatedQuizNumberOfItems($value)
    {
        $this->quizNumberOfItems = max(5, min(50, $value));
        $this->initializeQuizItems();
    }

    public function updateQuizItem($index, $field, $value)
    {
        $this->quizItems[$index][$field] = $value;
    }

    public function loadQuizzes()
{
    $user = Auth::user();

    if (!$user) {
        $this->availableQuizzes = collect();
        return;
    }

    $enrolledCourseIds = $user->enrolledCourses()->pluck('courses.id');

    $this->availableQuizzes = QuizMaster::query()
        ->whereIn('course_id', $enrolledCourseIds)
        ->when($this->course, function ($query) {
            return $query->where('course_id', $this->course);
        })
        ->with(['user', 'course', 'items'])
        ->latest()
        ->get();
}

    public function updatedCourse($value)
    {
        $this->loadQuizzes();
    }

    public function showQuizKeyModal($quizId, $quizTitle)
    {
        $this->selectedQuizId = $quizId;
        $this->quizTitle = $quizTitle;
        Flux::modal('quiz-key-modal')->show();
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

    public function submit()
    {
        // ...

        $quizMaster = QuizMaster::create([
            'user_id' => auth()->id(),
            'course_id' => $this->newQuizCourseId,
            'title' => $this->title,
            'quiz_key' => $this->quizKey,
        ]);

        foreach ($this->quizItems as $index => $item) {
            $this->validate([
                'quizItems.' . $index . '.question_answer' => 'required|in:A,B,C,D',
            ]);
            QuizItem::create([
                'quiz_master_id' => $quizMaster->id,
                'question' => $item['question'],
                'A' => $item['A'],
                'B' => $item['B'],
                'C' => $item['C'],
                'D' => $item['D'],
                'question_answer' => $item['question_answer'],
            ]);
        }

        session()->flash('message', 'Quiz created successfully!');
        $this->reset(['newQuizCourseId', 'title', 'quizNumberOfItems', 'quizKey', 'quizItems']);
        Flux::modal('create-quiz-modal')->close();
        $this->dispatch('quizCreated');
    }

    public function render()
    {
        return view('livewire.quiz-display');
    }
}

