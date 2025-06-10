<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">


                <div class="header-left">

                    {{-- <div class="search_bar dropdown">

                        <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                            <i class="mdi mdi-magnify"></i>
                        </span>
                        <div class="dropdown-menu p-0 m-0">
                            <form>
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search">

                            </form>

                        </div>
                    </div> --}}
                </div>


                <ul class="navbar-nav header-right">
                    <li class="nav-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">
                                    {{ __('status') }}
                                </label>
                                @livewire('switcher', ['model' => Auth::user(), 'field' => 'IsOnline'], key("vendor-".Auth::id()))


                            </div>
                        </div>

                    </li>


                    {{-- Lang List --}}
                    <li class="nav-item dropdown header-profile">
                        @if (LaravelLocalization::getCurrentLocale() == 'ar')
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <img src="{{asset('assets/images/flags/eg.png')}}" class="rounded-circle" style="width: 25px; height: 25px;" alt="">
                        </a>
                        @else
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <img src="{{asset('assets/images/flags/us.png')}}" class="rounded-circle" style="width: 25px; height: 25px;" alt=""></a>
                        @endif
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @if ($localeCode == 'en')
                            <a class="dropdown-item {{LaravelLocalization::getCurrentLocale() == 'en' ? 'active disabled' : ''}}" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <img src="{{asset('assets/images/flags/us.png')}}" class="rounded-circle" style="width: 25px; height: 25px;" alt=""> {{ $properties['native'] }}
                            </a>
                            @else
                            <a class="dropdown-item {{LaravelLocalization::getCurrentLocale() == 'ar' ? 'active disabled' : ''}}" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <img src="{{asset('assets/images/flags/eg.png')}}" class="rounded-circle" style="width: 25px; height: 25px;" alt=""> {{ $properties['native'] }}
                            </a>
                            @endif

                            @endforeach
                        </div>
                    </li>
                    {{-- End Lang List --}}



                    @livewire('vendor-side.tools.user-menue')


                </ul>
            </div>
        </nav>
    </div>
</div>
