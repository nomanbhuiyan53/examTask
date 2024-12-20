<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@stack('title')</title>

    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icon/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.6/dist/sweetalert2.min.css">

    @stack('css')
</head>
<body>
<div class="container-fluid">
    <button class="sidebar-collapse-mini d-xl-none d-block"><i class="bi bi-list"></i></button>
    <!-- main sidebar -->
    <div class="fixed-sidebar sidebar-mini">
        <div class="logo">
            <button class="sidebar-collapse"><i class="bi bi-list"></i></button>
            <a href="index.html"><img src="assets/images/logo.png" alt="LOGO"></a>
        </div>
        <!-- sidebar menu -->
        @include('layout.sidebar')
        <!-- sidebar menu -->
    </div>
    <!-- main sidebar -->
    <div class="main-content">
        @yield('content')
    </div>
</div>

<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.6/dist/sweetalert2.min.js"></script>

<script>
    function showAlert(title, message, icon, buttonText) {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            confirmButtonText: buttonText || 'OK'
        });
    }
</script>
@stack('js')
</body>
</html>
