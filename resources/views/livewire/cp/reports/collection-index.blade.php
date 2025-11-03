<div>
    <div class="card text-dark">
        <div class="card-header">
            <h3>
                {{ __('Summary of the next monthly collections') }}
            </h3>
            @include('tools.spinner')
        </div>
        <div class="card-body">
            {{-- <div class="row">
                <div class="col-lg-3">
                    <label for="">{{ __('From') }}</label>
                    <input type="date" name="" id="" class="form-control" wire:model="start_date">
                    <small class="text-danger">{{ $errors->first('start_date') }}</small><br>
                    <label for="">{{ __('To') }}</label>
                    <input type="date" name="" id="" class="form-control" wire:model="end_date">
                    <small class="text-danger">{{ $errors->first('end_date') }}</small>
                    <br>
                    <button class="btn btn-danger btn-rounded" wire:click.prevent="getBox()">
                        {{ __('Search') }} <i class="fa fa-search"></i>
                    </button>
                </div>
            </div> --}}
            <br>
            <div class="table-responsive" style="overflow-y: auto; height: 400px;">
                <table class="table table-bordered text-dark">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>#</th>
                            <th>{{ __('type') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('t.date') }}</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center bg-secondary text-white"><b>{{ __('Installments') }}</b></td>
                        </tr>
                        @foreach ($payments as $payment)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ __('Installment') }}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->due_date }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-center bg-secondary text-white"><b>{{ __('Costs') }}</b></td>
                        </tr>
                        @foreach ($costInstallments as $costInstallment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$costInstallment->costs->name }}</td>
                            <td>{{ number_format($costInstallment->value, 2) }}</td>
                            <td>{{ $costInstallment->date }}</td>
                        </tr>


                        @endforeach
                        {{-- <tr></tr> --}}
                    </tbody>
                </table>

            </div>


        </div>
        <div class="card-footer">
            @if ($costInstallments || $payments)
            <div class="row">
                <div class="col-lg-4">
                    <h2><b class="text-danger">{{ __('Total Costs') }} : {{ number_format($costInstallments->sum('value'), 2) }} جنيه</b></h2>
                </div>
                <div class="col-lg-4">
                    <h2><b class="text-danger">{{ __('Total installments') }} : {{ number_format($payments->sum('amount'), 2) }} جنيه</b></h2>
                </div>
                <div class="col-lg-3">
                    {{-- <h2><b class="text-primary">{{ __('Count') }} : {{ number_format($boxs->Count()) }}</b></h2> --}}
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

@section('title', __('Collection Summary'))
