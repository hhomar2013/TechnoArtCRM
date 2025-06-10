<?php

namespace App\Livewire\Cp\Settings\Users;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class Roles extends Component
{

    public $name, $roleId;
    public $permissions = [];
    public $allPermissions = [];
    public $show = false;

    public function mount()
    {
        $this->allPermissions = Permission::pluck('name')->toArray();
    }

    public function createRole()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $this->name]);
        $role->syncPermissions($this->permissions);

        session()->flash('message', 'Role created successfully.');
        $this->reset(['name', 'permissions']);
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->permissions = $role->permissions->pluck('name')->toArray();
    }

    public function updateRole()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->roleId,
            'permissions' => 'array'
        ]);

        $role = Role::findOrFail($this->roleId);
        $role->update(['name' => $this->name]);
        $role->syncPermissions($this->permissions);

        session()->flash('message', 'Role updated successfully.');
        $this->reset(['name', 'permissions', 'roleId']);
    }

    public function deleteRole($id)
    {
        Role::findOrFail($id)->delete();
        session()->flash('message', 'Role deleted successfully.');
    }


    public function render()
    {
        return view('livewire.cp.settings.users.roles',[
            'roles' => Role::with('permissions')->get(),
        ]);
    }
}
