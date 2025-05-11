<x-layouts.app :title="__('Manage Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-6 w-full">
            <flux:heading size="xl" level="1">{{ __('Manage Users') }}</flux:heading>
            <flux:subheading size="lg" class="mb-3">{{ __('Manage users here.') }}</flux:subheading>
            <div class="border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white z-10 mt-4 mb-3">
            
            </div>
            @can('user-create')
            <div class="mb-3">
                    <flux:modal.trigger name="create-user">
                        <flux:button>Create</flux:button>
                    </flux:modal.trigger>
            </div>
            @endcan
                <livewire:manage-users-post />
        </div>
    </div>
</x-layouts.app>


