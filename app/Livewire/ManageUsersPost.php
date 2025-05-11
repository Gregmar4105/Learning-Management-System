<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

class ManageUsersPost extends Component
{
    public $name;
    public $email;
    public $password;
    public $role_name;
    public $reload;
    public $currentlyEditingId;
    public $userIdToDelete; // Add this property

   

    #[On(("render"))]
    public function render()
    {
        $roles = Role::all();
        $users = User::all();
        return view('livewire.manage-users-post', compact('users', 'roles'));
    }


    public function submit(){

        
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $user->syncRoles($this->role_name);

        $this->resetForm();
        Flux::modal("create-user")->close();
    }
    
    public function resetForm()
{
    $this->name = '';
    $this->email = '';
    $this->password = '';
    $this->currentlyEditingId = null;
    $this->userIdToDelete = null; // Reset this property
}

    public function edit($id)
    {
        //dd($id);
        $user = User::find($id);
        $this->currentlyEditingId = $id; // Store the ID of the user being edited
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = ''; // It's good practice to clear the password field on edit
        Flux::modal("edit-user")->show();
    }

    public function update() // Remove the $id parameter here, we use $this->currentlyEditingId
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->currentlyEditingId),
            ],
            'password' => 'nullable|string|min:8',
        ]);

        $user = User::find($this->currentlyEditingId);
        if ($user) {
            $user->name = $this->name;
            $user->email = $this->email;
            if ($this->password) {
                $user->password = bcrypt($this->password);
            }
            $user->save();

            $this->resetForm();
            Flux::modal("edit-user")->close();
        } else {
            // Handle the case where the user with the ID is not found
            session()->flash('error', 'User not found.');
        }
    }
    public function confirmDelete($id)
{
    $this->userIdToDelete = $id;
    Flux::modal("delete-user")->show();
}


    
public function destroy()
{
    $user = User::find($this->userIdToDelete);
    if ($user) {
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
        Flux::modal("delete-user")->close();
    } else {
        session()->flash('error', 'User not found for deletion.');
    }
}

}
