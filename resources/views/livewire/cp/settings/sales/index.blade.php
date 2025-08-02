@section('title', __('Customers'))
<div>
    <div class="card">
        <div class="card-header">
            <h4> <i class="fa-solid fa-bars"></i> {{ __('Employees') }}</h4>

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
                            <form wire:submit.prevent="{{ $salesId ? 'update' : 'store' }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="">{{ __('Employee Code') }}</label>
                                        <input type="text" wire:model="code" placeholder="{{ __('Employee Code') }}"
                                            readonly class="form-control">
                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('job type') }}</label>
                                        <input type="text" wire:model="jop" placeholder="{{ __('job type') }}"
                                            class="form-control">
                                        @error('jop')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('Employee Name') }}</label>
                                        <input type="text" wire:model="name" placeholder="{{ __('Employee Name') }}"
                                            class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('ID Number') }}</label>
                                        <input type="number" wire:model="idCard" placeholder="{{ __('ID Number') }}"
                                            min="0" class="form-control">
                                        @error('idCard')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <br>

                                        <label for="">{{ __('Address') }}</label>
                                        <input type="text" wire:model="address" placeholder="{{ __('Address') }}"
                                            class="form-control">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('Mobile') }}</label>
                                        <input type="text" wire:model="mobile" placeholder="{{ __('Mobile') }}"
                                            class="form-control">
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary btn-rounded mt-2">
                                    <i class="fa fa-save"> </i> {{ $salesId ? __('Update') : __('Save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <ul class="list-group">
                @foreach ($sales as $sales_val)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <strong class="text-dark">{{ $sales_val->name }}</strong><br>
                            <small class="text-primary">{{ $sales_val->code }}</small>

                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="edit({{ $sales_val->id }})"
                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="delete({{ $sales_val->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="pagination-circle">
                {{ $sales->links() }}
            </div>

        </div>
    </div>
</div>
@script
    @include('tools.message')
@endscript
