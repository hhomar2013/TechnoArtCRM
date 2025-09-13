<div>
    <div class="card">
        <div class="card-header">
            <h4><i class="fa fa-users"> </i> {{ __('Users') }}</h4>
            {{-- <button class="btn btn-primary text-white btn-rounded"> <i class="fa fa-plus"></i>
                {{ __('Add New') }}</button> --}}
            @if (session()->has('message'))
                <div class="p-2 bg-green-500 text-white">{{ session('message') }}</div>
            @endif
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-6">
                            <form wire:submit.prevent="{{ $userId ? 'updateUser' : 'createUser' }}">
                                <label for="">{{ __('Name') }}</label>
                                <input type="text" wire:model="name" placeholder="Full Name" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <label for="">{{ __('Email') }}</label>
                                <input type="text" wire:model="email" placeholder="Email" class="form-control">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                @if (!$userId)
                                    <label for="">{{ __('Password') }}</label>
                                    <input type="password" wire:model="password" placeholder="Password"
                                        class="form-control">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                @endif

                                <h3 class="mt-2">Assign Roles:</h3>
                                @foreach ($allRoles as $role)
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model="roles" value="{{ $role }}">
                                        <span class="ml-2">{{ $role }}</span>
                                    </label>
                                @endforeach
                                <br>
                                <button type="submit" class="btn btn-primary btn-rounded mt-2">
                                    <i class="fa fa-user"></i> {{ $userId ? 'Update User' : 'Create User' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>
        <div class="card-footer">
            <ul class="list-group">
                @foreach ($users as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <p><b class="text-primary">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</b>
                            </p>
                            <strong class="text-dark">{{ $user->name }}</strong><br>
                            <small class="text-dark">{{ Str::limit($user->email, 100) }}</small>

                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="editUser({{ $user->id }})"
                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="deleteUser({{ $user->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="pagination-circle">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>
