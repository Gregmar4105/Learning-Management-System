<div>
    <div class="mt-2 mb-2 flex">
        <div style="width:325px; display:inline-block;">
            <flux:select wire:model.live="course" id="courseFilter">
                <flux:select.option value="">All Courses</flux:select.option>
                @foreach ($courses as $course)
                    <flux:select.option value="{{ $course->id }}">
                        {{ $course->course_name }}
                        @if ($course->quizzes_count > 0)
                            ({{ $course->quizzes_count }} Quizzes)
                        @else
                            (No Quizzes)
                        @endif
                    </flux:select.option>
                @endforeach
            </flux:select>

            @error('course') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <div wire:loading wire:target="course">
                <span class="text-sm align-center text-gray-500 dark:text-gray-400">Loading...</span>
            </div>
        </div>

        <div class="ml-2">
                <flux:modal.trigger name="create-quiz-modal">
                    <flux:button icon:trailing="plus">Create Quiz</flux:button>
                </flux:modal.trigger>
        </div>
    </div>

    <flux:modal x-ref="create-quiz-modal" name="create-quiz-modal" class="md:w-150">
        <form wire:submit.prevent="submit" action="#">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Create Quiz</flux:heading>
                    <flux:text class="mt-2">Enter the quiz details below.</flux:text>
                </div>
                <div>
                    <flux:label for="newQuizCourse" class="block text-sm font-medium text-gray-700 mb-1">Course</flux:label>
                    <flux:select wire:model="newQuizCourseId" id="newQuizCourse">
                        <flux:select.option value="">Select Course</flux:select.option>
                        @foreach($courses as $course)
                            <flux:select.option value="{{ $course->id }}">{{ $course->course_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('newQuizCourseId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <flux:input label="Title" id="quizTitle" wire:model="title" placeholder="e.g., Chapter 5 Quiz"/>
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <flux:label for="quizNumberOfItems" class="block text-sm font-medium text-gray-700 mb-1">Number of Items (5-50)</flux:label>
                    <flux:input type="number" id="quizNumberOfItems" wire:model.live="quizNumberOfItems" min="5" max="50"/>
                    @error('quizNumberOfItems') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <flux:label for="quizKey" class="block text-sm font-medium text-gray-700 mb-1">Quiz Key (Optional)</flux:label>
                    <flux:input type="password" id="quizKey" wire:model="quizKey" placeholder="Enter a key if required" viewable/>
                    @error('quizKey') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-4">
    <flux:heading size="md">Quiz Items</flux:heading>
    @foreach($quizItems as $index => $item)
        <div class="border rounded-md p-4 space-y-2">
            <flux:label for="question_{{ $index }}" class="block text-sm font-medium text-gray-700 mb-1">Question {{ $index + 1 }}</flux:label>
            <flux:textarea id="question_{{ $index }}" wire:model.lazy="quizItems.{{ $index }}.question" rows="2" placeholder="Enter question"/>
            @error('quizItems.' . $index . '.question') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <div class="space-y-1">
                @php
                    $letters = ['A', 'B', 'C', 'D'];
                @endphp
                @foreach($letters as $letterIndex => $letter)
                    <div class="flex items-start">
                        <span class="w-6 font-semibold text-gray-700 mt-2">{{ $letter }}.</span>
                        <div class="flex-grow">
                            <flux:input
                                label=""
                                wire:model.lazy="quizItems.{{ $index }}.{{ $letter }}"
                                class="w-full"
                                placeholder="Enter choice {{ $letter }}"
                            />
                        </div>
                        @error('quizItems.' . $index . '.' . $letter) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endforeach
            </div>

            <flux:label for="answer_{{ $index }}" class="block text-sm font-medium text-gray-700 mt-2 mb-1">Correct Answer</flux:label>
            <flux:select id="answer_{{ $index }}" wire:model.lazy="quizItems.{{ $index }}.question_answer">
                <flux:select.option value="">Select Answer</flux:select.option>
                <flux:select.option value="A">A</flux:select.option>
                <flux:select.option value="B">B</flux:select.option>
                <flux:select.option value="C">C</flux:select.option>
                <flux:select.option value="D">D</flux:select.option>
            </flux:select>
            @error('quizItems.' . $index . '.question_answer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    @endforeach
</div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <flux:modal.close target="create-quiz-modal">
                        <flux:button type="button">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">
                        <span wire:loading.remove wire:target="submit">Create Quiz</span>
                        <span wire:loading wire:target="submit">Creating...</span>
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    <flux:modal x-ref="quiz-key-modal" name="quiz-key-modal" class="md:w-130">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $quizTitle }}</flux:heading>
            </div>
            <div>
                <flux:input label="Quiz key" wire:model="quizKey" type="password" value="" viewable />
                @error('quizKey') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end">
                <flux:button type="button" wire:click="takeQuiz" variant="primary">Take Quiz</flux:button>
            </div>
        </div>
    </flux:modal>

    <div class="space-y-4 mt-6">
        @if ($availableQuizzes)
            @if (count($availableQuizzes) > 0)
                @foreach ($availableQuizzes as $quiz)
                    <div class="w-full sm:w-4/5 lg:w-2/3 mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow-md flex justify-between items-center">
                        <div class="w-4/5">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $quiz->title }}</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">
                                {!! nl2br(e($quiz->body)) !!}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Posted by: {{ $quiz->user->name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Course: {{ $quiz->course->course_name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $quiz->created_at->format('M d, Y h:i a') }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <flux:button icon="book-check" size="sm" variant="primary" wire:click="showQuizKeyModal({{ $quiz->id }}, '{{ $quiz->title }}')">
                                <span class="hidden sm:inline">Take Quiz</span>
                                <span class="inline sm:hidden">Take</span>
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                    No quizzes are currently available for the selected course.
                </div>
            @endif
        @else
            <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                No quizzes available.
            </div>
        @endif
    </div>
</div>