<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Flux;

class ManageRolePost extends Component
{
    public $role_name;
    public $selected_permissions = [];
    public $roleIdToDelete;
    public $currentlyEditingId; // To store the ID of the role being edited
    public $editingRoleName; // To store the name of the role being edited

    public function render()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        return view('livewire.manage-role-post', compact('roles', 'permissions'));
    }

    public function submit()
    {
        $this->validate([
            'role_name' => 'required|string|max:255|unique:roles,name',
            'selected_permissions' => 'array',
        ]);

        try {
            $role = Role::create(['name' => $this->role_name]);
            $permissionsToSync = [];
            if ($this->selected_permissions) {
                foreach ($this->selected_permissions as $permissionId) {
                    $permission = Permission::findById($permissionId);
                    if ($permission) {
                        $permissionsToSync[] = $permission;
                    } else {
                        \Log::error("Could not find permission with ID:", ['id' => $permissionId]);
                        $this->addError('selected_permissions', 'One or more selected permissions could not be found.');
                        return;
                    }
                }
                $role->syncPermissions($permissionsToSync);
            }
            session()->flash('message', 'Role created successfully.');
            $this->reset(['role_name', 'selected_permissions']);
            Flux::modal('create-role')->close();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Livewire
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while creating the role: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $this->roleIdToDelete = $id;
        Flux::modal('delete-role')->show();
    }

    public function destroy()
    {
        if ($this->roleIdToDelete) {
            try {
                $role = Role::findById($this->roleIdToDelete);
                if ($role) {
                    $role->delete();
                    session()->flash('message', 'Role deleted successfully.');
                } else {
                    session()->flash('error', 'Role not found.');
                }
            } catch (\Exception $e) {
                session()->flash('error', 'An error occurred while deleting the role: ' . $e->getMessage());
            } finally {
                $this->roleIdToDelete = null;
            }
        }
        Flux::modal('delete-role')->close();
    }

    public function edit($id)
    {
        $role = Role::findById($id);
        if ($role) {
            
            $this->currentlyEditingId = $role->id;
            $this->editingRoleName = $role->name;
            $this->selected_permissions = $role->permissions->pluck('id')->toArray();
            Flux::modal('edit-role')->show();
        } else {
            session()->flash('error', 'Role not found for editing.');
        }
    }

    public function update()
    {
        if ($this->currentlyEditingId) {
            try {
                $this->validate([
                    'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->currentlyEditingId)],
                    'selected_permissions' => 'array',
                ]);

                $role = Role::findById($this->currentlyEditingId);
                if ($role) {
                    $role->update(['name' => $this->editingRoleName]);
                    $permissionsToSync = [];
                    if ($this->selected_permissions) {
                        foreach ($this->selected_permissions as $permissionId) {
                            $permission = Permission::findById($permissionId);
                            if ($permission) {
                                $permissionsToSync[] = $permission;
                            } else {
                                \Log::error("Could not find permission with ID:", ['id' => $permissionId]);
                                $this->addError('selected_permissions', 'One or more selected permissions could not be found.');
                                return;
                            }
                        }
                        $role->syncPermissions($permissionsToSync);
                    } else {
                        $role->syncPermissions([]); // Remove all permissions if none are selected
                    }
                    session()->flash('message', 'Role updated successfully.');
                    $this->resetEditForm();
                    Flux::modal('edit-role')->close();
                } else {
                    session()->flash('error', 'Role not found for updating.');
                }
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Validation errors are automatically handled by Livewire
            } catch (\Exception $e) {
                session()->flash('error', 'An error occurred while updating the role: ' . $e->getMessage());
            }
        }
    }

    public function resetEditForm()
    {
        $this->currentlyEditingId = null;
        $this->editingRoleName = '';
        $this->selected_permissions = [];
    }
}