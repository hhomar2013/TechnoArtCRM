<div class="col-lg-6">
    <div class="row">
        <div class="col-2">
            <h5>{{ __('Installments') }}</h5>
        </div>
        <div class="col-6">
            <button class="btn btn-warning" wire:click.prevent="addInstallment()">
                <i class="fa fa-plus"></i>
                إضافه قسط
            </button>
        </div>
    </div>
    <hr>
    <div class="row">
        @php $i = 1; @endphp
        @foreach ($installments as $installment)
            <div class="col-4">
                <p class="badge bg-success text-white">
                    {{ __('Installment') }} &nbsp;
                    #{{ $i++ }} </p>
            </div>
            <div class="col-4">
                <p>{{ number_format($installment->amount, 2) }}
                    &nbsp;
                    جنيه</p>
            </div>
            <div class="col-4">
                @if ($installment->status == 'paid' || $installment->status == 'partially_paid')
                    <button class="btn btn-warning btn-rounded"
                        wire:click="editInstallment('edit_form_installment',{{ $installment->id }})">
                        <i class="fa fa-edit"></i>
                    </button>
                @else
                    <button class="btn btn-success btn-rounded"
                        wire:click="editInstallment('edit_installment',{{ $installment->id }})">
                        <i class="fa fa-edit"></i>
                    </button>
                @endif
                <button class="btn btn-danger btn-rounded"
                    onclick="confirmDelete({{ $installment->id }} ,'delteInstallment')">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        @endforeach
    </div>

</div>
