<div>
    <div class="card text-dark">
        <div class="card-header">
            <h3>
                {{ __('Payments') }}
            </h3>
            @include('tools.spinner')
        </div>
        <div class="card-body">
            <div class="row">
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
            </div>
            <br>
            <div class="table-responsive" style="overflow-y: auto; height: 400px;">
                <table class="table table-bordered text-dark table-sm">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>#</th>
                            <th>{{ __('type') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('t.date') }}</th>
                            <th>{{ __('Details') }}</th>
                            <th>{{ __('From') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($boxs as $box_val)
                            @php
                                $total += $box_val->value;
                            @endphp
                            <tr></tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $box_val->in_or_out == 0 ? 'تحصيل' : '' }}</td>
                            <td>{{ number_format($box_val->value, 2) }}</td>
                            <td>{{ $box_val->date }}</td>
                            <td>{{ $box_val->notes }}</td>
                            <td>{{ $box_val->users->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


        </div>
        <div class="card-footer">
            @if ($boxs)
                <div class="row">
                    <div class="col-lg-4">
                        <h2><b class="text-danger">{{ __('total') }} : {{ number_format($total, 2) }} جنيه</b></h2>
                    </div>
                    <div class="col-lg-3">
                        <h2><b class="text-primary">{{ __('Count') }} : {{ number_format($boxs->Count()) }}</b></h2>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@section('title', __('Payments'))
