<x-layouts.app :title="__('Take Quiz')">
        <div class="flex justify-between items-center">
                    <div >
                        <flux:heading size="xl" level="1">{{ __('Take Quiz') }}</flux:heading>
                        <flux:subheading size="lg">{{ __('Your quiz will appear here.') }}</flux:subheading>
                    </div>
                    <div style="display: flex; justify-content: flex-end;">
                        <img src="{{ asset('images/ICS.png') }}" alt="ICS Logo" style="width:30%;">
                    </div>
            </div>
            <div class="border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white z-10 mt-4 mb-3">
        </div>
                <livewire:currently-taking-quiz/>
        </div>
    </div>
</x-layouts.app>