<x-layouts.app :title="__('Dashboard')">
    <div class="flex justify-between items-center">
                    <div >
                        <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
                        <flux:subheading size="lg">{{ __('Everything is here.') }}</flux:subheading>
                    </div>
                    <div style="display: flex; justify-content: flex-end;">
                        <img src="{{ asset('images/ICS.png') }}" alt="ICS Logo" style="width:30%;">
                    </div>
            </div>
            <div class="border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white z-10 mt-4 mb-3">
        </div>
        <div class="mb-4">
        <livewire:enroll-search-bar/>
        </div>
        <livewire:dashboard-feed/>
    </div>
</x-layouts.app>
