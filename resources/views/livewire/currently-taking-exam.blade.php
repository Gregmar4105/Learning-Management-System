<div>
    @if (!$examEnded)
        @if ($exam->items->isNotEmpty())
            <div>
                <h3>Question {{ $currentQuestionIndex + 1 }} / {{ $exam->items->count() }}</h3>
                <p>{{ $currentQuestion->question }}</p>

                <div class="space-y-2">
                    <div>
                        <input
                            type="radio"
                            id="answer_a_{{ $currentQuestion->id }}"
                            name="question_{{ $currentQuestion->id }}"
                            value="A"
                            wire:model="userAnswers.{{ $currentQuestion->id }}"
                            wire:click="selectAnswer({{ $currentQuestion->id }}, 'A')"
                        />
                        <label for="answer_a_{{ $currentQuestion->id }}">A. {{ $currentQuestion->A }}</label>
                    </div>
                    <div>
                        <input
                            type="radio"
                            id="answer_b_{{ $currentQuestion->id }}"
                            name="question_{{ $currentQuestion->id }}"
                            value="B"
                            wire:model="userAnswers.{{ $currentQuestion->id }}"
                            wire:click="selectAnswer({{ $currentQuestion->id }}, 'B')"

                        />
                        <label for="answer_b_{{ $currentQuestion->id }}">B. {{ $currentQuestion->B }}</label>
                    </div>
                    <div>
                        <input
                            type="radio"
                            id="answer_c_{{ $currentQuestion->id }}"
                            name="question_{{ $currentQuestion->id }}"
                            value="C"
                            wire:model="userAnswers.{{ $currentQuestion->id }}"
                            wire:click="selectAnswer({{ $currentQuestion->id }}, 'C')"

                        />
                        <label for="answer_c_{{ $currentQuestion->id }}">C. {{ $currentQuestion->C }}</label>
                    </div>
                    <div>
                        <input
                            type="radio"
                            id="answer_d_{{ $currentQuestion->id }}"
                            name="question_{{ $currentQuestion->id }}"
                            value="D"
                            wire:model="userAnswers.{{ $currentQuestion->id }}"
                            wire:click="selectAnswer({{ $currentQuestion->id }}, 'D')"
                        />
                        <label for="answer_d_{{ $currentQuestion->id }}">D. {{ $currentQuestion->D }}</label>
                    </div>
                </div>

                <div class="flex justify-between mt-4">
                    <button wire:click="previousQuestion()" {{ $currentQuestionIndex == 0 ? 'disabled' : '' }}>Previous</button>
                    <button wire:click="nextQuestion()">{{ $currentQuestionIndex == ($exam->items->count() - 1) ? 'Finish' : 'Next' }}</button>
                </div>
            </div>
        @else
            <p>No questions found for this quiz.</p>
        @endif
    @else
        <h3>Examination Finished!</h3>
        <p>Your Score: {{ $score }} / {{ $exam->items->count() }}</p>
        //  Display correct answers, review, etc.
    @endif
</div>
