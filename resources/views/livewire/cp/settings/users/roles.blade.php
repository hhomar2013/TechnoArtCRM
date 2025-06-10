<div>
    <div class="card ">
        <div class="card-header">
            <h2 class="text-lg font-semibold">{{ __('Manage Roles') }}</h2>
            @if (session()->has('message'))
                <div class="p-2 bg-green-500 text-white">{{ session('message') }}</div>
            @endif
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $roleId ? 'updateRole' : 'createRole' }}">
                <input type="text" wire:model="name" placeholder="{{ __('Role Name') }}" class="border p-2 w-full">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <h3 class="mt-2">{{ __('Permissions') }}:</h3>
                @foreach ($allPermissions as $permission)
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="permissions" value="{{ $permission }}">
                        <span class="ml-2">{{ $permission }}</span>
                    </label>
                @endforeach
                    <br><br>
                <button type="submit" class="btn btn-primary btn-rounded text-white">
                    {{ $roleId ? __('Update Role') : __('Create Role') }}
                </button>
            </form>
        </div>
        <div class="card-footer">
            <h3 class="mt-4">{{ __('Existing Roles') }}:</h3>
            <ul class="list-group">
                @foreach ($roles as $role)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <strong class="text-dark">{{ $role->name }}</strong><br>
                            <small class="text-dark">{{ implode(', ', $role->permissions->pluck('name')->toArray()) }} </small>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="editRole({{ $role->id }})"
                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="deleteRole({{ $role->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</div>
