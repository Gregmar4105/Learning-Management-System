<div>

    {{-- Sticky Header Area for Controls --}}
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
        @can('assignment-create')
        <div class="ml-2">
                <flux:modal.trigger name="create-quiz-modal">
                    <flux:button icon:trailing="plus">Create Quiz</flux:button>
                </flux:modal.trigger>
        </div>
        @endcan
    </div>

    {{-- Create Assignment Modal Definition --}}
    <flux:modal name="create-module" class="md:w-150">
        <form wire:submit.prevent="submit">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Create Module</flux:heading>
                    <flux:text class="mt-2">Enter the module details below.</flux:text>
                </div>
                <div>
                    <flux:label for="newAssignmentCourse" class="block text-sm font-medium text-gray-700 mb-1">Course</flux:label>
                    <flux:select wire:model="newModuleCourseId" id="newModuleCourse">
                        @foreach($courses as $c)
                            <flux:select.option value="{{ $c->id }}">{{ $c->course_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:input label="Title" id="assignmentTitle" wire:model="title" placeholder="e.g., Chapter 5 Module"/>
                </div>
                <div>
                    <flux:textarea label="Description / Instructions" id="assignmentBody" wire:model="body" placeholder="Enter module description..." rows="5"/>
                </div>
                <div>
                    <flux:input type="file" label="Attachments (Optional)" id="attachments" wire:model="attachments" rows="5" multiple/>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <flux:modal.close>
                        <flux:button type="button">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">
                        <span wire:loading.remove wire:target="submit">Create Module</span>
                        <span wire:loading wire:target="submit">Creating...</span>
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>


    {{-- Display Area for Assignments --}}
    <div class="space-y-4 mt-6">
        @if($modules->count() > 0)
            @foreach($modules as $module)
                <div class="w-full sm:w-4/5 lg:w-275  mx-auto p-4 bg-white border border-black rounded-lg shadow-md mb-4 flex flex-col justify-end items-end">
                    {{-- Assignment Content --}}
                    <div class="w-full pb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $module->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">
                            {!! nl2br(e($module->body)) !!}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Posted by: {{ $module->creator->name }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Course: {{ $module->course->course_name }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $module->created_at->format('M d, Y h:i a') }}
                        </p>
                    </div>
                    {{-- START: Combined Attachments and Actions Container --}}
                    <div class="w-full flex justify-between items-center border-t dark:border-gray-600 pt-3 {{ $module->attachments->isEmpty() ? 'mt-3' : '' }}">
                        {{-- Left Side: Attachments List --}}
                        <div>
                            @if ($module->attachments->isNotEmpty())
                                <div class="space-y-1">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Attachments:</p>
                                    @foreach($module->attachments as $attachment)
                                        @php
                                            $fileUrl = Illuminate\Support\Facades\Storage::url($attachment->file_path);
                                            $extension = strtolower(pathinfo($attachment->file_path, PATHINFO_EXTENSION));
                                            $filename = $attachment->original_name ?? basename($attachment->file_path);
                                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                        @endphp
                                        <div class="flex items-center text-sm">
                                            @if (in_array($extension, $imageExtensions))
                                                <a href="{{ $fileUrl }}" target="_blank" title="View: {{ $filename }}" class="mr-1.5 flex-shrink-0">
                                                    <img src="{{ $fileUrl }}" alt="Preview" class="h-10 w-10 object-cover rounded border border-gray-300 dark:border-gray-600">
                                                </a>
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
                    </div>
                    {{-- END: Combined Attachments and Actions Container --}}
                </div>
            @endforeach
        @else
            <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                No modules found matching your criteria.
            </div>
        @endif
    </div>
</div>