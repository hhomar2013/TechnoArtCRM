<div class="col-lg-6">
    <div class="row">
        <div class="col-2">
            <h5>{{ __('Costs') }}</h5>
        </div>
        <div class="col-6">
            <button class="btn btn-warning" wire:click.prevent="addCost()">
                <i class="fa fa-plus"></i>
                إضافه تكاليف
            </button>
        </div>
    </div>

    <hr>
    <div class="row">
        @foreach ($costs as $cost)
            <div class="col-4">
                <p class="badge bg-info text-dark">
                    {{ $cost->costs->name }}</p>
            </div>
            <div class="col-4">
                <p>{{ number_format($cost->value, 2) }} &nbsp;
                    جنيه</p>
            </div>
            <div class="col-4">
                @if ($cost->status == 'paid' || $cost->status == 'partially_paid')
                    <button class="btn btn-warning btn-rounded" wire:click="editCost('edit_form',{{ $cost->id }})">
                        <i class="fa fa-edit"></i>
                    </button>
                @else
                    <button class="btn btn-success btn-rounded" wire:click="editCost('edit_cost',{{ $cost->id }})">
                        <i class="fa fa-edit"></i>
                    </button>
                @endif
                <button class="btn btn-danger btn-rounded" onclick="confirmDelete({{ $cost->id }} ,'delteCost')">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        @endforeach

    </div>

</div>
