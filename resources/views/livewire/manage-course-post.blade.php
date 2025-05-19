<div>
<div>
    <flux:modal name="create-course" class="md:w-150">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Create a Course</flux:heading>
                <flux:text class="mt-2">Submit course details.</flux:text>
            </div>

            <flux:input label="Course name" wire:model="course_name" placeholder="Ex. Programming 1"/>
            <flux:textarea label="Course description" wire:model="course_description" placeholder="Course description..."/>
            <flux:input label="Course key" wire:model="course_key" placeholder="Programming_1@philsca"/>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" wire:click="submit" variant="primary">Create</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="edit-course" class="md:w-150">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Course</flux:heading>
                <flux:text class="mt-2">Edit course details.</flux:text>
            </div>

            <flux:input label="Course name" wire:model="course_name" placeholder=""/>
            <flux:input label="Course key" wire:model="course_key" placeholder=""/>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" wire:click="update" variant="primary">Update</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="delete-course" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete course?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this course.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" wire:click="destroy" variant="danger">Delete course</flux:button>
            </div>
        </div>
    </flux:modal>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Course Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Course Description
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Created by
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Course Key
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Status
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($courses as $course)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $course->id }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                        {{ $course->course_name }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-pre-line">
                        {!! nl2br(e($course->course_description)) !!}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $course->creator->name }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white" style="word-break: break-word; overflow-wrap: break-word;">
                        {{ $course->course_key }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $course->status }}
                    </td>
                    <td>
                        <flux:modal.trigger name="edit-course">
                            <flux:button type="submit" wire:click="edit({{ $course->id }})" size="sm">Edit</flux:button>
                        </flux:modal.trigger>
                    </td>
                    <td>
                        <flux:modal.trigger name="delete-course">
                            <flux:button variant="danger" size="sm" wire:click="confirmDelete({{ $course->id }})">Delete</flux:button>
                        </flux:modal.trigger>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
