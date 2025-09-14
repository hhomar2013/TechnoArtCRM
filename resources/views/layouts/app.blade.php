<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="fcm-enabled" content="true">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> {{ config('app.name') }} | @yield('title') </title>
    <!-- Favicon icon -->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/' . getAppSetting('app_favicon') ) }}"> --}}
    <!-- Toastr -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/css/toastr.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="{{asset('assets/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    {{-- trix --}}
    {{-- End Trix --}}
    <link rel="stylesheet" href="{{ asset("assets/vendor/select2/css/select2.min.css") }}">


    <style>
        #map {
            width: 100% !important;
            height: 800px !important;
            z-index: 0;
            position: relative;
        }

    </style>
    <link href="{{ asset('assets/css/style_rtl.css') }}" rel="stylesheet">

    {{-- @if (LaravelLocalization::getCurrentLocale() == 'en')
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    @else
    <link href="{{ asset('assets/css/style_rtl.css') }}" rel="stylesheet">
    @endif --}}
    <style>
        body {
            zoom: 80%;
        }

    </style>


    @livewireStyles

    @stack('style')

    <!-- OpenLayers CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.3.0/ol.css">

    <!-- Custom CSS -->
    @yield('css')
</head>
<body dir="rtl">
    <!--*******************
        Preloader start
    ********************-->
    <p class="alert alert-warning" wire:offline>
        {{ __('Whoops, your device has lost connection. The web page you are viewing is offline.') }}
    </p>

    {{-- @include('tools.preloader') --}}

    <!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        @include('tools.nav-header')
        <!--**********************************
            Nav header end
        ***********************************-->
        <!--**********************************
            Header start
        ***********************************-->

        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        <!--**********************************
            Sidebar start
        ***********************************-->
        @if(Auth::guard()->name == 'web')
        @include('tools.header')
        @include('tools.sidebar')
        @else
        @include('tools.header_vendors')
        @include('tools.sidebar_vendors')
        @endif



        <!--**********************************
            Sidebar end
        ***********************************-->
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                {{-- <button  class="btn btn-primary" onclick="testNotification()">Send</button> --}}
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        <!--**********************************
            Footer start
        ***********************************-->
        @include('tools.footer')
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    <!--**********************************
        Scripts
    ***********************************-->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
    <!-- Toastr -->
    {{-- <script src="{{ asset('assets/vendor/toastr/js/toastr.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/layout-fixed-header.js') }}"></script>
    <script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/dashboard-2.js') }}"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/plugins-init/select2-init.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.onPageExpired((response, message) => {
                window.location('/login');
            })
        })

    </script>
    {{-- @include('tools.message') --}}

    <!-- OpenLayers JS -->
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.3.0/dist/ol.js"></script>
    <!-- Custom JS -->
    @stack('js')
    @yield('js')
    @livewireScripts
</body>
</html>
