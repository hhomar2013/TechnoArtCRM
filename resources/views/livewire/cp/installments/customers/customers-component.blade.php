@section('title', __('Customers'))
<div>
    <div class="card">
        <div class="card-header">
            <h4> <i class="fa-solid fa-bars"></i> {{ __('Customers') }}</h4>

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
                            <form wire:submit.prevent="{{ $customersId ? 'updateCustomer' : 'createCustomer' }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="">{{ __('Customer Code') }}</label>
                                        <input type="text" wire:model="code" placeholder="{{ __('Customer Code') }}"
                                            class="form-control">
                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('Customer Name') }}</label>
                                        <input type="text" wire:model="name" placeholder="{{ __('Customer Name') }}"
                                            class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('ID Number') }}</label>
                                        <input type="number" wire:model="idCard" placeholder="{{ __('ID Number') }}" min="0"
                                            class="form-control">
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

                                        <label for="">{{ __('Phone Number') }}</label>
                                        <input type="text" wire:model="phone" placeholder="{{ __('Phone Number') }}"
                                            class="form-control">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">{{ __('Area') }}</label>
                                        <input type="number" wire:model="area" placeholder="{{ __('Area') }}" min="0"
                                            class="form-control">
                                        @error('area')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>
                                        <label for="">{{ __('Floor') }}</label>
                                        <input type="number" wire:model="floor" placeholder="{{ __('Floor') }}" min="0"
                                            class="form-control">
                                        @error('floor')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('Other') }}</label>
                                        <input type="text" wire:model="other" placeholder="{{ __('Other') }}"
                                            class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>

                                        <label for="">{{ __('Contract Total') }}</label>
                                        <input type="number" wire:model="total" placeholder="{{ __('Contract Total') }}" min="0"
                                            class="form-control">
                                        @error('total')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-rounded mt-2">
                                    <i class="fa fa-save"> </i> {{ $customersId ? __('Update') : __('Save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <ul class="list-group">
                @foreach ($customers as $customer_val)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <strong class="text-dark">{{ $customer_val->name }}</strong><br>
                            <small class="text-primary">{{ $customer_val->code }}</small>

                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="editCustomer({{ $customer_val->id }})"
                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="deleteCustomer({{ $customer_val->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="pagination-circle">
                {{ $customers->links() }}
            </div>

        </div>
    </div>
</div>
@script
    @include('tools.message')
@endscript
