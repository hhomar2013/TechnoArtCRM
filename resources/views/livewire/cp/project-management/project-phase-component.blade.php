<div>
    <div class="text-center">
        @include('tools.spinner')
    </div>

    @if($page == 'phase')
    <div class="card">
        <div class="card-header text-end">
            <button class="btn btn-danger btn-rounded" wire:click="backToPphase()">
                <i class="fa fa-arrow-left"></i>&nbsp;{{ __('Back') }}</button>
        </div>
        @livewire('cp.settings.phases.index')
    </div>
    @endif

    <div class="card">
        <div class="card-body text-dark">
            <div class="container-fluied">
                <div class="basic-form">
                    <div class="row">
                        <div class="col-lg-2">
                            <label for="">{{ __('Project Code') }}</label>
                            <input type="text" placeholder="" class="form-control" wire:model="code" readonly>
                            <br>
                        </div>
                        <div class="col-lg-3">
                            <label for="">{{ __('Project Name') }}</label>
                            <select class="form-control" wire:model="name" wire:change="updateCode">
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($name)
                            <div class="col-lg-3">
                                <label for="">{{ __('Phases') }}</label>
                                <select class="form-control" wire:model.live="phase">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($phases as $phase_val)
                                        <option value="{{ $phase_val->id }}">{{ $phase_val->name }}</option>
                                    @endforeach
                                </select><br>
                                 <button class="btn btn-primary btn-rounded" wire:click="navigate('phase')" ><i class="fa fa-plus"></i>{{ __('Add New Phase') }}</button>

                            </div>
                        @endif
                    </div>{{-- كود& أسم المشروع --}}

                    <button class="btn btn-primary btn-rounded" wire:click.prevent="{{ $phaseId ? 'update' : 'save' }}" {{ $name && $phase ? '' : 'hidden' }}>
                        <i class="fa fa-save"></i> {{ __('Save') }}
                    </button>{{-- save --}}

                    <hr class="my-4" style="height: 5px; background-color: rgb(231, 10, 10); border: none;">

                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-group">
                                @foreach ($project_phases as $val)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="col-10">
                                            <strong class="text-dark"> {{ $val->phase->name }}</strong><br>
                                            <small class="text-dark">{{ $val->project->name }}</small>

                                        </div>
                                        <div class="col-2 d-flex justify-content-end">
                                            <button wire:click="edit({{ $val->id }})"
                                                class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                                            <button wire:click="delete({{ $val->id }})"
                                                class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@script
@include('tools.message')
@endscript
