<x-layouts.app :title="__('Assignment Upload')">
        <div class="flex justify-between items-center">
                    <div >
                        <flux:heading size="xl" level="1">{{ __('Assignment Upload') }}</flux:heading>
                        <flux:subheading size="lg">{{ __('Students assignment uploads are here.') }}</flux:subheading>
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
            
                <livewire:student-assignment-upload/>
        </div>
    </div>
</x-layouts.app>