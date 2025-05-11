<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\ExamItem;
use App\Models\ExamMaster;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Flux\Flux;

class ExamDisplay extends Component
{
    public $course = null;
    public $courses;
    public $availableExams;
    public $examKey;
    public $selectedExamId;
    public $examTitle;

    // Properties for creating a new quiz
    public $newExamCourseId;
    public $title;
    public $examNumberOfItems = 50;
    public Collection $examItems;

    public function __construct()
    {
        $this->examItems = collect(range(1, $this->examNumberOfItems))->map(function ($i) {
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
    $this->courses = $user?->enrolledCourses()->withCount('exams')->get() ?? collect();

    $this->loadExams();

    if (!$this->examItems) {
        $this->initializeExamItems();
    }
}

    public function initializeExamItems()
    {
        $this->examItems = collect(range(1, $this->examNumberOfItems))->map(function ($i) {
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

    public function updatedExamNumberOfItems($value)
    {
        $this->examNumberOfItems = max(50, min(100, $value));
        $this->initializeExamItems();
    }

    public function updateExamItem($index, $field, $value)
    {
        $this->examItems[$index][$field] = $value;
    }

    public function loadExams()
{
    $user = Auth::user();

    if (!$user) {
        $this->availableExams = collect();
        return;
    }

    $enrolledCourseIds = $user->enrolledCourses()->pluck('courses.id');

    $this->availableExams = ExamMaster::query()
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
        $this->loadExams();
    }

    public function showExamKeyModal($examId, $examTitle)
    {
        $this->selectedExamId = $examId;
        $this->examTitle = $examTitle;
        Flux::modal('exam-key-modal')->show();
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

    public function submit()
    {
        // ...

        $examMaster = ExamMaster::create([
            'user_id' => auth()->id(),
            'course_id' => $this->newExamCourseId,
            'title' => $this->title,
            'exam_key' => $this->examKey,
        ]);
        
        foreach ($this->examItems as $index => $item) {
            $this->validate([
                'examItems.' . $index . '.question_answer' => 'required|in:A,B,C,D',
            ]);
            //dd($this->examItems);
            ExamItem::create([
                'exam_master_id' => $examMaster->id,
                'question' => $item['question'],
                'A' => $item['A'],
                'B' => $item['B'],
                'C' => $item['C'],
                'D' => $item['D'],
                'question_answer' => $item['question_answer'],
            ]);
        }

        session()->flash('message', 'Exam created successfully!');
        $this->reset(['newExamCourseId', 'title', 'examNumberOfItems', 'examKey', 'examItems']);
        Flux::modal('create-exam-modal')->close();
        $this->dispatch('examCreated');
    }


    public function render()
    {
        return view('livewire.exam-display');
    }
}
