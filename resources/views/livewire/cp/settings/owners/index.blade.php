<div>
    <div class="card">
        <div class="card-header">
            <h4> <i class="fa-solid fa-bars"></i> {{ __('Owner Management') }}</h4>

            <select class="form-control-sm" wire:model.live="pageNumber">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            @if (session()->has('message'))
                <div class="p-2 bg-green-500 text-white">{{ session('message') }}</div>
            @endif
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-6">
                            <form wire:submit.prevent="{{ $ownersId ? 'updateOwners' : 'createOwners' }}">
                                <div class="col-lg-6">
                                    <label for="">{{ __('Owner Code') }}</label>
                                    <input type="text" wire:model="code" placeholder="{{ __('Owner Code') }}"
                                        class="form-control">
                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>

                                    <label for="">{{ __('Owner Name') }}</label>
                                    <input type="text" wire:model="name" placeholder="{{ __('Owner Name') }}"
                                        class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>

                                    <label for="">{{ __('notes') }}</label>
                                    <input type="text" wire:model="notes" placeholder="{{ __('notes') }}"
                                        class="form-control">
                                    @error('notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                                <button type="submit" class="btn btn-primary btn-rounded mt-2">
                                    <i class="fa fa-save"> </i> {{ $ownersId ? __('Update') : __('Save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>
        <div class="card-footer">
            <ul class="list-group">
                @foreach ($owners as $owner)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <strong class="text-dark">{{ $owner->name }}</strong><br>
                            <small class="text-dark">{{ $owner->code }}</small>

                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="editOwners({{ $owner->id }})"
                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="deleteOwners({{ $owner->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="pagination-circle">
                {{ $owners->links() }}
            </div>

        </div>
    </div>
</div>
