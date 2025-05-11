<div> <!-- Single root element -->
    <!-- Course Filter and Create Meeting Button -->
    <div class="mt-2 ml-2 mb-2 flex">
        <div style="width:250px; display:inline-block;">
            <flux:select wire:model="course" id="courseFilter" placeholder="Choose Course...">
                <flux:select.option value="">All Courses</flux:select.option>
                @foreach($this->courses as $course) <!-- Changed from $courses to $this->courses -->
                    <flux:select.option value="{{ $course->id }}">{{ $course->course_name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div>
            <flux:modal.trigger name="create-meeting">
                <flux:button class="ml-2" icon:trailing="plus">Create Meeting</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <!-- Create Meeting Modal -->
    <flux:modal name="create-meeting" class="md:w-150">
        <div class="space-y-6">
            <flux:heading size="lg">Create a Meeting</flux:heading>
            <flux:text class="mt-2">Enter the details below.</flux:text>

            <flux:input label="Meeting Name" wire:model="meeting_name" placeholder="Meeting Name" />
            <flux:textarea label="Meeting Description" wire:model="meeting_description" placeholder="Meeting description..." />
            <flux:input label="Meeting Start Time" type="datetime-local" wire:model="meeting_start_time" />
            <flux:select label="Course" wire:model="selectedCourseId">
                <flux:select.option value="">Select a Course</flux:select.option>
                @foreach ($this->courses as $course) <!-- Changed from $courses to $this->courses -->
                    <flux:select.option value="{{ $course->id }}">{{ $course->course_name }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" wire:click="submit" variant="primary">Create</flux:button>
            </div>
        </div>
    </flux:modal>
    
    <div>
    @if ($this->meetings->isNotEmpty())
        <div class="flex flex-wrap">
            @foreach ($this->meetings as $meeting) <!-- Check if there are meetings -->
                <div class="w-full sm:w-4/5 lg:w-29/100 p-4 bg-white border border-black rounded-lg shadow-md flex flex-col ml-4 mt-3">
                    <div class="mt-2">
                        <!-- Loop through the meetings -->
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ $meeting->title }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">
                            Start Time: {{ $meeting->start_time }}
                        </p>
                        @if($meeting->course)
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Course: {{ $meeting->course->course_name }}
                            </p>
                        @endif
                        <div class="mt-4">
                            <flux:button wire:click="joinMeeting({{ $meeting->id }})" variant="primary">Join Meeting</flux:button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No meetings scheduled at this time.</p>
    @endif
</div>


    @push('scripts')
        <script src="https://meet.jit.si/external_api.js"></script>
        <script>
            Livewire.on('open-jitsi-modal', (data) => {
                const { roomName, jwt } = data;

                const modal = document.createElement('div');
                modal.style.position = 'fixed';
                modal.style.top = '0';
                modal.style.left = '0';
                modal.style.width = '100%';
                modal.style.height = '100%';
                modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                modal.style.zIndex = '10000';
                modal.innerHTML = `
                    <div style="position: relative; width: 80%; height: 80%; margin: 5% auto; background: white;">
                        <div id="jitsi-container" style="width: 100%; height: 100%;"></div>
                        <button id="close-jitsi-modal" style="position: absolute; top: 10px; right: 10px;">Close</button>
                    </div>
                `;
                document.body.appendChild(modal);

                const domain = 'meet.jit.si';
                const options = {
                    roomName: roomName,
                    width: '100%',
                    height: '100%',
                    parentNode: document.querySelector('#jitsi-container'),
                    jwt: jwt,
                    configOverwrite: {
                        startWithAudioMuted: true,
                        startWithVideoMuted: true,
                    }
                };

                const api = new JitsiMeetExternalAPI(domain, options);

                document.getElementById('close-jitsi-modal').addEventListener('click', () => {
                    api.dispose();
                    modal.remove();
                });
            });
        </script>
    @endpush
</div> <!-- End of single root div -->
