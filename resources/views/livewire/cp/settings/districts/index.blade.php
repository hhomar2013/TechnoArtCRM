<div>
    <div class="card">
        <div class="card-header">
            <h4><i class="fa-solid fa-bars"></i> {{ __('Districts Management') }}</h4>
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
                            <form wire:submit.prevent="{{ $districtstId ? 'updateDistricts' : 'createDistricts' }}">
                                <div class="col-lg-6">
                                    <label for="">{{ __('District Code') }}</label>
                                    <input type="text" wire:model="code" placeholder="{{ __('District Code') }}"
                                        class="form-control">
                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>

                                    <label for="">{{ __('District Name') }}</label>
                                    <input type="text" wire:model="name" placeholder="{{ __('District Name') }}"
                                        class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>

                                    <label for="">{{ __('Governorate Name') }}</label>
                                   <select class="form-control"  wire:model.live="goverment">
                                    <option value="">{{ __('Select an option') }}</option>
                                        @foreach ($goverments as $goverment)
                                            <option value="{{ $goverment->id }}">{{ $goverment->name }}</option>
                                        @endforeach
                                   </select>
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
                                    <i class="fa fa-save"> </i> {{ $districtstId ? __('Update') : __('Save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>
        <div class="card-footer">
            <ul class="list-group">
                @foreach ($districts as $district)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <strong class="text-dark">{{ $district->governement->name }} - {{ $district->name }}</strong><br>
                            <small class="text-dark">{{ $district->code }}</small>

                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="editDistricts({{ $district->id }})"
                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="deleteDistricts({{ $district->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="pagination-circle">
                {{ $districts->links() }}
            </div>

        </div>
    </div>
</div>
