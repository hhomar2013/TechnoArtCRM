<div>
    @if ($page)
        <div class="card">
            <div class="card-header text-end">
                <button class="btn btn-danger btn-rounded" wire:click="backToMainData()">
                    <i class="fa fa-arrow-left"></i>&nbsp;{{ __('Back') }}</button>
            </div>
            @switch($page)
                @case('project')
                    @livewire('cp.settings.project.index')
                @break

                @case('goverment')
                    @livewire('cp.settings.goverments.index')
                @break

                @case('district')
                    @livewire('cp.settings.districts.index')
                @break

                @case('consultant')
                    @livewire('cp.settings.consultants.index')
                @break

                @case('owner')
                    @livewire('cp.settings.owners.index')
                @break

                @case('bank')
                    @livewire('cp.settings.banks.index')
                @break

                @case('marketing')
                    @livewire('cp.settings.marketing.index')
                @break

                @case('developer')
                    @livewire('cp.settings.developers.index')
                @break

                @default
            @endswitch
        </div>
        @else
        <div class="text-center">
            @include('tools.spinner')
        </div>
        <div class="card">
            <div class="card-header">

                <div id="accordion-eleven" class="accordion accordion-rounded-stylish accordion-bordered col-12  accordion-header-bg">
                    <div class="accordion__item">
                        <div class="accordion__header accordion__header--primary " data-toggle="collapse" data-target="#rounded-stylish_collapseOne" aria-expanded="true">
                            <span class="accordion__header--icon"></span>
                            <span class="accordion__header--text">{{ __('Search') }}</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="rounded-stylish_collapseOne" class="accordion__body collapse show" data-parent="#accordion-eleven" style="">
                            <div class="accordion__body--text">
                                <div class="col-lg-3">
                                    <label for="">{{ __('Project Name') }}</label>
                                    <select class="form-control" wire:model="searchName" >
                                        <option value="%">{{ __('Select all') }}</option>
                                        @foreach ($projectsData as $projectsData_val)
                                            <option value="{{ $projectsData_val->id }}">{{ $projectsData_val->project->name }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <button class="btn btn-primary btn-rounded" wire:click.prevent="searchProject">
                                        <i class="fa-solid fa-magnifying-glass"></i> &nbsp; {{ __('Search') }}
                                    </button>
                                </div>{{-- Name --}}

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body text-dark">
                <div class="container-fluied">
                    <div class="basic-form">
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="">{{ __('Project Code') }}</label>
                                <input type="text" placeholder="" class="form-control" wire:model="code" readonly>
                                <br>
                            </div>{{-- Code --}}
                            <div class="col-lg-3">
                                <label for="">{{ __('Project Name') }}</label>
                                <select class="form-control" wire:model="name" wire:change="updateCode">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <button class="btn btn-primary btn-rounded" wire:click="navigate('project')">
                                    <i class="fa fa-plus"></i>&nbsp;{{ __('Add New') }}
                                </button>
                            </div>{{-- Name --}}
                        </div>{{-- كود& أسم المشروع --}}
                        <hr class="my-4" style="height: 5px; background-color: rgb(231, 10, 10); border: none;">
                        @if ($name)
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mx-sm-3 mb-2">
                                        <label>{{ __('Governorate') }}</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <select class="form-control" wire:model.live="goverment">
                                                    <option value="">{{ __('Select an option') }}</option>
                                                    @foreach ($goverments as $goverment_value)
                                                        <option value="{{ $goverment_value->id }}">
                                                            {{ $goverment_value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-lg-5">
                                                <button type="submit" wire:click="navigate('goverment')"
                                                    class="btn btn-primary btn-rounded mb-2">{{ __('Add New') }}</button>
                                            </div>
                                        </div>
                                    </div>{{-- goverment --}}
                                    <div class="mx-sm-3 mb-2">
                                        <label>{{ __('Districts') }}</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <select class="form-control" wire:model="district"
                                                    {{ $goverment ? '' : 'disabled' }}>
                                                    <option value="">{{ __('Select an option') }}</option>
                                                    @foreach ($districts as $district_value)
                                                        <option value="{{ $district_value->id }}">
                                                            {{ $district_value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <button type="submit" wire:click="navigate('district')"
                                                    class="btn btn-primary btn-rounded mb-2">{{ __('Add New') }}</button>
                                            </div>
                                        </div>
                                    </div>{{-- district --}}
                                    <div class="mx-sm-3 mb-2">
                                        <label>{{ __('Consultants') }}</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <select class="form-control" wire:model="consultant">
                                                    <option value="">{{ __('Select an option') }}</option>
                                                    @foreach ($consultants as $consultant_value)
                                                        <option value="{{ $consultant_value->id }}">
                                                            {{ $consultant_value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <button type="submit" wire:click="navigate('consultant')"
                                                    class="btn btn-primary btn-rounded mb-2">{{ __('Add New') }}</button>
                                            </div>
                                        </div>
                                    </div>{{-- consultant --}}
                                </div> {{-- col-lg-6 right --}}
                                <div class="col-lg-6">
                                    <div class="mx-sm-3 mb-2">
                                        <label>{{ __('Owner') }}</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <select class="form-control" wire:model="owner">
                                                    <option value="">{{ __('Select an option') }}</option>
                                                    @foreach ($owners as $owner_value)
                                                        <option value="{{ $owner_value->id }}">{{ $owner_value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <button type="submit" wire:click="navigate('owner')"
                                                    class="btn btn-primary btn-rounded mb-2">{{ __('Add New') }}</button>
                                            </div>
                                        </div>
                                    </div>{{-- Owners --}}
                                    <div class="mx-sm-3 mb-2">
                                        <label>{{ __('Bank') }}</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <select class="form-control" wire:model="bank">
                                                    <option value="">{{ __('Select an option') }}</option>
                                                    @foreach ($banks as $bank_value)
                                                        <option value="{{ $bank_value->id }}">{{ $bank_value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <button type="submit" wire:click="navigate('bank')"
                                                    class="btn btn-primary btn-rounded mb-2">{{ __('Add New') }}</button>
                                            </div>
                                        </div>
                                    </div>{{-- Banks --}}
                                    <div class="mx-sm-3 mb-2">
                                        <label>{{ __('Marketing') }}</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <select class="form-control" wire:model="marketing">
                                                    <option value="">{{ __('Select an option') }}</option>
                                                    @foreach ($marketings as $marketing_value)
                                                        <option value="{{ $marketing_value->id }}">
                                                            {{ $marketing_value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <button type="submit" wire:click="navigate('marketing')"
                                                    class="btn btn-primary btn-rounded mb-2">{{ __('Add New') }}</button>
                                            </div>
                                        </div>
                                    </div>{{-- Marketing --}}
                                    <div class="mx-sm-3 mb-2">
                                        <label>{{ __('Developers') }}</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <select class="form-control" wire:model="developer">
                                                    <option value="">{{ __('Select an option') }}</option>
                                                    @foreach ($developers as $developer_value)
                                                        <option value="{{ $developer_value->id }}">
                                                            {{ $developer_value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <button type="submit" wire:click="navigate('developer')"
                                                    class="btn btn-primary btn-rounded mb-2">{{ __('Add New') }}</button>
                                            </div>
                                        </div>
                                    </div>{{-- Developers --}}
                                </div>{{-- col-lg-6 left --}}
                                <div class="col-12">
                                    <label for="">{{ __('notes') }}</label>
                                    <textarea name="" id="" cols="30" rows="5" class="form-control" wire:model="notes"></textarea>
                                </div>
                            </div>{{-- row --}}
                        @endif
                                <br>
                        <button class="btn btn-primary btn-rounded"
                            wire:click.prevent="{{ $projectId ? 'update' : 'save' }}">
                            <i class="fa fa-save"></i>&nbsp;{{ __('Save') }}</button>
                    </div>
                    <br>
                </div>

                <div class="card-footer">
                    <ul class="list-group">
                        @foreach ($projectData as $projectData_val)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="col-10">
                                    <strong class="text-dark"> {{ $projectData_val->project->name }}</strong><br>
                                    <small class="text-dark">{{ $projectData_val->nots }}</small>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <button wire:click="edit({{ $projectData_val->id }})"
                                        class="btn btn-sm btn-dark text-white btn-rounded">{{ __('Update') }}</button>&nbsp;
                                    <button wire:click="delete({{ $projectData_val->id }})"
                                        class="btn btn-sm btn-danger btn-rounded">{{ __('Delete') }}</button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>

        </div>
    @endif
</div>
@script
    @include('tools.message')
@endscript
