<div>

    {{-- Sticky Header Area for Controls --}}
    <div class="sticky top-14 z-10">
        <div class="flex">
            {{-- Course Filter Dropdown --}}
            <div class="mt-2 mb-2 flex">
        <div style="width:325px; display:inline-block;">
                    <flux:select wire:model.live="course" id="courseFilter"  placeholder="Choose Course...">
                        <flux:select.option value="">All Courses</flux:select.option>
                        @foreach($courses as $course)
                            <flux:select.option value="{{ $course->id }}">{{ $course->course_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <div wire:loading wire:target="course">
                        <span class="text-sm align-center text-gray-500 dark:text-gray-400">Loading...</span>
                    </div>
                </div>
            </div>

            {{-- Create Button & Modal Trigger --}}
            <div class="mt-2 ml-2">
                @can('assignment-create')
                    <flux:modal.trigger name="create-assignment">
                        <flux:button icon:trailing="plus">Create Assignment</flux:button>
                    </flux:modal.trigger>
                @endcan
            </div>
            <div class="mt-2 ml-2">
                @can('assignment-create')
                    <flux:button :href="route('assignment-upload')" variant="primary" icon:trailing="eye">View student uploads</flux:button>
                @endcan
            </div>
        </div>
    </div>

    {{-- Create Assignment Modal Definition --}}
    <flux:modal name="create-assignment" class="md:w-150">
        <form wire:submit.prevent="submit">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Create Assignment</flux:heading>
                    <flux:text class="mt-2">Enter the assignment details below.</flux:text>
                </div>
                <div>
                    <flux:label for="newAssignmentCourse" class="block text-sm font-medium text-gray-700 mb-1">Course</flux:label>
                    <flux:select wire:model="newAssignmentCourseId" id="newAssignmentCourse">
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $c)
                            <flux:select.option value="{{ $c->id }}">{{ $c->course_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:input label="Title" id="assignmentTitle" wire:model="title" placeholder="e.g., Chapter 5 Homework"/>
                </div>
                <div>
                    <flux:textarea label="Description / Instructions" id="assignmentBody" wire:model="body" placeholder="Enter assignment instructions..." rows="5"/>
                </div>
                <div>
                    <flux:input type="file" label="Attachments (Optional)" id="attachments" wire:model="attachments" rows="5" multiple/>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <flux:modal.close>
                        <flux:button type="button">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">
                        <span wire:loading.remove wire:target="submit">Create Assignment</span>
                        <span wire:loading wire:target="submit">Creating...</span>
                    </flux:button>
                </div>
            </div>
        </form>
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

    {{-- Display Area for Assignments --}}
    <div class="space-y-4 mt-6">
        @if($assignments->count() > 0)
            @foreach($assignments as $assignment)
                <div class="w-full sm:w-4/5 lg:w-275  mx-auto p-4 bg-white border border-black rounded-lg shadow-md mb-4 flex flex-col justify-end items-end">
                    {{-- Assignment Content --}}
                    <div class="w-full pb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $assignment->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">
                            {!! nl2br(e($assignment->body)) !!}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Posted by: {{ $assignment->creator->name }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Course: {{ $assignment->course->course_name }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $assignment->created_at->format('M d, Y h:i a') }}
                        </p>
                    </div>
                    {{-- START: Combined Attachments and Actions Container --}}
                    <div class="w-full flex justify-between items-center border-t dark:border-gray-600 pt-3 {{ $assignment->attachments->isEmpty() ? 'mt-3' : '' }}">
                        {{-- Left Side: Attachments List --}}
                        <div>
                            @if ($assignment->attachments->isNotEmpty())
                                <div class="space-y-1">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Attachments:</p>
                                    @foreach($assignment->attachments as $attachment)
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
                        <div class="flex-shrink-0 position-bottom">
                            <flux:button icon="upload" size="sm" variant="primary" wire:click="uploadshow({{ $assignment->id }})">
                                <span class="hidden sm:inline">Upload Assignment</span>
                                <span class="inline sm:hidden">Upload</span>
                            </flux:button>
                        </div>
                    </div>
                    {{-- END: Combined Attachments and Actions Container --}}
                </div>
            @endforeach
        @else
            <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                No assignments found matching your criteria.
            </div>
        @endif
    </div>
</div>