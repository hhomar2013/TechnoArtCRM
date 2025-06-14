<div>
    <div class="card">
        <div class="card-header">
            <h4> <i class="fa-solid fa-bars"></i> {{ __('Banks Management') }}</h4>

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
                            <form wire:submit.prevent="{{ $banksId ? 'updateBanks' : 'createBanks' }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="">{{ __('Bank Code') }}</label>
                                        <input type="text" wire:model="code" placeholder="{{ __('Bank Code') }}"
                                            class="form-control">
                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('Bank Name') }}</label>
                                        <input type="text" wire:model="name" placeholder="{{ __('Bank Name') }}"
                                            class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('Bank Account Number') }}</label>
                                        <input type="text" wire:model="account_number"
                                            placeholder="{{ __('Bank Account Number') }}" class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">{{ __('Other') }}</label>
                                        <input type="text" wire:model="other" placeholder="{{ __('Other') }}"
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
                                </div>

                                <button type="submit" class="btn btn-primary btn-rounded mt-2">
                                    <i class="fa fa-save"> </i> {{ $banksId ? __('Update') : __('Save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>
        <div class="card-footer">
            <ul class="list-group">
                @foreach ($banks as $bank)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <strong class="text-dark">{{ $bank->name }}</strong><br>
                            <small class="text-dark">{{ $bank->code }}</small>

                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="editBanks({{ $bank->id }})"
                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="deleteBanks({{ $bank->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="pagination-circle">
                {{ $banks->links() }}
            </div>

        </div>
    </div>
</div>
