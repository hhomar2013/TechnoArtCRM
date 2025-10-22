@section('title', __('Withdraw savings'))
<div>
    <div class="card">
        <div class="card-header">
            <h4> <i class="fa-solid fa-bars"></i> {{ __('Withdraw savings') }}</h4>

            @if (session()->has('message'))
                <div class="p-2 bg-green-500 text-white">{{ session('message') }}</div>
            @endif
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        {{-- Search Area --}}
                        <div class="card bg-dark text-white p-3">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label for="">{{ __('Choose Search type') }}</label>
                                    <select class="form-control" wire:model.live="search_type">
                                        <option value="code">{{ __('Customer Code') }}</option>
                                        <option value="name">{{ __('Customer Name') }}</option>
                                        <option value="mobile">{{ __('Mobile') }}</option>
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <label for="">{{ __('Search') }} </label>
                                    <input type="text" class="form-control" wire:model.live="search_txt" />
                                    <br />
                                </div>

                                <div class="col-lg-6">
                                    @if ($customer_details)
                                        <div class="col-lg-12 py-3">
                                            <b class="text-white"> {{ __('Customer Name') }} :
                                                {{ $customer_details->name }}</b> <br>
                                            <b class="text-white"> {{ __('Mobile') }} :
                                                {{ $customer_details->mobile }}</b> <br>
                                            <b class="text-white"><b>{{ __('ID Number') }} :
                                                    {{ $customer_details->idCard }}</b></b>

                                        </div>
                                    @endif
                                </div>

                            </div>

                            <div class="col-lg-3">
                                <button wire:click="searchCustomer"
                                    class="btn btn-primary btn-rounded">{{ __('Search') }}</button>
                            </div>

                        </div> {{-- End Search Area --}}
                        {{-- Details Area --}}
                        @if ($action == 'add')
                            @include('livewire.cp.installments.withdrawal.add_withdrawal')
                        @elseif ($action == 'withdrawal')
                            @include('livewire.cp.installments.withdrawal.withdrawal_details')
                        @endif

                        {{-- End Details Area --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@include('tools.confimDelete', ['method' => 'delete'])
@script
    @include('tools.message')
@endscript
