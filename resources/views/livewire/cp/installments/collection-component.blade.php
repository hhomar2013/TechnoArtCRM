<div>
    @if ($collectCosts || $collectPayments)
        <div class="card text-dark">
            @if ($collectCosts)
                <div class="card-header">
                    {{ __('Costs') }}
                    <button class="btn btn-warning btn-rounded" wire:click="back">{{ __('Back') }} <i
                            class="fa fa-arrow-left"></i></button>
                </div>
            @else
                <div class="card-header">
                    {{ __('Payments') }}
                    <button class="btn btn-warning btn-rounded" wire:click="back">{{ __('Back') }} <i
                            class="fa fa-arrow-left"></i></button>
                </div>
            @endif
            <div class="card-body">
                <div class="basic-list-group">
                    <ul class="list-group">
                        <?php $value = 0; ?>
                        @foreach ($selectedCosts as $index => $val)
                            <?php $value += $val['value']; ?>
                            <li wire:key="cost-{{ $index }}"
                                class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $val['cost'] }} <br>
                                {{ $val['date'] }} <br>
                                {{ number_format($val['value'], 2) }} &nbsp;
                                <button class="btn btn-danger btn-sm"
                                    wire:click="removeCost({{ $index }})">-</button>
                            </li>
                        @endforeach
                    </ul>
                </div>


                <div class="basic-list-group">
                    <ul class="list-group">
                        @foreach ($selectedPayments as $payment_index => $payment_val)
                            <?php $value += $payment_val['amount']; ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                wire:key="payment-{{ $payment_index }}">
                                {{ $payment_val['type'] }} <br>
                                {{ $payment_val['date'] }} <br>
                                {{ number_format($payment_val['amount'], 2) }} &nbsp;
                                <button class="btn btn-danger btn-sm"
                                    wire:click="removePayment({{ $payment_index }})">-</button>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <hr>
                <h4>{{ __('total') }} : {{ number_format($value, 2) }} جنيه</h4>
                <br>
                <div class="card">
                    <div class="card-body shadow">
                        <div class="basic-form">
                            @if ($cost_reaming)
                                <form wire:submit.prevent="save_cost_reaming">
                                @elseif($payment_reaming)
                                    <form wire:submit.prevent="save_payments_reaming">
                                    @else
                                        <form wire:submit.prevent="{{ $collectCosts ? 'saveCosts' : 'savePayments' }}">
                            @endif

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('Bank Name') }}</label>
                                    <select name="" id="" class="form-control" wire:model="bank">
                                        <option value="">{{ __('Select an option') }}</option>
                                        @foreach ($banks as $bank_val)
                                            <option value="{{ $bank_val->id }}">{{ $bank_val->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('bank')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('Receipt number') }}</label>
                                    <input type="number" class="form-control" placeholder="{{ __('Receipt number') }}"
                                        wire:model="transaction_id">
                                    @error('transaction_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('Receipt date') }}</label>
                                    <input type="date" class="form-control" placeholder="{{ __('Receipt date') }}"
                                        wire:model="transaction_date">
                                    @error('transaction_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{ __('Time') }}</label>
                                    <input type="time" class="form-control" placeholder="{{ __('Time') }}"
                                        wire:model="time">
                                    @error('time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>{{ __('Total receipt') }}</label>
                                    <input type="number" class="form-control" placeholder="{{ __('Total receipt') }}"
                                        wire:model.live="receipt_value" min="1">
                                    @error('receipt_value')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                    <h4><b class="text-danger"> {{ __('reaming') }} :
                                            {{ number_format((float) $reaming, 2) }}</b></h4>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for=""> {{ __('notes') }} </label>
                                    <Textarea class="form-control" cols="2" rows="2" wire:model.live="notes"></Textarea>
                                    @error('notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ $collectCosts ? __('Collect') . ' ' . __('Costs') : __('Collect') . ' ' . __('Installments') }}
                            </button>


                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="card ">
            <div class="card-header">
                <h3>{{ __('Collections') }}</h3>
                @include('tools.spinner')
            </div>
            <div class="card-body text-dark">
                <div id="accordion-eleven"
                    class="accordion accordion-rounded-stylish accordion-bordered col-12  accordion-header-bg">
                    <div class="accordion__item">
                        <div class="accordion__header accordion__header--primary" data-toggle="collapse"
                            data-target="#rounded-stylish_collapseOne" aria-expanded="true">
                            <span class="accordion__header--icon"></span>
                            <span class="accordion__header--text">بحث</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="rounded-stylish_collapseOne" class="accordion__body collapse show"
                            data-parent="#accordion-eleven" style="">
                            <div class="accordion__body--text">
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
                                        <input type="text" class="form-control" wire:model.live="customer_id" />
                                        <br />
                                    </div>
                                    {{-- <div class="col-lg-2">
                                    <label for=""><i class="fa fa-search"></i></label> <br>
                                    <button class="btn btn-primary btn-rounded" wire:click="searchCustomer({{ $customer_id }})">{{ __('Search') }}</button>
                                </div> --}}

                                    <div class="col-lg-3">
                                        <label for="">{{ __('Customers') }}</label>
                                        <select name="" id="" class="form-control"
                                            wire:model.live="customer">

                                            @foreach ($customer as $cut_val)
                                                <option value="{{ $cut_val->id }}">{{ $cut_val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($customer_details)
                                        <div class="col-lg-3 py-3">
                                            <h4 class="text-primary"> <b>{{ __('Mobile') }} :
                                                    {{ $customer_details->mobile }}</b> </h4><br>
                                            <h4 class="text-primary"><b>{{ __('ID Number') }} :
                                                    {{ $customer_details->idCard }}</b></h4>
                                        </div>
                                    @endif



                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                @if ($greaterThanCustomerCount)
                    <div class="card col-4">
                        <div class="card-body">
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    @foreach ($greaterThanCustomerCount as $greaterThanCustomerCount_val)
                                        @if ($greaterThanCustomerCount_val->statusip == 'pending')
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <h4><b>{{ __('Project Name') }}</b> :
                                                    {{ $greaterThanCustomerCount_val->project_name }}</h4>
                                                <h4><b>{{ __('Phase Name') }}</b> :
                                                    {{ $greaterThanCustomerCount_val->phase_name }}</h4>
                                                <span class="badge badge-primary badge-pill">
                                                    <button class="btn text-white"
                                                        wire:click="getSearch({{ $greaterThanCustomerCount_val->installment_plan_id }})"><i
                                                            class="fa fa-eye"></i></button>
                                                </span>
                                                <button class="btn btn-danger btn-rounded text-white"
                                                    wire:click="previewCustomerReport({{ $greaterThanCustomerCount_val->installment_plan_id }})">
                                                    <i class="fa fa-print"></i>
                                                    {{ __('Preview') }}</button>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                @endif

                <h5><b class="text-primary">
                        {{ __('Customer Balance') }} : {{ number_format($this->customer_balance, 2) }} &nbsp;
                        {{ __('جنيه') }}
                    </b></h5>

                <div class="row">
                    <div class="card mt-3 col-lg-6">
                        <div class="card-header">
                            <h3>{{ __('Costs') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive " style="overflow-y: auto; height: 400px;">
                                <table class="table table-hover text-dark">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('type') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('t.date') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($costs as $cost_val)
                                            <tr></tr>
                                            <td>{{ $cost_val->id }}</td>
                                            <td>{{ $cost_val->costs->name }}</td>
                                            <td>{{ number_format($cost_val->value, 2) }}</td>
                                            <td>{{ $cost_val->date }}</td>
                                            <td>
                                                @if ($cost_val->status == 'pending')
                                                    <span class="badge badge-warning">{{ __('pending') }}</span>
                                                @elseif ($cost_val->status == 'paid')
                                                    <span
                                                        class="badge badge-success text-white">{{ __('Paid') }}</span>
                                                @elseif($cost_val->status == 'partiallycollected')
                                                    <span
                                                        class="badge badge-danger text-white">{{ __('Partially collected') }}
                                                    </span>
                                                    {{-- <br>
                                                    <span>
                                                        <b class="text-white badge badge-danger">
                                                            {{ __('reaming') }}
                                    {{ number_format($cost_val->reamings->remaining, 2) }}</b>
                                    </span> --}}
                                                @endif
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-dark btn-rounded text-white "
                                                    {{ $selectedPayments ? 'hidden' : '' }}
                                                    {{ $cost_val->status == 'paid' ? 'hidden' : '' }}
                                                    @if ($cost_val->status == 'partiallycollected') wire:click="selectCostReaming({{ $cost_val->id }})">
                                        @else
                                        wire:click="selectCost({{ $cost_val->id }})"> @endif
                                                    <i class="fa-regular fa-circle-check"></i>
                                                </button>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            @if ($costs)
                                <div class="py-4">
                                    <span>{{ __('Count') }}</span>
                                    <b colspan="3">{{ $costs->count() }}</b>
                                </div>
                            @endif

                        </div>



                    </div>

                    <div class="card mt-3 col-lg-6">
                        <div class="card-header">
                            <h3>{{ __('Installments') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive " style="overflow-y: auto; height: 400px;">
                                <table class="table table-hover text-dark">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('type') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('t.date') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($payments as $payment_val)
                                            <tr></tr>
                                            <td>{{ $payment_val->id }}</td>
                                            <td> <span
                                                    class="badge badge-primary">{{ $payment_val->type == 'installment' ? 'قسط' : '' }}</span>
                                            </td>
                                            <td>{{ number_format($payment_val->amount, 2) }}</td>
                                            <td>{{ $payment_val->due_date }}</td>
                                            <td>
                                                @if ($payment_val->status == 'pending')
                                                    <span class="badge badge-warning">{{ __('pending') }}</span>
                                                @elseif($payment_val->status == 'paid')
                                                    <span
                                                        class="badge badge-success text-white">{{ __('Paid') }}</span>
                                                @elseif($payment_val->status == 'partiallycollected')
                                                    <span
                                                        class="badge badge-danger text-white">{{ __('Partially collected') }}</span>
                                                    {{-- <span>
                                                        <b class="text-white badge badge-danger">
                                                            {{ __('reaming') }}
                                    {{$payment_val->reamings->remaining }}
                                    </b>
                                    </span> --}}
                                                @endif
                                            </td>
                                            <td>

                                                <button type="submit" class="btn btn-dark btn-rounded text-white "
                                                    {{ $selectedCosts ? 'hidden' : '' }}
                                                    {{ $payment_val->status == 'paid' ? 'hidden' : '' }}
                                                    @if ($payment_val->status == 'partiallycollected') wire:click="selectPaymentReaming({{ $payment_val->id }})">
                                        @else
                                        wire:click="selectPayments({{ $payment_val->id }})"> @endif
                                                    <i class="fa-regular fa-circle-check"></i>
                                                </button>


                                            </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>
                            @if ($payments)
                                <div class="py-4">
                                    <span>{{ __('Count') }}</span>
                                    <b colspan="3">{{ $payments->count() }}</b>
                                </div>
                            @endif

                        </div>



                    </div>
                </div>


                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    @foreach ($selectedCosts as $index => $val)
                                        <li wire:key="cost-{{ $index }}"
                                            class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $val['cost'] }} <br>
                                            {{ $val['date'] }} <br>
                                            {{ number_format($val['value'], 2) }} &nbsp;
                                            <button class="btn btn-danger btn-sm"
                                                wire:click="removeCost({{ $index }})">-</button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


                            @if ($selectedCosts && !$selectedPayments)
                                <hr>
                                <button class="btn btn-primary"
                                    wire:click.prevent="$set('collectCosts',true)">{{ __('Collect') . ' ' . __('Costs') }}<i
                                        class="fa-solid fa-money-bill"></i></button>

                                <button class="btn btn-danger"
                                    wire:click="removeAll">{{ __('Remove All') }}</button>
                            @endif
                        </div>


                        <div class="col-lg-6">
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    @foreach ($selectedPayments as $payment_index => $payment_val)
                                        <li class="list-group-item d-flex justify-content-between align-items-center"
                                            wire:key="payment-{{ $payment_index }}">
                                            {{ $payment_val['type'] }} <br>
                                            {{ $payment_val['date'] }} <br>
                                            {{ number_format($payment_val['amount'], 2) }} &nbsp;
                                            <button class="btn btn-danger btn-sm"
                                                wire:click="removePayment({{ $payment_index }})">-</button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


                            @if (!$selectedCosts && $selectedPayments)
                                <hr>
                                <button class="btn btn-primary"
                                    wire:click.prevent="collectPayment">{{ __('Collect') . ' ' . __('Installments') }}<i
                                        class="fa-solid fa-money-bill"></i></button>

                                <button class="btn btn-danger"
                                    wire:click="removeAll">{{ __('Remove All') }}</button>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    @endif


</div>
@section('title', __('Collections'))
@script
    @include('tools.message')
@endscript
