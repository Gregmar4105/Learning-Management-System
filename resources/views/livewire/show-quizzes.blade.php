<div class="flex">
    {{-- Course Filter Dropdown --}}
    <div class="mt-2 mb-2">
        <div style="width:250px; display:inline-block;">
            <flux:select wire:model.live="course" id="courseFilter" placeholder="Choose Course...">
                <flux:select.option value="">All Courses</flux:select.option>
                @foreach($courses as $course)
                    <flux:select.option value="{{ $course->id }}">
                        {{ $course->course_name }}
                        @if ($course->quizzes_count > 0)
                            <span class="text-green-500 text-sm">(Has {{ $course->quizzes_count }} Quizzes)</span>
                        @else
                            <span class="text-gray-500 text-sm">(No Quizzes)</span>
                        @endif
                    </flux:select.option>
                @endforeach
            </flux:select>
            <div wire:loading wire:target="course">
                <span class="text-sm align-center text-gray-500 dark:text-gray-400">Loading...</span>
            </div>
        </div>
    </div>
</div>

<div>
    <h2>Available Quizzes</h2>

    @if ($availableQuizzes->isNotEmpty())
        <ul>
            @foreach ($availableQuizzes as $quiz)
                <li>
                    <a href="{{ route('take.quiz', ['quiz' => $quiz->id]) }}">
                        {{ $quiz->title }}
                        @if ($quiz->quiz_key)
                            (Key Required)
                        @endif
                    </a>
                    {{-- You can display more quiz information here if needed --}}
                </li>
            @endforeach
        </ul>
    @else
        <p>No quizzes are currently available for the selected course (or all courses).</p>
    @endif
</div>