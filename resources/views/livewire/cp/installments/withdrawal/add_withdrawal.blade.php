<form wire:submit.prevent="save">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="">{{ __('Amount') }}</label>
                                        <input type="number" wire:model="amount" placeholder="{{ __('Amount') }}"
                                            min="0" class="form-control">
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="">{{ __('notes') }}</label>
                                        <textarea rows="3" wire:model.live="notes" placeholder="{{ __('notes') }}" class="form-control"></textarea>
                                        @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button class="btn btn-primary btn-rounded" wire:click.prevent="addCost">جدوله
                                        المدخرات</button>
                                    @if ($costs)
                                        <button class="btn btn-danger btn-rounded"
                                            wire:click.prevent="deleteAllCosts">{{ __('Delete Resource') }}</button>
                                    @endif

                                </div>
                                <div class="row mt-4">
                                    @foreach ($costs as $index => $value_cost)
                                        <div class="col-lg-2 col-md-4">
                                            <h4># : {{ $index + 1 }}</h4>
                                            <label for="">شيك / إيصال</label>
                                            <select class="form-control"
                                                wire:model="costs.{{ $index }}.cost_id">
                                                <option value="" disabled>{{ __('type') }}</option>
                                                <option value="check">{{ __('Check') }}</option>
                                                <option value="withdrawal">{{ __('Withdraw savings') }}</option>
                                            </select>
                                            <label for="">التاريخ</label>
                                            <input type="date" wire:model="costs.{{ $index }}.date"
                                                class="form-control" placeholder="{{ __('t.date') }}">
                                            <label for="">رقم الشيك/ الإيصال</label>
                                            <input type="number" wire:model="costs.{{ $index }}.transaction_id"
                                                class="form-control" placeholder="0" min="0">
                                            <label for="">المبلغ</label>
                                            <input type="number" wire:model.live="costs.{{ $index }}.value"
                                                class="form-control" placeholder="{{ __('Value') }}">

                                            <label for="">دفعه / مقسمه</label>
                                            <select class="form-control"
                                                wire:model.live="costs.{{ $index }}.actions">
                                                <option value="">{{ __('Select an option') }}</option>
                                                @foreach ($actionsOptions as $key => $label)
                                                    <option value="{{ $key }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <label for="">الملاحظه</label>
                                            <textarea wire:model="costs.{{ $index }}.notes" class="form-control"></textarea>
                                            <br>
                                            @if ($value_cost['actions'] === 'payments')
                                                <div class="row" wire:key="{{ $index }}">
                                                    <div class="col-lg-6">
                                                        <label>العدد</label>
                                                        <input type="number" class="form-control"
                                                            wire:model="costs.{{ $index }}.costs_installments_count" />
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>الفتره بعدد الايام</label>
                                                        <input type="number" class="form-control"
                                                            wire:model="costs.{{ $index }}.costs_installments_period" />
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="button"
                                                    wire:click="generateCostPayments({{ $index }})"
                                                    class="btn btn-sm btn-primary btn-rounded">
                                                    <i class="fa-solid fa-list-check"></i>
                                                    {{ __('Sume The Installments') }}
                                                </button>
                                            @endif
                                            <hr>
                                            <button type="button" wire:click="removeCosts({{ $index }})"
                                                class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i>
                                            </button>
                                            <br>
                                        </div> {{-- col-lg-4 --}}
                                    @endforeach

                                </div>
                                <hr>
                                <button type="submit"
                                    class="btn btn-primary btn-rounded">{{ __('Save') }}</button>
                            </form>