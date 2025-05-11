<div>
    <div class="sticky top-0"> 
           
            <div class="flex mb-3">

            <flux:modal.trigger name="search">
            <flux:input as="button" placeholder="Search..." style="width:300px" icon="magnifying-glass"/>
            </flux:modal.trigger>

            <flux:modal.trigger name="view-courses">
                        <flux:button class="ml-2" icon:trailing="eye">View enrolled courses</flux:button>
                    </flux:modal.trigger>
        </div>

        <flux:modal name="course-passkey" class="md:w-130">
        <div class="space-y-6">
            <div>
                <flux:heading  size="lg">{{ $course_name }}</flux:heading>
                <flux:text class="mt-2" >{{ $description }}</flux:text>
            </div>
            <div>
            <flux:input label="Course key" wire:model="course_key" type="password" value="" viewable />
            </div>
            <div class="flex justify-end">
            <flux:button type="submit" wire:click="enroll"  variant="primary">Enroll</flux:button>
            </div>
        </div>
</flux:modal>
<flux:modal name="search" class="md:w-150">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Search Course</flux:heading>
            <flux:text class="mt-2">Search courses here.</flux:text>
        </div>
        <div>
            <div class="relative w-full mb-3">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 ">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live="search" // Bind input to the search property
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600
                           dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search courses..."
                >
            </div>
        </div>
        @if($search)  @foreach($courses as $cor)
            <div class="w-full  mb-2 sm:w-4/5 lg:w-full mx-auto p-4 bg-white border border-black rounded-lg shadow-md flex flex-col">

                <div class="w-full">
                    <div class="flex justify-between items-center mb-3 ">
                        <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white ">{{ $cor->course_name}}</h2>
                        </div>
                        <div>
                        
                        <flux:button variant="primary" icon:trailing="arrow-up-right" wire:click="CourseKey({{ $cor->id }})" class="ml-2" type="button">
                            Join
                        </flux:button>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-2">
                    {{ $cor->course_description }}
                    </p>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 ">by: {{ $cor->creator->name }}</p>
            </div>
            @endforeach
        @endif
    </div>
</flux:modal>
       
    </div>
   
    <div class="flex flex-wrap mt-2">
        @foreach($enrollCourses as $c)
        <div class="w-full sm:w-4/5 lg:w-29/100 p-4 bg-white border border-black rounded-lg shadow-md mb-4 mr-4 flex justify-end items-end">
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $c->course_name}}</h2>
                <p class="text-gray-600 dark:text-gray-300">
                {{ $c->course_description }}
                </p>
                <div class="flex justify-between items-center mt-4 border-t border-gray-300">
                <p class="text-sm text-gray-500 dark:text-gray-400 "> by: {{ $c->creator->name }}</p>
                <flux:button size="sm" class="mt-2" wire:click="CourseKey({{ $c->id }})" variant="primary">Join</flux:button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
</div>