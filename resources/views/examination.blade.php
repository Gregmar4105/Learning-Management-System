<x-layouts.app :title="__('Examination')">
    <div x-data="{ tab: 'Exam', init() { } }" class="flex h-full w-full flex-1 flex-col rounded-xl" x-init="$nextTick(() => { tab = 'Exam' })">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Examination') }}</flux:heading>
                <flux:subheading size="lg">{{ __('Take your exams here.') }}</flux:subheading>
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
                            @click.prevent="tab = 'Exam'"
                            :class="tab === 'Exam' ? 'border-gray-900 text-gray-900 border-b-2' : 'border-transparent border-b-2 hover:border-gray-900 dark:hover:text-gray-900'"
                            class="inline-block p-1 sm:p-3 md:p-4 text-sm sm:text-sm md:text-base rounded-t-lg whitespace-nowrap font-medium tab-button"
                            role="tab">
                            Exam
                        </a>
                    </li>
                    <li class="mr-2" role="presentation">
                        <a href="#"
                            @click.prevent="tab = 'Result of Examination'"
                            :class="tab === 'Result of Examination' ? 'border-gray-900 text-gray-900 border-b-2' : 'border-transparent border-b-2 hover:border-gray-900 dark:hover:text-gray-900'"
                            class="inline-block p-1 sm:p-3 md:p-4 text-sm sm:text-sm md:text-base rounded-t-lg whitespace-nowrap font-medium tab-button"
                            role="tab">
                            Result of Examination
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-1">
            <div x-show="tab === 'Exam'" x-transition>
                <livewire:exam-display />
            </div>

            <div x-show="tab === 'Result of Examination'" x-transition>
                <livewire:related-resources />
            </div>

        </div>
    </div>
</x-layouts.app>
