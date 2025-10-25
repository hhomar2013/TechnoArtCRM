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
                        <label for="">{{ __('Choose Search type') }}</label>
                        <select class="form-control" wire:model.live="search_type">
                            <option value="code">{{ __('Customer Code') }}</option>
                            <option value="name">{{ __('Customer Name') }}</option>
                            <option value="mobile">{{ __('Mobile') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label for="">{{ __('Search') }} </label>
                        <input type="text" class="form-control" wire:model="customer_id" wire:keyup="searchCustomer" />
                    </div>

                    <div class="col-lg-3">
                        <label for="">{{ __('Customers') }}</label>
                        <select class="form-control" name="" id="" wire:model="customer" wire:change="updateCode">
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-lg-2">
                        <label class="btn btn-primary btn-rounded my-4" for="selectCustomer">{{ __('Add Customer To Contract') }}</label>
                        <button wire:click="selectCustomer" id="selectCustomer" hidden></button>
                    </div>
                    @if ($customer_units)
                    <div class="col-lg-4">
                        <div class="card-body">
                            <div class="basic-list-group">
                                <ul class="list-group">
                                    @foreach ($customer_units as $customer_units_val)
                                    @if ($customer_units_val->status == 'pending')
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <h4><b>{{ __('Project Name') }}</b> :
                                            {{ $customer_units_val->project_name }}</h4>
                                        <h4><b>{{ __('Phase Name') }}</b> :
                                            {{ $customer_units_val->phase_name }}</h4>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                    @endif


                </div>
                @if ($selected_customers)
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">{{ __('Projects') }}</label>
                                <select class="form-control" wire:model.live="project" wire:change="selectProject">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($projects as $project_val)
                                    <option value="{{ $project_val->id }}">{{ $project_val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 ">
                                <label for="">{{ __('Phases') }}</label>
                                <select class="form-control" wire:model.live="phase">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($phases as $phase)
                                    <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                @if ($phase && $project)

                <div class="col-lg-12">
                    <button class="btn btn-primary btn-rounded" wire:click="addCost">{{ __('Add Costs') }}</button>
                    @if ($costs)
                    <button class="btn btn-danger btn-rounded" wire:click="deleteAllCosts">{{ __('Delete Resource') }}</button>
                    @endif

                </div>
                <div class="row mt-4">
                    @foreach ($costs as $index => $value_cost)
                    <div class="col-lg-2 col-md-4">
                        <h4># : {{ $index + 1 }}</h4>
                        <select class="form-control" wire:model="costs.{{ $index }}.cost_id">
                            <option value="" disabled>{{ __('type') }}</option>
                            @foreach ($costsData as $costsDataVal)
                            <option value="{{ $costsDataVal->id }}">{{ $costsDataVal->name }}
                            </option>
                            @endforeach
                        </select>

                        <input type="date" wire:model.live="costs.{{ $index }}.date" class="form-control" placeholder="{{ __('t.date') }}">

                        <input type="number" wire:model.live="costs.{{ $index }}.value" class="form-control" placeholder="{{ __('Value') }}">

                        <select class="form-control" wire:model.live="costs.{{ $index }}.actions">
                            <option value="">{{ __('Select an option') }}</option>
                            @foreach ($actionsOptions as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <br>
                        @if ($value_cost['actions'] === 'payments')
                        <div class="row" wire:key="{{ $index }}">
                            <div class="col-lg-6">
                                <label>عدد الأقساط</label>
                                <input type="number" class="form-control" wire:model="costs.{{ $index }}.costs_installments_count" />
                            </div>
                            <div class="col-lg-6">
                                <label>الفتره بعدد الشهور</label>
                                <input type="number" class="form-control" wire:model="costs.{{ $index }}.costs_installments_period" />
                            </div>
                        </div>
                        <br>
                        <button type="button" wire:click="generateCostPayments({{ $index }})">
                            <i class="fa-solid fa-list-check"></i>
                            {{ __('Sume The Installments') }}
                        </button>
                        @endif
                        <hr>
                        <button type="button" wire:click="removeCosts({{ $index }})" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i>
                        </button>
                        <br>
                    </div> {{-- col-lg-4 --}}
                    @endforeach

                </div>
                <hr>




                @endif


                <br>
                {{-- @if (!collect($this->costs)->contains(fn($item) => $item['date'] == 0) && $costs) --}}
                @if (!$this->hasEmptyDate() && $costs)
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="">{{ __('Installment Value') }}</label>
                                <input type="text" name="" id="" class="form-control" wire:model="installment_value" placeholder="{{ __('Installment Value') }}">
                            </div>
                            <div class="col-lg-4">
                                <label for="">{{ __('Number of installments') }}</label>
                                <input type="text" name="" id="" class="form-control" wire:model="installments_count" placeholder="{{ __('Number of installments') }}">
                            </div>
                            <div class="col-lg-4">
                                <label for="">{{ __('Starting from the date') }}</label>
                                <input type="date" name="" id="" class="form-control" wire:model="start_installment_date" placeholder="{{ __('Starting from the date') }}">
                            </div>

                            {{-- @if(!collect($this->costs)->contains(fn($item) => $item['date'] == 0))
                            @endif --}}
                            <div class="col-lg-4">
                                {{-- <label class="btn btn-warning btn-rounded my-4" for="generate"></label> --}}
                                <button wire:click="generate" id="generate" class="btn btn-warning btn-rounded my-4">
                                    {{ __('Sume The Installments') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


                @endif



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
                                    <button class="btn btn-danger btn-rounded" wire:click="removeSelectedCustomer({{ $index }})">{{ __('Delete') }}
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

                            <div class="col-lg-6">
                                {{-- Start Table --}}
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('Costs') }}</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped verticle-middle table-responsive-sm text-dark h5">
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
                                                    @foreach ($customer_costs as $customer_costs_val)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $customer_costs_val->date }}</td>
                                                        <td>{{ number_format($customer_costs_val->value, 2) }}</td>
                                                        <td>
                                                            <span class="badge badge-primary badge-rounded text-white">
                                                                {{ $customer_costs_val->costs->name }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        {{-- <div>
                                            {{ $customer_costs != null ? $customer_costs->links(data: ['scrollTo' => false]) : '' }}
                                    </div> --}}
                                </div>
                            </div>
                            {{-- End Table --}}
                        </div>

                        <div class="col-lg-6">
                            {{-- Start Table --}}
                            <div class="card" id="installments-table">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('Installments') }}</h4>
                                    <select class="form-control-sm" wire:model.live="installment_pages">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm text-dark h5" {{-- style="display: inline-block; overflow: auto; height: 200px;" --}}>
                                            <thead>
                                                <tr>
                                                    <th scope="col"> # </th>
                                                    <th scope="col">{{ __('t.date') }}</th>
                                                    <th scope="col">{{ __('Amount') }}</th>
                                                    <th scope="col">{{ __('type') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = ($customer_payments->currentPage() - 1) * $customer_payments->perPage() + 1; ?>
                                                @foreach ($customer_payments as $customer_payment_val)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $customer_payment_val->due_date }}</td>
                                                    <td>{{ number_format($customer_payment_val->amount, 2) }}
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $customer_payment_val->type == 'down_payment' ? 'badge-primary' : 'badge-danger badge-rounded text-white' }}">
                                                            {{ $customer_payment_val->type == 'down_payment' ? 'دفعه مقدم' : 'دفعه قسط' }}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                {{-- <tr>
                                                        <td>
                                                            <span class="badge badge-primary">{{ __('total') }}</span>
                                                </td>
                                                <td colspan="3">{{ $customer_payments->sum('amount')}}</td>
                                                </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div>
                                        {{ $customer_payments != null ? $customer_payments->links(data: ['scrollTo' => false]) : '' }}
                                    </div>
                                </div>
                            </div>
                            {{-- End Table --}}
                        </div>



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


<script>
    // منع F5 و Ctrl+R و Shift+F5
    window.addEventListener('keydown', function(e) {
        if (
            e.key === 'F5' ||
            (e.ctrlKey && e.key === 'r') ||
            (e.ctrlKey && e.shiftKey && e.key === 'R')
        ) {
            e.preventDefault();
            // alert('تم تعطيل تحديث الصفحة');
            Swal.fire({
                // position: "top-start",
                position: "center"
                , title: "لا يمكن تحديث الصفحه"
                , type: "error"
                , showConfirmButton: false
                , timer: 1500
            });
        }
    });

    // منع تحديث الصفحة باستخدام context menu reload
    window.addEventListener('beforeunload', function(e) {
        // دا بيمنع التحديث عند اغلاق أو اعادة تحميل
        e.preventDefault();
        // alert('تم تعطيل تحديث الصفحة');
        Swal.fire({
            // position: "top-start",
            position: "center"
            , title: "لا يمكن تحديث الصفحه"
            , type: "error"
            , showConfirmButton: false
            , timer: 1500
        });
        e.returnValue = '';
    });

</script>
