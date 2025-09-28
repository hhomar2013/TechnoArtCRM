<form wire:submit.prevent="saveInstallment()">
    <div class="card text-dark">
        <div class="card-header">
            <h5>إضافه قسط</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="form-group col-md-6">
                <label>{{ __('Amount') }}</label>
                <input type="number" class="form-control" placeholder="{{ __('00.0') }}" wire:model="amount">
                @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label>{{ __('t.date') }}</label>
                <input type="date" class="form-control" placeholder="{{ __('t.date') }}"
                    wire:model="transaction_date">
                @error('transaction_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <button type="button" class="btn btn-danger" wire:click="backToCostsInstallment">{{ __('Cancel') }}</button>
    </div>
</form>
