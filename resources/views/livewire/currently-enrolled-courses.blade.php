

<div>
    <flux:button :href="route('enroll')" icon="arrow-left">Back</flux:button>
    @if($enrollCourses->isEmpty())
        <div class="flex justify-center items-center h-full">
            <p class="text-gray-600 dark:text-gray-300">No enrolled courses found.</p>
        </div>
        @else
    <div class="flex flex-wrap mt-2">
        @foreach($enrollCourses as $c)
        <div class="w-full sm:w-4/5 lg:w-29/100 p-4 bg-white border border-black rounded-lg shadow-md mb-4 mr-4 flex justify-end items-end">
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $c->course_name}}</h2>
                <p class="text-gray-600 dark:text-gray-300">
                {{ $c->course_description }}
                </p>
                <div class="flex justify-between items-center mt-4 border-t border-gray-300">
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 "> by: {{ $c->creator->name }}</p>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
