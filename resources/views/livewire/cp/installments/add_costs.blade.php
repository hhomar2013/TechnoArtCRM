<form wire:submit.prevent="saveCosts()">
    <div class="card text-dark">
        <div class="card-header">
            <h5>إضافه تكاليف</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label>{{ __('Costs') }}</label>
                <select class="form-control" wire:model.live="costType">
                    <option value="">{{ __('Select an option') }}</option>
                    @foreach ($costTypes as $costType)
                        <option value="{{ $costType->id }}">{{ $costType->name }}</option>
                    @endforeach
                </select>
                @error('costType')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
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
