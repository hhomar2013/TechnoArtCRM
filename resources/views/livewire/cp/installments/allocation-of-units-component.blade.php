<div>
    <div class="card text-dark">
        <div class="card-header">
            <h2>{{ __('Allocation Of Units') }}</h2>
            <div class="float-right">
                @include('tools.spinner')
            </div>
        </div>
        <div class="card-body">
            <hr>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2">
                        <label for="">{{ __('Search') }}&nbsp;{{ __('Customer Code') }} &nbsp; &
                            {{ __('Customer Name') }}</label>
                        <input type="text" class="form-control" wire:model="customer_id" wire:keyup="searchCustomer" />
                    </div>

                    <div class="col-lg-4">
                        <label for="">{{ __('Customers') }}</label>
                        <select class="form-control" name="" id="" wire:model="customer"
                            wire:change="updateCode">
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <label class="btn btn-primary btn-rounded my-4"
                        for="selectCustomer">{{ __('Add Customer To Contract') }}</label>
                    <button wire:click="selectCustomer" id="selectCustomer" hidden></button>

                </div>

                <div class="row">
                    {{-- <div class="col-lg-2">
                        <label for="">{{ __('Search') }}&nbsp;{{ __('Building Code') }} &nbsp; &
                            {{ __('Building Name') }}</label>
                        <input type="text" class="form-control" wire:model="building_id"
                            wire:keyup="searchBuilding" />
                    </div> --}}

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">{{ __('Projects') }}</label>
                                <select class="form-control" wire:model="project" wire:change="selectProject">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($projects as $project_val)
                                        <option value="{{ $project_val->id }}">{{ $project_val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="">{{ __('Buildings') }}</label>
                                <select class="form-control" wire:model.live="building_id">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($buildings as $building_val)
                                        <option value="{{ $building_val->id }}">{{ $building_val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label for="">{{ __('Appartments') }}</label>
                                <select class="form-control" wire:model.live="appartment">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($appartments as $appartments_val)
                                        <option value="{{ $appartments_val->id }}">
                                            {{ __('#') . ':' . $appartments_val->code . ' - ' . $appartments_val->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($appartment)
                                <div class="col-lg-3">
                                    <label for="">{{ __('total') }}</label>
                                    <input type="text" class="form-control" wire:model="unit_price" readonly>
                                </div>
                            @endif



                        </div>


                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="">{{ __('Payment Plans') }}</label>
                                <select class="form-control" wire:model="payment_plan">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($payment_plans as $payment_plans_val)
                                        <option value="{{ $payment_plans_val->id }}">{{ $payment_plans_val->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="btn btn-warning btn-rounded my-4"
                                    for="generate">{{ __('Sume The Installments') }}</label>
                                <button wire:click="generate" id="generate" hidden></button>
                            </div>
                        </div>
                    </div>
                </div>


                <br />
                <div class="card shadow p-3">
                    <div class="card-header">
                        <h4>{{ __('Customer Information') }}</h4>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-lg-12"> --}}
                            <?php $i = 1; ?>
                            @forelse ($selected_customers as $index => $val)
                                <div class="row col-lg-3 col-md-12" wire:key="row-{{ $index }}">
                                    <div class="col-lg-6">
                                        <ul>
                                            <h5>{{ __('#') }} : {{ $i++ }}</h5>
                                            <h5>{{ $val['code'] }}</h5>
                                            <h5>{{ $val['name'] }}</h5>
                                            <br>
                                        </ul>

                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-danger btn-rounded"
                                            wire:click="removeSelectedCustomer({{ $index }})">{{ __('Delete') }}
                                        </button>
                                    </div>
                                </div>

                            @empty
                                <div class="col-lg-12">
                                    <p class="text-danger">{{ __('Select An Customer') }}</p>
                                </div>
                            @endforelse
                            {{-- </div> --}}
                        </div>

                        <div class="row">


                            {{-- Start Table --}}
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('Installment system') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col"> # </th>
                                                    <th scope="col">{{ __('t.date') }}</th>
                                                    <th scope="col">{{ __('Amount') }}</th>
                                                    <th scope="col">{{ __('type') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($customer_payment as $customer_payment_val)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $customer_payment_val->due_date }}</td>
                                                        <td>{{ $customer_payment_val->amount }}</td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $customer_payment_val->type == 'down_payment' ? 'badge-primary' : 'badge-success' }}">
                                                                {{ $customer_payment_val->type  == 'down_payment' ? 'دفعه مقدم' :'دفعه قسط'}}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- End Table --}}
                        </div>
                    </div>

                </div>


            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
@section('title', __('Allocation Of Units'))
@script
    @include('tools.message')
@endscript

@script
    <script>
        // منع F5 و Ctrl+R و Shift+F5
        window.addEventListener('keydown', function(e) {
            if (
                e.key === 'F5' ||
                (e.ctrlKey && e.key === 'r') ||
                (e.ctrlKey && e.shiftKey && e.key === 'R')
            ) {
                e.preventDefault();
                alert('تم تعطيل تحديث الصفحة');
            }
        });

        // منع تحديث الصفحة باستخدام context menu reload
        window.addEventListener('beforeunload', function(e) {
            // دا بيمنع التحديث عند اغلاق أو اعادة تحميل
            e.preventDefault();
            alert('تم تعطيل تحديث الصفحة');
            e.returnValue = '';
        });
    </script>
@endscript
