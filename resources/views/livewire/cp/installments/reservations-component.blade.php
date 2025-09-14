<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                .<div class="card">
                    <div class="card-header">
                        <h3>{{ __('Reservations') }}</h3>
                    </div>
                    <div class="card-body">
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
                                <input type="text" class="form-control" wire:model="search" />
                            </div>

                            <div class="col-lg-3">
                                <label><i class="fa fa-search"></i></label><br>
                                <button wire:click="searchCustomer" class="btn btn-primary btn-rounded">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">نتائج البحث</h4>
                    </div>

                    <div class="card-body">
                        <!-- Nav tabs -->
                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ $tabs == "home" ? "active" : '' }} " data-toggle="tab" href="#home" wire:click="changeTabs('home')">{{ __('Main data') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $tabs =='info' ? 'active' :'disabled' }}" data-toggle="tab" href="#info" wire:click="changeTabs('info')">{{ __('Reservation info') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade {{ $tabs == "home" ? "active show" : '' }}" id="home" role="tabpanel">
                                    @foreach($results as $plan)
                                    <div class="card mb-3 text-dark">
                                        <div class="card-header">

                                        </div>
                                        <div class="card-body">
                                            {{-- <p>{{ $plan->total_amount }}</p> --}}
                                            <div class="row">
                                                <div class="col-lg-6 d">
                                                    <p>{{ __('Project Name') }} : {{ $plan->project->name }}</p>
                                                    <p>{{ __('Phase Name') }} : {{ $plan->phases->name }}</p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button class="btn btn-sm btn-danger btn-rounded text-end" type="submit" wire:click.prevent="reservationInfo({{ $plan->id }})">{{ __('Show') }}</button>
                                                </div>
                                            </div>

                                            <hr>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane fade {{ $tabs == "info" ? "active show" : '' }}" id="info">
                                    <div class="pt-4 text-dark">
                                        {{-- <h4>{{ __('Customers Count')}} : {{ $reservation_Info->customer->count() }}</h4> --}}
                                        {{-- <hr> --}}
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach ( $reservation_Info as $info)
                                        <p># {{ $i++ }}</p>
                                        <p>{{ __("Customer Code") }} : {{ $info->customer->code }}</p>
                                        <p>{{ __("Customer Name") }} : {{ $info->customer->name }}</p>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('title', __('Reservations'))
@script
@include('tools.message')
@endscript
