<div>

    <div class="card">
        <div class="card-body">
            <div class="row">

            <div class="col">
                <h5 class="card-title text-uppercase p-2">
                    {{ __('General Settings') }}
                </h5>
            </div>
            <div class="col text-right text-dark">
                @include('tools.spinner')
            </div>
            </div>

            <hr>

                <div class="basic-form">
                    <form wire:submit.prevent="{{ $mySettings ? 'update' : 'store' }}">

                        <div class="form-row">
                            <div class="form-group col-md-6 ">
                                <label>{{ __('Name') }}</label>
                                <input type="text" class="form-control rounded-pill" placeholder="" wire:model="name" />
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('Email Address') }}</label>
                                <input type="email" class="form-control rounded-pill" placeholder=""  wire:model="email"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Phone Number') }}</label>
                                <input type="text" class="form-control rounded-pill" placeholder="" wire:model="phone" />
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="logo" class="btn btn-primary btn-rounded">{{   __('Choose').' '.__('Company logo') }}</label>
                                <input id="logo" type="file" class="form-control" hidden wire:model="logo" />
                                <br>
                                @if($logo)
                                <label for="logo">
                                    <img src="{{ $logo->temporaryUrl() }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="logo">
                                </label>
                                @elseif($mySettings->app_logo)
                                    <label for="logo">
                                        <img src="{{ asset('storage/' . $mySettings->app_logo) }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="logo">
                                    </label>
                                    @else
                                    <label for="logo">
                                        <img src="{{ asset('assets/images/logo-1.png') }}" class="img-fluid rounded" style="width: 200px; height: 200px" alt="logo">
                                    </label>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="favicon" class="btn btn-primary btn-rounded">{{   __('Choose').' '.__('faveicon') }}</label>
                                <input type="file" class="form-control" hidden wire:model="favicon" id="favicon"/>
                                <br>
                                @if($favicon)
                                <label for="favicon">
                                    <img src="{{ $favicon->temporaryUrl() }}" class="img-fluid rounded" style="width: 130px; height: 130px" alt="logo">
                                </label>
                                @elseif($mySettings->app_favicon)
                                <label for="favicon">
                                    <img src="{{ asset('storage/' . $mySettings->app_favicon) }}" class="img-fluid rounded" style="width: 130px; height: 130px" alt="logo">
                                </label>
                                @else
                                <label for="favicon">
                                <img  src="{{ asset('assets/images/logo-1.png') }}" class="img-fluid rounded" style="width: 130px; height: 130px" alt="logo">
                                </label>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary w-25">
                            <i class="fa fa-save"></i>
                            {{ __('Save') }}
                        </button>
                    </form>
                </div>
        </div>
    </div>
</div>
