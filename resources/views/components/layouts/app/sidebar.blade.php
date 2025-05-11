<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo/>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <div class="flex items-center">
                        <flux:navlist.item class="flex items-center justify-between" icon="notebook-pen" :href="route('assigned')" :current="request()->routeIs('assigned')" wire:navigate>
                        {{ __('Assigned') }}
                        </flux:navlist.item>
                        @can('Faculty')
                        <flux:button class="ml-1" icon="chevron-down" variant="ghost" position="right" size="sm" onclick="toggleHiddenNav()"></flux:button>
                        @endcan
                    </div>
                    <div id="hiddenAssignmentNav" class="hidden mb-3">
                    <flux:navlist.item  icon="chevron-right" :href="route('assignment-upload')" :current="request()->routeIs('assignment-upload')" wire:navigate>
                        Assignment Uploads
                    </flux:navlist.item>
                    <flux:navlist.item  icon="chevron-right" :href="route('activity-upload')" :current="request()->routeIs('activity-upload')" wire:navigate>
                        Activity Uploads
                    </flux:navlist.item>
                    <flux:navlist.item  icon="chevron-right" :href="route('performance-task-upload')" :current="request()->routeIs('performance-task-upload')" wire:navigate>
                        Performance Task Uploads
                    </flux:navlist.item>
                    </div>

                    <flux:navlist.item  icon="library-big" :href="route('learning-materials')" :current="request()->routeIs('learning-materials')" wire:navigate>
                        {{ __('Learning Materials') }}
                    </flux:navlist.item>


                    <flux:navlist.item icon="book-check" :href="route('quizzes')" :current="request()->routeIs('quizzes')" wire:navigate>{{ __('Quizzes') }}</flux:navlist.item>
                    <flux:navlist.item icon="book-open-check" :href="route('examination')" :current="request()->routeIs('examination')" wire:navigate>{{ __('Examinations') }}</flux:navlist.item>
                    @can('administratornull')
                    <flux:navlist.item icon="presentation" :href="route('virtual-meetings')" :current="request()->routeIs('virtual-meetings')" wire:navigate>{{ __('Virtual Meetings') }}</flux:navlist.item>
                    @endcan
                    <flux:navlist.item icon="contact-round" :href="route('enroll')" :current="request()->routeIs('enroll')" wire:navigate>{{ __('Enrollment') }}</flux:navlist.item>
                    @can('Faculty')
                    <flux:navlist.item icon="book-marked" :href="route('manage-course')" :current="request()->routeIs('manage-course')" wire:navigate>{{ __('Manage Course') }}</flux:navlist.item>
                    @endcan
                    @can('administrator')
                    <flux:navlist.item icon="users" :href="route('manage-users')" :current="request()->routeIs('manage-users')" wire:navigate>{{ __('Manage Users') }}</flux:navlist.item>
                    <flux:navlist.item icon="user-cog" :href="route('manage-role')" :current="request()->routeIs('manage-role')" wire:navigate>{{ __('Manage Roles') }}</flux:navlist.item>
                    @endcan
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />


            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
<script>
    function toggleHiddenNav() {
        const hiddenNav = document.getElementById('hiddenAssignmentNav');
        hiddenNav.classList.toggle('hidden');

    }
</script>
</html>
