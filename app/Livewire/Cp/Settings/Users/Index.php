<?php

namespace App\Livewire\Cp\Settings\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $email, $password, $userId;
    public $roles = [], $allRoles = [];

    #[Title('Users')]

    public function mount()
    {
        $this->allRoles = Role::pluck('name')->toArray();
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'array'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->syncRoles($this->roles);
        $this->dispatch('message',message: __('Done Save'));
        session()->flash('message', 'User created successfully.');
        $this->reset(['name', 'email', 'password', 'roles']);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $user->roles->pluck('name')->toArray();
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'roles' => 'array'
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user->syncRoles($this->roles);
        $this->dispatch('message',message: __('Done Save'));
        session()->flash('message', 'User updated successfully.');
        $this->reset(['name', 'email', 'roles', 'userId']);
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        $this->dispatch('message',message: __('Done Save'));
        session()->flash('message', 'User deleted successfully.');
    }
    public function render()
    {

        return view(
            'livewire.cp.settings.users.index',
            [
                'users' => User::query()->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'superadmin');
                })->with('roles')->paginate(5)
            ]
        );
    }
}
