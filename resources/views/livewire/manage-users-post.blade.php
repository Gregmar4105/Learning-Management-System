<div>
    <flux:modal name="create-user" class="md:w-150">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Create a User</flux:heading>
                <flux:text class="mt-2">Submit your personal details.</flux:text>
            </div>

            <flux:input label="Name" wire:model="name" placeholder="Your name"/>
            <flux:input label="Email" wire:model="email" placeholder="Your email"/>
            <flux:input label="Password" wire:model="password" type="password"/>
            <div class="mt-2">
                <label>Role:</label>
                <select wire:model="role_name" class="mt-1 p-2.5 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option>Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" wire:click="submit" variant="primary">Create</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="edit-user" class="md:w-150">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit User</flux:heading>
                <flux:text class="mt-2">Edit a user personal details.</flux:text>
            </div>

            <flux:input label="Name" wire:model="name" placeholder="Your name"/>
            <flux:input label="Email" wire:model="email" placeholder="Your email"/>
            <flux:input label="Password Reset" wire:model="password" type="password"/>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" wire:click="update" variant="primary">Update</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="delete-user" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete user?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this user.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" wire:click="destroy" variant="danger">Delete user</flux:button>
            </div>
        </div>
    </flux:modal>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Status
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                    @if ($user->roles->isNotEmpty())
                        {{ $user->roles->first()->name }}
                    @else
                        No Role Assigned
                    @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->status }}
                    </td>
                    <td>
                        @can('user-edit')
                        <flux:modal.trigger name="edit-user">
                            <flux:button type="submit" wire:click="edit({{ $user->id }})" size="sm">Edit</flux:button>
                        </flux:modal.trigger>
                        @endcan
                    </td>
                    <td>
                        @can('user-delete')
                        <flux:modal.trigger name="delete-user">
                            <flux:button variant="danger" size="sm" wire:click="confirmDelete({{ $user->id }})">Delete</flux:button>
                        </flux:modal.trigger>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>