<x-layouts.app :title="__('Virtual Meetings')">
    <div x-data="{ tab: 'Meetings', init() { } }" class="flex h-full w-full flex-1 flex-col rounded-xl" x-init="$nextTick(() => { tab = 'Meetings' })">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Virtual Meetings') }}</flux:heading>
                <flux:subheading size="lg">{{ __('Join your virtual meetings here.') }}</flux:subheading>
            </div>
            <div style="display: flex; justify-content: flex-end;">
                <img src="{{ asset('images/ICS.png') }}" alt="ICS Logo" style="width:30%;">
            </div>
        </div>
        <div class="border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white z-10 mt-4 mb-3">
        </div>
            

            <livewire:currently-taking-meetings/>


    </div>
</x-layouts.app>
