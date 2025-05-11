<x-layouts.app :title="__('Enroll')">
    <div class="flex h-full w-full flex-1 flex-col rounded-xl">
    <div class="flex justify-between items-center">
                    <div >
                        <flux:heading size="xl" level="1">{{ __('Enroll Courses') }}</flux:heading>
                        <flux:subheading size="lg">{{ __('Enroll courses here.') }}</flux:subheading>
                    </div>
                    <div style="display: flex; justify-content: flex-end;">
                        <img src="{{ asset('images/ICS.png') }}" alt="ICS Logo" style="width:30%;">
                    </div>
            </div>
            <div class="border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white z-10 mt-4 mb-3">
        </div>
            
            {{--<div class="mb-3">
                    <flux:modal.trigger name="create-user">
                        <flux:button>Create</flux:button>
                    </flux:modal.trigger>
            </div>--}}
            
                <livewire:enroll-courses />
        </div>
    </div>
</x-layouts.app>