<div>
    <flux:modal name="create-role" class="md:w-150">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Create a Role</flux:heading>
                <flux:text class="mt-2">Submit role details.</flux:text>
            </div>

            <flux:input label="Role name" wire:model="role_name" placeholder="Role name"/>

            <div class="mt-2">
                <h4>Permissions:</h4>
                @foreach ($permissions as $permission)
                    <div class="flex items-center">
                        <flux:checkbox type="checkbox" wire:model="selected_permissions" value="{{ $permission->id }}" />
                        <span class="ml-2">{{ $permission->name }}</span>
                    </div>
                    @endforeach
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
                <flux:heading size="lg">Edit Role</flux:heading>
                <flux:text class="mt-2">Edit role details.</flux:text>
            </div>

            <flux:input label="Role name" wire:model="role_name" placeholder=""/>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" wire:click="update" variant="primary">Update</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="delete-role" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete role?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this role.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" wire:click="destroy" variant="danger">Delete role</flux:button>
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
                        Role Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Permissions
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($roles as $role)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $role->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                    {{ $role->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        @foreach ($role->permissions as $permission)
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @can('role-edit')
                        <flux:modal.trigger name="edit-user">
                            <flux:button type="submit" wire:click="edit({{ $role->id }})" size="sm">Edit</flux:button>
                        </flux:modal.trigger>
                        @endcan
                    </td>
                    <td>
                        @can('role-delete')
                        <flux:modal.trigger name="delete-user">
                            <flux:button variant="danger" size="sm" wire:click="confirmDelete({{ $role->id }})">Delete</flux:button>
                        </flux:modal.trigger>
                        @endcan
                    </td>
                </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
</div>