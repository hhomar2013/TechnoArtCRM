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
                    <select wire:model.live="project_id" class="form-control" wire:change="getResult()">
                        <option value="">{{ __('Select an option') }}</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <button class="btn btn-danger btn-rounded m-auto" wire:click.prevent="getResult()">
                        {{ __('Search') }} <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <br>
            @if ($results)
                <div class="row">
                    <div class="col-lg-6">
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
                                        <td>{{ $customer->customer_type_name }}</td>
                                        <td>{{ $customer->sales_name }}</td>
                                        <td><button class="btn btn-primary btn-sm btn-rounded" type="submit"
                                                wire:click="getCustomerInstallments({{ $customer->installment_plan_id }} , {{ $customer->id }})">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>


                </div>
            @endif


        </div>
        <div class="card-footer">
            @if ($results)
                <div class="row">
                    <div class="col-lg-4">
                        <h3><b class="text-danger">{{ __('Total installments') }} :
                                {{ number_format($total_payment_pending, 2) }}
                                جنيه</b></h3><br>
                        <h3><b class="text-danger">{{ __('Total installment paid') }} :
                                {{ number_format($total_payment_paid, 2) }}
                                جنيه</b></h3><br>
                    </div>
                    <div class="col-lg-3">
                        <h3><b class="text-primary">{{ __('Total Costs') }} :
                                {{ number_format($total_cost_pending, 2) }}</b>
                        </h3><br>
                        <h3><b class="text-primary">{{ __('Total Costs Paid') }} :
                                {{ number_format($total_cost_paid, 2) }}</b>
                        </h3>
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
