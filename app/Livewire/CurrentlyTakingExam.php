<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ExamMaster;
use App\Models\ExamItem;

class CurrentlyTakingExam extends Component
{
    use WithPagination;

    public ExamMaster $exam; // Receive the QuizMaster model directly
    public $currentQuestionIndex = 0;
    public $userAnswers = [];
    public $examEnded = false;
    public $score = 0;

    public function mount()
{
    $examData = session()->get('exam'); // Get the quiz data from the session

    if ($examData instanceof ExamMaster) {
        $this->exam = $examData;
        $this->exam->load('items');
    } else {
        // Handle the case where the quiz data is not in the session or is not a QuizMaster instance.
        // This could mean the user tried to access the quiz page directly without selecting a quiz first.
        session()->flash('error', 'Quiz not found. Please select a exam to take.');
        $this->redirect('/'); // Redirect to a safe page, like the quiz listing page
        return; // Important:  Exit the mount() method to prevent further errors
    }

    if ($this->exam->items->isEmpty()) {
        session()->flash('error', 'This exam has no questions.');
        return;
    }
    $this->initializeUserAnswers();
}

    public function initializeUserAnswers()
    {
        foreach ($this->exam->items as $item) {
            $this->userAnswers[$item->id] = null;
        }
    }

    public function selectAnswer($questionId, $answer)
    {
        $this->userAnswers[$questionId] = $answer;
    }

    public function nextQuestion()
    {
        $this->currentQuestionIndex++;
        if ($this->currentQuestionIndex >= $this->exam->items->count()) {
            $this->finishExam();
        }
    }

    public function previousQuestion()
    {
        $this->currentQuestionIndex--;
        if ($this->currentQuestionIndex < 0) {
            $this->currentQuestionIndex = 0;
        }
    }


    public function finishExam()
    {
        $this->examEnded = true;
        $this->score = $this->calculateScore();
        //  You would also store the results in the database here
    }

    private function calculateScore()
    {
        $correctAnswers = 0;
        foreach ($this->exam->items as $item) {
            if (isset($this->userAnswers[$item->id]) && $this->userAnswers[$item->id] == $item->question_answer) {
                $correctAnswers++;
            }
        }
        return $correctAnswers;
    }

    public function render()
    {
        //dd("CurrentlyTakingExam render() - ExamMaster:", $this->exam->toArray(), $this->exam->load('items')->toArray());
        if ($this->exam->items->isEmpty()) {
            session()->flash('error', 'This exam has no questions.');
            return view('livewire.currently-taking-exam', ['currentQuestion' => null]);
        }

        // Ensure the index is within bounds
        if ($this->currentQuestionIndex >= $this->exam->items->count()) {
             $this->currentQuestionIndex = $this->exam->items->count() - 1;
        }
        if($this->currentQuestionIndex < 0){
            $this->currentQuestionIndex = 0;
        }
        $currentQuestion = $this->exam->items[$this->currentQuestionIndex];

        return view('livewire.currently-taking-exam', [
            'currentQuestion' => $currentQuestion,
        ]);
    }
}

