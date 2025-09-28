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
                                <select class="form-control" wire:model.live="searchType">
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
                                <button wire:click="searchCustomer"
                                    class="btn btn-primary btn-rounded">{{ __('Search') }}</button>
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
                                    <a class="nav-link {{ $tabs == 'home' ? 'active' : '' }} " data-toggle="tab"
                                        href="#home" wire:click="changeTabs('home')">{{ __('Main data') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $tabs == 'info' ? 'active' : 'disabled' }}" data-toggle="tab"
                                        href="#info" wire:click="changeTabs('info')">{{ __('Reservation info') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $tabs == 'costs_installments' ? 'active' : 'disabled' }}"
                                        data-toggle="tab" href="#costs_installments"
                                        wire:click="changeTabs('costs_installments')">{{ __('Costs') . ' & ' . __('Installments') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade {{ $tabs == 'home' ? 'active show' : '' }}" id="home"
                                    role="tabpanel">
                                    @foreach ($results as $plan)
                                        <div class="card mb-3 text-dark" wire:key="card-{{ $plan->id }}">
                                            <div class="card-header">

                                            </div>
                                            <div class="card-body">
                                                {{-- <p>{{ $plan->total_amount }}</p> --}}
                                                <div class="row">
                                                    <div class="col-lg-6 ">
                                                        <p>{{ __('Project Code') }} : {{ $plan->project->code }}</p>
                                                        <p>{{ __('Project Name') }} : {{ $plan->project->name }}</p>
                                                        <p>{{ __('Phase Name') }} : {{ $plan->phases->name }}</p>
                                                    </div>
                                                    <div class="col-lg-6 ">
                                                        <button class="btn btn-sm btn-info btn-rounded text-end"
                                                            type="submit"
                                                            wire:click.prevent="reservationInfo({{ $plan->id }})">{{ __('Show') }}</button>
                                                        <button class="btn btn-sm btn-danger btn-rounded text-end"
                                                            type="button"
                                                            onclick="confirmDelete({{ $plan->id }} ,'deleteReservation')">{{ __('Delete') }}</button>
                                                    </div>
                                                </div>

                                                <hr>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane fade {{ $tabs == 'info' ? 'active show' : '' }}" id="info">
                                    <div class="pt-4 text-dark">
                                        <button class="btn btn-rounded btn-warning text-white"
                                            wire:click="$set('newCustomer',true)">
                                            <i class="fa fa-users"></i>
                                            {{ __('Add a new beneficiary') }} </button>

                                        <button class="btn btn-rounded btn-dark text-white"
                                            wire:click="changeTabs('costs_installments')">
                                            <i class="fa fa-users"></i>
                                            {{ __('Show Costs & Installments') }} </button>
                                        <hr>
                                        @if ($newCustomer)
                                            <div class="card">
                                                <div class="card-header">
                                                    {{ __('Customer Code') }} : #{{ $addedCustomer }}
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="">{{ __('Customer Name') }}</label>
                                                            <select class="form-control-sm" name=""
                                                                id="" wire:model.live="addedCustomer">
                                                                <option value="">{{ __('Select Action') }}
                                                                </option>
                                                                @foreach ($customers as $cust)
                                                                    <option value="{{ $cust->id }}">
                                                                        {{ $cust->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="card-footer">
                                                    <button class="btn btn-rounded btn-primary text-white"
                                                        wire:click="addNewCustomer({{ $plan->id }})">
                                                        {{ __('Save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                        @php
                                            $i = 1;
                                        @endphp
                                        <div class="row">
                                            @if ($isWithdrawal)
                                                <div class="col-lg-6">
                                                    <label for=""> {{ __('Customers Types') }} </label>
                                                    <select wire:model.live="selectedCustomerType" class="form-control"
                                                        name="" id="">
                                                        <option value=""> {{ __('Select an option') }} </option>
                                                        @forelse ($CustomerTypes as $customeeType)
                                                            <option value="{{ $customeeType->id }}">
                                                                {{ $customeeType->name }} </option>
                                                        @empty
                                                            <option value=""> {{ __('No Data') }} </option>
                                                        @endforelse
                                                    </select>
                                                    <br>
                                                    <button class="btn btn-danger btn-sm btn-rounded"
                                                        wire:click="saveWithdrawal">
                                                        <i class="fa-solid fa-user-slash"></i>
                                                        {{ __('Withdrawal') }} </button>
                                                </div>
                                            @else
                                                @foreach ($reservation_Info as $info)
                                                    <div class="col-lg-6">
                                                        <p># {{ $i++ }} </p>
                                                        <p>{{ __('Customer Code') }} : {{ $info->customer->code }}</p>
                                                        <p>{{ __('Customer Name') }} : {{ $info->customer->name }}</p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <button class="btn btn-danger btn-sm btn-rounded"
                                                            wire:click="WithDrawal({{ $info->customer->code }})">
                                                            <i class="fa-solid fa-user-slash"></i>
                                                            {{ __('Delete beneficiary') }} </button>
                                                    </div>
                                                @endforeach

                                            @endif
                                        </div>



                                    </div>
                                </div>
                                <div class="tab-pane fade {{ $tabs == 'costs_installments' ? 'active show' : '' }}"
                                    id="costs_installments">
                                    @if ($isEditCostsInstallment)
                                        @if ($isEditCostsInstallment = 'costs')
                                            @include('livewire.cp.installments.edit_costs')
                                        @else
                                            @include('livewire.cp.installments.edit_installments')
                                        @endif
                                    @else
                                        <div class="card">
                                            <div class="card-body text-dark">
                                                <div class="row">
                                                    @if ($addCostsInstallments == 'costs')
                                                        @include('livewire.cp.installments.add_costs')
                                                    @elseif ($addCostsInstallments == 'installment')
                                                        @include('livewire.cp.installments.add_installment')
                                                    @else
                                                        @include('livewire.cp.installments.show_costs')
                                                        @include('livewire.cp.installments.show_installment')
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

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
</div>

@section('title', __('Reservations'))
@include('tools.confimDelete', ['method' => 'deleteReservation'])
@script
    @include('tools.message')
@endscript
