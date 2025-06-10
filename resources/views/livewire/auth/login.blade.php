@section('title',__('Login'))
<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-4">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <h4 class="text-center mb-4 p-3">{{ __('Login to Your Account') }}</h4>
                                <hr>
                                <form wire:submit.prevent="login">
                                    <div class="form-group">
                                        <label><strong>{{ __('Email Address') }}</strong></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror {{ session()->has('error') ? 'is-invalid' : '' }}" wire:model="email" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        @if(session()->has('error'))
                                        <span class="text-danger " role="alert">
                                            <small><b> {{ session()->get('error') }}</b></small>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{ __('Password') }}</strong></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" />
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2" dir="rtl">
                                        <div class="form-group">
                                            <div class="form-check ml-2">
                                                <input class="form-check-input" type="checkbox" id="basic_checkbox_1" wire:model="remember">
                                                <label class="form-check-label" for="basic_checkbox_1">{{ __('Remember me') }}</label>

                                            </div>
                                        </div>
                                        <div class="form-group">

                                        </div>
                                    </div>

                                    <div class="text-center">

                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Login') }}
                                        </button>
                                        <br>
                                        @include('tools.spinner')

                                    </div>
                                </form>
                                <div class="new-account mt-3">
                                    {{-- <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
