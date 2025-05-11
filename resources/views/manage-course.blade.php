<x-layouts.app :title="__('Manage Course')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-6 w-full">
            <flux:heading size="xl" level="1">{{ __('Manage Course') }}</flux:heading>
            <flux:subheading size="lg" class="mb-3">{{ __('Manage courses here.') }}</flux:subheading>
            <div class="border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white z-10 mt-4 mb-3">
            
            </div>
            <div class="mb-3">
                    <flux:modal.trigger name="create-course">
                        <flux:button>Create</flux:button>
                    </flux:modal.trigger>
            </div>

                <livewire:manage-course-post />
        </div>
    </div>
</x-layouts.app>


