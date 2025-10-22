<div>
    <h3> <i class="fa fa-user"></i> {{ __('Customers Types') }} </h3>
    <hr>
    <form action="" wire:submit.prevent="saveTransfer">
        <div class="row">
            <div class="col-lg-12">
                <p>{{ __('Project Code') }} : {{ $plan->project->code }}</p>
                <p>{{ __('Project Name') }} : {{ $plan->project->name }}</p>
                <p>{{ __('Phase Name') }} : {{ $plan->phases->name }}</p>
                <hr>
            </div>
            <div class="col-lg-6">
                <h4>{{ __('Costs') }}</h4>
                <table class="table table-bordered table-striped text-dark text-center">
                    <thead>
                        <tr class="text-primary">
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Amount') }}</th>
                            <th scope="col">{{ __('status') }}</th>
                            {{-- <th scope="col"><i class="fa fa-cogs"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cost_transfare as $cost)
                            <tr
                                class="{{ $cost->status == 'paid' ? 'bg-success text-white' : 'bg-warning text-white' }}">
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $cost->value }}</td>
                                @if ($cost->status == 'paid')
                                    <td>{{ __('Paid') }}</td>
                                @else
                                    <td>{{ __('Partially collected') }} - {{ __('reaming') }} :
                                        {{ $cost->remaining ?? '' }}
                                    </td>
                                @endif
                                {{-- <td><i class="fa fa-cogs"></i></td> --}}
                            </tr>
                        @endforeach
                        <tr class="bg-dark text-white">
                            <td colspan="2">{{ __('Total Costs Paid') }}</td>
                            <td>{{ $total['total_costs'] }} &nbsp; {{ __('EGP') }}</td>

                        </tr>
                    </tbody>
                </table>{{-- Costs Table --}}
            </div>
            <div class="col-lg-6">
                <h4>{{ __('Installments') }}</h4>
                <table class="table table-bordered table-striped text-dark text-center">
                    <thead>
                        <tr class="text-primary">
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Amount') }}</th>
                            <th scope="col">{{ __('status') }}</th>
                            {{-- <th scope="col"><i class="fa fa-cogs"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment_transfare as $payment)
                            <tr
                                class="{{ $payment->status == 'paid' ? 'bg-success text-white' : 'bg-warning text-white' }}">
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $payment->amount }}</td>
                                @if ($payment->status == 'paid')
                                    <td>{{ __('Paid') }}</td>
                                @else
                                    <td>{{ __('Partially collected') }} - {{ __('reaming') }} :
                                        {{ $payment->remaining ?? '' }}
                                    </td>
                                @endif
                                {{-- <td><i class="fa fa-cogs"></i></td> --}}
                            </tr>
                        @endforeach
                        <tr class="bg-dark text-white">
                            <td colspan="2">{{ __('Total installment paid') }}</td>
                            <td>{{ $total['total_payments'] }} &nbsp; {{ __('EGP') }}</td>
                        </tr>
                    </tbody>
                </table>{{-- Payments Table --}}
            </div>

            <div class="col-12">
                <h3 class="text-warrning">{{ __('Transfer request to') }}</h3>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="">{{ __('Projects') }}</label>
                        <select class="form-control" wire:model.live="project">
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

                    <div class="col-12">
                        <br>
                        <label for="">{{ __('reason of transferred') }}</label>
                        <textarea class="form-control" name="" id="" cols="30" rows="10" wire:model.live="reason"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <hr>
                @php
                    $total_all = $total['total_payments'] + $total['total_costs'];
                @endphp
                <h3 class="text-danger">
                    {{ __('Total Paid') }} :
                    <b class="text-primary"> {{ number_format($total_all, 2) }}
                        &nbsp;</b>
                    {{ __('EGP') }}
                </h3>
                <hr>
            </div>

            <div class="col-12">
                <button class="btn btn-primary btn-rounded text-white">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    {{ __('Transfer') }}</button>
                <button class="btn btn-danger btn-rounded text-white" wire:click.prevent="back()">
                    <i class="fa-solid fa-arrow-left"></i>
                    {{ __('Back') }}</button>
            </div>
        </div>

    </form>





</div>
