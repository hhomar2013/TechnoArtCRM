<div class="nav-header">
    <a href="{{ route('dashboard') }}" class="brand-logo">
        {{-- <img class="logo-abbr" src="{{ asset('storage/' . getAppSetting('app_logo') ) }}" alt=""> --}}
        {{-- <img class="logo-compact" src="{{ asset('storage/' . getAppSetting('app_logo') ) }}" alt=""> --}}
        <span class="brand-title">{{ config('app.name') }}</span>
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
