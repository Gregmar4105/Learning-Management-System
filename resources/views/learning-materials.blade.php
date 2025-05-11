<x-layouts.app :title="__('Learning Materials')">
    <div x-data="{ tab: 'Modules', init() { } }" class="flex h-full w-full flex-1 flex-col rounded-xl" x-init="$nextTick(() => { tab = 'Modules' })">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Learning Materials') }}</flux:heading>
                <flux:subheading size="lg">{{ __('Get your learning materials here.') }}</flux:subheading>
            </div>
            <div style="display: flex; justify-content: flex-end;">
                <img src="{{ asset('images/ICS.png') }}" alt="ICS Logo" style="width:30%;">
            </div>
        </div>
        <div class="w-full sticky top-0">
            <div class="border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white z-10">
                <ul class="flex flex-wrap -mb-px mb-0.45 xs:mb-6" id="myTab" role="tablist">
                    <li class="mr-2" role="presentation">
                        <a href="#"
                            @click.prevent="tab = 'Modules'"
                            :class="tab === 'Modules' ? 'border-gray-900 text-gray-900 border-b-2' : 'border-transparent border-b-2 hover:border-gray-900 dark:hover:text-gray-900'"
                            class="inline-block p-1 sm:p-3 md:p-4 text-xs sm:text-sm md:text-base rounded-t-lg whitespace-nowrap font-medium tab-button"
                            role="tab">
                            Modules
                        </a>
                    </li>
                    <li class="mr-2" role="presentation">
                        <a href="#"
                            @click.prevent="tab = 'Related Resources'"
                            :class="tab === 'Related Resources' ? 'border-gray-900 text-gray-900 border-b-2' : 'border-transparent border-b-2 hover:border-gray-900 dark:hover:text-gray-900'"
                            class="inline-block p-1 sm:p-3 md:p-4 text-xs sm:text-sm md:text-base rounded-t-lg whitespace-nowrap font-medium tab-button"
                            role="tab">
                            Related Resources
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-1">
            <div x-show="tab === 'Modules'" x-transition>
                <livewire:modules />
            </div>

            <div x-show="tab === 'Related Resources'" x-transition>
                <livewire:related-resources />
            </div>

        </div>
    </div>
</x-layouts.app>
