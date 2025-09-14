<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? config('app.name') }} </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="{{ asset('assets/css/rtl_style.css') }}" rel="stylesheet">

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700&display=swap');
    body{
        font-family: "Cairo", sans-serif;
    }
</style>
<body class="h-100" style="background-color: gainsboro">

    <div class="authincation h-100">
        <div class="container-fluid h-100 pt-5">
            {{-- <div class="row justify-content-center h-100 align-items-center"> --}}
                <div class="col-lg-12">
                    @yield('content')
                </div>
            {{-- </div> --}}
        </div>
    </div>

</body>

</html>
