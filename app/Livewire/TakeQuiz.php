<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use App\Models\StudentQuizResult;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TakeQuiz extends Component
{
    public $quizId;
    public $quizKeyInput;
    public $quiz;
    public $currentQuestionIndex = 0;
    public $studentAnswers = [];
    public $correctAnswerCount = 0;
    public $quizSubmitted = false;
    public $keyVerified = false;
    public $errorMessage = '';

    public function mount($quizId)
    {
        $this->quizId = $quizId;
        $this->quiz = Quiz::findOrFail($quizId); // Eager load the quiz
        // Initialize student answers array based on the choices
        $this->studentAnswers = array_fill(0, 1, null); // Assuming one question per quiz record for now
    }

    public function verifyKey()
    {
        if ($this->quiz->quiz_key === $this->quizKeyInput) {
            $this->keyVerified = true;
        } else {
            $this->errorMessage = 'Incorrect Quiz Key.';
        }
    }

    public function nextQuestion()
    {
        // Since each quiz record is a question, we don't really have "next" in the same way.
        // For this structure, once the key is verified, the single question is presented.
    }

    public function previousQuestion()
    {
        // Not applicable in this single-question-per-quiz structure after key verification.
    }

    public function selectAnswer($answer)
    {
        $this->studentAnswers[0] = $answer;
    }

    public function getCurrentQuestion()
    {
        return $this->quiz->question;
    }

    public function getCurrentChoices()
    {
        return [
            'A' => $this->quiz->A,
            'B' => $this->quiz->B,
            'C' => $this->quiz->C,
            'D' => $this->quiz->D,
        ];
    }

    public function submitQuiz()
    {
        $this->correctAnswerCount = 0;

        if (isset($this->studentAnswers[0]) && $this->studentAnswers[0] === $this->quiz->question_answer) {
            $this->correctAnswerCount++;
        }

        StudentQuizResult::create([
            'user_id' => Auth::id(),
            'quiz_id' => $this->quiz->id,
            'correct_answers' => $this->correctAnswerCount,
            'total_questions' => 1,
            'score' => ($this->correctAnswerCount / 1) * 100,
        ]);

        $this->quizSubmitted = true;
    }

    public function render()
    {
        return view('livewire.take-quiz');
    }
}