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

                    {{-- Lang List --}}
                        {{-- <li class="nav-item dropdown header-profile">
                            @if (LaravelLocalization::getCurrentLocale() == 'ar')
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="{{asset('assets/images/flags/eg.png')}}"  class="rounded-circle" style="width: 25px; height: 25px;" alt="">
                                </a>
                            @else
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <img src="{{asset('assets/images/flags/us.png')}}"  class="rounded-circle" style="width: 25px; height: 25px;" alt=""></a>
                            @endif
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    @if ($localeCode == 'en')
                                        <a class="dropdown-item {{LaravelLocalization::getCurrentLocale() == 'en' ? 'active disabled' : ''}}" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            <img src="{{asset('assets/images/flags/us.png')}}"  class="rounded-circle" style="width: 25px; height: 25px;" alt=""> {{ $properties['native'] }}
                                        </a>
                                    @else
                                        <a class="dropdown-item {{LaravelLocalization::getCurrentLocale() == 'ar' ? 'active disabled' : ''}}" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            <img src="{{asset('assets/images/flags/eg.png')}}"  class="rounded-circle" style="width: 25px; height: 25px;" alt=""> {{ $properties['native'] }}
                                        </a>
                                    @endif

                                @endforeach
                            </div>
                        </li> --}}
                    {{-- End Lang List --}}

                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-bell"></i>
                            <div class="pulse-css"></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-unstyled">
                                <li class="media dropdown-item">
                                    <span class="success"><i class="ti-user"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>Martin</strong> has added a <strong>customer</strong> Successfully
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="primary"><i class="ti-shopping-cart"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="danger"><i class="ti-bookmark"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>Robin</strong> marked a <strong>ticket</strong> as unsolved.
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="primary"><i class="ti-heart"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>David</strong> purchased Light Dashboard 1.0.</p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="success"><i class="ti-image"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong> James.</strong> has added a<strong>customer</strong> Successfully
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                            </ul>
                            <a class="all-notification" href="#">
                                See all notifications <i class="ti-arrow-right"></i></a>
                        </div>
                    </li>


                       <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown"><small>{{ Auth::user()->name }}</small>
                            <i class="mdi mdi-account"></i>
                            </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <span class="dropdown-item">{{ Auth::user()->name }} </span>
                            <hr>
                            {{-- <a href="{{ route('admins.profile') }}" class="dropdown-item">
                                <i class="icon-user"></i>
                                <span clas  s="ml-2">{{ __('Profile') }} </span>
                            </a> --}}
                             @livewire('auth.logout')
                        </div>
                        </li>


                </ul>
            </div>
        </nav>
    </div>
</div>
