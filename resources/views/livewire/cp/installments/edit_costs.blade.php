@if ($status == 'edit_form')
    <form wire:submit.prevent="updateCostReceipt()">
        <div class="card text-dark">
            <div class="card-header">
                <h5>تعديل الايصال</h5>
            </div>
            <hr>
            {{ __('Amount') }} <p> {{ number_format($costsShow->value, 2) }}</p>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{ __('bank') }}</label>
                    <select class="form-control" wire:model="bank">
                        <option value="">{{ __('Select an option') }}</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                    @error('bank')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>{{ __('Receipt number') }}</label>
                    <input type="number" class="form-control" placeholder="{{ __('Receipt number') }}"
                        wire:model="transaction_id">
                    @error('transaction_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>{{ __('Receipt date') }}</label>
                    <input type="date" class="form-control" placeholder="{{ __('Receipt date') }}"
                        wire:model="transaction_date">
                    @error('transaction_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>{{ __('Time') }}</label>
                    <input type="time" class="form-control" placeholder="{{ __('Time') }}" wire:model="time">
                    @error('time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            <button type="button" class="btn btn-danger"
                wire:click="backToCostsInstallment">{{ __('Cancel') }}</button>
        </div>
    </form>
@elseif($status == 'edit_cost')
    <form wire:submit.prevent="updateCostValue()">
        <div class="card text-dark">
            <div class="card-header">
                <h5>تعديل قيمه التكاليف</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>{{ __('Amount') }}</label>
                        <input type="number" class="form-control" placeholder="{{ __('Amount') }}"
                            wire:model="amount">
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <button type="button" class="btn btn-danger"
                    wire:click="backToCostsInstallment">{{ __('Cancel') }}</button>
            </div>
        </div>
    </form>

    @else
    @include('livewire.cp.installments.edit_installments')
@endif
