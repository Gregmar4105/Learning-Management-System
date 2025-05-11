<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\QuizMaster;
use App\Models\QuizItem;

class CurrentlyTakingQuiz extends Component
{
    use WithPagination;

    public QuizMaster $quiz; // Receive the QuizMaster model directly
    public $currentQuestionIndex = 0;
    public $userAnswers = [];
    public $quizEnded = false;
    public $score = 0;

    public function mount()
{
    $quizData = session()->get('quiz'); // Get the quiz data from the session

    if ($quizData instanceof QuizMaster) {
        $this->quiz = $quizData;
        $this->quiz->load('items');
    } else {
        // Handle the case where the quiz data is not in the session or is not a QuizMaster instance.
        // This could mean the user tried to access the quiz page directly without selecting a quiz first.
        session()->flash('error', 'Quiz not found. Please select a quiz to take.');
        $this->redirect('/'); // Redirect to a safe page, like the quiz listing page
        return; // Important:  Exit the mount() method to prevent further errors
    }

    if ($this->quiz->items->isEmpty()) {
        session()->flash('error', 'This quiz has no questions.');
        return;
    }
    $this->initializeUserAnswers();
}

    public function initializeUserAnswers()
    {
        foreach ($this->quiz->items as $item) {
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
        if ($this->currentQuestionIndex >= $this->quiz->items->count()) {
            $this->finishQuiz();
        }
    }

    public function previousQuestion()
    {
        $this->currentQuestionIndex--;
        if ($this->currentQuestionIndex < 0) {
            $this->currentQuestionIndex = 0;
        }
    }


    public function finishQuiz()
    {
        $this->quizEnded = true;
        $this->score = $this->calculateScore();
        //  You would also store the results in the database here
    }

    private function calculateScore()
    {
        $correctAnswers = 0;
        foreach ($this->quiz->items as $item) {
            if (isset($this->userAnswers[$item->id]) && $this->userAnswers[$item->id] == $item->question_answer) {
                $correctAnswers++;
            }
        }
        return $correctAnswers;
    }

    public function render()
    {
        //  dd("CurrentlyTakingQuiz render() - QuizMaster:", $this->quiz->toArray(), $this->quiz->load('items')->toArray());
        if ($this->quiz->items->isEmpty()) {
            session()->flash('error', 'This quiz has no questions.');
            return view('livewire.currently-taking-quiz', ['currentQuestion' => null]);
        }

        // Ensure the index is within bounds
        if ($this->currentQuestionIndex >= $this->quiz->items->count()) {
             $this->currentQuestionIndex = $this->quiz->items->count() - 1;
        }
        if($this->currentQuestionIndex < 0){
            $this->currentQuestionIndex = 0;
        }
        $currentQuestion = $this->quiz->items[$this->currentQuestionIndex];

        return view('livewire.currently-taking-quiz', [
            'currentQuestion' => $currentQuestion,
        ]);
    }
}

