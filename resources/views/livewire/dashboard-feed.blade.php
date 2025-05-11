<div class="flex flex-col gap-4 rounded-xl">
    <!-- Dynamic Content Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Assignments -->
        <div class="p-4 bg-white border border-black rounded-lg shadow-md h-auto">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Assignments</h2>
            @forelse ($assignments as $assignment)
            <button wire:click="uploadshow({{ $assignment->id }})"
                class="w-full flex items-center justify-between mb-0.5 border border-gray px-4 py-1.5 text-sm font-medium text-gray-900  rounded-md hover:bg-gray-300">
                <div class="flex items-center gap-2">
                    <x-icon name="notebook-pen" class="w-4 h-4" />
                    {{ $assignment->title }}
                </div>
                <x-icon name="arrow-up-right" class="w-4 h-4" />
            </button>
            @empty
                <p class="text-gray-400">No assignments available.</p>
            @endforelse
        </div>

        <!-- Activities -->
        <div class="p-4 bg-white border border-black rounded-lg shadow-md h-auto">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Activities</h2>
            @forelse ($activities as $activity)
                <button wire:click="uploadshow({{ $activity->id }})"
                class="w-full flex items-center justify-between mb-0.5 border border-gray px-4 py-1.5 text-sm font-medium text-gray-900  rounded-md hover:bg-gray-300">
                <div class="flex items-center gap-2">
                    <x-icon name="notebook-pen" class="w-4 h-4" />
                    {{ $activity->title }}
                </div>
                <x-icon name="arrow-up-right" class="w-4 h-4" />
            </button>
            @empty
                <p class="text-gray-400">No activities available.</p>
            @endforelse
        </div>

        <!-- Performance Tasks -->
        <div class="p-4 bg-white border border-black rounded-lg shadow-md h-auto">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Performance Tasks</h2>
            @forelse ($performanceTasks as $task)
                <button wire:click="uploadshow({{ $task->id }})"
                class="w-full flex items-center justify-between mb-0.5 border border-gray px-4 py-1.5 text-sm font-medium text-gray-900  rounded-md hover:bg-gray-300">
                <div class="flex items-center gap-2">
                    <x-icon name="notebook-pen" class="w-4 h-4" />
                    {{ $task->title }}
                </div>
                <x-icon name="arrow-up-right" class="w-4 h-4" />
            </button>
            @empty
                <p class="text-gray-400">No performance tasks available.</p>
            @endforelse
        </div>

        <!-- Quizzes -->
        <div class="p-4 bg-white border border-black rounded-lg shadow-md h-auto">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Quizzes</h2>
            @forelse ($quizzes as $quiz)
                <button wire:click="showQuizKeyModal({{ $quiz->id }}, '{{ $quiz->title }}')"
                class="w-full flex items-center justify-between mb-0.5 border border-gray px-4 py-1.5 text-sm font-medium text-gray-900  rounded-md hover:bg-gray-300">
                <div class="flex items-center gap-2">
                    <x-icon name="book-check" class="w-4 h-4" />
                    {{ $quiz->title }}
                </div>
                <x-icon name="arrow-up-right" class="w-4 h-4" />
            </button>
            @empty
                <p class="text-gray-400">No quizzes available.</p>
            @endforelse
        </div>

        <!-- Examinations -->
        <div class="p-4 bg-white border border-black rounded-lg shadow-md h-auto">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Examinations</h2>
            @forelse ($exams as $exam)
                <button wire:click="showExamKeyModal({{ $exam->id }}, '{{ $exam->title }}')"
                class="w-full flex items-center justify-between mb-0.5 border border-gray px-4 py-1.5 text-sm font-medium text-gray-900  rounded-md hover:bg-gray-300">
                <div class="flex items-center gap-2">
                    <x-icon name="book-open-check" class="w-4 h-4" />
                    {{ $exam->title }}
                </div>
                <x-icon name="arrow-up-right" class="w-4 h-4" />
            </button>
            @empty
                <p class="text-gray-400">No exams available.</p>
            @endforelse
        </div>

        <!-- Modules -->
        <div class="p-4 bg-white border border-black rounded-lg shadow-md h-auto">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Modules</h2>
            @forelse ($modules as $module)
                <button wire:click="uploadshow({{ $module->id }})"
                class="w-full flex items-center justify-between mb-0.5 border border-gray px-4 py-1.5 text-sm font-medium text-gray-900  rounded-md hover:bg-gray-300">
                <div class="flex items-center gap-2">
                    <x-icon name="library-big" class="w-4 h-4" />
                    {{ $module->title }}
                </div>
                <x-icon name="arrow-down-tray" class="w-4 h-4" />
            </button>
            @empty
                <p class="text-gray-400">No modules available.</p>
            @endforelse
        </div>
    </div>

    <!-- Enrolled Courses -->
    <div class="w-full p-4 bg-white border border-black rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Enrolled Courses</h2>
        @forelse($enrollCourses as $course)
            <button wire:click="uploadshow({{ $course->id }})"
                class="w-full flex items-center justify-between mb-0.5 border border-gray px-4 py-1.5 text-sm font-medium text-gray-900  rounded-md hover:bg-gray-300">
                <div class="flex items-center gap-2">
                    <x-icon name="book-marked" class="w-4 h-4" />
                    {{ $course->course_name }}
                </div>
                <x-icon name="graduation-cap" class="w-4 h-4" />
            </button>
        @empty
            <p class="text-gray-400 italic">No enrolled courses yet.</p>
        @endforelse
    </div>

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
</div>


