<div>
    <div class="card text-dark">
        <div class="card-header">
            <h3>
                {{ __('Total of each project') }}
            </h3>
            @include('tools.spinner')
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <label for="">{{ __('Projects') }}</label>
                    <select wire:model.live="project_id" class="form-control">
                        <option value="">{{ __('Select an option') }}</option>
                        @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <button class="btn btn-danger btn-rounded m-auto" wire:click.prevent="getResult()">
                        {{ __('Search') }} <i class="fa fa-search"></i>
                    </button>
                    &nbsp;
                    <button class="btn btn-warning btn-rounded m-auto" wire:click.prevent="clearAll()">
                        {{ __('Clear All') }} <i class="fa fa-trash"></i>
                    </button>
                </div>

                <div class="col-lg-3">
                    <label for="">{{ __('Phases') }}</label>
                    <select wire:model.live="phases_id" class="form-control">
                        <option value="">{{ __('Select an option') }}</option>
                        @foreach ($phases as $phase)
                        <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                        @endforeach
                    </select>
                    <br><br>

                </div>
            </div>
            <br>
            {{-- @if ($results)
            <div class="row">
                <div class="col-lg-12">
                    <h4><i class="fa fa-users"></i>{{ __('Customers') }}</h4>
            <div class="table-responsive" style="overflow-y: auto; height: 400px;">
                <table class="table table-bordered text-dark table-sm text-center">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>#</th>
                            <th>{{ __('Customer ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Project Name') }}</th>
                            <th>{{ __('Phases') }}</th>
                            <th>{{ __('Area') }}</th>
                            <th>{{ __('Customers Types') }}</th>
                            <th>{{ __('Sales') }}</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($totalProjects as $customer)
                        <tr></tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $customer->code }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->project_name }}</td>
                        <td>{{ $customer->phase_name }}</td>
                        <td>{{ $customer->area }}</td>
                        <td>{{ $customer->customer_type_name }}</td>
                        <td>{{ $customer->sales_name }}</td>
                        <td><button class="btn btn-primary btn-sm btn-rounded" type="submit" wire:click="getCustomerInstallments({{ $customer->installment_plan_id }} , {{ $customer->id }})">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>


    </div>
    @endif --}}
    @if ($results)

    <div class="row">

        <div class="col-lg-12">
            <h4><i class="fa fa-users"></i> {{ __('Customers') }}</h4>
            <div class="table-responsive" style="overflow-y: auto; height: 400px;">
                <table class="table table-bordered text-dark table-sm text-center ">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>#</th>
                            <th>{{ __('Customer ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Project Name') }}</th>
                            <th>{{ __('Phases') }}</th>
                            <th>{{ __('Area') }}</th>
                            <th>{{ __('Customers Types') }}</th>
                            <th>{{ __('Sales') }}</th>
                            <th>{{ __('Monthly payment') }}</th>
                            <th>{{ __('Total Payments') }}</th>
                            <th>{{ __('Total Costs') }}</th>
                            <th>{{ __('Grand Total') }}</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($totalProjects as $customer)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $customer->code }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->project_name }}</td>
                            <td>{{ $customer->phase_name }}</td>
                            <td>{{ $customer->area }}</td>
                            <td>{{ $customer->customer_type_name }}</td>
                            <td>{{ $customer->sales_name }}</td>
                            <td>{{ number_format($customer->monthly_payment, 0) }}</td>
                            <td>{{ number_format($customer->total_payments, 0) }}</td>
                            <td>{{ number_format($customer->total_costs, 0) }}</td>
                            <td class="fw-bold">{{ number_format($customer->grand_total, 0) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm btn-rounded" type="button" wire:click="getCustomerInstallments({{ $customer->installment_plan_id }}, {{ $customer->id }})">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="col-lg-6">
            <button class="btn btn-dark btn-rounded" wire:click.prevent="previewReport()"> <i class="fas fa-eye"></i> {{ __('Preview') }}</button>
        </div>
    </div>
    @endif

</div>
<div class="card-footer">
    @if ($results)
    <div class="row">
        <div class="col-lg-6">
            <h3><b class="text-danger">{{ __('Total installments') }} :
                    {{ number_format($total_payment_pending, 2) }}
                    جنيه</b></h3><br>
            <h3><b class="text-danger">{{ __('Total installment paid') }} :
                    {{ number_format($total_payment_paid, 2) }}
                    جنيه</b></h3><br>
        </div>
        <div class="col-lg-6">
            <h3><b class="text-primary">{{ __('Total Costs') }} :
                    {{ number_format($total_cost_pending, 2) }}جنيه</b></h3><br>
            <h3><b class="text-primary">{{ __('Total Costs Paid') }} :
                    {{ number_format($total_cost_paid, 2) }}جنيه</b></h3><br></h3>

        </div>

        <div class="col-lg-12">
            <hr>
            <h3><b class="text-dark">{{ __('Grand Total') }} :
                    {{ number_format($total_cost_paid + $total_payment_pending, 2) }}جنيه</b></h3><br></h3>

        </div>

    </div>
    @endif

</div>
</div>
</div>

@section('title', __('Total of each project'))


@script
@include('tools.message')
@endscript
