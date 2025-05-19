<div class="flex flex-col gap-4 rounded-xl">
    <!-- Dynamic Content Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Assignments -->
        <div class="p-4 bg-white border border-black rounded-lg shadow-md h-auto">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Assignments</h2>
            @forelse ($assignments as $assignment)
            <button wire:click="showAssignment({{ $assignment->id }})"
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
            <p class="text-gray-400">No enrolled courses yet.</p>
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

    <flux:modal name="assignment-show" class="md:w-150">
        @if ($assignmentNow)
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Assignment</flux:heading>
                <flux:text class="mt-2">These are the assignment details.</flux:text>
            </div>
                <div class="w-full sm:w-4/5 lg:w-130  mx-auto p-4 bg-white border border-black rounded-lg shadow-md mb-2 flex flex-col justify-end items-end">
                    {{-- Assignment Content --}}
                    <div class="w-full pb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $assignmentNow->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">
                            {!! nl2br(e($assignmentNow->body)) !!}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Posted by: {{ $assignmentNow->creator->name }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Course: {{ $assignmentNow->course->course_name }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $assignmentNow->created_at->format('M d, Y h:i a') }}
                        </p>
                    </div>
                    {{-- START: Combined Attachments and Actions Container --}}
                    <div class="w-full flex justify-between items-center border-t dark:border-gray-600 pt-3 {{ $assignmentNow->attachments->isEmpty() ? 'mt-3' : '' }}">

                        {{-- Left Side: Attachments List --}}
                        <div>
                            @if ($assignmentNow->attachments->isNotEmpty())
                                <div class="space-y-1">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Attachments:</p>
                                    @foreach($assignmentNow->attachments as $attachment)
                                        @php
                                            $fileUrl = Illuminate\Support\Facades\Storage::url($attachment->file_path);
                                            $extension = strtolower(pathinfo($attachment->file_path, PATHINFO_EXTENSION));
                                            $filename = $attachment->original_name ?? basename($attachment->file_path);
                                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                            $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
                                        @endphp
                                        <div class="flex items-center text-sm">
                                            @if (in_array($extension, $imageExtensions))
                                                <a href="{{ $fileUrl }}" target="_blank" title="View: {{ $filename }}" class="mr-1.5 flex-shrink-0">
                                                    <img src="{{ $fileUrl }}" alt="Preview" class="h-10 w-10 object-cover rounded border border-gray-300 dark:border-gray-600">
                                                </a>
                                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline truncate max-w-[150px] sm:max-w-[200px] md:max-w-[250px]" title="{{ $filename }}">
                                                    {{ $filename }}
                                                </a>
                                            @elseif (in_array($extension, $videoExtensions))
                                                <svg class="w-4 h-4 mr-1 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M0 12V4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm6.79-6.907A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/></svg>
                                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline truncate max-w-[150px] sm:max-w-[200px] md:max-w-[250px]" title="{{ $filename }}">
                                                    {{ $filename }}
                                                </a>
                                            @else
                                                <svg class="w-4 h-4 mr-1 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 16 16" ><path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/></svg>
                                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline truncate max-w-[150px] sm:max-w-[200px] md:max-w-[250px]" title="{{ $filename }}">
                                                    {{ $filename }}
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div>&nbsp;</div>
                            @endif
                        </div>
                       
                        {{-- Right Side: Action Button(s) --}}
                        <div class="flex justify-end space-x-3 pt-4">
                            <flux:modal.close>
                                <flux:button type="button">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="submit" wire:click="uploadshow({{ $assignmentNow->id }})" variant="primary">
                                Upload
                            </flux:button>
                        </div>
                    </div>
                    {{-- END: Combined Attachments and Actions Container --}}
                </div>
            
        </div>
         @endif
</flux:modal>

    <flux:modal name="upload-assignment" class="md:w-150">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Upload Assignment</flux:heading>
                <flux:text class="mt-2">Upload your assignment below.</flux:text>
            </div>
            <div>
                <flux:input label="Title of upload" wire:model="title" placeholder="e.g., Chapter 5 Homework"/>
            </div>
            <div>
                <flux:textarea label="Description of upload" wire:model="body" placeholder="Enter assignment description..." rows="5"/>
            </div>
            <div>
            <flux:input type="file" label="Attachments" wire:model="attachments" rows="5" multiple/>
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <flux:modal.close>
                    <flux:button type="button">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" wire:click="uploadAssignment" variant="primary">
                    Upload
                </flux:button>
            </div>
        </div>
</flux:modal>
</div>


