<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">{{ __('Main Menu') }}</li>
            <li><a href="{{ route('dashboard') }}" class="">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-text">{{ __('Dashboard') }}</span></a>
            </li>

            <li class="nav-label">{{ __('Projects Management') }}</li>
            <li class="{{ Route::is('project-management') ? 'mm-active' : '' }}">
                <a href="{{ route('project-management') }}">
                    <i class="fa-solid fa-bars"></i>&nbsp;<span
                        class="nav-text">{{ __('Project Main Data') }}</span></a>
            </li>

            <li class="nav-label">{{ __('Installment system') }}</li>
            <li class="{{ Route::is('customers') ? 'mm-active' : '' }}"><a href="{{ route('customers') }}">
                    <i class="fa-solid fa-bars"></i>&nbsp;<span class="nav-text">{{ __('Customers') }}</span></a>
            </li>

            <li class="{{ Route::is('allocation-of-units') ? 'mm-active' : '' }}"><a
                    href="{{ route('allocation-of-units') }}">
                    <i class="fa-solid fa-bars"></i>&nbsp;<span
                        class="nav-text">{{ __('Allocation Of Units') }}</span></a>
            </li>

            <li class="{{ Route::is('collection') ? 'mm-active' : '' }}"><a href="{{ route('collection') }}">
                    <i class="fa-solid fa-bars"></i>&nbsp;<span class="nav-text">{{ __('Collections') }}</span></a>
            </li>



            @can('settings')
                <li class="nav-label">{{ __('Setup') }}</li>
                <li class="{{ Route::is('settings') ? 'mm-active' : '' }}"><a href="{{ route('settings') }}">
                        <i class="fa-solid fa-sliders"></i>&nbsp;<span class="nav-text">{{ __('Settings') }}</span></a>
                </li>
            @endcan

            <li class="nav-label">{{ __('Reports') }}</li>
            <li class="{{ Route::is('reports.payment-movements') ? 'mm-active' : '' }}">
                <a href="{{ route('reports.payment-movements') }}">
                    <i class="fa-solid fa-bars"></i>&nbsp;<span
                        class="nav-text">{{ __('Movement of payment receipts') }}</span></a>
            </li>


            <li class="{{ Route::is('reports.totel-projects') ? 'mm-active' : '' }}">
                <a href="{{ route('reports.totel-projects') }}">
                    <i class="fa-solid fa-bars"></i>&nbsp;<span
                        class="nav-text">{{ __('Total of each project') }}</span></a>
            </li>

              <li class="{{ Route::is('reports.customer-data') ? 'mm-active' : '' }}">
                <a href="{{ route('reports.customer-data') }}">
                    <i class="fa-solid fa-bars"></i>&nbsp;<span
                        class="nav-text">{{ __('Customer data') }}</span></a>
            </li>
        </ul>
    </div>


</div>
