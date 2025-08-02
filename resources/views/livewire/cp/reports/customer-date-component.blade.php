<div>
    <div class="card text-dark">
        <div class="card-header">
            <h3>
                <i class="fa-solid fa-bars"></i> {{ __('Customer data') }}
            </h3>
            @include('tools.spinner')
            <select name="" id="" wire:model.live="pageNumber">
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="10000000000">{{ __('Show All Fields') }}</option>
            </select>

        </div>
        <div class="card-body">
            <br>
            <div class="row">
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
                                    <div class="col-lg-3">
                                        <label for="">{{ __('Search') }}&nbsp;{{ __('Customer ID') }}&nbsp;&
                                            {{ __('Customer Name') }} &nbsp; & {{ __('Phone Number') }} </label>
                                        <input type="text" class="form-control" wire:model.live="search" />
                                        <br>
                                        <button class="btn btn-danger btn-rounded" wire:click.prevent="resetSearch()">
                                           <i class="fa-solid fa-rotate"></i>
                                        </button>
                                    </div>
                                    {{-- <div class="col-lg-3">
                                        <label for="">{{ __('Customers Types') }}</label>
                                        <select wire:model.live="customerTypesId" class="form-control">
                                            <option value="">{{ __('Select an option') }}</option>
                                            @foreach($cutomerTypes as $cutomerType)
                                                    <option value="{{ $cutomerType->id }}">{{ $cutomerType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-lg-12">

                    <div class="table-responsive" style="overflow-y: auto; height: 750px;">
                        <table class="table table-bordered text-dark table-sm text-center">
                            <thead>
                                <tr class="bg-dark text-white">
                                    <th>{{ __('Customer ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Customers Types') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('t.national_id') }}</th>
                                    <th>{{ __('Mobile') }}</th>
                                    <th>{{ __('Phone Number') }}</th>
                                    <th>{{ __('Area') }}</th>
                                    <th>{{ __('Sales') }}</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($customers as $customer)
                                    <tr></tr>
                                    <td>{{ $customer->code }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->customers_type->name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->idCard }}</td>
                                    <td>{{ $customer->mobile }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->area }}</td>
                                    <td>{{ $customer->sales->name }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm btn-rounded" type="submit"
                                            wire:click.prevent="customerdEdit({{ $customer->id }})">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        {{-- <button class="btn btn-primary btn-sm btn-rounded" type="submit">
                                            <i class="fa fa-eye"></i>
                                        </button> --}}
                                    </td>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        </div>
        <div class="card-footer" wire:ignor>
            {{ $customers->links() }}
        </div>
    </div>
</div>
@script
    @include('tools.message')
@endscript

@section('title', __('Customer data'))
