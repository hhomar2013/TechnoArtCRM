<div>
    <div class="card">
        <div class="card-header">
            <h4> <i class="fa-solid fa-bars"></i> {{ __('Phases') }}</h4>

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
                            <form wire:submit.prevent="{{ $paymentsId ? 'update' : 'create' }}">
                                <div class="col-lg-6">

                                    <label for="">{{ __('Name') }}</label>
                                    <input type="text" wire:model="name" placeholder="{{ __('Name') }}"
                                        class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                    <label for="">{{ __('Years') }}</label>
                                    <input type="text" wire:model="years" placeholder="{{ __('Years') }}"
                                        class="form-control">
                                    @error('years')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                    <label for="">{{ __('Installments Count') }}</label>
                                    <input type="text" wire:model="installment_count" placeholder="{{ __('Installments Count') }}"
                                        class="form-control">
                                    @error('installment_count')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                    <label for="">{{ __('Down Payment Percent') }}</label>
                                    <input type="text" wire:model="down_payment_percent" placeholder="{{ __('Down Payment Percent') }}"
                                        class="form-control">
                                    @error('down_payment_percent')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                </div>
                                <button type="submit" class="btn btn-primary btn-rounded mt-2">
                                    <i class="fa fa-save"> </i> {{ $paymentsId ? __('Update') : __('Save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <ul class="list-group">
                @foreach ($payments_plan as $payments_plan_val)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="col-10">
                            <strong class="text-dark">{{ $payments_plan_val->name }}</strong><br>
                            <small class="text-danger">{{ __('Years') }} : {{ $payments_plan_val->years }}</small>

                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <button wire:click="edit({{ $payments_plan_val->id }})"
                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                            <button wire:click="delete({{ $payments_plan_val->id }})"
                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                        </div>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div class="pagination-circle">
                {{ $payments_plan->links() }}
            </div>

        </div>
    </div>
</div>
