<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{ config('app.name') }} | @yield('title','')</title>
    <!-- Favicon icon -->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/' . getAppSetting('app_favicon') ) }}"> --}}
    {{-- @if (LaravelLocalization::getCurrentLocale() == 'en')
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    @else
    <link href="{{ asset('assets/css/style_rtl.css') }}" rel="stylesheet">
    @endif --}}
    <link href="{{ asset('assets/css/style_rtl.css') }}" rel="stylesheet">
    <style>
        body {
            zoom: 100%;
        }

    </style>
    @livewireStyles
</head>

<body class="h-100">
    @yield('content')

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
    @livewireScripts
</body>

</html>
