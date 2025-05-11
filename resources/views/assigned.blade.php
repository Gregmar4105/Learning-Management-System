<x-layouts.app :title="__('Assigned')">
    <div x-data="{ tab: 'assignments' }" class="flex h-full w-full flex-1 flex-col rounded-xl">
            <div class="flex justify-between items-center">
                    <div >
                        <flux:heading size="xl" level="1">{{ __('Assigned') }}</flux:heading>
                        <flux:subheading size="lg">{{ __('Submit your assigned tasks here.') }}</flux:subheading>
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
                                @click.prevent="tab = 'assignments'"
                                :class="tab === 'assignments' ? 'border-gray-900 text-gray-900' : 'border-transparent'"
                                class="inline-block p-1 sm:p-3 md:p-4 text-sm sm:text-sm md:text-base border-b-2 rounded-t-lg
                                    hover:border-gray-900 dark:hover:text-gray-900 whitespace-nowrap font-medium tab-button"
                                role="tab">
                                Assignments
                            </a>
                        </li>
                        <li class="mr-2" role="presentation">
                            <a href="#"
                                @click.prevent="tab = 'activities'"
                                :class="tab === 'activities' ? 'border-gray-900 text-gray-900' : 'border-transparent'"
                                class="inline-block p-1 sm:p-3 md:p-4 text-sm sm:text-sm md:text-base border-b-2 rounded-t-lg
                                    hover:border-gray-900 dark:hover:text-gray-900 whitespace-nowrap font-medium tab-button"
                                role="tab">
                                Activities
                            </a>
                        </li>
                        <li class="mr-2" role="presentation">
                            <a href="#"
                                @click.prevent="tab = 'performance'"
                                :class="tab === 'performance' ? 'border-gray-900 text-gray-900' : 'border-transparent'"
                                class="inline-block p-1 sm:p-3 md:p-4 text-sm sm:text-sm md:text-base border-b-2 rounded-t-lg
                                    hover:border-gray-900 dark:hover:text-gray-900 whitespace-nowrap font-medium tab-button"
                                role="tab">
                                Performance Tasks
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-1">
                <div x-show="tab === 'assignments'" x-transition>
                    <livewire:assignments />
                </div>

                <div x-show="tab === 'activities'" x-transition>
                    <livewire:activities />
                </div>

                <div x-show="tab === 'performance'" x-transition>
                    <livewire:performance-tasks />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
