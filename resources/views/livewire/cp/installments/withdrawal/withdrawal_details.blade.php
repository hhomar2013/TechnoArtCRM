<div class="row">
    @foreach ($withdrawal as $withdrawal)
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title bg-dark text-white p-2">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">{{ __('Customer Code') }}</label>
                            <p class="text-danger">
                                <b>{{ $withdrawal->customer->code }}</b>
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-success btn-rounded" wire:click="edit({{ $withdrawal->id }})">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <button class="btn btn-sm btn-danger btn-rounded text-end" type="button"
                                onclick="confirmDelete({{ $withdrawal->id }} ,'deleteWithDrawal')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body text-dark text-bold">
                    @foreach ($withdrawal->WithdarawalBody as $withdrawalBody)
                        <div class="row">
                            <div class="col-lg-6">
                                <p>
                                    <b
                                        class="{{ $withdrawalBody->transaction_type == 'check' ? 'text-danger' : 'text-primary' }}">
                                        {{ $withdrawalBody->transaction_type == 'check' ? __('Check') : __('Withdraw savings') }}
                                    </b>
                                </p>
                                <b>{{ $withdrawalBody->transaction_type == 'check' ? __('Check number') : __('Receipt number') }}:
                                </b>
                                <p>{{ $withdrawalBody->transaction_id }}</p>
                                <b>{{ __('t.date') }}:</b>
                                <p>{{ $withdrawalBody->transaction_date }}</p>
                                <b>{{ __('Amount') }} : </b>
                                <p>{{ number_format($withdrawalBody->amount, 2) }} {{ __('EGP') }}</p>

                                <hr>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    @endforeach
</div>
