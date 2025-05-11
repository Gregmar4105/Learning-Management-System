<div>
    <div class="mt-2 mb-2 flex">
        <div style="width:325px; display:inline-block;">
            <flux:select wire:model.live="course" id="courseFilter">
                <flux:select.option value="">All Courses</flux:select.option>
                @foreach ($courses as $course)
                    <flux:select.option value="{{ $course->id }}">
                        {{ $course->course_name }}
                        @if ($course->exams_count > 0)
                            ({{ $course->exams_count }} Exams)
                        @else
                            (No Exams)
                        @endif
                    </flux:select.option>
                @endforeach
            </flux:select>

            @error('course') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <div wire:loading wire:target="course">
                <span class="text-sm align-center text-gray-500 dark:text-gray-400">Loading...</span>
            </div>
        </div>
        @can('assignment-create')
        <div class="ml-2">
                <flux:modal.trigger name="create-exam-modal">
                    <flux:button icon:trailing="plus">Create Exam</flux:button>
                </flux:modal.trigger>
        </div>
        @endcan
    </div>

    <flux:modal x-ref="create-exam-modal" name="create-exam-modal" class="md:w-150">
        <form wire:submit.prevent="submit" action="#">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Create Exam</flux:heading>
                    <flux:text class="mt-2">Enter the examination details below.</flux:text>
                </div>
                <div>
                    <flux:label for="newExamCourse" class="block text-sm font-medium text-gray-700 mb-1">Course</flux:label>
                    <flux:select wire:model="newExamCourseId" id="newExamCourse">
                        <flux:select.option value="">Select Course</flux:select.option>
                        @foreach($courses as $course)
                            <flux:select.option value="{{ $course->id }}">{{ $course->course_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('newExamCourseId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <flux:input label="Title" id="examTitle" wire:model="title" placeholder="e.g., Chapter 5 Exam"/>
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <flux:label for="examNumberOfItems" class="block text-sm font-medium text-gray-700 mb-1">Number of Items (50-100)</flux:label>
                    <flux:input type="number" id="examNumberOfItems" wire:model.live="examNumberOfItems" min="50" max="100"/>
                    @error('examNumberOfItems') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <flux:label for="examKey" class="block text-sm font-medium text-gray-700 mb-1" >Examination Key</flux:label>
                    <flux:input type="password" id="examKey" wire:model="examKey" placeholder="Enter a key if required" viewable/>
                    @error('examKey') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-4">
    <flux:heading size="md">Exam Items</flux:heading>
    @foreach($examItems as $index => $item)
        <div class="border rounded-md p-4 space-y-2">
            <flux:label for="question_{{ $index }}" class="block text-sm font-medium text-gray-700 mb-1">Question {{ $index + 1 }}</flux:label>
            <flux:textarea id="question_{{ $index }}" wire:model.lazy="examItems.{{ $index }}.question" rows="2" placeholder="Enter question"/>
            @error('examItems.' . $index . '.question') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

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
                                wire:model.lazy="examItems.{{ $index }}.{{ $letter }}"
                                class="w-full"
                                placeholder="Enter choice {{ $letter }}"
                            />
                        </div>
                        @error('examItems.' . $index . '.' . $letter) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endforeach
            </div>

            <flux:label for="answer_{{ $index }}" class="block text-sm font-medium text-gray-700 mt-2 mb-1">Correct Answer</flux:label>
            <flux:select id="answer_{{ $index }}" wire:model.lazy="examItems.{{ $index }}.question_answer">
                <flux:select.option value="">Select Answer</flux:select.option>
                <flux:select.option value="A">A</flux:select.option>
                <flux:select.option value="B">B</flux:select.option>
                <flux:select.option value="C">C</flux:select.option>
                <flux:select.option value="D">D</flux:select.option>
            </flux:select>
            @error('examItems.' . $index . '.question_answer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    @endforeach
</div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <flux:modal.close target="create-exam-modal">
                        <flux:button type="button">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">
                        <span wire:loading.remove wire:target="submit">Create Exam</span>
                        <span wire:loading wire:target="submit">Creating...</span>
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    <flux:modal x-ref="exam-key-modal" name="exam-key-modal" class="md:w-130">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $examTitle }}</flux:heading>
            </div>
            <div>
                <flux:input label="Examination key" wire:model="examKey" type="password" value="" viewable />
                @error('examKey') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end">
                <flux:button type="button" wire:click="takeExam" variant="primary">Take Exam</flux:button>
            </div>
        </div>
    </flux:modal>

    <div class="space-y-4 mt-6">
        @if ($availableExams)
            @if (count($availableExams) > 0)
                @foreach ($availableExams as $exam)
                    <div class="w-full sm:w-4/5 lg:w-200  mx-auto p-4 bg-white border border-black rounded-lg shadow-md mb-4 flex  justify-between items-end">
                        <div class="w-4/5">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $exam->title }}</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">
                                {!! nl2br(e($exam->body)) !!}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Posted by: {{ $exam->user->name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Course: {{ $exam->course->course_name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $exam->created_at->format('M d, Y h:i a') }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <flux:button icon="book-check" size="sm" variant="primary" wire:click="showExamKeyModal({{ $exam->id }}, '{{ $exam->title }}')">
                                <span class="hidden sm:inline">Take Exam</span>
                                <span class="inline sm:hidden">Take</span>
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                    No examination are currently available for the selected course.
                </div>
            @endif
        @else
            <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                No examination available.
            </div>
        @endif
    </div>
</div>