<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col h-screen">
        <div class="flex justify-between items-center mb-3">
            <div>
                <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
                <flux:subheading size="lg">{{ __('Everything you need is here.') }}</flux:subheading>
            </div>
            <div style="display: flex; justify-content: flex-end;">
                <img src="{{ asset('images/ICS.png') }}" alt="ICS Logo" style="width:30%;">
            </div>
        </div>
        <div class="mt-2 mb-4">
        <livewire:enroll-search-bar/>
        </div>
        <div class="flex-grow flex flex-col gap-4 rounded-xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white/5 backdrop-blur-md rounded-xl p-4 border border-white/10 shadow-lg">
                    <h2 class="text-lg font-semibold text-white mb-2">Container 1</h2>
                    <p class="text-gray-300">Some content here.</p>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-xl p-4 border border-white/10 shadow-lg">
                    <h2 class="text-lg font-semibold text-white mb-2">Container 2</h2>
                    <p class="text-gray-300">Some content here.</p>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-xl p-4 border border-white/10 shadow-lg">
                    <h2 class="text-lg font-semibold text-white mb-2">Container 3</h2>
                    <p class="text-gray-300">Some content here.</p>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-xl p-4 border border-white/10 shadow-lg">
                    <h2 class="text-lg font-semibold text-white mb-2">Container 3</h2>
                    <p class="text-gray-300">Some content here.</p>
                </div>
            </div>
            <div class="bg-white/5 backdrop-blur-md rounded-xl p-6 border border-white/10 shadow-lg flex-grow">
                <h2 class="text-2xl font-semibold text-white mb-4">Main Container</h2>
                <p class="text-gray-300">This container takes up the remaining space.</p>
            </div>
        </div>
    </div>
</x-layouts.app>
