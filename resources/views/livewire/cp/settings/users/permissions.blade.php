<div>
    <div class="card">
        <div class="card-header">
            <h2 class="text-lg font-semibold">{{ __('Manage Permissions') }}</h2>
            <select class="form-control-sm" wire:model.live="pageNumber">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>

            @if(session()->has('message'))
                <div class="p-2 bg-green-500 text-white">{{ session('message') }}</div>
            @endif
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $permissionId ? 'updatePermission' : 'createPermission' }}">
                <input type="text" wire:model="name" placeholder="{{ __('Permission Name') }}" class="border p-2 w-full">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                <h3 class="mt-2">{{ __('Assign to Roles') }}:</h3>
                @foreach($allRoles as $role)
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="roles" value="{{ $role }}">
                        <span class="ml-2">{{ $role }}</span>
                    </label>
                @endforeach
                    <br> <br>
                <button type="submit" class="btn btn-primary btn-rounded text-white">
                    {{ $permissionId ? __('Update Permission') : __('Create Permission') }}
                </button>
            </form>
        </div>
        <div class="card-footer">

    <h3 class="mt-4">{{ __('Existing Permissions') }}:</h3>

            <div class="p-3">
                <ul class="list-group">
                    @foreach($permissions as $permission)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="col-10">
                                <strong class="text-dark">{{ $permission->name }}</strong><br>
                                <small class="text-dark">{{ implode(', ', $permission->roles->pluck('name')->toArray()) }}</small>
                            </div>
                            <div class="col-2 d-flex justify-content-end">
                                <button wire:click="editPermission({{ $permission->id }})"
                                    class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                                <button wire:click="deletePermission({{ $permission->id }})"
                                    class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>


    <div class="pagination-circle">

        {{ $permissions->links() }}
    </div>
        </div>
    </div>
</div>
